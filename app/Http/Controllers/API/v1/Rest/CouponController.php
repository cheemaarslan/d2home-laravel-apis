<?php

namespace App\Http\Controllers\API\v1\Rest;

use App\Helpers\ResponseError;
use App\Http\Requests\CouponCheckRequest;
use App\Http\Resources\CouponResource;
use App\Models\Coupon;
use App\Models\OrderCoupon;
use App\Repositories\CouponRepository\CouponRepository;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CouponController extends RestBaseController
{
    use ApiResponse;
    private Coupon $model;
    private CouponRepository $repository;

    public function __construct(Coupon $model, CouponRepository $repository)
    {
        parent::__construct();
        $this->model = $model;
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $coupons = $this->repository->couponsList($request->all());

        return CouponResource::collection($coupons);
    }

    /**
     * Handle the incoming request.
     *
     * @param CouponCheckRequest $request
     * @return JsonResponse
     */
    public function check(CouponCheckRequest $request): JsonResponse
    {

        $couponCode = $request->input('coupon');
        $coupon = Coupon::where('name', $couponCode)->first();
       
        $shopId = $request->input('shop_id');

        if ($coupon->for === 'new_user_only') {
            if (\DB::table('coupon_user')->where('user_id', $request->input('user_id'))->where('coupon_id', $coupon->id)->exists()) {
                return $this->onErrorResponse([
                    'code'    => ResponseError::ERROR_251,
                    'message' => __('You already used this coupon', locale: $this->language)
                ]);
            }
        } else {
            $coupon = Coupon::checkCoupon($couponCode, $shopId)->first();
        }

        if (empty($coupon)) {
            return $this->onErrorResponse([
                'code'    => ResponseError::ERROR_250,
                'message' => __('errors.' . ResponseError::ERROR_250, locale: $this->language)
            ]);
        }

        $result = OrderCoupon::where(function ($q) use ($request) {
                $q->where('user_id', $request->input('user_id'))
                    ->orWhere('user_id', auth('sanctum')->id());
            })
            ->where('name', $couponCode)
            ->first();

        if (empty($result)) {
            return $this->successResponse(
                __('errors.' . ResponseError::SUCCESS, locale: $this->language),
                CouponResource::make($coupon)
            );
        }

        return $this->onErrorResponse([
            'code'    => ResponseError::ERROR_251,
            'message' => __('errors.' . ResponseError::ERROR_251, locale: $this->language)
        ]);
    }
}
