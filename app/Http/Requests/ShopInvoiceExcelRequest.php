<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopInvoiceExcelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'params.filteredData' => 'required|array|min:1',
            'params.filteredData.*.shop.id' => 'required|integer|exists:shops,id',
            'params.filteredData.*.shop.uuid' => 'required|uuid',
            'params.filteredData.*.shop.name' => 'required|string|max:255',
            'params.filteredData.*.week_range' => 'required|string|max:255',
            'params.filteredData.*.orders_count' => 'required|integer|min:0',
            'params.filteredData.*.total_price' => 'required|numeric|min:0',
            'params.filteredData.*.total_commission' => 'required|numeric|min:0',
            'params.filteredData.*.total_discounts' => 'required|numeric|min:0',
            'params.filteredData.*.status' => 'required|string|in:paid,unpaid',
            'params.filteredData.*.record_id' => 'required|integer|min:1',
        ];
    }
}
