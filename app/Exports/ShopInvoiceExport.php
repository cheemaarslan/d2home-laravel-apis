<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ShopInvoiceExport implements FromCollection, WithHeadings, WithStyles
{
    protected $shop;
    protected $weeklyRecord;
    protected $orders;

    public function __construct($shop, $weeklyRecord, $orders)
    {
        $this->shop = $shop;
        $this->weeklyRecord = $weeklyRecord;
        $this->orders = $orders;
    }

    public function collection()
    {
        $data = [];
        
        // Add shop and weekly record info
        $data[] = ['Shop Name', $this->shop->name];
        $data[] = ['Week Range', $this->weeklyRecord->week_identifier];
        $data[] = ['Total Price', $this->weeklyRecord->total_price];
        $data[] = ['Total Commission', $this->weeklyRecord->total_commission];
        $data[] = ['Total Discounts', $this->weeklyRecord->total_discounts];
        $data[] = ['Status', ucfirst($this->weeklyRecord->status)];
        $data[] = []; // Empty row
        
        // Add orders header
        $data[] = ['Order Details'];
        $data[] = [
            'Order ID',
            'Date',
            'Status',
            'Total Price',
            'Commission Fee',
            'Delivery Fee',
            'Service Fee',
            'Customer Phone',
            'Delivery Address'
        ];
        
        // Add order data
        foreach ($this->orders as $order) {
            $data[] = [
                $order->id,
                $order->delivery_date . ' ' . $order->delivery_time,
                ucfirst($order->status),
                $order->total_price,
                $order->commission_fee,
                $order->delivery_fee,
                $order->service_fee,
                $order->phone,
                $order->address['address'] ?? 'N/A'
            ];
        }
        
        return collect($data);
    }

    public function headings(): array
    {
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row (shop info) as bold
            1 => ['font' => ['bold' => true]],
            2 => ['font' => ['bold' => true]],
            3 => ['font' => ['bold' => true]],
            4 => ['font' => ['bold' => true]],
            5 => ['font' => ['bold' => true]],
            6 => ['font' => ['bold' => true]],
            
            // Style the orders header row
            8 => ['font' => ['bold' => true]],
            
            // Set column widths
            'A' => ['width' => 15],
            'B' => ['width' => 20],
            'C' => ['width' => 15],
            'D' => ['width' => 15],
            'E' => ['width' => 15],
            'F' => ['width' => 15],
            'G' => ['width' => 15],
            'H' => ['width' => 20],
            'I' => ['width' => 40],
        ];
    }
}