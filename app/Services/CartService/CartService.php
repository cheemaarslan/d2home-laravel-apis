<?php

namespace App\Services\CartService;

use Str;
use Throwable;
use App\Models\Cart;
use App\Models\Shop;
use App\Models\User;
use App\Models\Bonus;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Receipt;
use App\Models\Currency;
use App\Models\Language;
use App\Models\UserCart;
use App\Models\CartDetail;
use App\Services\CoreService;
use App\Helpers\ResponseError;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Cart\CartResource;

class CartService extends CoreService
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Cart::class;
    }

    /**
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        /** @var User $user */
        /** @var Stock $stock */
        $locale   = data_get(Language::languagesList()->where('default', 1)->first(), 'locale');

        $user = auth('sanctum')->user();

        if (!empty(data_get($data, 'user_id')) && $user && $user->hasRole(['admin', 'seller'])) {
            $user = User::find(data_get($data, 'user_id'));
        }

        $data['user_id']  = $user?->id;
        $data['owner_id'] = $user?->id;
        $data['name']     = $user?->name_or_email;

        $stock = Stock::with([
            'countable:id,status,active,shop_id,min_qty,max_qty,tax,img,interval',
            'countable.unit.translation' => fn($q) => $q
                ->where(fn($q) => $q->where('locale', $this->language)->orWhere('locale', $locale)),
            'countable.discounts' => fn($q) => $q
                ->where('start', '<=', today())
                ->where('end', '>=', today())
                ->where('active', 1)
        ])->find(data_get($data, 'stock_id', 0));

        if (!$stock?->id || $stock->countable?->status !== Product::PUBLISHED) {
            return [
                'status'    => false,
                'code'      => ResponseError::ERROR_404,
                'message'   => __('errors.' . ResponseError::ERROR_404, locale: $this->language)
            ];
        }

        if ($stock->countable?->shop_id !== data_get($data, 'shop_id')) {
            return [
                'status'  => false,
                'code'    => ResponseError::ERROR_440,
                'message' => __('errors.' . ResponseError::OTHER_SHOP, locale: $this->language)
            ];
        }

        $quantity = $this->actualQuantity($stock, data_get($data, 'quantity', 0)) ?? 0;

        data_set($data, 'quantity', $quantity);

        data_set($data, 'price', ($stock->price + $stock->tax_price) * $quantity);
        data_set($data, 'discount', $stock->actual_discount * $quantity);

        /** @var Cart $cart */
        $cart = $this->model()
            ->where('owner_id', $user->id)
            ->first();

        if ($cart) {
            return $this->createToExistCart($data, $cart, $stock, $user);
        }

        return $this->createCart($data);
    }

    #region create when exist cart

    /**
     * @param array $data
     * @param Cart $cart
     * @param Stock $stock
     * @param User $user
     * @return array
     */
    private function createToExistCart(array $data, Cart $cart, Stock $stock, User $user): array
    {
        try {

            if ($cart->shop_id !== data_get($stock->countable, 'shop_id')) {
                return [
                    'status'  => false,
                    'code'    => ResponseError::ERROR_440,
                    'message' => __('errors.' . ResponseError::OTHER_SHOP, locale: $this->language)
                ];
            }

            $cartId = DB::transaction(function () use ($data, $cart, $user) {

                $userCart = $cart->userCarts()->firstOrCreate([
                    'cart_id' => data_get($cart, 'id'),
                    'user_id' => $user->id,
                ], $data);

                /** @var UserCart $userCart */
                $userCart->cartDetails()->where([
                    'stock_id'      => data_get($data, 'stock_id'),
                    'parent_id'     => data_get($data, 'parent_id'),
                    'user_cart_id'  => $userCart->id,
                ])->updateOrCreate([
                    'stock_id'      => data_get($data, 'stock_id'),
                    'user_cart_id'  => $userCart->id,
                ], [
                    'quantity'      => data_get($data, 'quantity', 0),
                    'price'         => data_get($data, 'price', 0),
                    'discount'      => data_get($data, 'discount', 0),
                ]);

                return $cart->id;
            });

            return $this->successReturn($cartId);
        } catch (Throwable $e) {
            $this->error($e);
            return [
                'status'  => false,
                'code'    => ResponseError::ERROR_501,
                'message' => __('errors.' . ResponseError::ERROR_501, locale: $this->language)
            ];
        }
    }
    #endregion

    #region create new cart
    /**
     * @param array $data
     * @return array
     */
    private function createCart(array $data): array
    {
        try {
            $cartId = DB::transaction(function () use ($data) {

                /** @var Cart $cart */
                $cart = $this->model()->create($data);

                /** @var UserCart $userCarts */
                $userCarts = $cart->userCarts()->create($data);

                $userCarts->cartDetails()->create($data);

                return $cart->id;
            });

            return $this->successReturn($cartId);
        } catch (Throwable $e) {
            $this->error($e);
            return [
                'status'  => false,
                'code'    => ResponseError::ERROR_501,
                'message' => __('errors.' . ResponseError::ERROR_501, locale: $this->language)
            ];
        }
    }
    #endregion

    /**
     * @param array $data
     * @return array
     */
    public function groupCreate(array $data): array
    {
        $locale   = data_get(Language::languagesList()->where('default', 1)->first(), 'locale');

        /** @var Stock $stock */
        $stock = Stock::with([
            'countable:id,status,active,shop_id,min_qty,max_qty,tax,img,interval',
            'countable.unit.translation' => fn($q) => $q->where(fn($q) => $q->where('locale', $this->language)->orWhere('locale', $locale)),
            'countable.discounts' => fn($q) => $q
                ->where('start', '<=', today())
                ->where('end', '>=', today())
                ->where('active', 1)
        ])->find(data_get($data, 'stock_id', 0));

        if (!data_get($stock, 'id') || $stock->countable?->status !== Product::PUBLISHED) {
            return [
                'status' => false,
                'code'   => ResponseError::ERROR_400,
            ];
        }

        $quantity = data_get($data, 'quantity', 0);

        data_set($data, 'price', ($stock->price + $stock->tax_price) * $quantity);
        data_set($data, 'discount', $stock->actual_discount * $quantity);

        $checkQuantity = $this->checkQuantity($stock, $quantity);

        if (!data_get($checkQuantity, 'status')) {
            return $this->errorCheckQuantity($checkQuantity);
        }

        /**
         * @var Cart $model
         * @var UserCart $userCart
         */
        $model    = $this->model()->find(data_get($data, 'cart_id', 0));
        $userCart = $model->userCarts->where('uuid', data_get($data, 'user_cart_uuid'))->first();

        if (!$userCart) {
            return [
                'status'  => false,
                'code'    => ResponseError::ERROR_404,
                'message' => ResponseError::USER_CARTS_IS_EMPTY
            ];
        }

        try {
            if ($model->shop_id !== data_get($stock->countable, 'shop_id')) {
                return [
                    'status'  => true,
                    'code'    => ResponseError::ERROR_440,
                    'message' => __('errors.' . ResponseError::OTHER_SHOP, locale: $this->language)
                ];
            }

            $cartId = DB::transaction(function () use ($data, $model, $userCart) {

                $userCart->cartDetails()->updateOrCreate([
                    'stock_id'      => data_get($data, 'stock_id'),
                    'user_cart_id'  => $userCart->id,
                    'parent_id'     => data_get($data, 'parent_id'),
                ], [
                    'quantity'      => data_get($data, 'quantity', 0),
                    'price'         => data_get($data, 'price', 0),
                    'discount'      => data_get($data, 'discount', 0),
                ]);

                return $model->id;
            });

            return $this->successReturn($cartId);
        } catch (Throwable $e) {
            $this->error($e);
            return [
                'status'  => false,
                'code'    => ResponseError::ERROR_501,
                'message' => __('errors.' . ResponseError::ERROR_501, locale: $this->language)
            ];
        }
    }

    /**
     * @param array $data
     * @return array
     */
    public function groupInsertProducts(array $data): array
    {
        $userCart = clone UserCart::where('uuid', data_get($data, 'user_cart_uuid'))->first();

        $model = $userCart?->cart?->loadMissing([
            'shop',
            'userCarts.cartDetails' => fn($q) => $q->whereNull('parent_id'),
            'userCarts.cartDetails.stock.countable.discounts' => fn($q) => $q->where('start', '<=', today())
                ->where('end', '>=', today())
                ->where('active', 1),
            'userCarts.cartDetails.stock.countable:id,status,active,shop_id,min_qty,max_qty,tax,img,interval',
            'userCarts.cartDetails.children.stock.countable:id,status,active,shop_id,min_qty,max_qty,tax,img,interval',
        ]);

        if (empty($model)) {
            return [
                'status'  => true,
                'code'    => ResponseError::ERROR_404,
                'message' => __('errors.' . ResponseError::ERROR_404, locale: $this->language)
            ];
        }

        try {
            /** @var UserCart $userCart */
            $cartId = $this->collectProducts($data, $model, $userCart);

            return $this->successReturn($cartId);
        } catch (Throwable $e) {
            $this->error($e);
            return [
                'status'  => false,
                'code'    => ResponseError::ERROR_501,
                'message' => __('errors.' . ResponseError::ERROR_501, locale: $this->language)
            ];
        }
    }

    /**
     * @param array $data
     * @return array
     */
    public function openCart(array $data): array
    {
        $cart = $this->model()
            ->with('userCarts')
            ->where('shop_id', data_get($data, 'shop_id', 0))
            ->find(data_get($data, 'cart_id', 0));

        if (empty($cart)) {
            return [
                'status'  => true,
                'code'    => ResponseError::ERROR_404,
                'message' => __('errors.' . ResponseError::ERROR_404, locale: $this->language)
            ];
        }

        if (empty(data_get($data, 'user_id'))) {
            $data['user_id']  = auth('sanctum')->id();
        }

        /** @var Cart $cart */
        $model = $cart->userCart()->create($data);

        return ['status' => true, 'code' => ResponseError::NO_ERROR, 'data' => $model];
    }

    /**
     * @param array $data
     * @return array
     */
    public function openCartOwner(array $data): array
    {
        /** @var User $user */
        /** @var Cart $cart */

        $user = auth('sanctum')->user();

        if (!empty(data_get($data, 'user_id')) && $user && $user->hasRole(['admin', 'seller'])) {
            $user = User::find(data_get($data, 'user_id'));
        }

        $model = $this->model();
        $cart  = $model->with('userCarts')->where('owner_id', $user->id)->first();

        if ($cart?->userCart) {
            return [
                'status'  => false,
                'code'    => ResponseError::ERROR_440,
                'message' => __('errors.' . ResponseError::OTHER_SHOP, locale: $this->language)
            ];
        }

        try {
            $cartId = DB::transaction(function () use ($data, $user) {

                $cart = $this->model()
                    ->firstOrCreate([
                        'shop_id' => data_get($data, 'shop_id', 0),
                        'owner_id' => $user->id,
                    ], $data);

                $cart->userCarts()
                    ->firstOrCreate([
                        'cart_id' => $cart->id,
                        'user_id' => $user->id,
                    ], $data);

                return $cart->id;
            });

            return $this->successReturn($cartId);
        } catch (Throwable $e) {
            $this->error($e);
            return [
                'status'  => false,
                'code'    => ResponseError::ERROR_501,
                'message' => __('errors.' . ResponseError::ERROR_501, locale: $this->language)
            ];
        }
    }

    /**
     * @param array|null $ids
     * @return array
     */
    public function delete(?array $ids = []): array
    {
        foreach ($this->model()->whereIn('id', is_array($ids) ? $ids : [])->get() as $cart) {
            $cart->delete();
        }

        return ['status' => true, 'code' => ResponseError::NO_ERROR];
    }

    /**
     * @param $ownerId
     * @return array
     */
    public function myDelete($ownerId): array
    {
        foreach ($this->model()->where('owner_id', $ownerId)->get() as $cart) {
            $cart->delete();
        }

        return ['status' => true, 'code' => ResponseError::NO_ERROR];
    }

    /**
     * @param array|null $ids
     * @return array
     */
    public function cartProductDelete(?array $ids = []): array
    {
        try {
            $data = DB::transaction(function () use ($ids) {

                /** @var CartDetail $cartDetail */
                $cartDetails = CartDetail::with([
                    'userCart.cart.shop.bonus',
                    'stock.bonus'
                ])
                    ->whereIn('id', is_array($ids) ? $ids : [])
                    ->get();

                $cart = $cartDetails->first()?->userCart?->cart;

                foreach ($cartDetails as $cartDetail) {

                    $cartDetail->userCart?->cart?->decrement(
                        'total_price',
                        $cartDetail->price - $cartDetail->discount
                    );

                    if ($cartDetail->stock?->bonus?->bonus_stock_id) {
                        DB::table('cart_details')
                            ->where('stock_id', $cartDetail->stock->bonus->bonus_stock_id)
                            ->where('user_cart_id', $cartDetail->userCart?->id)
                            ->where('bonus', true)
                            ->delete();
                    }

                    $cartDetail->children()->delete();
                    $cartDetail->delete();
                }

                if (!$cart) {
                    return [
                        'status' => false,
                        'code'   => ResponseError::ERROR_400,
                        'data'   => null,
                    ];
                }

                return $this->successReturn($cart->id);
            });

            return [
                'status'  => true,
                'message' => __('errors.' . ResponseError::NO_ERROR, locale: $this->language),
                'data'      => $data,
            ];
        } catch (Throwable $e) {
            return [
                'status'  => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * @param array|null $ids
     * @param int|null $cartId
     * @return array
     */
    public function userCartDelete(?array $ids = [], ?int $cartId = null): array
    {
        /** @var Cart $cart */
        $cart = $this->model()->with([
            'shop:id',
            'shop.bonus',
            'userCarts' => fn($q) => $q->whereIn('uuid', is_array($ids) ? $ids : []),
            'userCarts.cartDetails.stock.bonus',
        ])->find($cartId);

        if (!$cart?->userCarts) {
            return [
                'status'  => true,
                'code'    => ResponseError::ERROR_404,
                'message' => __('errors.' . ResponseError::ERROR_404, locale: $this->language)
            ];
        }

        $cart->userCarts()->whereIn('uuid', is_array($ids) ? $ids : [])->delete();

        $this->calculateTotalPrice(
            $cart->fresh([
                'userCarts.cartDetails.stock.countable',
                'userCarts.cartDetails.stock.bonus',
            ])
        );

        return $this->successReturn($cartId);
    }

    /**
     * @param string $uuid
     * @param int $cartId
     * @return array
     */
    public function statusChange(string $uuid, int $cartId): array
    {
        $cart = $this->model()->with([
            'userCart' => fn($query) => $query->where('uuid', $uuid)
        ])
            ->whereHas('userCart', fn($query) => $query->where('uuid', $uuid))
            ->find($cartId);

        if (empty($cart)) {
            return [
                'status'  => true,
                'code'    => ResponseError::ERROR_404,
                'message' => __('errors.' . ResponseError::ERROR_404, locale: $this->language)
            ];
        }

        /** @var Cart $cart */
        $cart->userCart->update(['status' => !$cart->userCart->status]);

        return [
            'status' => true,
            'code' => ResponseError::NO_ERROR,
            'data' => CartResource::make($cart),
        ];
    }

    /**
     * @param int|null $id
     * @return array
     */
    public function setGroup(?int $id): array
    {

        $cart = $this->model()->with([
            'userCart' => fn($query) => $query->where('user_id', auth('sanctum')->id())
        ])
            ->whereHas('userCart', fn($query) => $query->where('user_id', auth('sanctum')->id()))
            ->find($id);

        if (empty($cart)) {
            return [
                'status'  => true,
                'code'    => ResponseError::ERROR_404,
                'message' => __('errors.' . ResponseError::ERROR_404, locale: $this->language)
            ];
        }

        /** @var Cart $cart */
        $cart->update(['group' => !$cart->group]);

        return [
            'status' => true,
            'code'   => ResponseError::NO_ERROR,
            'data'   => $cart
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    public function insertProducts(array $data): array
    {
        /** @var User $user */
        $user = auth('sanctum')->user();

        if (!empty(data_get($data, 'user_id')) && $user && $user->hasRole(['admin', 'seller'])) {
            $user = User::find(data_get($data, 'user_id'));
        }

        $userId           = $user?->id;

        $data['owner_id'] = $userId;
        $data['user_id']  = $userId;
        $data['rate']     = Currency::find($data['currency_id'])->rate;

        /** @var Cart $exist */
        $exist = $this->model()->select(['id', 'shop_id', 'owner_id'])->where('owner_id', $userId)->first();

        if ($exist && $exist->shop_id !== data_get($data, 'shop_id')) {
            return [
                'status'  => false,
                'code'    => ResponseError::ERROR_440,
                'message' => __('errors.' . ResponseError::OTHER_SHOP, locale: $this->language)
            ];
        }

        $cart = $this->model()->with([
            'shop',
            'userCarts.cartDetails' => fn($q) => $q->whereNull('parent_id'),
            'userCarts.cartDetails.stock.countable.discounts' => fn($q) => $q->where('start', '<=', today())
                ->where('end', '>=', today())
                ->where('active', 1),
            'userCarts.cartDetails.stock.countable:id,status,shop_id,active,min_qty,max_qty,tax,img,interval',
            'userCarts.cartDetails.children.stock.countable:id,status,shop_id,active,min_qty,max_qty,tax,img,interval',
        ])
            ->firstOrCreate([
                'owner_id'  => $userId,
                'shop_id'   => data_get($data, 'shop_id', 0)
            ], $data);

        return $this->cartDetailsUpdate($data, $cart);
    }

    /**
     * @param array $data
     * @param Cart $cart
     * @return array
     */
    private function cartDetailsUpdate(array $data, Cart $cart): array
    {
        /** @var UserCart $userCart */

        /** @var User $user */
        $user = auth('sanctum')->user();

        if (!empty(data_get($data, 'user_id')) && $user && $user->hasRole(['admin', 'seller'])) {
            $user = User::find(data_get($data, 'user_id'));
        }

        $userCart = $cart->userCarts()->firstOrCreate([
            'user_id' => $user->id,
            'cart_id' => $cart->id,
        ], [
            'uuid'    => Str::uuid()
        ]);

        $cartId = $this->collectProducts($data, $cart, $userCart);

        return $this->successReturn($cartId);
    }

    /**
     * @param array $data
     * @param Cart $cart
     * @param UserCart $userCart
     * @return int
     */
    /**
     * @param array $data
     * @param Cart $cart
     * @param UserCart $userCart
     * @return int
     */
    /**
     * @param array $data
     * @param Cart $cart
     * @param UserCart $userCart
     * @return int
     */
    /**
     * @param array $data
     * @param Cart $cart
     * @param UserCart $userCart
     * @return int
     */
    /**
     * @param array $data
     * @param Cart $cart
     * @param UserCart $userCart
     * @return int
     */
    /**
     * @param array $data
     * @param Cart $cart
     * @param UserCart $userCart
     * @return int
     */
    /**
     * @param array $data
     * @param Cart $cart
     * @param UserCart $userCart
     * @return int
     */
    /**
     * @param array $data
     * @param Cart $cart
     * @param UserCart $userCart
     * @return int
     */
    private function collectProducts(array $data, Cart $cart, UserCart $userCart): int
    {
        try {
            //            $result =
            //                DB::transaction(function () use ($data, $cart, $userCart) {
            Log::debug('Starting collectProducts', [
                'cart_id' => $cart->id,
                'user_cart_id' => $userCart->id,
                'products' => data_get($data, 'products', []),
            ]);

            // Delete existing bonus cart details
            DB::table('cart_details')
                ->where('user_cart_id', $userCart->id)
                ->where('bonus', true)
                ->delete();
            Log::debug('Deleted existing bonus cart details for user_cart_id', ['user_cart_id' => $userCart->id]);

            $products = collect(data_get($data, 'products', []));
            $addons = $products->whereNotNull('parent_id')->groupBy('parent_id')->toArray();
            $parents = $products->whereIn('stock_id', array_keys($addons))->toArray();

            if (empty($parents)) {
                $parents = $products;
            }
            Log::debug('Processed products', [
                'parent_count' => count($parents),
                'addon_count' => count($addons),
            ]);

            foreach ($parents as $parent) {
                Log::debug('Processing parent product', [
                    'stock_id' => data_get($parent, 'stock_id'),
                    'quantity' => data_get($parent, 'quantity', 0),
                ]);

                $parentStock = Stock::with([
                    'countable' => fn($q) => $q
                        ->with(['unit'])
                        ->select(['id', 'status', 'active', 'shop_id', 'min_qty', 'max_qty', 'tax', 'img', 'interval', 'is_bogo'])
                        ->where('status', Product::PUBLISHED)
                        ->where('active', 1)
                        ->where('shop_id', data_get($data, 'shop_id')),
                    'countable.discounts' => fn($q) => $q
                        ->where('start', '<=', today())
                        ->where('end', '>=', today())
                        ->where('active', 1)
                ])
                    ->whereHas(
                        'countable',
                        fn($q) => $q
                            ->where('status', Product::PUBLISHED)
                            ->where('active', 1)
                            ->where('shop_id', data_get($data, 'shop_id'))
                    )
                    ->find(data_get($parent, 'stock_id'));

                if (!$parentStock) {
                    Log::warning('Parent stock not found or invalid', [
                        'stock_id' => data_get($parent, 'stock_id'),
                        'shop_id' => data_get($data, 'shop_id'),
                    ]);
                    DB::table('cart_details')
                        ->where([
                            'user_cart_id' => $userCart->id,
                            'stock_id' => data_get($parent, 'stock_id'),
                            'parent_id' => null
                        ])
                        ->delete();
                    continue;
                }

                /** @var Stock $parentStock */
                Log::debug('Parent stock loaded', [
                    'stock_id' => $parentStock->id,
                    'countable_id' => $parentStock->countable_id,
                    'is_bogo' => $parentStock->countable->is_bogo ?? 'not_set',
                    'stock_quantity' => $parentStock->quantity,
                ]);

                $children = collect(data_get($addons, $parentStock->id));
                $childrenIds = $children->pluck('quantity', 'stock_id')->sortDesc()->toArray();
                $quantity = $this->actualQuantity($parentStock, data_get($parent, 'quantity', 0)) ?? 0;

                Log::debug('Quantity calculated', [
                    'stock_id' => $parentStock->id,
                    'requested_quantity' => data_get($parent, 'quantity', 0),
                    'actual_quantity' => $quantity,
                ]);

                if ((int)$quantity === 0 || (int)$parentStock->quantity === 0) {
                    Log::warning('Invalid quantity or no stock available', [
                        'stock_id' => $parentStock->id,
                        'quantity' => $quantity,
                        'stock_quantity' => $parentStock->quantity,
                    ]);
                    $parent = CartDetail::where([
                        ['stock_id', data_get($parent, 'parent_id')],
                        ['user_cart_id', $userCart->id],
                    ])->first();

                    $cartDetail = CartDetail::where([
                        ['stock_id', $parentStock->id],
                        ['user_cart_id', $userCart->id],
                        ['parent_id', $parent?->id],
                    ])->first();

                    if ($cartDetail) {
                        $cartDetail->children()->delete();
                        $cartDetail->delete();
                        Log::debug('Deleted invalid cart detail', ['cart_detail_id' => $cartDetail->id]);
                    }

                    continue;
                }

                $price = $parentStock->price + $parentStock->tax_price;
                $discount = $parentStock->actual_discount;
                $price *= $quantity;
                $discount *= $quantity;

                Log::debug('Price and discount calculated', [
                    'stock_id' => $parentStock->id,
                    'price' => $price,
                    'discount' => $discount,
                ]);

                $parentCartDetail = CartDetail::where([
                    'user_cart_id' => $userCart->id,
                    'stock_id' => $parentStock->id,
                    'parent_id' => null,
                    'bonus' => false
                ])->first();

                if (!empty($parentCartDetail)) {
                    $parentCartDetail->update([
                        'quantity' => $quantity,
                        'bonus' => false,
                        'price' => $price,
                        'discount' => $discount,
                    ]);
                    Log::debug('Updated parent cart detail', ['cart_detail_id' => $parentCartDetail->id]);
                } else {
                    $parentCartDetail = CartDetail::create([
                        'user_cart_id' => $userCart->id,
                        'stock_id' => $parentStock->id,
                        'parent_id' => null,
                        'quantity' => $quantity,
                        'bonus' => false,
                        'price' => $price,
                        'discount' => $discount,
                    ]);
                    Log::debug('Created parent cart detail', ['cart_detail_id' => $parentCartDetail->id]);
                }

                // Handle BOGO offer for parent product
                if ($parentStock->countable && $parentStock->countable->is_bogo === 1) {
                    Log::debug('BOGO condition met', [
                        'stock_id' => $parentStock->id,
                        'is_bogo' => $parentStock->countable->is_bogo,
                        'stock_quantity' => $parentStock->quantity,
                        'required_quantity' => $quantity,
                    ]);

                    if ($parentStock->quantity >= $quantity) {
                        // Check if a BOGO entry already exists for this stock_id
                        $existingBogo = CartDetail::where([
                            'user_cart_id' => $userCart->id,
                            'stock_id' => $parentStock->id,
                            'parent_id' => null,
                            'bonus' => true
                        ])->first();

                        if (!$existingBogo) {
                            try {
                                $bogoCartDetail = CartDetail::create([
                                    'user_cart_id' => $userCart->id,
                                    'stock_id' => $parentStock->id,
                                    'parent_id' => null,
                                    'quantity' => $quantity,
                                    'bonus' => true,
                                    'price' => 0,
                                    'discount' => 0,
                                ]);
                                Log::info('Created BOGO cart detail', [
                                    'cart_detail_id' => $bogoCartDetail->id,
                                    'stock_id' => $parentStock->id,
                                    'user_cart_id' => $userCart->id,
                                    'quantity' => $quantity,
                                ]);
                            } catch (\Exception $e) {
                                Log::error('Failed to create BOGO cart detail', [
                                    'stock_id' => $parentStock->id,
                                    'error' => $e->getMessage(),
                                    'trace' => $e->getTraceAsString(),
                                ]);
                            }
                        } else {
                            Log::debug('BOGO cart detail already exists, skipping creation', [
                                'cart_detail_id' => $existingBogo->id,
                            ]);
                        }
                    } else {
                        Log::warning('Insufficient stock for BOGO', [
                            'stock_id' => $parentStock->id,
                            'stock_quantity' => $parentStock->quantity,
                            'required_quantity' => $quantity,
                        ]);
                    }
                } else {
                    Log::debug('BOGO not applicable', [
                        'stock_id' => $parentStock->id,
                        'is_bogo' => $parentStock->countable->is_bogo ?? 'not_set',
                    ]);
                }

                if (!empty($childrenIds)) {
                    Log::debug('Processing add-ons', ['addon_count' => count($children)]);
                    foreach ($children as $child) {
                        Log::debug('Processing child product', [
                            'stock_id' => data_get($child, 'stock_id'),
                            'quantity' => data_get($child, 'quantity', 0),
                        ]);

                        $childStock = Stock::with([
                            'countable' => fn($q) => $q
                                ->with(['unit'])
                                ->select(['id', 'status', 'active', 'shop_id', 'min_qty', 'max_qty', 'tax', 'img', 'interval'])
                                ->where('status', Product::PUBLISHED)
                                ->where('active', 1)
                                ->where('shop_id', data_get($data, 'shop_id')),
                            'countable.discounts' => fn($q) => $q
                                ->where('start', '<=', today())
                                ->where('end', '>=', today())
                                ->where('active', 1)
                        ])
                            ->whereHas(
                                'countable',
                                fn($q) => $q
                                    ->where('status', Product::PUBLISHED)
                                    ->where('active', 1)
                                    ->where('shop_id', data_get($data, 'shop_id'))
                            )
                            ->find(data_get($child, 'stock_id'));

                        if (empty($childStock)) {
                            Log::warning('Child stock not found or invalid', [
                                'stock_id' => data_get($child, 'stock_id'),
                                'shop_id' => data_get($data, 'shop_id'),
                            ]);
                            DB::table('cart_details')
                                ->where([
                                    'user_cart_id' => $userCart->id,
                                    'stock_id' => data_get($child, 'stock_id'),
                                    'parent_id' => $parentCartDetail->id
                                ])
                                ->delete();
                            continue;
                        }

                        /** @var Stock $childStock */
                        $childQuantity = $this->actualQuantity($childStock, data_get($child, 'quantity', 0)) ?? 0;

                        Log::debug('Child quantity calculated', [
                            'stock_id' => $childStock->id,
                            'requested_quantity' => data_get($child, 'quantity', 0),
                            'actual_quantity' => $childQuantity,
                        ]);

                        if ((int)$childQuantity === 0 || (int)$childStock->quantity === 0) {
                            Log::warning('Invalid child quantity or no stock', [
                                'stock_id' => $childStock->id,
                                'quantity' => $childQuantity,
                                'stock_quantity' => $childStock->quantity,
                            ]);
                            $cartDetail = CartDetail::where([
                                'stock_id' => $parentStock->id,
                                'user_cart_id' => $userCart->id,
                                'parent_id' => $parentCartDetail?->id,
                            ])->first();

                            if ($cartDetail) {
                                $cartDetail->children()->delete();
                                $cartDetail->delete();
                                Log::debug('Deleted invalid child cart detail', ['cart_detail_id' => $cartDetail->id]);
                            }

                            continue;
                        }

                        $childPrice = $childStock->price + $childStock->tax_price;
                        $childDiscount = $childStock->actual_discount;
                        $childPrice *= $childQuantity;
                        $childDiscount *= $childQuantity;

                        Log::debug('Child price and discount calculated', [
                            'stock_id' => $childStock->id,
                            'price' => $childPrice,
                            'discount' => $childDiscount,
                        ]);

                        $cartDetail = CartDetail::where([
                            'user_cart_id' => $userCart->id,
                            'stock_id' => $childStock->id,
                            'parent_id' => $parentCartDetail->id
                        ])->first();

                        if (empty($cartDetail)) {
                            $cartDetail = CartDetail::create([
                                'user_cart_id' => $userCart->id,
                                'stock_id' => $childStock->id,
                                'parent_id' => $parentCartDetail->id,
                                'quantity' => $childQuantity,
                                'bonus' => false,
                                'price' => $childPrice,
                                'discount' => $childDiscount
                            ]);
                            Log::debug('Created child cart detail', ['cart_detail_id' => $cartDetail->id]);
                        } else {
                            $cartDetail->update([
                                'quantity' => $childQuantity,
                                'bonus' => false,
                                'price' => $childPrice,
                                'discount' => $childDiscount
                            ]);
                            Log::debug('Updated child cart detail', ['cart_detail_id' => $cartDetail->id]);
                        }
                    }
                }
            }

            // Verify cart details within transaction
            $finalCartDetails = DB::table('cart_details')
                ->where('user_cart_id', $userCart->id)
                ->get();
            Log::debug('Cart details within transaction', [
                'user_cart_id' => $userCart->id,
                'details' => $finalCartDetails->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'stock_id' => $item->stock_id,
                        'parent_id' => $item->parent_id,
                        'quantity' => $item->quantity,
                        'bonus' => $item->bonus,
                        'price' => $item->price,
                        'discount' => $item->discount,
                    ];
                })->all(),
            ]);
            Log::info('Collect products completed', [
                'cart_id' => $cart->id,
                'user_cart_id' => $userCart->id,
            ]);
            $result = data_get($cart, 'id');
            //            });

            // Verify cart details after transaction commit with timestamp and delay
            //            sleep(2); // Wait 2 seconds to detect any immediate cleanup
            $postCommitCartDetails = DB::table('cart_details')
                ->where('user_cart_id', $userCart->id)
                ->get();
            Log::debug('Cart details after transaction at ' . now()->toDateTimeString() . ' (after 2s delay)', [
                'user_cart_id' => $userCart->id,
                'details' => $postCommitCartDetails->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'stock_id' => $item->stock_id,
                        'parent_id' => $item->parent_id,
                        'quantity' => $item->quantity,
                        'bonus' => $item->bonus,
                        'price' => $item->price,
                        'discount' => $item->discount,
                    ];
                })->all(),
            ]);

            // Calculate total price for the cart
            $this->calculateTotalPrice($cart);

            // Collect products bonus
            foreach ($cart->userCarts as $userCart) {
                foreach ($userCart->cartDetails as $cartDetail) {
                    $this->bonus($cartDetail, $userCart);
                }
            }
            return $result;
        } catch (Throwable $e) {
            Log::error('Error in collectProducts', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return 0;
        }
    }

    /**
     * @todo Telegram bot not used for web,mobile
     * @param CartDetail $cartDetail
     * @param UserCart $userCart
     * @return void
     */
    public function bonus(CartDetail $cartDetail, UserCart $userCart): void
    {
        $stock = $cartDetail->stock;

        /** @var Bonus $bonusStock */
        $bonusStock = Bonus::with([
            'stock.countable',
        ])->where([
            ['bonusable_id', data_get($stock, 'id', 0)],
            ['bonusable_type', Stock::class],
            ['expired_at', '>', now()],
        ])
            ->first();

        /** @var Bonus $bonusShop */
        $bonusShop = Bonus::with([
            'shop',
            'stock.countable',
        ])->where([
            ['bonusable_id', data_get($cartDetail->userCart, 'cart.shop_id')],
            ['bonusable_type', Shop::class],
            ['expired_at', '>', now()],
        ])
            ->first();

        if (data_get($bonusStock, 'id') && data_get($bonusStock, 'stock.id')) {
            $this->checkBonus($userCart, $bonusStock, $bonusStock->stock?->id, $cartDetail->quantity);
        }

        if (data_get($bonusShop, 'id') && data_get($bonusShop, 'stock.id')) {
            $this->checkBonus($userCart, $bonusShop, $bonusShop->stock?->id, $cartDetail->quantity);
        }
    }

    /**
     * @param UserCart $userCart
     * @param Bonus $bonus
     * @param int $stockId
     * @param int $quantity
     * @return void
     */
    public function checkBonus(UserCart $userCart, Bonus $bonus, int $stockId, int $quantity): void
    {
        try {

            /** @var Stock|null $stock */
            $stock = Stock::with(['countable'])->find($stockId);

            if (
                ($bonus->type === Bonus::TYPE_COUNT && $quantity < $bonus->value)
                || empty($bonus->stock?->quantity)
                || !$bonus->status
                || !$bonus->stock?->countable?->active
                || $bonus->stock?->countable?->status != Product::PUBLISHED

                || empty($stock?->quantity)
                || !$stock?->countable?->active
                || $stock?->countable?->status != Product::PUBLISHED
            ) {
                CartDetail::where([
                    'stock_id'      => $bonus->bonus_stock_id,
                    'user_cart_id'  => $userCart->id,
                    'price'         => 0,
                    'bonus'         => 1,
                    'discount'      => 0,
                    'bonus_type'    => $bonus->bonusable_type,
                ])->delete();

                return;
            }

            $userCart->cartDetails()->updateOrCreate([
                'stock_id'      => $bonus->bonus_stock_id,
                'user_cart_id'  => $userCart->id,
                'price'         => 0,
                'bonus'         => 1,
                'discount'      => 0,
                'bonus_type'    => Bonus::BONUS_TYPE_PRODUCT,
            ], [
                'quantity' => $bonus->type === Bonus::TYPE_COUNT ?
                    $bonus->bonus_quantity * (int)floor($quantity / $bonus->value) :
                    $bonus->bonus_quantity,
            ]);
        } catch (Throwable $e) {
            $this->error($e);
        }
    }

    /**
     * @param Stock $stock
     * @param int $quantity
     * @return array
     */
    protected function checkQuantity(Stock $stock, int $quantity): array
    {
        if ($stock->quantity < $quantity) {
            return [
                'status'   => false,
                'code'     => ResponseError::NO_ERROR,
                'quantity' => $stock->quantity,
            ];
        }

        $countable  = $stock->countable;
        $minQty     = $countable?->min_qty ?? 0;
        $maxQty     = $countable?->max_qty ?? 0;

        if ($quantity < $minQty || $quantity > $maxQty) {
            return [
                'status'   => false,
                'code'     => ResponseError::NO_ERROR,
                'quantity' => "$minQty-$maxQty",
            ];
        }

        return ['status' => true, 'code' => ResponseError::NO_ERROR,];
    }

    /**
     * @param array $checkQuantity
     * @return array
     */
    private function errorCheckQuantity(array $checkQuantity): array
    {
        $data = ['quantity' => data_get($checkQuantity, 'quantity', 0)];

        return [
            'status'  => false,
            'code'    => ResponseError::ERROR_111,
            'message' => __('errors.' . ResponseError::ERROR_111, $data, $this->language),
            'data'    => $data
        ];
    }

    /**
     * @param Stock $stock
     * @param $quantity
     * @return int|mixed|null
     */
    private function actualQuantity(Stock $stock, $quantity): mixed
    {
        $countable = $stock->countable;
        //		$cartDetailsSumQuantity = CartDetail::where('stock_id', $stock->id)->sum('quantity');
        //
        //		if ($cartDetailsSumQuantity > $stock->quantity) {
        //			return 0;
        //		}

        if ($quantity === 0) {
            return 0;
        }

        if ($quantity < ($countable?->min_qty ?? 0)) {

            $quantity = $countable->min_qty;
        } else if ($quantity > ($countable?->max_qty ?? 0)) {

            $quantity = $countable->max_qty;
        }

        return $quantity > $stock->quantity ? max($stock->quantity, 0) : $quantity;
    }

    /**
     * @param int $cartId
     * @return array
     */
    private function successReturn(int $cartId): array
    {
        /** @var Cart $cart */
        $locale = data_get(Language::languagesList()->where('default', 1)->first(), 'locale');

        if (empty($this->language)) {
            $this->language = $locale;
        }

        $cart = $this->model()->with([
            'userCarts.cartDetails:id,user_cart_id,stock_id,price,discount,quantity,bonus_type',
            'userCarts.cartDetails.stock.bonus' => fn($q) => $q->where('expired_at', '>', now()),
            'shop',
            'shop.bonus' => fn($q) => $q->where('expired_at', '>', now()),
        ])
            ->select('id', 'total_price', 'shop_id')
            ->find($cartId);

        if (empty($cart)) {
            return [
                'status'  => false,
                'code'    => ResponseError::ERROR_502,
                'message' => __('errors.' . ResponseError::ERROR_502, locale: $this->language),
            ];
        }

        $this->calculateTotalPrice($cart);

        $cart = $this->model()->with([
            'shop',
            'shop.bonus' => fn($q) => $q->where('expired_at', '>', now())->where('status', true),

            'userCarts.cartDetails' => fn($q) => $q->whereNull('parent_id'),
            'userCarts.cartDetails.stock.bonus' => fn($q) => $q->where('expired_at', '>', now())->where('status', true),
            'userCarts.cartDetails.stock.countable.unit.translation' => fn($q) => $q
                ->where(fn($q) => $q->where('locale', $this->language)->orWhere('locale', $locale)),
            'userCarts.cartDetails.stock.countable.translation' => fn($q) => $q
                ->where(fn($q) => $q->where('locale', $this->language)->orWhere('locale', $locale)),
            'userCarts.cartDetails.stock.stockExtras.group.translation' => fn($q) => $q
                ->where(fn($q) => $q->where('locale', $this->language)->orWhere('locale', $locale)),

            'userCarts.cartDetails.children.stock.bonus' => fn($q) => $q->where('expired_at', '>', now())->where('status', true),
            'userCarts.cartDetails.children.stock.countable.unit.translation' => fn($q) => $q
                ->where(fn($q) => $q->where('locale', $this->language)->orWhere('locale', $locale)),
            'userCarts.cartDetails.children.stock.countable.translation' => fn($q) => $q
                ->where(fn($q) => $q->where('locale', $this->language)->orWhere('locale', $locale)),
            'userCarts.cartDetails.children.stock.stockExtras.group.translation' => fn($q) => $q
                ->where(fn($q) => $q->where('locale', $this->language)->orWhere('locale', $locale)),
        ])->find($cart->id);

        return [
            'status' => true,
            'code'   => ResponseError::NO_ERROR,
            'data'   => CartResource::make($cart),
        ];
    }

    /**
     * @param Cart $cart
     * @return bool
     */
    public function calculateTotalPrice(Cart $cart): bool
    {
        if (empty($cart->userCarts)) {
            return true;
        }

        DB::table('cart_details')
            ->whereIn('user_cart_id', $cart->userCarts->pluck('id')->toArray())
            ->where('bonus', true)
            ->delete();

        $price = 0;

        $inReceipts = [];

        foreach ($cart->userCarts as $userCart) {

            $stocks = [];

            foreach ($userCart->cartDetails as $cartDetail) {

                $isContinue = $this->recalculateCartDetails($cartDetail, $userCart);

                if ($isContinue || $cartDetail->bonus) {
                    continue;
                }

                $price += (max($cartDetail->price, 0) - max($cartDetail->discount, 0));

                $inReceipts[$cartDetail->stock_id] = $cartDetail->quantity;

                if (isset($stocks[$cartDetail->stock_id])) {
                    $stocks[$cartDetail->stock_id] += $cartDetail->quantity;
                    continue;
                }

                $stocks[$cartDetail->stock_id] = $cartDetail->quantity;
            }

            foreach ($stocks as $stockId => $value) {

                $bonus = Bonus::where('type', Bonus::TYPE_COUNT)
                    ->where('bonusable_type', Stock::class)
                    ->where('bonusable_id', $stockId)
                    ->where('value', '<=', $value)
                    ->where('expired_at', '>=', now())
                    ->first();

                if (empty($bonus)) {
                    continue;
                }

                $this->checkBonus($userCart, $bonus, $stockId, (int)$value);
            }
        }

        $receiptDiscount = $this->recalculateReceipt($cart, $inReceipts);

        $cart = $cart->fresh('userCarts');

        $totalPrice = max($price - $receiptDiscount, 0);

        if ($cart?->userCarts?->count() === 0) {
            $totalPrice = 0;
        }

        /** @var UserCart $userCart */
        $userCart = $cart->userCarts?->first();

        $bonus = $cart->shop?->bonus
            ?->where('type', Bonus::TYPE_SUM)
            ?->where('expired_at', '>=', now())
            ?->first();

        $bonusIsActual =
            $bonus?->status
            && $totalPrice >= $bonus?->value
            && !empty($bonus?->stock?->quantity)
            && $bonus?->stock?->countable?->active
            && $bonus?->stock?->countable?->status === Product::PUBLISHED;

        if ($userCart && $bonusIsActual) {

            $userCart->cartDetails()->updateOrCreate([
                'stock_id'      => $bonus->bonus_stock_id,
                'user_cart_id'  => $userCart->id,
                'bonus'         => 1,
                'bonus_type'    => Bonus::BONUS_TYPE_SHOP
            ], [
                'price'            => 0,
                'discount'         => 0,
                'quantity'         => $bonus->bonus_quantity,
            ]);
        }

        return $cart->update(['total_price' => $totalPrice]);
    }

    /**
     * @param CartDetail $cartDetail
     * @param UserCart $userCart
     * @return bool
     */
    public function recalculateCartDetails(CartDetail $cartDetail, UserCart $userCart): bool
    {

        if (
            empty($cartDetail->stock)
            || $cartDetail->quantity === 0
            || !$cartDetail->stock->countable?->active
            || $cartDetail->stock->countable?->status != Product::PUBLISHED
        ) {

            if ($cartDetail->stock?->bonus?->bonus_stock_id) {
                DB::table('cart_details')
                    ->where('stock_id', $cartDetail->stock->bonus->bonus_stock_id)
                    ->where('user_cart_id', $userCart->id)
                    ->where('bonus', true)
                    ->delete();
            }

            $cartDetail->children()->delete();
            $cartDetail->delete();

            return true;
        }

        return false;
    }

    /**
     * @param Cart $cart
     * @param array $inReceipts
     * @return int|float
     */
    public function recalculateReceipt(Cart $cart, array $inReceipts): int|float
    {
        /** @var Receipt|null $receipt */
        $receipts = Receipt::with('stocks')
            ->whereHas('stocks')
            ->where('shop_id', $cart->shop_id)
            ->get();

        return $this->receipts($receipts, $inReceipts);
    }

    /**
     * @param Collection|Receipt[] $receipts
     * @param array $inReceipts
     * @return float|int|null
     */
    public function receipts(array|Collection $receipts, array $inReceipts): float|int|null
    {
        $receiptDiscount    = 0;
        $totalReceiptCount  = 0;

        foreach ($receipts as $receipt) {

            $stocks = $receipt?->stocks?->pluck('pivot.min_quantity', 'id')->toArray();

            $receiptStockIds = array_intersect(array_keys($stocks), array_keys($inReceipts));

            if ($receiptStockIds !== array_keys($stocks)) {
                continue;
            }

            $receiptCount = [];

            foreach ($inReceipts as $key => $inReceipt) {

                if ($inReceipt === data_get($stocks, $key)) {
                    $receiptCount[] = 1;
                    break;
                } else if ($inReceipt > data_get($stocks, $key)) {
                    try {
                        $divideQty = ($inReceipt / data_get($stocks, $key));

                        $receiptCount[] = $divideQty;
                    } catch (Throwable) {
                    }
                }
            }

            $receiptCount = !empty($receiptCount) ? min($receiptCount) : 1;

            $originPrice = $receipt->stocks
                ->reduce(fn(mixed $c, $i) => $c + ($i->total_price * ($i->pivot?->min_quantity ?? 1)));

            $discountPrice = $receipt->discount_type === 0 ? $receipt->discount_price : $originPrice / 100 * $receipt->discount_price;

            $receiptDiscount    += ($discountPrice * $receiptCount);
            $totalReceiptCount  += $receiptCount;
        }

        request()->offsetSet('receipt_discount', $receiptDiscount);
        request()->offsetSet('receipt_count', $totalReceiptCount);

        return $receiptDiscount;
    }
}
