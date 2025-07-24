<?php

namespace App\Services\OrderService;

use Throwable;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Language;
use App\Models\UserCart;
use App\Models\OrderDetail;
use App\Models\Translation;
use App\Traits\Notification;
use App\Services\CoreService;
use App\Helpers\Admin\Utility;
use App\Helpers\ResponseError;
use App\Models\PushNotification;
use Illuminate\Support\Facades\Log;
use App\Services\CartService\CartService;

class OrderDetailService extends CoreService
{
	use Notification;

    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return OrderDetail::class;
    }

    public function create(Order $order, array $collection, ?array $notes = []): Order
    {
        Log::info('OrderDetailService: Starting create', ['order_id' => $order->id, 'collection_count' => count($collection)]);
        
        if (empty($order->table_id)) {
            foreach ($order->orderDetails as $orderDetail) {
                $orderDetail?->stock?->increment('quantity', $orderDetail?->quantity);
                $orderDetail?->forceDelete();
            }
        }

        return $this->update($order, $collection, $notes);
    }

    public function update(Order $order, $collection, $notes): Order
    {
        Log::info('OrderDetailService: Updating order details', [
            'order_id' => $order->id,
            'collection_count' => count($collection),
            'notes' => $notes
        ]);

        foreach ($collection as $item) {
            Log::info('OrderDetailService: Processing item', ['stock_id' => data_get($item, 'stock_id'), 'quantity' => data_get($item, 'quantity')]);

            $stock = Stock::with([
                'countable:id,status,shop_id,active,min_qty,max_qty,tax,img,interval,is_bogo',
                'countable.discounts' => fn($q) => $q
                    ->where('start', '<=', today())
                    ->where('end', '>=', today())
                    ->where('active', 1)
            ])
                ->select('id', 'countable_id', 'price', 'quantity')
                ->find(data_get($item, 'stock_id'));

            if (!$stock) {
                Log::warning('OrderDetailService: Stock not found', ['stock_id' => data_get($item, 'stock_id')]);
                continue;
            }

            if (!$stock->countable?->active || $stock->countable?->status != Product::PUBLISHED) {
                Log::warning('OrderDetailService: Product inactive or unpublished', ['stock_id' => $stock->id, 'product_id' => $stock->countable->id]);
                continue;
            }

            $actualQuantity = $this->actualQuantity($stock, data_get($item, 'quantity', 0));
            Log::info('OrderDetailService: Stock check for paid item', [
                'stock_id' => $stock->id,
                'requested_quantity' => data_get($item, 'quantity', 0),
                'actual_quantity' => $actualQuantity,
                'available_quantity' => $stock->quantity
            ]);

            if (empty($actualQuantity) || $actualQuantity <= 0) {
                Log::warning('OrderDetailService: Insufficient stock for paid item', ['stock_id' => $stock->id, 'requested_quantity' => data_get($item, 'quantity')]);
                continue;
            }

            data_set($item, 'quantity', $actualQuantity);
            data_set($item, 'note', data_get($notes, $stock->id, ''));

            $orderDetail = $order->orderDetails()->create($this->setItemParams($item, $stock));
            $stock->decrement('quantity', $actualQuantity);

            Log::info('OrderDetailService: Created order detail', ['order_detail_id' => $orderDetail->id, 'stock_id' => $stock->id, 'quantity' => $actualQuantity]);

            if ($stock->countable->is_bogo == 1) {
                Log::info('OrderDetailService: BOGO detected', ['stock_id' => $stock->id, 'product_id' => $stock->countable->id]);
                $bogoQuantity = $actualQuantity;
                $bogoAvailable = $stock->quantity >= $bogoQuantity ? $bogoQuantity : 0;
                Log::info('OrderDetailService: BOGO stock check', [
                    'stock_id' => $stock->id,
                    'bogo_quantity' => $bogoQuantity,
                    'available_quantity' => $stock->quantity,
                    'bogo_available' => $bogoAvailable
                ]);
                if ($bogoAvailable > 0) {
                    $bogoItem = array_merge($item, [
                        'quantity' => $bogoQuantity,
                        'price' => 0,
                        'discount' => $stock->price ?? 0,
                        'note' => 'BOGO free item'
                    ]);
                    $bogoOrderDetail = $order->orderDetails()->create($this->setItemParams($bogoItem, $stock));
                    $stock->decrement('quantity', $bogoQuantity);
                    Log::info('OrderDetailService: BOGO applied', [
                        'order_id' => $order->id,
                        'order_detail_id' => $bogoOrderDetail->id,
                        'stock_id' => $stock->id,
                        'quantity' => $bogoQuantity
                    ]);
                } else {
                    Log::warning('OrderDetailService: Insufficient stock for BOGO', ['stock_id' => $stock->id, 'bogo_quantity' => $bogoQuantity]);
                }
            }

            $addons = (array)data_get($item, 'addons', []);
            foreach ($addons as $addon) {
                Log::info('OrderDetailService: Processing addon', ['addon_stock_id' => data_get($addon, 'stock_id')]);
                $addonStock = Stock::with([
                    'countable:id,status,shop_id,active,min_qty,max_qty,tax,img,interval',
                    'countable.discounts' => fn($q) => $q
                        ->where('start', '<=', today())
                        ->where('end', '>=', today())
                        ->where('active', 1)
                ])
                    ->select('id', 'countable_id', 'price', 'quantity')
                    ->find(data_get($addon, 'stock_id'));

                if (!$addonStock) {
                    Log::warning('OrderDetailService: Addon stock not found', ['addon_stock_id' => data_get($addon, 'stock_id')]);
                    continue;
                }

                $addonQuantity = $this->actualQuantity($addonStock, data_get($addon, 'quantity', 0));
                if (empty($addonQuantity) || $addonQuantity <= 0) {
                    Log::warning('OrderDetailService: Insufficient addon stock', ['addon_stock_id' => $addonStock->id]);
                    continue;
                }

                $addon['quantity'] = $addonQuantity;
                $addon['parent_id'] = $orderDetail->id;
                $order->orderDetails()->create($this->setItemParams($addon, $addonStock));
                $addonStock->decrement('quantity', $addonQuantity);
                Utility::calculateInventory($addonStock);
            }

            Utility::calculateInventory($stock);
        }

        Log::info('OrderDetailService: Update completed', ['order_id' => $order]);
        return $order;
    }

 public function createOrderUser(Order $order, int $cartId, ?array $notes = []): Order
{
    Log::info('OrderDetailService: Starting createOrderUser', ['order_id' => $order->id, 'cart_id' => $cartId]);

    $cart = clone Cart::with([
        'userCarts.cartDetails:id,user_cart_id,stock_id,price,discount,quantity',
        'userCarts.cartDetails.stock.bonus' => fn($q) => $q->where('expired_at', '>', now()),
        'userCarts.cartDetails.stock' => fn($q) => $q->select('id', 'countable_id', 'price', 'quantity')->with([
            'countable:id,status,shop_id,active,min_qty,max_qty,tax,img,interval,is_bogo'
        ]),
        'shop',
        'shop.bonus' => fn($q) => $q->where('expired_at', '>', now()),
    ])
        ->select('id', 'total_price', 'shop_id')
        ->find($cartId);

    if (!$cart) {
        Log::warning('OrderDetailService: Cart not found', ['cart_id' => $cartId]);
        return $order;
    }

    Log::info('OrderDetailService: Cart found', ['cart_id' => $cart->id, 'user_carts_count' => $cart->userCarts->count()]);

    (new CartService)->calculateTotalPrice($cart);

    $cart = clone Cart::with([
        'shop',
        'userCarts.cartDetails' => fn($q) => $q->whereNull('parent_id'),
        'userCarts.cartDetails.stock' => fn($q) => $q->select('id', 'countable_id', 'price', 'quantity')->with([
            'countable:id,status,shop_id,active,min_qty,max_qty,tax,img,interval,is_bogo'
        ]),
        'userCarts.cartDetails.children.stock.countable',
    ])->find($cart->id);

    if (empty($cart?->userCarts)) {
        Log::warning('OrderDetailService: No user carts found', ['cart_id' => $cart->id]);
        return $order;
    }

    foreach ($cart->userCarts as $userCart) {
        $cartDetails = $userCart->cartDetails;
        if (empty($cartDetails)) {
            Log::info('OrderDetailService: No cart details, deleting user cart', ['user_cart_id' => $userCart->id]);
            $userCart->delete();
            continue;
        }

        Log::info('OrderDetailService: Processing user cart', ['user_cart_id' => $userCart->id, 'cart_details_count' => $cartDetails->count()]);

        foreach ($cartDetails as $cartDetail) {
            $stock = $cartDetail->stock;
            if (!$stock || !$stock->countable) {
                Log::warning('OrderDetailService: Invalid stock or product', ['stock_id' => $cartDetail->stock_id]);
                continue;
            }

            Log::info('OrderDetailService: Processing cart detail', [
                'cart_detail_id' => $cartDetail->id,
                'stock_id' => $stock->id,
                'quantity' => $cartDetail->quantity,
                'is_bogo' => $stock->countable->is_bogo ?? 'N/A'
            ]);

            $cartDetail->setAttribute('note', data_get($notes, $stock->id, ''));

            $actualQuantity = $this->actualQuantity($stock, $cartDetail->quantity);
            Log::info('OrderDetailService: Stock check for paid item', [
                'stock_id' => $stock->id,
                'requested_quantity' => $cartDetail->quantity,
                'actual_quantity' => $actualQuantity,
                'available_quantity' => $stock->quantity
            ]);

            if ($actualQuantity <= 0) {
                Log::warning('OrderDetailService: Insufficient stock for paid item', ['stock_id' => $stock->id, 'requested_quantity' => $cartDetail->quantity]);
                continue;
            }

            $parent = $order->orderDetails()->create($this->setItemParams($cartDetail, $stock));
            $stock->decrement('quantity', $actualQuantity);

            Log::info('OrderDetailService: Created order detail', ['order_detail_id' => $parent->id, 'stock_id' => $stock->id]);

            if ($stock->countable->is_bogo == 1) {
                Log::info('OrderDetailService: BOGO detected', ['stock_id' => $stock->id, 'product_id' => $stock->countable->id]);
                $bogoQuantity = $cartDetail->quantity;
                $bogoAvailable = $stock->quantity >= $bogoQuantity ? $bogoQuantity : 0;
                Log::info('OrderDetailService: BOGO stock check', [
                    'stock_id' => $stock->id,
                    'bogo_quantity' => $bogoQuantity,
                    'available_quantity' => $stock->quantity,
                    'bogo_available' => $bogoAvailable
                ]);
                if ($bogoAvailable > 0) {
                    $bogoItem = [
                        'stock_id' => $stock->id,
                        'quantity' => $bogoQuantity,
                        'price' => 0,
                        'discount' => $stock->price ?? 0,
                        'note' => 'BOGO free item'
                    ];
                    $bogoOrderDetail = $order->orderDetails()->create($this->setItemParams($bogoItem, $stock));
                    $stock->decrement('quantity', $bogoQuantity);
                    Log::info('OrderDetailService: BOGO applied', [
                        'order_id' => $order->id,
                        'order_detail_id' => $bogoOrderDetail->id,
                        'stock_id' => $stock->id,
                        'quantity' => $bogoQuantity
                    ]);

                    // Process addons for BOGO item
                    foreach ($cartDetail->children as $addon) {
                        $addonStock = $addon->stock;
                        if (!$addonStock) {
                            Log::warning('OrderDetailService: Invalid addon stock for BOGO item', ['addon_stock_id' => $addon->stock_id]);
                            continue;
                        }

                        Log::info('OrderDetailService: Processing addon for BOGO item', [
                            'addon_stock_id' => $addonStock->id,
                            'bogo_order_detail_id' => $bogoOrderDetail->id
                        ]);

                        $addonActualQuantity = $this->actualQuantity($addonStock, $addon->quantity);
                        if ($addonActualQuantity <= 0) {
                            Log::warning('OrderDetailService: Insufficient stock for BOGO addon', [
                                'addon_stock_id' => $addonStock->id,
                                'requested_quantity' => $addon->quantity
                            ]);
                            continue;
                        }

                        $addon->setAttribute('parent_id', $bogoOrderDetail->id);
                        $addon->setAttribute('note', data_get($notes, $addonStock->id, ''));
                        $order->orderDetails()->create($this->setItemParams($addon, $addonStock));
                        $addonStock->decrement('quantity', $addonActualQuantity);
                        Log::info('OrderDetailService: BOGO addon applied', [
                            'order_id' => $order->id,
                            'order_detail_id' => $bogoOrderDetail->id,
                            'addon_stock_id' => $addonStock->id,
                            'quantity' => $addonActualQuantity
                        ]);
                    }
                } else {
                    Log::warning('OrderDetailService: Insufficient stock for BOGO', ['stock_id' => $stock->id, 'bogo_quantity' => $bogoQuantity]);
                }
            }

            foreach ($cartDetail->children as $addon) {
                $stock = $addon->stock;
                if (!$stock) {
                    Log::warning('OrderDetailService: Invalid addon stock', ['addon_stock_id' => $addon->stock_id]);
                    continue;
                }

                Log::info('OrderDetailService: Processing addon', ['addon_stock_id' => $stock->id]);
                $addon->setAttribute('parent_id', $parent?->id);
                $addon->setAttribute('note', data_get($notes, $stock->id, ''));
                $order->orderDetails()->create($this->setItemParams($addon, $stock));
                $stock->decrement('quantity', $addon->quantity);
            }
        }
    }

    Log::info('OrderDetailService: Deleting cart', ['cart_id' => $cart->id]);
    $cart->delete();

    Log::info('OrderDetailService: createOrderUser completed', ['order_id' => $order->id]);
    return $order;
}

    private function setItemParams($item, ?Stock $stock): array
    {

        $quantity  = data_get($item, 'quantity', 0);
        $kitchenId = 0;

        if (data_get($item, 'bonus')) {

            data_set($item, 'origin_price', 0);
            data_set($item, 'total_price', 0);
            data_set($item, 'tax', 0);
            data_set($item, 'discount', 0);

        } else {

            $originPrice = $stock?->price * $quantity;

            $discount    = $stock?->actual_discount * $quantity;

            $tax         = $stock?->tax_price * $quantity;

            $totalPrice  = $originPrice - $discount + $tax;

            data_set($item, 'origin_price', $originPrice);
            data_set($item, 'total_price', max($totalPrice,0));
            data_set($item, 'tax', $tax);
            data_set($item, 'discount', $discount);
        }

        if (!$stock->addon) {
            $kitchenId = $stock->countable?->kitchen_id;
        }

        return [
            'note'         => data_get($item, 'note', 0),
            'origin_price' => data_get($item, 'origin_price', 0),
            'tax'          => data_get($item, 'tax', 0),
            'discount'     => data_get($item, 'discount', 0),
            'total_price'  => data_get($item, 'total_price', 0),
            'stock_id'     => data_get($item, 'stock_id'),
            'parent_id'    => data_get($item, 'parent_id'),
            'quantity'     => $quantity,
            'bonus'        => data_get($item, 'bonus', false),
            'kitchen_id'   => $kitchenId
        ];
    }

    /**
     * @param Stock|null $stock
     * @param $quantity
     * @return mixed
     */
    private function actualQuantity(?Stock $stock, $quantity): mixed
    {

        $countable = $stock?->countable;

        if ($quantity < ($countable?->min_qty ?? 0)) {

            $quantity = $countable?->min_qty;

        } else if($quantity > ($countable?->max_qty ?? 0)) {

            $quantity = $countable?->max_qty;

        }

        return $quantity > $stock->quantity ? max($stock->quantity, 0) : $quantity;
    }

    /**
     * @param int $orderId
     * @param int $cookId
     * @param int|null $shopId
     * @return array
     */
    public function updateCook(int $orderId, int $cookId, int|null $shopId = null): array
    {
        try {
            /** @var User $cook */

            $cook = User::with(['roles'])
                ->when($shopId, fn($q) => $q->whereHas('invitations', fn($q) => $q->where('shop_id', $shopId)))
                ->find($cookId);

            $orderDetail = OrderDetail::when($shopId, fn($q) => $q->whereHas('order', fn($b) => $b->where('shop_id',$shopId)))
                ->find($orderId);

            if ($cook?->kitchen_id !== $orderDetail?->kitchen_id) {
                return [
                    'status'  => false,
                    'code'    => ResponseError::ERROR_511,
                    'message' => __('errors.' . ResponseError::ERROR_511, locale: $this->language)
                ];
            }

            if (!$orderDetail) {
                return [
                    'status'  => false,
                    'code'    => ResponseError::ERROR_404,
                    'message' => __('errors.' . ResponseError::ERROR_404, locale: $this->language)
                ];
            }

            if ($orderDetail->order?->delivery_type !== Order::DINE_IN) {
                return [
                    'status'  => false,
                    'code'    => ResponseError::ERROR_502,
                    'message' => __('errors.' . ResponseError::ORDER_PICKUP, locale: $this->language)
                ];
            }

            if (!$cook || !$cook->hasRole('cook')) {
                return [
                    'status'  => false,
                    'code'    => ResponseError::ERROR_211,
                    'message' => __('errors.' . ResponseError::ERROR_211, locale: $this->language)
                ];
            }

            if (!$cook->invitations?->where('shop_id', $orderDetail->order?->shop_id)?->first()?->id) {
                return [
                    'status'  => false,
                    'code'    => ResponseError::ERROR_212,
                    'message' => __('errors.' . ResponseError::ERROR_212, locale: $this->language)
                ];
            }

            $orderDetail->update([
                'cook_id' => $cook->id,
            ]);

            return ['status' => true, 'message' => ResponseError::NO_ERROR, 'data' => $orderDetail];
        } catch (Throwable) {
            return [
                'status'  => false,
                'code'    => ResponseError::ERROR_502,
                'message' => __('errors.' . ResponseError::ERROR_502, locale: $this->language)
            ];
        }
    }

    /**
     * @param int|null $id
     * @return array
     */
    public function attachCook(?int $id): array
    {
        try {
            /** @var OrderDetail $orderDetail */
            $orderDetail = OrderDetail::with('user')->find($id);

//            if ($orderDetail?->order?->delivery_type !== Order::DINE_IN) {
//                return [
//                    'status'  => false,
//                    'code'    => ResponseError::ERROR_502,
//                    'message' => __('errors.' . ResponseError::ORDER_PICKUP, locale: $this->language)
//                ];
//            }

            if (!empty($orderDetail->cook_id)) {
                return [
                    'status'  => false,
                    'code'    => ResponseError::COOKER_NOT_EMPTY,
                    'message' => __('errors.' . ResponseError::COOKER_NOT_EMPTY, locale: $this->language)
                ];
            }

            /** @var User $user */
            $user = auth('sanctum')->user();

            if (!$user?->invitations?->where('shop_id', $orderDetail?->order?->shop_id)?->first()?->id) {
                return [
                    'status'  => false,
                    'code'    => ResponseError::ERROR_212,
                    'message' => __('errors.' . ResponseError::ERROR_212, locale: $this->language)
                ];
            }

            $orderDetail->update([
                'cook_id' => auth('sanctum')->id(),
            ]);

            return ['status' => true, 'message' => ResponseError::NO_ERROR, 'data' => $orderDetail];
        } catch (Throwable) {
            return [
                'status'  => false,
                'code'    => ResponseError::ERROR_502,
                'message' => __('errors.' . ResponseError::ERROR_502, locale: $this->language)
            ];
        }
    }

    public function statusUpdate(OrderDetail $orderDetail, ?string $status): array
    {
        if ($orderDetail->status == $status) {
            return [
                'status'  => false,
                'code'    => ResponseError::ERROR_252,
                'message' => __('errors.' . ResponseError::ERROR_252, locale: $this->language)
            ];
        }

        $orderDetail->update([
            'status' => $status
        ]);

		$orderDetail->children()->update([
            'status' => $status
        ]);

		$default = data_get(Language::languagesList()->where('default', 1)->first(), 'locale');

		$tStatus = Translation::where(function ($q) use ($default) {
			$q->where('locale', $this->language)->orWhere('locale', $default);
		})
			->where('key', $status)
			->first()?->value;

		$orderDetail = $orderDetail->load([
			'cooker:id,firebase_token',
			'order:id,user_id,waiter_id',
			'order.waiter:id,firebase_token',
		]);

		$isCook   = request()->is('api/v1/dashboard/cook/*');
		$isWaiter = request()->is('api/v1/dashboard/waiter/*');

		$firebaseTokens = array_merge(
			!$isCook ? $orderDetail?->cooker?->firebase_token  ?? [] : [],
			!$isWaiter ? $orderDetail?->order?->waiter?->firebase_token ?? [] : [],
		);

		$userIds = [];

		if (!$isCook) {
			$userIds[] = $orderDetail?->cooker?->id;
		}

		if (!$isWaiter) {
			$userIds[] = $orderDetail?->order?->waiter?->id;
		}

		$this->sendNotification(
			array_values(array_unique($firebaseTokens)),
			__('errors.' . ResponseError::STATUS_CHANGED, ['status' => !empty($tStatus) ? $tStatus : $status], $this->language),
			$orderDetail->id,
			[
				'id'     => $orderDetail->id,
				'status' => $orderDetail->status,
				'type'   => PushNotification::STATUS_CHANGED
			],
			$userIds,
			__('errors.' . ResponseError::STATUS_CHANGED, ['status' => !empty($tStatus) ? $tStatus : $status], $this->language),
		);

		return ['status' => true, 'message' => ResponseError::NO_ERROR, 'data' => $orderDetail];
    }

}
