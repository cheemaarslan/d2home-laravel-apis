<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Shop;

class ShopInvoiceExport implements FromCollection, WithHeadings
{
    protected $filterData;

    public function __construct(array $filterData)
    {
        $this->filterData = $filterData;
    }

    public function collection()
    {
        $groupedData = $this->filterAndSummarizeByShopName($this->filterData);

        return collect($groupedData)->map(function ($item) {
            return [
                'Seller Name'   => $item['seller_name'],
                'Orders Count'  => $item['orders_count'],
                'Total Price'   => $item['total_price'],
                'Commission'    => $item['total_commission'],
                'Discounts'     => $item['total_discounts'],
                'Status'        => $item['status'],
            ];
        });
    }

    protected function filterAndSummarizeByShopName(array $data)
    {
        $shopIds = collect($data)->pluck('shop_id')->unique();
        $shops = Shop::with('seller')->whereIn('id', $shopIds)->get()->keyBy('id');

        $grouped = [];
        foreach ($data as $item) {
            $shop = $shops->get($item['shop_id']);
            $sellerName = $shop && $shop->seller ? trim($shop->seller->firstname . ' ' . $shop->seller->lastname) : '';
            $key = $sellerName; // group by seller name now (or you can use any unique key)

            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'seller_name'      => $sellerName,
                    'orders_count'     => 0,
                    'total_price'      => 0,
                    'total_commission' => 0,
                    'total_discounts'  => 0,
                    'status'           => $item['status'],
                ];
            }

            $grouped[$key]['orders_count']     += $item['orders_count'];
            $grouped[$key]['total_price']      += $item['total_price'];
            $grouped[$key]['total_commission'] += $item['total_commission'];
            $grouped[$key]['total_discounts']  += $item['total_discounts'];
        }

        return array_values($grouped);
    }

    public function headings(): array
    {
        return [
            'Seller Name',
            'Orders Count',
            'Total Price',
            'Commission',
            'Discounts',
            'Status',
        ];
    }
}
