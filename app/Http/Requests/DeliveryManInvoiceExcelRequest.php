<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryManInvoiceExcelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'params.filteredData' => 'required|array|min:1',
            'params.filteredData.*.deliveryMan.id' => 'required|integer|exists:users,id',
            'params.filteredData.*.deliveryMan.uuid' => 'required|uuid',
            'params.filteredData.*.deliveryMan.firstname' => 'required|string|max:255',
            'params.filteredData.*.deliveryMan.lastname' => 'required|string|max:255',
            'params.filteredData.*.deliveryMan.email' => 'required|email|max:255',
            'params.filteredData.*.deliveryMan.phone' => 'required|string|max:20',
            'params.filteredData.*.weekly_reports' => 'required|array',
            'params.filteredData.*.weekly_reports.*.week_range' => 'required|string|max:255',
            'params.filteredData.*.weekly_reports.*.statistics.orders_count' => 'required|integer|min:0',
            'params.filteredData.*.weekly_reports.*.statistics.total_price' => 'required|numeric|min:0',
            'params.filteredData.*.weekly_reports.*.statistics.total_commission' => 'required|numeric|min:0',
            'params.filteredData.*.weekly_reports.*.statistics.total_discounts' => 'required|numeric|min:0',
            'params.filteredData.*.weekly_reports.*.record_id' => 'required|integer|min:1',
            'params.filteredData.*.weekly_reports.*.status' => 'nullable|string|in:paid,unpaid',
        ];
    }
}
