<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DeliveryManInvoiceExport implements FromCollection, WithHeadings
{
    protected $filterData;

    public function __construct(array $filterData)
    {
        $this->filterData = $filterData;
    }

    protected function filterAndSummarizeByDeliveryMan(array $data)
    {
        $grouped = [];

        foreach ($data as $item) {
            $deliveryManId = $item['delivery_man_id'];

            if (!isset($grouped[$deliveryManId])) {
                $grouped[$deliveryManId] = [
                    'delivery_man_id' => $deliveryManId, // needed for name resolution later
                    'Orders Count'    => 0,
                    'Total Price'     => 0,
                    'Status'          => $item['status'] ?? 'unpaid',
                ];
            }

            $grouped[$deliveryManId]['Total Price']  += $item['total_price'] ?? 0;
            $grouped[$deliveryManId]['Orders Count'] += $item['orders_count'] ?? 0;
        }

        return array_values($grouped);
    }

    public function collection()
    {
        // \Log::info('Data in Delivery Man Excel Export File: ' . print_r($this->filterData, true));

        $groupedData = $this->filterAndSummarizeByDeliveryMan($this->filterData);

        return collect($groupedData)->map(function ($item) {
            $user = User::find($item['delivery_man_id']);
            $fullName = $user ? $user->firstname . ' ' . $user->lastname : 'Unknown';

            return [
                'Delivery Man'  => $fullName,
                'Orders Count'  => $item['Orders Count'],
                'Total Price'   => $item['Total Price'],
                'Status'        => $item['Status'],
            ];
        });
    }



    public function headings(): array
    {
        return [
            'Delivery Man',
            'Orders Count',
            'Total Price',
            'Status',
        ];
    }
}
