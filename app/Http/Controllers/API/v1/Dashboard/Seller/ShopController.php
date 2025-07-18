<?php

namespace App\Http\Controllers\API\v1\Dashboard\Seller;

use DB;
use Throwable;
use App\Models\Shop;
use App\Models\Language;
use App\Helpers\ResponseError;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\ShopResource;
use App\Http\Requests\Shop\StoreRequest;
use App\Services\Interfaces\ShopServiceInterface;

use App\Repositories\Interfaces\ShopRepoInterface;
use App\Services\ShopServices\ShopActivityService;

class ShopController extends SellerBaseController
{

    private ShopRepoInterface $shopRepository;
    private ShopServiceInterface $shopService;

    public function __construct(ShopRepoInterface $shopRepository, ShopServiceInterface $shopService)
    {
        parent::__construct();

        $this->shopRepository = $shopRepository;
        $this->shopService = $shopService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function shopCreate(StoreRequest $request): JsonResponse
    {
        $result = $this->shopService->create($request->all());

        if (!data_get($result, 'status')) {
            return $this->onErrorResponse($result);
        }

        auth('sanctum')->user()?->invitations()->delete();

        return $this->successResponse(
            __('errors.' . ResponseError::RECORD_WAS_SUCCESSFULLY_CREATED, locale: $this->language),
            ShopResource::make(data_get($result, 'data'))
        );

    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     */
    public function shopShow(): JsonResponse
    {
        $locale = data_get(Language::languagesList()->where('default', 1)->first(), 'locale');

        if (empty($this->shop?->uuid)) {
            return $this->onErrorResponse([
                'code'      => ResponseError::ERROR_404,
                'message'   => __('errors.' . ResponseError::ERROR_404, locale: $this->language)
            ]);
        }

        $shop = $this->shopRepository->shopDetails($this->shop->uuid);

        if (empty($shop)) {
            return $this->onErrorResponse([
                'code'      => ResponseError::ERROR_404,
                'message'   => __('errors.' . ResponseError::ERROR_404, locale: $this->language)
            ]);
        }

		/** @var Shop $shop */
		try {
			DB::table('shop_subscriptions')
				->where('shop_id', $shop->id)
				->whereDate('expired_at', '<=', now())
				->delete();
		} catch (Throwable) {}

        return $this->successResponse(
            __('errors.' . ResponseError::NO_ERROR),
            ShopResource::make($shop->load([
				'translations',
				'seller.wallet',
				'subscription' => fn($q) => $q->where('expired_at', '>=', now())->where('active', true),
				'subscription.subscription',
				'tags.translation' => fn($q) => $q->where(fn($q) => $q->where('locale', $this->language)->orWhere('locale', $locale)),
			]))
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function shopUpdate(StoreRequest $request): JsonResponse
    {
        $result = $this->shopService->update($this->shop->uuid, $request->all());

        if (!data_get($result, 'status')) {
            return $this->onErrorResponse($result);
        }

        return $this->successResponse(
            __('errors.' . ResponseError::RECORD_WAS_SUCCESSFULLY_UPDATED),
            ShopResource::make(data_get($result, 'data'))
        );
    }

    /**
     * @return JsonResponse
     */
    public function setWorkingStatus(): JsonResponse
    {
        (new ShopActivityService)->changeOpenStatus($this->shop->uuid);

        return $this->successResponse(
            __('errors.' . ResponseError::RECORD_WAS_SUCCESSFULLY_UPDATED),
            ShopResource::make($this->shop)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy(int $id): void
    {
        //
    }



}