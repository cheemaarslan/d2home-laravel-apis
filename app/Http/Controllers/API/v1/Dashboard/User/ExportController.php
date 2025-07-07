<?php

namespace App\Http\Controllers\API\v1\Dashboard\User;

use App\Models\Order;
use App\Models\Language;
use App\Models\Settings;
use Illuminate\Http\Response;
use App\Helpers\ResponseError;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;

class ExportController extends UserBaseController
{
    /**
     * @param int $id
     * @return Response|JsonResponse|Application|ResponseFactory
     */
    public function orderExportPDF(int $id): Response|JsonResponse|Application|ResponseFactory
    {
        $locale = data_get(Language::languagesList()->where('default', 1)->first(), 'locale');

        $order = Order::with([
            'orderDetails' => fn($q) => $q->whereNull('parent_id'),
            'orderDetails.stock.countable.translation'  => fn($q) => $q->where(fn($q) => $q->where('locale', $this->language)->orWhere('locale', $locale)),
            'orderDetails.children.stock.countable.translation'  => fn($q) => $q->where(fn($q) => $q->where('locale', $this->language)->orWhere('locale', $locale)),
            'orderDetails.stock.stockExtras.group.translation' => function ($q) use($locale) {
                $q->select('id', 'extra_group_id', 'locale', 'title')
                    ->where(fn($q) => $q->where('locale', $this->language)->orWhere('locale', $locale));
            },
            'shop:id,phone',
            'shop.seller:id,phone',
            'shop.translation' => fn($q) => $q->select('id', 'shop_id', 'locale', 'title', 'address')
                ->where(fn($q) => $q->where('locale', $this->language)->orWhere('locale', $locale)),
            'user:id,phone,firstname,lastname',
            'currency:id,symbol'
        ])->find($id);

        if (!$order) {
            return $this->onErrorResponse([
                'code'    => ResponseError::ERROR_404,
                'message' => __('errors.' . ResponseError::ERROR_404, locale: $this->language)
            ]);
        }

        $logo = Settings::where('key', 'logo')->first()?->value;

		Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);

        $lang = $this->language;
        Log::info('Exporting order to PDF', [
            'order' => $order,
            'language' => $lang,
            'logo'     => $logo
        ]);

     $deliveryFreeCouponUsed = \DB::table('coupon_user')
                   ->where('user_id', $order->user_id)
                   ->where('order_id', $order->id)
                   ->exists();

        $pdf = PDF::loadView('order-invoice', compact('order', 'logo', 'lang', 'deliveryFreeCouponUsed'));

        return $pdf->download('invoice.pdf');
    }

}
