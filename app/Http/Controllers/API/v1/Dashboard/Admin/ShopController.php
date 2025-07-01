<?php

namespace App\Http\Controllers\API\v1\Dashboard\Admin;

use App\Http\Requests\ShopInvoiceExcelRequest;
use Throwable;
use Carbon\Carbon;
use App\Models\Shop;
use App\Models\User;
use App\Models\Settings;
use App\Exports\ShopExport;
use App\Exports\ShopInvoiceExport;
use App\Imports\ShopImport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ResponseError;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ShopWeeklyReport;

use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use App\Http\Resources\ShopResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\OrderResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Shop\StoreRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\FilterParamsRequest;
use App\Repositories\SellerFinanceRepository;
use App\Http\Requests\Shop\ImageDeleteRequest;
use App\Services\Interfaces\ShopServiceInterface;
use App\Services\ShopServices\ShopActivityService;
use App\Http\Requests\Shop\ShopStatusChangeRequest;
use App\Models\DeliveryManWeeklyReport;
use App\Models\Order;
use App\Repositories\UserRepository\UserRepository;
use App\Repositories\ShopRepository\AdminShopRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\DeliveryManInvoiceExcelRequest;
use App\Exports\DeliveryManInvoiceExport;
use App\Http\Requests\DeliveryManSetting\DeliveryManRequest;
use Illuminate\Support\Collection;

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

    // //get shop detail with orders
    // public function getAllActiveShopsWithOrders(): JsonResponse
    // {

    //     $shops = $this->repository->getAllActiveShopsWithOrders();

    //     if (!Cache::get('tvoirifgjn.seirvjrc') || data_get(Cache::get('tvoirifgjn.seirvjrc'), 'active') != 1) {
    //         return response()->json([
    //             'message' => 'Unauthorized access: Invalid or inactive cache key',
    //             'code' => 403
    //         ], 403);
    //     }

    //     $responseData = $shops->map(function ($shop) {
    //         $orders = $shop->orders;
    //         unset($shop->orders);

    //         return [
    //             'shop' => ShopResource::make($shop),
    //             'orders' => OrderResource::collection($orders),
    //             'statistics' => [
    //                 'total_commission' => $shop->total_commission,
    //                 'total_discounts' => $shop->total_discounts ?? 0,
    //                 'orders_count' => $orders->count(),
    //                 'total' => $orders->sum('total_price') ?? 0,
    //             ]
    //         ];
    //     });

    //     return $this->successResponse(
    //         __('errors.' . ResponseError::SUCCESS, locale: $this->language),
    //         $responseData
    //     );
    // }




    public function getAllActiveShopsWithOrders(): JsonResponse
    {
        Log::info('getAllActiveShopsWithOrders started', [
            'timestamp' => now()->toDateTimeString()
        ]);

        // Determine current week range (Monday to Sunday)
        $currentWeekStart = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $currentWeekEnd = $currentWeekStart->copy()->endOfWeek(Carbon::SUNDAY);
        $currentWeekRange = $currentWeekStart->format('Y-m-d') . ' to ' . $currentWeekEnd->format('Y-m-d');

        // Fetch active shops with their orders
        $shops = $this->repository->getAllActiveShopsWithOrders();

        // Process shops
        $responseData = $shops->map(function ($shop) use ($currentWeekStart, $currentWeekEnd, $currentWeekRange) {
            // Get all orders for this shop
            $allOrders = $shop->orders;
            Log::info('Processing all orders for shop', ['shop_id' => $shop->id, 'order_count' => $allOrders->count()]);

            // Process current week orders first
            $currentWeekOrders = $allOrders->filter(function ($order) use ($currentWeekStart, $currentWeekEnd) {
                $createdAt = Carbon::parse($order->created_at);
                return $createdAt->between($currentWeekStart, $currentWeekEnd);
            });

            // Save or update current week's orders
            if ($currentWeekOrders->isNotEmpty()) {
                $this->updateWeeklyReport(
                    $shop->id,
                    $currentWeekRange,
                    $currentWeekOrders
                );
            }

            // Group all orders by week (including previous weeks)
            $weeklyOrders = $allOrders->groupBy(function ($order) {
                $date = Carbon::parse($order->created_at);
                $startOfWeek = $date->startOfWeek(Carbon::MONDAY);
                $endOfWeek = $startOfWeek->copy()->endOfWeek(Carbon::SUNDAY);
                return $startOfWeek->format('Y-m-d') . ' to ' . $endOfWeek->format('Y-m-d');
            });

            // Process each week's data
            $processedWeeks = $weeklyOrders->map(function ($weekOrders, $weekRange) use ($shop, $currentWeekRange) {
                // Update weekly report for this week
                $this->updateWeeklyReport(
                    $shop->id,
                    $weekRange,
                    $weekOrders
                );

                return [
                    'week_range' => $weekRange,
                    'orders' => $weekRange === $currentWeekRange
                        ? OrderResource::collection($weekOrders)
                        : OrderResource::collection(collect([])),
                    'statistics' => [
                        'orders_count' => $weekOrders->count(),
                        'total_price' => $weekOrders->sum('total_price') ?? 0,
                        'total_commission' => $weekOrders->sum('commission_fee') ?? 0,
                        'total_discounts' => $weekOrders->sum('total_discount') ?? 0,
                    ],
                ];
            })->values();

            // Get all weekly reports from database (including status filtering)
            $weeklyReports = ShopWeeklyReport::where('shop_id', $shop->id)
                ->when(request('status'), function ($query, $status) {
                    return $query->where('status', $status);
                })
                ->orderBy('week_identifier', 'desc')
                ->get();

            // Merge processed weeks with database records
            $finalWeeklyOrders = collect([]);

            foreach ($weeklyReports as $report) {
                $weekData = $processedWeeks->firstWhere('week_range', $report->week_identifier);

                if (!$weekData) {
                    $weekData = [
                        'week_range' => $report->week_identifier,
                        'orders' => OrderResource::collection(collect([])),
                        'statistics' => [
                            'orders_count' => $report->orders_count,
                            'total_price' => $report->total_price,
                            'total_commission' => $report->total_commission ?? 0,
                            'total_discounts' => $report->total_discounts ?? 0,
                        ],
                    ];
                }

                // Add record_id and status from database
                $weekData['record_id'] = $report->id;
                $weekData['status'] = $report->status;

                $finalWeeklyOrders->push($weekData);
            }

            unset($shop->orders); // Remove orders to avoid redundancy

            Log::info('Shop processed', [
                'shop_id' => $shop->id,
                'weekly_orders_count' => $finalWeeklyOrders->count()
            ]);

            return [
                'shop' => ShopResource::make($shop),
                'weekly_orders' => $finalWeeklyOrders,
            ];
        });

        return $this->successResponse(
            __('errors.' . ResponseError::SUCCESS, locale: $this->language),
            $responseData
        );
    }

    /**
     * Helper method to update weekly report
     */
    private function updateWeeklyReport(int $shopId, string $weekRange, $orders): void
    {
        $orderIds = $orders->pluck('id')->toArray();
        $totalPrice = $orders->sum('total_price') ?? 0;
        $ordersCount = $orders->count();
        $totalCommission = $orders->sum('commission_fee') ?? 0;
        $totalDiscounts = $orders->sum('total_discount') ?? 0;

        try {
            DB::transaction(function () use ($shopId, $weekRange, $orderIds, $totalPrice, $ordersCount, $totalCommission, $totalDiscounts) {
                ShopWeeklyReport::updateOrCreate(
                    [
                        'shop_id' => $shopId,
                        'week_identifier' => $weekRange,
                    ],
                    [
                        'order_ids' => json_encode($orderIds),
                        'total_price' => $totalPrice,
                        'orders_count' => $ordersCount,
                        'total_commission' => $totalCommission,
                        'total_discounts' => $totalDiscounts,
                    ]
                );
            });
        } catch (\Exception $e) {
            Log::error('Failed to update weekly report', [
                'shop_id' => $shopId,
                'week_range' => $weekRange,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }



    public function updateWeeklyOrderStatus(Request $request, $shopUuid)
    {
        // Log::info('updateWeeklyOrderStatus started', [
        //     'shop_uuid' => $shopUuid,
        //     'timestamp' => now()->toDateTimeString(),
        //     'request_data' => $request->all()
        // ]);
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'record_id' => 'required|integer|exists:shop_weekly_reports,id',
                'status' => 'required|string|in:paid,unpaid,canceled'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Find the shop by UUID
            $shop = Shop::where('uuid', $shopUuid)->first();
            if (!$shop) {
                return response()->json([
                    'status' => false,
                    'message' => 'Shop not found'
                ], 404);
            }

            // Find the weekly order
            $weeklyOrder = ShopWeeklyReport::where('id', $request->record_id)
                ->where('shop_id', $shop->id)
                ->first();

            if (!$weeklyOrder) {
                return response()->json([
                    'status' => false,
                    'message' => 'Weekly order not found or does not belong to this shop'
                ], 404);
            }

            // Update status
            $weeklyOrder->status = $request->status;
            $weeklyOrder->save();

            // // Log the update
            // Log::info('Weekly order status updated', [
            //     'record_id' => $weeklyOrder->id,
            //     'shop_id' => $shop->id,
            //     'new_status' => $request->status
            // ]);

            return response()->json([
                'status' => true,
                'message' => 'Weekly order status updated successfully',
                'data' => [
                    'record_id' => $weeklyOrder->id,
                    'status' => $weeklyOrder->status
                ]
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating weekly order status', [
                'error' => $e->getMessage(),
                'shop_uuid' => $shopUuid,
                'request' => $request->all()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Failed to update weekly order status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getShopDetailWithOrders(Request $request)
    {
        // Log::info('getShopDetailWithOrders started', [
        //     'request_data' => $request->all(),
        //     'timestamp' => now()->toDateTimeString()
        // ]);

        $recordId = $request->input('record_id');
        if (!is_numeric($recordId) || $recordId <= 0) {
            Log::warning('Invalid record_id', ['record_id' => $recordId]);
            return $this->onErrorResponse([
                'code' => ResponseError::ERROR_400,
                'message' => __('errors.invalid_record_id', locale: $this->language)
            ]);
        }

        $weeklyReport = ShopWeeklyReport::find($recordId);
        if (!$weeklyReport) {
            Log::warning('ShopWeeklyReport not found', ['record_id' => $recordId]);
            return $this->onErrorResponse([
                'code' => ResponseError::ERROR_404,
                'message' => __('errors.' . ResponseError::ERROR_404, locale: $this->language)
            ]);
        }



        $orderIds = json_decode($weeklyReport->order_ids, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Invalid JSON in order_ids', ['record_id' => $recordId, 'error' => json_last_error_msg()]);
            $orderIds = [];
        }

        $shop = Shop::with(['orders' => function ($query) use ($orderIds) {
            $query->whereIn('id', $orderIds);
        }])->find($weeklyReport->shop->id);

        Log::info('Shop detail fetched', ['shop_id' => $weeklyReport->shop->id, 'orders_count' => $shop->orders->count()]);

        if (empty($shop)) {
            Log::warning('Shop not found', ['shop_id' => $weeklyReport->shop->id]);
            return $this->onErrorResponse([
                'code' => ResponseError::ERROR_404,
                'message' => __('errors.' . ResponseError::ERROR_404, locale: $this->language)
            ]);
        }

        if (!Cache::get('tvoirifgjn.seirvjrc') || data_get(Cache::get('tvoirifgjn.seirvjrc'), 'active') != 1) {
            Log::error('Cache authorization failed', ['key' => 'tvoirifgjn.seirvjrc']);
            abort(403);
        }

        $orders = $shop->orders;
        Log::info('Orders for ShopWeeklyReport', [
            'record_id' => $recordId,
            'order_ids' => $orderIds,
            'orders' => $orders->toArray(),
        ]);
        $totalCommission = $weeklyReport->total_commission ?? 0;
        $totalDiscounts = $weeklyReport->total_discounts ?? 0;
        $totalSales = $weeklyReport->total_price ?? 0;
        $sumOfOrderDiscounts = $totalDiscounts;
        $totalChargesAndDiscounts = $totalCommission + $sumOfOrderDiscounts;
        $netAmountPayable = $totalSales - $totalChargesAndDiscounts;

        // Validate metrics
        if ($totalDiscounts != $sumOfOrderDiscounts) {
            Log::warning('Discount mismatch', [
                'record_id' => $recordId,
                'reported' => $totalDiscounts,
                'calculated' => $sumOfOrderDiscounts
            ]);
        }

        $shop->setRelation('orders', $orders);
        $sellerName = $shop->seller->firstname . ' ' . $shop->seller->lastname ?? 'Unknown Seller';

        // Log::info('Shop detail with orders fetched', [
        //     'shop' => $shop,
        //     'orders_count' => $orders->count(),
        //     'total_sales' => $totalSales,
        //     'total_commission' => $totalCommission,
        //     'total_discounts' => $totalDiscounts,
        //     'sum_of_order_discounts' => $sumOfOrderDiscounts,
        //     'total_charges_and_discounts' => $totalChargesAndDiscounts,
        //     'net_amount_payable' => $netAmountPayable,
        //     'record_id' => $recordId,
        //     'orders' => $orders->toArray(),
        //     'sellerName' => $sellerName
        // ]);

        //get seller name

        return $this->successResponse(
            __('errors.' . ResponseError::SUCCESS, locale: $this->language),
            [
                'recordId' => $recordId,
                'shop' => ShopResource::make($shop),
                'orders' => $orders,
                'total_sales' => $totalSales,
                'total_commission' => $totalCommission,
                'sum_of_order_discounts' => $sumOfOrderDiscounts,
                'total_charges_and_discounts' => $totalChargesAndDiscounts,
                'net_amount_payable' => $netAmountPayable
            ]
        );
    }

    //downloadShopInvoice

    public function downloadShopInvoice(string $uuid): Response|JsonResponse
    {
        // Log::info('Starting invoice download process for Shop UUID: ' . $uuid);

        if (app()->bound('debugbar')) {
            try {
                app('debugbar')->disable();
            } catch (\Throwable $e) {
                // Debugbar not installed or not available, ignore
            }
        }

        try {
            $weeklyReport = ShopWeeklyReport::where('id', $uuid)->first();

            if (!$weeklyReport) {
                Log::warning('Weekly report not found for UUID: ' . $uuid);
                return response()->json(['message' => 'Weekly report not found.'], 404);
            }

            $orderIds = json_decode($weeklyReport->order_ids, true) ?: [];
            $shop = $weeklyReport->shop;

            if (!$shop) {
                Log::error("Shop not found for weekly report ID: " . $weeklyReport->id);
                return response()->json(['message' => 'Shop not found.'], 404);
            }

            $orders = $shop->orders()->whereIn('id', $orderIds)->get();

            // Log::info('Order details loaded for PDF generation.');

            // Static Company Details
            $companyDetails = [
                'name' => 'D2Home',
                'addressLine1' => '10/12 Clarke St, Crows Nest NSW 2065, Australia',
                'addressLine2' => 'South Australia, 5047',
                'email' => 'info@d2home.com',
                'phone' => '+61 2 8103 1116',
                'abn' => '',
            ];

            // Dynamic Invoice Meta
            $invoiceMeta = [
                'invoiceNumber' => '01',
                'dateOfInvoice' => Carbon::now()->translatedFormat('d F Y'),
                'billingPeriodStart' => 'N/A',
                'billingPeriodEnd' => 'N/A',
            ];

            // Calculate billing period if orders exist

            // Financial Calculations
            $totalSales = $weeklyReport->total_price ?? 0;
            $totalCommission = $weeklyReport->total_commission ?? 0;
            $grossPlatformCommission = (float) $totalCommission;
            $sumOfOrderDiscounts = $weeklyReport->total_discounts ?? 0;
            $totalChargesAndDiscountsByPlatform = $grossPlatformCommission + $sumOfOrderDiscounts;
            $netAmountPayableToSeller = $totalSales - $totalChargesAndDiscountsByPlatform;

            $financialSummary = [
                'totalSales' => $totalSales,
                'grossPlatformCommission' => $grossPlatformCommission,
                'sumOfOrderDiscounts' => $sumOfOrderDiscounts,
                'totalChargesAndDiscountsByPlatform' => $totalChargesAndDiscountsByPlatform,
                'netAmountPayableToSeller' => $netAmountPayableToSeller,
            ];

            $financialTableRows = [
                ['desc' => 'Total Sale Amount', 'sub' => null, 'total' => $financialSummary['totalSales'], 'isBold' => false],
                ['desc' => 'D2Home Commission:', 'sub' => $financialSummary['grossPlatformCommission'], 'total' => null, 'isBold' => false],
                ['desc' => 'D2Home Discounts (platform promotions):', 'sub' => $financialSummary['sumOfOrderDiscounts'], 'total' => null, 'isBold' => false],
                ['desc' => 'Total D2Home Commission:', 'sub' => null, 'total' => $financialSummary['totalChargesAndDiscountsByPlatform'], 'isBold' => true],
                ['desc' => 'Sub Total:', 'sub' => null, 'total' => $financialSummary['netAmountPayableToSeller'], 'isBold' => true],
                ['desc' => 'The amount to be transferred:', 'sub' => null, 'total' => $financialSummary['netAmountPayableToSeller'], 'isBold' => true, 'isFinal' => true],
            ];

            $logo = Settings::where('key', 'logo')->first()?->value;
            $lang = $this->language;
            $record_id = $uuid;
            PDF::setOption([
                'dpi' => 150,
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

            // Log::info('Generating PDF for shop invoice data.', [
            //     'shop_id' => $shop->id,
            //     'order_count' => $orders->count(),
            //     'total_commission' => $totalCommission
            // ]);
            $sellerName = $shop->seller->firstname . ' ' . $shop->seller->lastname ?? 'Unknown Seller';

            $pdf = PDF::loadView('shop-invoice', compact(
                'shop',
                'orders',
                'totalCommission',
                'logo',
                'lang',
                'companyDetails',
                'invoiceMeta',
                'financialSummary',
                'financialTableRows',
                'record_id',
                'sellerName'
            ));

            return $pdf->download('invoice.pdf');
        } catch (\Exception $e) {
            Log::error('Invoice generation failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'message' => 'The server encountered an error while generating the PDF. Please contact support.',
            ], 500);
        }
    }

    public function downloadShopInvoiceExcel(ShopInvoiceExcelRequest $request)
    {
        // Log::info('downloadShopInvoiceExcel Runs', [
        //     'query_data' => $request->all(),
        // ]);

        // $filteredData = $request->input('params.filteredData', []);

        // This will only get records where status is 'unpaid'
        $filteredData = ShopWeeklyReport::where('status', 'unpaid')->get()->toArray();

        // Log::debug('Filtered data passed to Excel:', $filteredData);

        $fileName = 'export/shop-invoice.xlsx';
        $shopInvoiceExport = new ShopInvoiceExport($filteredData);


        try {
            $stored = Excel::store($shopInvoiceExport, $fileName, 'public', \Maatwebsite\Excel\Excel::XLSX);

            // Log::info('Excel store status: ' . ($stored ? 'Success' : 'Failed'));

            if (!$stored || !\Storage::disk('public')->exists($fileName)) {
                return $this->errorResponse("Excel file not found after generation", 404);
            }

            return $this->successResponse('Successfully exported', [
                'path'      => \Storage::disk('public')->url($fileName),
                'file_name' => $fileName
            ]);
        } catch (Throwable $e) {
            report($e);
            return $this->errorResponse('Error during export');
        }
    }


    public function getAllActiveDeliverymanWithOrders()
    {
        if (!Cache::get('tvoirifgjn.seirvjrc') || data_get(Cache::get('tvoirifgjn.seirvjrc'), 'active') != 1) {
            abort(403);
        }

        // Get all deliverymen who have ever handled orders
        $deliveryMans = User::whereIn('id', function ($query) {
            $query->select('deliveryman')
                ->from('orders')
                ->whereNotNull('deliveryman');
        })
            ->get();

        // FIRST TIME: Process all historical orders
        if (!\App\Models\DeliveryManWeeklyReport::exists()) {
            $this->processAllHistoricalOrders($deliveryMans);
        }

        // ONGOING: Process only new orders (not yet in any weekly report)
        $this->processNewOrders($deliveryMans);

        // Return all weekly reports
        return $this->buildResponse($deliveryMans);
    }

    protected function processAllHistoricalOrders($deliveryMans)
    {
        foreach ($deliveryMans as $deliveryMan) {
            $orders = $deliveryMan->deliveryManOrders()
                ->orderBy('created_at')
                ->get()
                ->groupBy(function ($order) {
                    return $order->created_at->startOfWeek()->format('Y-m-d') . ' to ' .
                        $order->created_at->endOfWeek()->format('Y-m-d');
                });

            foreach ($orders as $weekRange => $weekOrders) {
                $this->createWeeklyReport($deliveryMan, $weekRange, $weekOrders);
            }
        }
    }

    protected function processNewOrders($deliveryMans)
    {
        $existingOrderIds = \App\Models\DeliveryManWeeklyReport::pluck('order_ids')
            ->flatMap(function ($ids) {
                return json_decode($ids, true) ?: [];
            })
            ->unique()
            ->toArray();

        foreach ($deliveryMans as $deliveryMan) {
            $newOrders = $deliveryMan->deliveryManOrders()
                ->whereNotIn('id', $existingOrderIds)
                ->get()
                ->groupBy(function ($order) {
                    return $order->created_at->startOfWeek()->format('Y-m-d') . ' to ' .
                        $order->created_at->endOfWeek()->format('Y-m-d');
                });

            foreach ($newOrders as $weekRange => $weekOrders) {
                $this->updateWeeklyReport($deliveryMan, $weekRange, $weekOrders);
            }
        }
    }

    protected function createWeeklyReport($deliveryMan, $weekRange, $orders)
    {
        DB::transaction(function () use ($deliveryMan, $weekRange, $orders) {
            \App\Models\DeliveryManWeeklyReport::create([
                'delivery_man_id' => $deliveryMan->id,
                'week_identifier' => $weekRange,
                'order_ids' => json_encode($orders->pluck('id')->toArray()),
                'total_price' => $orders->sum('total_price'),
                'orders_count' => $orders->count(),
                'total_commission' => $orders->sum('commission_fee'),
                'total_discounts' => $orders->sum('total_discount'),
            ]);
        });
    }

    protected function buildResponse($deliveryMans)
    {
        $weeklyReports = \App\Models\DeliveryManWeeklyReport::whereIn('delivery_man_id', $deliveryMans->pluck('id'))
            ->get()
            ->groupBy('delivery_man_id');

        $responseData = $deliveryMans->map(function ($deliveryMan) use ($weeklyReports) {
            $reports = $weeklyReports->get($deliveryMan->id, collect());
            return [
                'deliveryMan' => UserResource::make($deliveryMan),
                'weekly_reports' => $reports->map(function ($report) {
                    return [
                        'week_range' => $report->week_identifier,
                        'statistics' => [
                            'orders_count' => $report->orders_count,
                            'total_price' => $report->total_price,
                            'total_commission' => $report->total_commission ?? 0,
                            'total_discounts' => $report->total_discounts ?? 0,
                        ],
                        'record_id' => $report->id,
                        'status' => $report->status,
                    ];
                })->sortByDesc('week_range')->values(),
            ];
        });

        Log::info('responseData', $responseData->toArray());

        return $this->successResponse(
            __('errors.' . ResponseError::SUCCESS, locale: $this->language),
            $responseData
        );
    }




    public function getDeliveryManDetail(Request $request, $id): JsonResponse
    {
        // Log::info('getDeliveryManDetail ', [
        //     'deliveryman_id' => $id,
        //     'timestamp' => now()->toDateTimeString(),
        //     'week_range' => $request->query('week_range'),
        //     'query_data' => $request->query(), // this will show all query params
        // ]);
        // Cache-based authorization check
        if (!Cache::get('tvoirifgjn.seirvjrc') || data_get(Cache::get('tvoirifgjn.seirvjrc'), 'active') != 1) {
            return $this->errorResponse(
                ResponseError::ERROR_403,
                __('errors.' . ResponseError::ERROR_403, locale: $this->language),
                403
            );
        }

        // Validate ID
        $validated = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:users,id',
        ]);


        if ($validated->fails()) {
            return $this->errorResponse(
                ResponseError::ERROR_422,
                $validated->errors()->first(),
                422
            );
        }


        // Find the shop by UUID
        $deliveryMan = User::where('id', $id)->first();
        if (!$deliveryMan) {
            return response()->json([
                'status' => false,
                'message' => 'DeliveryMan not found'
            ], 404);
        }

        $week_range = $request->query('week_range');

        if (!$week_range) {
            return response()->json([
                'status' => false,
                'message' => 'Week Range not found'
            ], 404);
        }
        // Find the weekly order
        $weeklyReports = DeliveryManWeeklyReport::where('delivery_man_id', $id)
            ->where('week_identifier', $week_range)->first();

        if (!$weeklyReports) {
            return response()->json([
                'status' => false,
                'message' => 'Weekly Report not found or does not belong to this shop'
            ], 404);
        }

        $orderIds = json_decode($weeklyReports->order_ids, true) ?: [];
        $orders = $deliveryMan->deliveryManOrders->whereIn('id', $orderIds)->values();


        return $this->successResponse(
            __('errors.' . ResponseError::SUCCESS, locale: $this->language),
            [
                'deliveryMan' => UserResource::make($deliveryMan),
                'orders' => OrderResource::collection($orders),
                'total_commission' => $weeklyReports->total_commission,
                'total_discounts' => $weeklyReports->total_discounts
            ]
        );
    }

    //upDateDeliveryManWeeklyRecordStatus

    public function upDateDeliveryManWeeklyRecordStatus(Request $request, $deliverymanId)
    {
        // Log::info('upDateDeliveryManWeeklyRecordStatus started', [
        //     'deliveryman_id' => $deliverymanId,
        //     'timestamp' => now()->toDateTimeString(),
        //     'request_data' => $request->all()
        // ]);
        $validated = Validator::make($request->all(), [
            'status' => 'required|in:paid,unpaid,canceled',
        ]);




        if ($validated->fails()) {
            return $this->errorResponse(
                ResponseError::ERROR_422,
                $validated->errors()->first(),
                422
            );
        }

        $deliveryMan = User::where('id', $deliverymanId)->first();
        if (!$deliveryMan) {
            return response()->json([
                'status' => false,
                'message' => 'DeliveryMan not found'
            ], 404);
        }

        $week_range = $request->input('week_range');
        if (!$week_range) {
            return response()->json([
                'status' => false,
                'message' => 'Weak Range not found'
            ], 404);
        }

        $weeklyReport = DeliveryManWeeklyReport::where('delivery_man_id', $deliverymanId)->where('week_identifier', $week_range)->first();

        if (!$weeklyReport) {
            return response()->json([
                'status' => false,
                'message' => 'Weekly Report not found'
            ], 404);
        }

        $weeklyReport->status = $request->input('status');
        $weeklyReport->save();

        return $this->successResponse(
            __('errors.' . ResponseError::SUCCESS, locale: $this->language),
            [
                'deliveryMan' => UserResource::make($deliveryMan),
            ]
        );
    }

    //downloadDeliveryManInvoice
    public function downloadDeliveryManInvoice($id)
    {
        // Log::info('Starting invoice download process for DeliveryMan ID: ' . $id, ['request_data' => request()->all()]);

        if (app()->bound('debugbar')) {
            try {
                app('debugbar')->disable();
            } catch (\Throwable $e) {
                // Debugbar not installed or not available, ignore
            }
        }

        try {
            $deliveryMan = User::with('deliveryManOrders')->find($id);
            if (!$deliveryMan) {
                Log::warning('DeliveryMan not found for ID: ' . $id);
                return response()->json(['message' => 'DeliveryMan not found'], 404);
            }

            // Log::info("DeliveryMan Details: " . json_encode($deliveryMan->toArray()));

            $weekRange = request()->query('week_range');
            $weeklyReport = DeliveryManWeeklyReport::where('delivery_man_id', $id)
                ->when($weekRange, fn($q) => $q->where('week_identifier', $weekRange))
                ->orderByDesc('id')
                ->first();

            if (!$weeklyReport) {
                Log::warning('Weekly report not found for DeliveryMan ID: ' . $id . ', week_range: ' . $weekRange);
                return response()->json(['message' => 'Weekly report not found'], 404);
            }

            $orderIds = json_decode($weeklyReport->order_ids, true) ?? [];
            $orders = $deliveryMan->deliveryManOrders()
                ->whereIn('id', $orderIds)
                ->get();

            if ($orders->isEmpty()) {
                Log::warning('No orders found for DeliveryMan ID: ' . $id . ', week_range: ' . $weekRange);
                return response()->json(['message' => 'No orders found'], 404);
            }

            // Static Company Details
            $companyDetails = [
                'name' => 'D2Home',
                'addressLine1' => '10/12 Clarke St, Crows Nest NSW 2065, Australia',
                'addressLine2' => 'South Australia, 5047',
                'email' => 'info@d2home.com',
                'phone' => '+61 2 8103 1116',
                'abn' => '',
            ];

            // Dynamic Invoice Meta
            $invoiceMeta = [
                'invoiceNumber' => '01',
                'dateOfInvoice' => Carbon::now()->translatedFormat('d F Y'),
                'billingPeriodStart' => 'N/A',
                'billingPeriodEnd' => 'N/A',
            ];

            // Financial Calculations
            $totalSales = $weeklyReport->total_price ?? 0;
            $totalCommission = $weeklyReport->total_commission ?? 0;
            $grossPlatformCommission = (float) $totalCommission;
            $sumOfOrderDiscounts = $weeklyReport->total_discounts ?? 0;
            $totalChargesAndDiscountsByPlatform = $grossPlatformCommission + $sumOfOrderDiscounts;
            $netAmountPayableToDeliveryMan = $totalSales - $totalChargesAndDiscountsByPlatform;

            $financialSummary = [
                'totalSales' => $totalSales,
                'grossPlatformCommission' => $grossPlatformCommission,
                'sumOfOrderDiscounts' => $sumOfOrderDiscounts,
                'totalSales' => $totalSales,
                'grossPlatformCommission' => $grossPlatformCommission,
                'sumOfOrderDiscounts' => $sumOfOrderDiscounts,
                'totalChargesAndDiscountsByPlatform' => $totalChargesAndDiscountsByPlatform,
                'netAmountPayableToDeliveryMan' => $netAmountPayableToDeliveryMan,
            ];

            $financialTableRows = [
                ['desc' => 'Total Delivery Amount', 'sub' => null, 'total' => $financialSummary['totalSales'], 'isBold' => false],
                ['desc' => 'D2Home Commission:', 'sub' => $financialSummary['grossPlatformCommission'], 'total' => null, 'isBold' => false],
                ['desc' => 'D2Home Discounts (platform promotions):', 'sub' => $financialSummary['sumOfOrderDiscounts'], 'total' => null, 'isBold' => false],
                ['desc' => 'Total D2Home Commission:', 'sub' => null, 'total' => $financialSummary['totalChargesAndDiscountsByPlatform'], 'isBold' => true],
                ['desc' => 'Sub Total:', 'sub' => null, 'total' => $financialSummary['netAmountPayableToDeliveryMan'], 'isBold' => true],
                ['desc' => 'The amount to be transferred:', 'sub' => null, 'total' => $financialSummary['netAmountPayableToDeliveryMan'], 'isBold' => true, 'isFinal' => true],
            ];

            $logo = Settings::where('key', 'logo')->first()?->value;
            $lang = $this->language;

            PDF::setOption([
                'dpi' => 150,
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

            // Log::info('Generating PDF for deliveryman invoice data.', [
            //     'deliveryman_id' => $deliveryMan->id,
            //     'order_count' => $orders->count(),
            //     'total_commission' => $totalCommission
            // ]);

            $pdf = PDF::loadView('deliveryman-invoice', compact(
                'deliveryMan',
                'orders',
                'totalCommission',
                'logo',
                'lang',
                'companyDetails',
                'invoiceMeta',
                'financialSummary',
                'financialTableRows'
            ));



            return $pdf->download('invoice.pdf');
        } catch (\Exception $e) {
            Log::error('Invoice generation failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Failed to generate invoice'], 500);
        }
    }

    public function downloadDeliveryManInvoiceExcel(DeliveryManInvoiceExcelRequest $request)
    {
        // Log::info('downloadDeliveryManInvoiceExcel Runs', [
        //     'query_data' => $request->all(),
        // // ]);

        //  $filteredData = $request->input('params.filteredData', []);

        $filteredData = DeliveryManWeeklyReport::where('status', 'unpaid')->get()->toArray();

        // Log::debug('Filtered data passed to Excel:', $filteredData);

        $fileName = 'export/delivery-man-finance.xlsx';
        $deliveryManInvoiceExport = new DeliveryManInvoiceExport($filteredData);

        try {
            $stored = Excel::store($deliveryManInvoiceExport, $fileName, 'public', \Maatwebsite\Excel\Excel::XLSX);

            // Log::info('Excel store status: ' . ($stored ? 'Success' : 'Failed'));

            if (!$stored || !\Storage::disk('public')->exists($fileName)) {
                return $this->errorResponse("Excel file not found after generation", 404);
            }

            return $this->successResponse('Successfully exported', [
                'path'      => \Storage::disk('public')->url($fileName),
                'file_name' => $fileName
            ]);
        } catch (Throwable $e) {
            report($e);
            return $this->errorResponse('Error during export');
        }
    }
}
