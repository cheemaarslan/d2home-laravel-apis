<?php

namespace App\Http\Controllers\API\v1\Dashboard\Admin;

use Throwable;
use Carbon\Carbon;
use App\Models\Shop;
use App\Models\User;
use App\Models\Settings;
use App\Exports\ShopExport;
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

        // Cache-based authorization check
        if (!Cache::get('tvoirifgjn.seirvjrc') || data_get(Cache::get('tvoirifgjn.seirvjrc'), 'active') != 1) {
            return response()->json([
                'message' => 'Unauthorized access: Invalid or inactive cache key',
                'code' => 403
            ], 403);
        }

        // Determine current week range (Monday to Sunday)
        $currentWeekStart = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $currentWeekEnd = $currentWeekStart->copy()->endOfWeek(Carbon::SUNDAY);
        $currentWeekRange = $currentWeekStart->format('Y-m-d') . ' to ' . $currentWeekEnd->format('Y-m-d');

        // Check if weekly_orders has been initialized
        $isInitialized = Cache::get('weekly_orders_initialized', false);

        // Fetch active shops
        $shops = $this->repository->getAllActiveShopsWithOrders();

        // Process shops
        $responseData = $shops->map(function ($shop) use ($isInitialized, $currentWeekStart, $currentWeekEnd, $currentWeekRange) {

            if (!$isInitialized) {
                // First run: Process all orders
                $orders = $shop->orders;

                $weeklyOrders = $orders->groupBy(function ($order) {
                    $date = Carbon::parse($order->created_at);
                    $startOfWeek = $date->startOfWeek(Carbon::MONDAY);
                    $endOfWeek = $startOfWeek->copy()->endOfWeek(Carbon::SUNDAY);
                    $weekRange = $startOfWeek->format('Y-m-d') . ' to ' . $endOfWeek->format('Y-m-d');

                    return $weekRange;
                })->map(function ($weekOrders, $weekRange) use ($shop) {

                    $orderIds = $weekOrders->pluck('id')->toArray();
                    $totalPrice = $weekOrders->sum('total_price') ?? 0;
                    $ordersCount = $weekOrders->count();
                    $totalCommission = $weekOrders->sum('commission_fee') ?? 0; // Use commission_fee
                    $totalDiscounts = $weekOrders->sum('total_discount') ?? 0; // Use total_discount



                    // Save to weekly_orders
                    try {
                        DB::transaction(function () use ($shop, $weekRange, $orderIds, $totalPrice, $ordersCount, $totalCommission, $totalDiscounts) {
                            ShopWeeklyReport::updateOrCreate(
                                [
                                    'shop_id' => $shop->id,
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

                        throw $e;
                    }

                    return [
                        'week_range' => $weekRange,
                        'orders' => OrderResource::collection($weekOrders),
                        'statistics' => [
                            'orders_count' => $ordersCount,
                            'total_price' => $totalPrice,
                            'total_commission' => $totalCommission,
                            'total_discounts' => $totalDiscounts,
                        ],
                    ];
                })->values();

                // Mark as initialized (no expiration)
                Cache::forever('weekly_orders_initialized', true);
            } else {
                // Subsequent runs: Process only current week's orders

                $currentWeekOrders = $shop->orders->filter(function ($order) use ($currentWeekStart, $currentWeekEnd) {
                    $isInWeek = Carbon::parse($order->created_at)->between($currentWeekStart, $currentWeekEnd);

                    return $isInWeek;
                });

                // Save or update current week's orders
                if ($currentWeekOrders->isNotEmpty()) {
                    $orderIds = $currentWeekOrders->pluck('id')->toArray();
                    $totalPrice = $currentWeekOrders->sum('total_price') ?? 0;
                    $ordersCount = $currentWeekOrders->count();
                    $totalCommission = $currentWeekOrders->sum('commission_fee') ?? 0;
                    $totalDiscounts = $currentWeekOrders->sum('total_discount') ?? 0;



                    try {
                        DB::transaction(function () use ($shop, $currentWeekRange, $orderIds, $totalPrice, $ordersCount, $totalCommission, $totalDiscounts) {
                            ShopWeeklyReport::updateOrCreate(
                                [
                                    'shop_id' => $shop->id,
                                    'week_identifier' => $currentWeekRange,
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

                        throw $e;
                    }
                }

                // Fetch all weekly orders from database
                $weeklyOrders = ShopWeeklyReport::where('shop_id', $shop->id)
                    ->when(request('status'), function ($query, $status) {
                        return $query->where('status', $status);
                    })
                    ->get()
                    ->map(function ($weeklyOrder) use ($shop, $currentWeekRange) {

                        $orders = $weeklyOrder->week_identifier === $currentWeekRange
                            ? $shop->orders->whereIn('id', json_decode($weeklyOrder->order_ids, true) ?: [])
                            : collect([]);

                        return [
                            'week_range' => $weeklyOrder->week_identifier,
                            'orders' => OrderResource::collection($orders),
                            'statistics' => [
                                'orders_count' => $weeklyOrder->orders_count,
                                'total_price' => $weeklyOrder->total_price,
                                'total_commission' => $weeklyOrder->total_commission ?? 0,
                                'total_discounts' => $weeklyOrder->total_discounts ?? 0,
                            ],
                            'record_id' => $weeklyOrder->id,
                            'status' => $weeklyOrder->status,
                        ];
                    })->values();
                Log::info('Weekly orders fetched from database', ['shop_id' => $shop->id, 'week_count' => $weeklyOrders->count()]);
            }

            unset($shop->orders); // Remove orders to avoid redundancy

            return [
                'shop' => ShopResource::make($shop),
                'weekly_orders' => $weeklyOrders,
            ];
        });


        return $this->successResponse(
            __('errors.' . ResponseError::SUCCESS, locale: $this->language),
            $responseData
        );
    }



    public function updateWeeklyOrderStatus(Request $request, $shopUuid)
    {
        Log::info('updateWeeklyOrderStatus started', [
            'shop_uuid' => $shopUuid,
            'timestamp' => now()->toDateTimeString(),
            'request_data' => $request->all()
        ]);
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

            // Log the update
            Log::info('Weekly order status updated', [
                'record_id' => $weeklyOrder->id,
                'shop_id' => $shop->id,
                'new_status' => $request->status
            ]);

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
        log::info('getShopDetailWithOrders started', [
            'request_data' => $request->all(),
            'timestamp' => now()->toDateTimeString()
        ]);
        // Get record_id from request
        $recordId = $request->input('record_id');

        //get record from ShopWeeklyReport
        $weeklyReport = ShopWeeklyReport::find($recordId);
        if (!$weeklyReport) {
            return $this->onErrorResponse([
                'code'      => ResponseError::ERROR_404,
                'message'   => __('errors.' . ResponseError::ERROR_404, locale: $this->language)
            ]);
        }
        // Get shop UUID from the weekly report
        $uuid = $weeklyReport->shop->id;
        Log::info('Fetching shop details with orders', [
            'record_id' => $recordId,
            'shop_uuid' => $uuid,
            'timestamp' => now()->toDateTimeString()
        ]);
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
        //get order ids from weekly report
        $orderIds = json_decode($weeklyReport->order_ids, true) ?: [];
        // Filter orders based on the order IDs from the weekly report
        $orders = $shop->orders->whereIn('id', $orderIds)->values(); // Add values() to reset keys and ensure array

        // Calculate total commission
        $totalCommission = $orders->sum('commission_fee');
        $totalDiscount = $orders->sum('discount_amount') ?? 0;


        // Remove orders from shop object to avoid duplication in response

        //add log for debugging
        Log::info('Shop detail with orders fetched', [
            'shop' => $shop,
            'orders_count' => $orders->count(),
            'total_commission' => $totalCommission,
            'total_discounts' => $totalDiscount,
            'record_id' => $recordId
        ]);
        return $this->successResponse(
            __('errors.' . ResponseError::SUCCESS, locale: $this->language),
            [
                'recordId' => $recordId,
                'shop' => ShopResource::make($shop),
                'orders' => $orders,
                'total_commission' => $totalCommission,
                'total_discounts' => $totalDiscount
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

        $record_id = $uuid;

        try {

            $shop = $this->repository->shopDetailsWithOrders($uuid);

            if (empty($shop)) {
                Log::warning('Shop not found for UUID: ' . $uuid);
                return response()->json(['message' => 'Invoice target shop not found.'], 404);
            }

            if (!Cache::get('tvoirifgjn.seirvjrc') || data_get(Cache::get('tvoirifgjn.seirvjrc'), 'active') != 1) {

                return response()->json(['message' => 'You are not authorized to perform this action.'], 403);
            }
            $totalCommission = $shop->orders->sum('commission_fee');
            $orders = $shop->orders;
            unset($shop->orders);

            $logo = Settings::where('key', 'logo')->first()?->value;
            $lang = $this->language;

            PDF::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif', 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

            $pdf = PDF::loadView('shop-invoice', compact('shop', 'orders', 'totalCommission', 'logo', 'lang', 'record_id'));


            return $pdf->download('invoice.pdf');
        } catch (\Exception $e) {

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
        foreach ($deliveryMans as $deliveryMan) {
            try {
                DB::transaction(function () use ($deliveryMan, $weekRange) {
                    $orderIds = $deliveryMan->deliveryManOrders->pluck('id')->toArray();
                    $totalPrice = $deliveryMan->deliveryManOrders->sum('total_price') ?? 0;
                    $ordersCount = $deliveryMan->deliveryManOrders->count();
                    $totalCommission = $deliveryMan->deliveryManOrders->sum('commission_fee') ?? 0;
                    $totalDiscounts = $deliveryMan->deliveryManOrders->sum('total_discount') ?? 0;

                    // Assuming you have a DeliveryManWeeklyReport model/table
                    \App\Models\DeliveryManWeeklyReport::updateOrCreate(
                        [
                            'delivery_man_id' => $deliveryMan->id,
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
                Log::error('Error saving delivery man weekly report', [
                    'delivery_man_id' => $deliveryMan->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $weeklyReports = \App\Models\DeliveryManWeeklyReport::whereIn('delivery_man_id', $deliveryMans->pluck('id'))
            ->get()
            ->groupBy('delivery_man_id');

        $responseData = $deliveryMans->map(function ($deliveryMan) use ($weeklyReports) {
            $reports = $weeklyReports->get($deliveryMan->id, collect());
            return [
                'deliveryMan' => UserResource::make($deliveryMan),
                'weekly_reports' => $reports->map(function ($report) use ($deliveryMan) {
                    $orderIds = json_decode($report->order_ids, true) ?: [];
                    $orders = $deliveryMan->deliveryManOrders->whereIn('id', $orderIds)->values();
                    return [
                        'week_range' => $report->week_identifier,
                        'orders' => OrderResource::collection($orders),
                        'statistics' => [
                            'orders_count' => $report->orders_count,
                            'total_price' => $report->total_price,
                            'total_commission' => $report->total_commission ?? 0,
                            'total_discounts' => $report->total_discounts ?? 0,
                        ],
                        'record_id' => $report->id,
                        'status' => $report->status,
                    ];
                })->values(),
            ];
        });


        return $this->successResponse(
            __('errors.' . ResponseError::SUCCESS, locale: $this->language),
            $responseData
        );
    }


public function getDeliveryManDetail($id): JsonResponse
{
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

            // Find the weekly order
            $weeklyReports = DeliveryManWeeklyReport::where('delivery_man_id', $id)
                ->first();

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

    //downloadDeliveryManInvoice

    public function downloadDeliveryManInvoice($id)
    {
        $deliveryMan = User::where('id', $id)->first();
            if (!$deliveryMan) {
                return response()->json([
                    'status' => false,
                    'message' => 'DeliveryMan not found'
                ], 404);
            }

        Log::info('Starting invoice download process for DeliveryMan ID: ' . $deliveryMan);



        $totalCommission = $deliveryMan->orders->sum('commission_fee');
        $orders = $deliveryMan->delivery_man_orders;
        unset($deliveryMan->orders);

        Log::info('orders count: ' . $orders);

        $logo = Settings::where('key', 'logo')->first()?->value;
        $lang = $this->language;

        Log::info('Data prepared. Logo path: ' . ($logo ?? 'NULL'));

        // Generate PDF
        Log::info('Setting PDF options and loading view: shop-invoice');
        PDF::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif', 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

        $pdf = PDF::loadView('deliveryman-invoice', compact('deliveryMan', 'orders', 'totalCommission', 'logo', 'lang'));



        return $pdf->download('invoice.pdf');
    }
}
