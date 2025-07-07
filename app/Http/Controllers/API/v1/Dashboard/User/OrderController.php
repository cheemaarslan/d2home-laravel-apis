<?php

namespace App\Http\Controllers\API\v1\Dashboard\User;

use Exception;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Settings;
use App\Models\OrderRefund;
use App\Models\OrderRepeat;
use App\Traits\Notification;
use App\Helpers\ResponseError;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\OrderResource;
use App\Http\Requests\FilterParamsRequest;
use App\Http\Requests\Order\AddRepeatRequest;
use App\Http\Requests\Order\AddReviewRequest;
use App\Http\Requests\Order\UserStoreRequest;
use App\Services\OrderService\OrderRepeatService;
use App\Services\OrderService\OrderReviewService;
use App\Services\Interfaces\OrderServiceInterface;
use App\Repositories\Interfaces\OrderRepoInterface;
use App\Services\OrderService\OrderStatusUpdateService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends UserBaseController
{
	use Notification;

	private OrderRepoInterface $orderRepository;
	private OrderServiceInterface $orderService;

	/**
	 * @param OrderRepoInterface $orderRepository
	 * @param OrderServiceInterface $orderService
	 */
	public function __construct(OrderRepoInterface $orderRepository, OrderServiceInterface $orderService)
	{
		parent::__construct();
		$this->orderRepository = $orderRepository;
		$this->orderService = $orderService;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param FilterParamsRequest $request
	 * @return AnonymousResourceCollection
	 */
	public function paginate(FilterParamsRequest $request): AnonymousResourceCollection
	{
		$filter = $request->merge(['user_id' => auth('sanctum')->id()])->all();

		$orders = $this->orderRepository->ordersPaginate($filter, isUser: true);

		return OrderResource::collection($orders);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param UserStoreRequest $request
	 * @return JsonResponse
	 */
	public function store(UserStoreRequest $request): JsonResponse
	{
		
		$validated = $request->validated();

		if ((int)data_get(Settings::where('key', 'order_auto_approved')->first(), 'value') === 1) {
			$validated['status'] = Order::STATUS_ACCEPTED;
		}

		$validated['user_id'] = auth('sanctum')->id();


		// ✅ Coupon logic
		if (!empty($validated['coupon'])) {
			$user = auth('sanctum')->user();
			$coupon = Coupon::where('name', $validated['coupon'])->where('for', 'new_user_only')->first();

			if (!$coupon) {
				return $this->onErrorResponse([
					'code' => ResponseError::ERROR_400,
					'message' => __('Coupon not found.', locale: $this->language),
				]);
			}

			if (!empty($coupon) && $coupon->for === 'new_user_only') {
				// Check if user already has any orders
				$userHasAnyCoupon = DB::table('coupon_user')
				->where('user_id', $user->id)
				->where('coupon_id', $coupon->id)
				->exists();

			if ($userHasAnyCoupon) {
				return $this->onErrorResponse([
					'code' => ResponseError::ERROR_400,
					'message' => __('You have already used a coupon.', locale: $this->language),
				]);
			}

			$validated['coupon_id'] = $coupon->id;
			$validated['discount'] = $coupon->price ?? 0;

			}
		
		}


		$cart = Cart::with([
			'userCarts:id,cart_id',
			'userCarts.cartDetails:id'
		])
			->select('id')
			->find(data_get($validated, 'cart_id'));

		if (empty($cart)) {
			return $this->onErrorResponse([
				'code'      => ResponseError::ERROR_404,
				'message'   => __('errors.' . ResponseError::ERROR_404, locale: $this->language)
			]);
		}

		/** @var Cart $cart */
		if ($cart->user_carts_count === 0) {
			return $this->onErrorResponse([
				'code'    => ResponseError::ERROR_400,
				'message' => __('errors.' . ResponseError::USER_CARTS_IS_EMPTY, locale: $this->language)
			]);
		}

		if ($cart->userCarts()->withCount('cartDetails')->get()->sum('cart_details_count') === 0) {
			return $this->onErrorResponse([
				'code'    => ResponseError::ERROR_400,
				'message' => __('errors.' . ResponseError::PRODUCTS_IS_EMPTY, locale: $this->language)
			]);
		}

		$result = $this->orderService->create($validated);

		if (!data_get($result, 'status')) {
			return $this->onErrorResponse($result);
		}

		//update coupon_user table add order_id
		if (!empty($coupon) && $coupon->for === 'new_user_only') {
				DB::table('coupon_user')->insert([
				'user_id'   => $user->id,
				'coupon_id' => $coupon->id,
				'order_id'  => data_get($result, 'data.id'),
				'used_at'   => now(),
				'created_at' => now(),
				'updated_at' => now(),
			]);
			Log::info('Coupon marked as used', [
				'user_id' => auth('sanctum')->id(),
				'coupon_id' => $validated['coupon_id'],
			]);
		}

		return $this->successResponse(
			__('errors.' . ResponseError::RECORD_WAS_SUCCESSFULLY_CREATED, locale: $this->language),
			$this->orderRepository->reDataOrder(data_get($result, 'data'))
		);
	}

	// public function store(UserStoreRequest $request): JsonResponse
	// {
	// 	$validated = $request->validated();

	// 	if ((int)data_get(Settings::where('key', 'order_auto_approved')->first(), 'value') === 1) {
	// 		$validated['status'] = Order::STATUS_ACCEPTED;
	// 	}

	// 	$validated['user_id'] = auth('sanctum')->id();

	// 	// ✅ Coupon logic
	// 	if (!empty($validated['coupon'])) {
	// 		$user = auth('sanctum')->user();
	// 		$coupon = Coupon::where('name', $validated['coupon'])->where('for', 'new_user_only')->first();

	// 		if (!$coupon) {
	// 			return $this->onErrorResponse([
	// 				'code' => ResponseError::ERROR_400,
	// 				'message' => __('Coupon not found.', locale: $this->language),
	// 			]);
	// 		}

	// 		// Check if this coupon is for new users only
	// 		// if ($coupon->is_for_new_users) {
	// 		//     $hasOrders = Order::where('user_id', $user->id)->exists();
	// 		//     if ($hasOrders) {
	// 		//         return $this->onErrorResponse([
	// 		//             'code' => ResponseError::ERROR_400,
	// 		//             'message' => __('This coupon is for new users only.', locale: $this->language),
	// 		//         ]);
	// 		//     }
	// 		// }

	// 		// Check if user already has any coupon (only 1 coupon per user allowed)
	// 		$userHasAnyCoupon = DB::table('coupon_user')
	// 			->where('user_id', $user->id)
	// 			->exists();

	// 		if ($userHasAnyCoupon) {
	// 			return $this->onErrorResponse([
	// 				'code' => ResponseError::ERROR_400,
	// 				'message' => __('You have already used a coupon.', locale: $this->language),
	// 			]);
	// 		}

	// 		// All good, attach coupon to validated data
	// 		$validated['coupon_id'] = $coupon->id;
	// 		$validated['discount'] = $coupon->price ?? 0;

	// 		// Pre-mark the coupon as used (you can also do it after order success)
	// 		DB::table('coupon_user')->insert([
	// 			'user_id'   => $user->id,
	// 			'coupon_id' => $coupon->id,
	// 			'used_at'   => now(),
	// 			'created_at' => now(),
	// 			'updated_at' => now(),
	// 		]);
	// 	}


	// 	// ✅ Cart validation
	// 	$cart = Cart::with([
	// 		'userCarts:id,cart_id',
	// 		// 'userCarts.cartDetails:id'
	// 	])->select('id')
	// 		->find(data_get($validated, 'cart_id'));

	// 	if (empty($cart)) {
	// 		\Log::error('Cart not found', [
	// 			'cart_id' => data_get($validated, 'cart_id'),
	// 			'user_id' => auth('sanctum')->id(),
	// 		]);
	// 		return $this->onErrorResponse([
	// 			'code'      => ResponseError::ERROR_404,
	// 			'message'   => __('errors.' . ResponseError::ERROR_404, locale: $this->language)
	// 		]);
	// 	}

	// 	/** @var Cart $cart */
	// 	if ($cart->user_carts_count === 0) {
	// 		\Log::warning('Cart is empty', [
	// 			'cart_id' => $cart->id,
	// 			'user_id' => auth('sanctum')->id(),
	// 		]);
	// 		return $this->onErrorResponse([
	// 			'code'    => ResponseError::ERROR_400,
	// 			'message' => __('errors.' . ResponseError::USER_CARTS_IS_EMPTY, locale: $this->language)
	// 		]);
	// 	}

	// 	if ($cart->userCarts()->withCount('cartDetails')->get()->sum('cart_details_count') === 0) {
	// 		\Log::warning('Cart has no products', [
	// 			'cart_id' => $cart->id,
	// 			'user_id' => auth('sanctum')->id(),
	// 		]);
	// 		return $this->onErrorResponse([
	// 			'code'    => ResponseError::ERROR_400,
	// 			'message' => __('errors.' . ResponseError::PRODUCTS_IS_EMPTY, locale: $this->language)
	// 		]);
	// 	}

	// 	// ✅ Create the order
	// 	$result = $this->orderService->create($validated);

	// 	if (!data_get($result, 'status')) {
	// 		\Log::error('Order creation failed', [
	// 			'user_id' => auth('sanctum')->id(),
	// 			'validated' => $validated,
	// 			'result' => $result,
	// 		]);
	// 		return $this->onErrorResponse($result);
	// 	}

	// 	// ✅ Mark coupon as used (optional)
	// 	if (!empty($validated['coupon_id'])) {
	// 		DB::table('coupon_user')
	// 			->where('coupon_id', $validated['coupon_id'])
	// 			->where('user_id', auth('sanctum')->id())
	// 			->update(['used_at' => now()]);
	// 		\Log::info('Coupon marked as used', [
	// 			'user_id' => auth('sanctum')->id(),
	// 			'coupon_id' => $validated['coupon_id'],
	// 		]);
	// 	}

	// 	return $this->successResponse(
	// 		__('errors.' . ResponseError::RECORD_WAS_SUCCESSFULLY_CREATED, locale: $this->language),
	// 		$this->orderRepository->reDataOrder(data_get($result, 'data'))
	// 	);
	// }

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return JsonResponse
	 */
	public function show(int $id): JsonResponse
	{
		$order = $this->orderRepository->orderById($id, userId: auth('sanctum')->id());

		if (optional($order)->user_id !== auth('sanctum')->id()) {
			return $this->onErrorResponse([
				'code'    => ResponseError::ERROR_404,
				'message' => __('errors.' . ResponseError::ORDER_NOT_FOUND, locale: $this->language)
			]);
		}

		return $this->successResponse(ResponseError::NO_ERROR, $this->orderRepository->reDataOrder($order));
	}

	/**
	 * Add Review to Order.
	 *
	 * @param int $id
	 * @param AddReviewRequest $request
	 * @return JsonResponse
	 */
	public function addOrderReview(int $id, AddReviewRequest $request): JsonResponse
	{
		/** @var Order $order */
		$order = Order::with(['review', 'reviews'])->where('user_id', auth('sanctum')->id())->find($id);

		if (!$order) {
			return $this->onErrorResponse([
				'code'    => ResponseError::ERROR_404,
				'message' =>  __('errors.' . ResponseError::ORDER_NOT_FOUND, locale: $this->language)
			]);
		}

		$result = (new OrderReviewService)->addReview($order, $request->validated());

		if (!data_get($result, 'status')) {
			return $this->onErrorResponse($result);
		}

		return $this->successResponse(
			ResponseError::NO_ERROR,
			$this->orderRepository->reDataOrder(data_get($result, 'data'))
		);
	}

	/**
	 * Add Review to Deliveryman.
	 *
	 * @param int $id
	 * @param AddReviewRequest $request
	 * @return JsonResponse
	 */
	public function addDeliverymanReview(int $id, AddReviewRequest $request): JsonResponse
	{
		$result = (new OrderReviewService)->addDeliverymanReview($id, $request->validated());

		if (!data_get($result, 'status')) {
			return $this->onErrorResponse($result);
		}

		return $this->successResponse(
			ResponseError::NO_ERROR,
			$this->orderRepository->reDataOrder(data_get($result, 'data'))
		);
	}

	/**
	 * Add Review to Waiter.
	 *
	 * @param int $id
	 * @param AddReviewRequest $request
	 * @return JsonResponse
	 */
	public function addWaiterReview(int $id, AddReviewRequest $request): JsonResponse
	{
		$result = (new OrderReviewService)->addWaiterReview($id, $request->validated());

		if (!data_get($result, 'status')) {
			return $this->onErrorResponse($result);
		}

		return $this->successResponse(
			ResponseError::NO_ERROR,
			$this->orderRepository->reDataOrder(data_get($result, 'data'))
		);
	}

	/**
	 * @param int $id
	 * @param FilterParamsRequest $request
	 * @return JsonResponse
	 */
	public function orderStatusChange(int $id, FilterParamsRequest $request): JsonResponse
	{
		/** @var Order $order */
		$order = Order::with([
			'shop.seller',
			'deliveryMan',
			'user.wallet',
		])
			->where('user_id', auth('sanctum')->id())
			->find($id);

		if (!$order) {
			return $this->onErrorResponse([
				'code'    => ResponseError::ERROR_404,
				'message' => __('errors.' . ResponseError::ERROR_404, locale: $this->language)
			]);
		}

		if (!$request->input('status')) {
			return $this->onErrorResponse([
				'code'    => ResponseError::ERROR_254,
				'message' => __('errors.' . ResponseError::EMPTY_STATUS, locale: $this->language)
			]);
		}

		if ($order->status !== Order::STATUS_NEW) {
			return $this->onErrorResponse([
				'code'    => ResponseError::ERROR_254,
				'message' => __('errors.' . ResponseError::ERROR_254, locale: $this->language)
			]);
		}

		$result = (new OrderStatusUpdateService)->statusUpdate($order, $request->input('status'));

		if (!data_get($result, 'status')) {
			return $this->onErrorResponse($result);
		}

		return $this->successResponse(
			ResponseError::NO_ERROR,
			$this->orderRepository->reDataOrder(data_get($result, 'data'))
		);
	}

	/**
	 * @param int $id
	 * @param AddRepeatRequest $request
	 * @return JsonResponse
	 * @throws Exception
	 */
	public function repeatOrder(int $id, AddRepeatRequest $request): JsonResponse
	{
		$order = Order::whereDoesntHave('orderRefunds', fn($q) => $q->where('status', OrderRefund::STATUS_ACCEPTED))
			->where('user_id', auth('sanctum')->id())
			->where('status', Order::STATUS_DELIVERED)
			->find($id);

		if (!$order) {
			return $this->onErrorResponse([
				'code'    => ResponseError::ERROR_404,
				'message' => __('errors.' . ResponseError::ERROR_404, locale: $this->language)
			]);
		}

		$result = (new OrderRepeatService)->create($order, $request->validated());

		return $this->successResponse(ResponseError::NO_ERROR, $result);
	}

	/**
	 * @param int $id
	 * @return JsonResponse
	 * @throws Exception
	 */
	public function repeatOrderDelete(int $id): JsonResponse
	{
		$order = OrderRepeat::whereHas('order', fn($q) => $q->where('user_id', auth('sanctum')->id()))
			->find($id);

		if (!$order) {
			return $this->onErrorResponse([
				'code'    => ResponseError::ERROR_404,
				'message' => __('errors.' . ResponseError::ERROR_404, locale: $this->language)
			]);
		}

		(new OrderRepeatService)->del($order);

		return $this->successResponse(ResponseError::NO_ERROR);
	}
}
