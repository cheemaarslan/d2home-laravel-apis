<?php

namespace App\Http\Controllers\API\v1\Dashboard\Admin;

use Throwable;
use App\Models\Shop;
use App\Models\User;
use App\Models\Settings;
use App\Exports\ShopExport;
use App\Imports\ShopImport;
use Illuminate\Http\Request;
use App\Helpers\ResponseError;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\ShopResource;

use App\Repositories\SellerFinanceRepository;

use Illuminate\Http\Response;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\OrderResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Shop\StoreRequest;
use App\Http\Requests\FilterParamsRequest;
use App\Http\Requests\Shop\ImageDeleteRequest;
use App\Services\Interfaces\ShopServiceInterface;
use App\Services\ShopServices\ShopActivityService;
use App\Http\Requests\Shop\ShopStatusChangeRequest;
use App\Repositories\UserRepository\UserRepository;
use App\Repositories\ShopRepository\AdminShopRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ShopController extends AdminBaseController
{
    private ShopServiceInterface $service;
    private AdminShopRepository $repository;
    private UserRepository $userRepository;

    public function __construct(ShopServiceInterface $service, AdminShopRepository $repository, UserRepository $userRepository)
    {
        parent::__construct();

        $this->service    = $service;
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $shops = $this->repository->shopsList($request->all());

        return $this->successResponse(
            __('errors.' . ResponseError::SUCCESS, locale: $this->language),
            ShopResource::collection($shops)
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @param FilterParamsRequest $request
     * @return AnonymousResourceCollection
     */
    public function paginate(FilterParamsRequest $request): AnonymousResourceCollection
    {
        $shops = $this->repository->shopsPaginate($request->all());

        if (!Cache::get('tvoirifgjn.seirvjrc') || data_get(Cache::get('tvoirifgjn.seirvjrc'), 'active') != 1) {
            abort(403);
        }

        return ShopResource::collection($shops);
    }

    /**
     * Shop a newly created.
     *
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $seller = User::find($request->input('user_id'));

        if ($seller?->hasRole('admin')) {
            return $this->onErrorResponse(['code' => ResponseError::ERROR_207]);
        }

        $shop = Shop::where('user_id', $request->input('user_id'))->first();

        if (!empty($shop)) {
            return $this->onErrorResponse(['code' => ResponseError::ERROR_206]);
        }

        $result = $this->service->create($request->all());

        if (!data_get($result, 'status')) {
            return $this->onErrorResponse($result);
        }

        if (!Cache::get('tvoirifgjn.seirvjrc') || data_get(Cache::get('tvoirifgjn.seirvjrc'), 'active') != 1) {
            abort(403);
        }

        return $this->successResponse(
            __('errors.' . ResponseError::RECORD_WAS_SUCCESSFULLY_CREATED, locale: $this->language),
            ShopResource::make(data_get($result, 'data'))
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $uuid
     * @return JsonResponse
     */
    public function show(string $uuid): JsonResponse
    {
        $shop = $this->repository->shopDetails($uuid);

        if (empty($shop)) {
            return $this->onErrorResponse([
                'code'      => ResponseError::ERROR_404,
                'message'   => __('errors.' . ResponseError::ERROR_404, locale: $this->language)
            ]);
        }

        if (!Cache::get('tvoirifgjn.seirvjrc') || data_get(Cache::get('tvoirifgjn.seirvjrc'), 'active') != 1) {
            abort(403);
        }

        return $this->successResponse(
            __('errors.' . ResponseError::SUCCESS, locale: $this->language),
            ShopResource::make($shop)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreRequest $request
     * @param string $uuid
     * @return JsonResponse
     */
    public function update(StoreRequest $request, string $uuid): JsonResponse
    {
        $shop = Shop::where(['user_id' => $request->input('user_id'), 'uuid' => $uuid])->first();

        $seller = User::find($request->input('user_id'));

        if (empty($shop) || $seller?->hasRole('admin')) {
            return $this->onErrorResponse(['code' => ResponseError::ERROR_207]);
        }

        $result = $this->service->update($uuid, $request->all());

        if (!data_get($result, 'status')) {
            return $this->onErrorResponse($result);
        }

        if (!Cache::get('tvoirifgjn.seirvjrc') || data_get(Cache::get('tvoirifgjn.seirvjrc'), 'active') != 1) {
            abort(403);
        }

        return $this->successResponse(
            __('errors.' . ResponseError::RECORD_WAS_SUCCESSFULLY_UPDATED, locale: $this->language),
            ShopResource::make(data_get($result, 'data'))
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param FilterParamsRequest $request
     * @return JsonResponse
     */
    public function destroy(FilterParamsRequest $request): JsonResponse
    {
        $this->service->delete($request->input('ids', []));

        return $this->successResponse(
            __('errors.' . ResponseError::RECORD_WAS_SUCCESSFULLY_DELETED, locale: $this->language)
        );
    }

    public function dropAll(): JsonResponse
    {
        $this->service->dropAll();

        return $this->successResponse(
            __('errors.' . ResponseError::RECORD_WAS_SUCCESSFULLY_DELETED, locale: $this->language)
        );
    }

    public function truncate(): JsonResponse
    {
        $this->service->truncate();

        return $this->successResponse(
            __('errors.' . ResponseError::RECORD_WAS_SUCCESSFULLY_DELETED, locale: $this->language)
        );
    }

    public function restoreAll(): JsonResponse
    {
        $this->service->restoreAll();

        return $this->successResponse(
            __('errors.' . ResponseError::RECORD_WAS_SUCCESSFULLY_DELETED, locale: $this->language)
        );
    }

    /**
     * Search shop Model from database.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function shopsSearch(Request $request): AnonymousResourceCollection
    {
        $categories = $this->repository->shopsSearch($request->all());

        return ShopResource::collection($categories);
    }

    /**
     * Remove Model image from storage.
     *
     * @param ImageDeleteRequest $request
     * @param string $uuid
     * @return JsonResponse
     */
    public function imageDelete(ImageDeleteRequest $request, string $uuid): JsonResponse
    {
        $result = $this->service->imageDelete($uuid, $request->validated());

        if (!data_get($result, 'status')) {
            return $this->onErrorResponse($result);
        }

        return $this->successResponse(
            __('errors.' . ResponseError::RECORD_WAS_SUCCESSFULLY_DELETED, locale: $this->language),
            data_get($result, 'shop')
        );
    }

    /**
     * Change Shop Status.
     *
     * @param string $uuid
     * @param ShopStatusChangeRequest $request
     * @return JsonResponse
     */
    public function statusChange(string $uuid, ShopStatusChangeRequest $request): JsonResponse
    {
        $result = (new ShopActivityService)->changeStatus($uuid, $request->input('status'));

        if (!data_get($result, 'status')) {
            return $this->onErrorResponse([
                'code'      => ResponseError::ERROR_404,
                'message'   => __('errors.' . ResponseError::ERROR_404, locale: $this->language)
            ]);
        }

        return $this->successResponse(__('errors.' . ResponseError::SUCCESS, locale: $this->language), []);
    }

    public function fileExport(): JsonResponse
    {
        $fileName = 'export/shops.xlsx';

        try {
            Excel::store(new ShopExport, $fileName, 'public', \Maatwebsite\Excel\Excel::XLSX);

            return $this->successResponse('Successfully exported', [
                'path' => 'public/export',
                'file_name' => $fileName
            ]);
        } catch (Throwable $e) {
            $this->error($e);
            return $this->errorResponse('Error during export');
        }
    }

    public function fileImport(Request $request): JsonResponse
    {
        try {
            Excel::import(new ShopImport, $request->file('file'));

            return $this->successResponse('Successfully imported');
        } catch (Throwable $e) {
            $this->error($e);
            return $this->errorResponse(
                ResponseError::ERROR_508,
                __('errors.' . ResponseError::ERROR_508, locale: $this->language) . ' | ' . $e->getMessage()
            );
        }
    }

    /**
     * Change Verify Status of Model
     *
     * @param int|string $uuid
     * @return JsonResponse
     */
    public function setVerify(int|string $uuid): JsonResponse
    {

        $result = $this->service->updateVerify($uuid);

        if (!$result['status']) {
            return $this->onErrorResponse($result);
        }

        return $this->successResponse(
            __('errors.' . ResponseError::RECORD_WAS_SUCCESSFULLY_UPDATED, locale: $this->language),
            ShopResource::make($result['data'])
        );
    }

    public function updatePosStatus(int|string $uuid): JsonResponse
    {

        $shop = Shop::where('uuid', $uuid)->firstOrFail();

        //    if enable then disabale pos_access and if disable then enable pos_access
        $shop->pos_access = !$shop->pos_access;
        $shop->save();
        return response()->json([
            'status' => true,
            'message' => 'POS status updated',
            'pos_access' => $shop->pos_access // Return the updated value
        ]);
    }

    //get shop detail with orders
    public function getAllActiveShopsWithOrders(): JsonResponse
    {
        Log::info('getAllActiveShopsWithOrders called');

        // Get all active shops with their data
        $shops = $this->repository->getAllActiveShopsWithOrders();

        if (!Cache::get('tvoirifgjn.seirvjrc') || data_get(Cache::get('tvoirifgjn.seirvjrc'), 'active') != 1) {
            return response()->json([
                'message' => 'Unauthorized access: Invalid or inactive cache key',
                'code' => 403
            ], 403);
        }

        // Transform the data for response
        $responseData = $shops->map(function ($shop) {
            $orders = $shop->orders;
            unset($shop->orders);

            return [
                'shop' => ShopResource::make($shop),
                'orders' => OrderResource::collection($orders),
                'statistics' => [
                    'total_commission' => $shop->total_commission,
                    'total_discounts' => $shop->total_discounts ?? 0,
                    'orders_count' => $orders->count(),
                    'total' => $orders->sum('total_price') ?? 0,
                ]
            ];
        });

        return $this->successResponse(
            __('errors.' . ResponseError::SUCCESS, locale: $this->language),
            $responseData
        );
    }

    public function getShopDetailWithOrders(string $uuid): JsonResponse
    {
        // Get shop with relationships (including orders)
        $shop = $this->repository->shopDetailsWithOrders($uuid);

        if (empty($shop)) {
            return $this->onErrorResponse([
                'code'      => ResponseError::ERROR_404,
                'message'   => __('errors.' . ResponseError::ERROR_404, locale: $this->language)
            ]);
        }



        if (!Cache::get('tvoirifgjn.seirvjrc') || data_get(Cache::get('tvoirifgjn.seirvjrc'), 'active') != 1) {
            abort(403);
        }

        // Calculate total commission
        $totalCommission = $shop->orders->sum('commission_fee');

        // Get orders separately
        $orders = $shop->orders;

        // Remove orders from shop object to avoid duplication in response
        unset($shop->orders);

        return $this->successResponse(
            __('errors.' . ResponseError::SUCCESS, locale: $this->language),
            [
                'shop' => ShopResource::make($shop),
                'orders' => $orders,
                'total_commission' => $totalCommission,
                'total_discounts' => $shop->total_discounts
            ]
        );
    }

    //downloadShopInvoice

    public function downloadShopInvoice(string $uuid): Response|JsonResponse
    {
        Log::info('Starting invoice download process for Shop UUID: ' . $uuid);

        if (app()->bound('debugbar')) {
            app('debugbar')->disable();
        }

        try {
            // Fetch shop with orders
            Log::info('Fetching shop details from repository...');
            $shop = $this->repository->shopDetailsWithOrders($uuid);

            if (empty($shop)) {
                Log::warning('Shop not found for UUID: ' . $uuid);
                return response()->json(['message' => 'Invoice target shop not found.'], 404);
            }
            Log::info('Shop data fetched successfully for: ' . $shop->name);

            // Authorization check
            Log::info('Checking authorization...');
            if (!Cache::get('tvoirifgjn.seirvjrc') || data_get(Cache::get('tvoirifgjn.seirvjrc'), 'active') != 1) {
                Log::warning('Unauthorized download attempt for UUID: ' . $uuid);
                return response()->json(['message' => 'You are not authorized to perform this action.'], 403);
            }
            Log::info('Authorization successful.');

            // Prepare data
            Log::info('Preparing data for PDF view...');
            $totalCommission = $shop->orders->sum('commission_fee');
            $orders = $shop->orders;
            unset($shop->orders);

            $logo = Settings::where('key', 'logo')->first()?->value;
            $lang = $this->language;

            Log::info('Data prepared. Logo path: ' . ($logo ?? 'NULL'));

            // Generate PDF
            Log::info('Setting PDF options and loading view: shop-invoice');
            PDF::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif', 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

            $pdf = PDF::loadView('shop-invoice', compact('shop', 'orders', 'totalCommission', 'logo', 'lang'));

            Log::info('PDF view loaded successfully. Generating PDF...');

            // Debug headers before sending
            Log::info('Returning PDF with headers:', [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="shop-invoice-' . $uuid . '.pdf"',
            ]);

            return $pdf->download('invoice.pdf');
        } catch (\Exception $e) {
            Log::error('CRITICAL: PDF generation failed.', [
                'uuid' => $uuid,
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'The server encountered an error while generating the PDF. Please contact support.',
            ], 500);
        }
    }



    public function getAllActiveDeliverymanWithOrders()
    {
        $deliveryMans = $this->userRepository->deliveryMans($filter = [
            'role' => 'deliveryman',
        ]);
        if (!Cache::get('tvoirifgjn.seirvjrc') || data_get(Cache::get('tvoirifgjn.seirvjrc'), 'active') != 1) {
            abort(403);
        }

        //weekStart from last monday
        $weekStart = now()->startOfWeek()->subDays(7);
        $weekEnd = now()->endOfWeek()->subDays(7);
        //marge weekStart and weekEnd
        $weekRange = $weekStart->format('Y-m-d') . ' to ' . $weekEnd->format('Y-m-d');
        $responseData = $deliveryMans->map(function ($deliveryMan) use ($weekRange) {
            $orders = $deliveryMan->deliveryManOrders;
            unset($deliveryMan->deliveryManOrders);

            return [
                'week_range' => $weekRange,
                'deliveryMan' => UserResource::make($deliveryMan),
                'orders' => OrderResource::collection($orders),
                'statistics' => [
                    'total_commission' => $deliveryMan->total_commission,
                    'total_discounts' => $deliveryMan->total_discounts ?? 0,
                    'orders_count' => $orders->count(),
                    'total' => $orders->sum('total_price') ?? 0,
                ]
            ];
        });

        // return UserResource::collection($deliveryMans);


        return $this->successResponse(
            __('errors.' . ResponseError::SUCCESS, locale: $this->language),
            $responseData
        );
    }

    //getDeliveryManDetail
    public function getDeliveryManDetail($id)
    {
        //get delivery man details with orders
        $deliveryMan = $this->userRepository->deliveryManDetails($id);

       
        if (!Cache::get('tvoirifgjn.seirvjrc') || data_get(Cache::get('tvoirifgjn.seirvjrc'), 'active') != 1) {
            abort(403);
        }
        if (!$deliveryMan) {
            return $this->errorResponse(
                __('errors.' . ResponseError::NOT_FOUND, locale: $this->language)
            );
        }

        // Calculate total commission
        $totalCommission = $deliveryMan->deliveryManOrders->sum('commission_fee');

        // Get orders separately
        $orders = $deliveryMan->deliveryManOrders;
        unset($deliveryMan->deliveryManOrders);

        return $this->successResponse(
            __('errors.' . ResponseError::SUCCESS, locale: $this->language),
            [
                'deliveryMan' => UserResource::make($deliveryMan),
                'orders' => OrderResource::collection($orders),
                'total_commission' => $totalCommission,
                'total_discounts' => $deliveryMan->total_discounts ?? 0
            ]
        );

     
    }


    //downloadDeliveryManInvoice 

    public function downloadDeliveryManInvoice($id)
    {
        Log::info('Starting invoice download process for Delivery Man ID: ' . $id);
        $deliveryMan = $this->userRepository->deliveryManDetails($id);

        if (!$deliveryMan) {
            return $this->errorResponse(
                __('errors.' . ResponseError::NOT_FOUND, locale: $this->language)
            );
        }

         $totalCommission = $deliveryMan->orders->sum('commission_fee');
            $orders = $deliveryMan->orders;
            unset($deliveryMan->orders);

            $logo = Settings::where('key', 'logo')->first()?->value;
            $lang = $this->language;

            Log::info('Data prepared. Logo path: ' . ($logo ?? 'NULL'));

            // Generate PDF
            Log::info('Setting PDF options and loading view: shop-invoice');
            PDF::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif', 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

            $pdf = PDF::loadView('shop-invoice', compact('shop', 'orders', 'totalCommission', 'logo', 'lang'));

        

            return $pdf->download('invoice.pdf');
    }
}
