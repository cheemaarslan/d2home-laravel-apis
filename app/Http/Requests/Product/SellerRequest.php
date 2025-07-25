<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseRequest;
use App\Models\Category;
use Illuminate\Validation\Rule;

class SellerRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $isAddon = [
            'required',
            Rule::exists('categories', 'id')
				->whereNull('deleted_at')
                ->whereIn('type', [Category::MAIN, Category::SUB_MAIN]),
        ];

        return [
            'category_id'           => (int)request('addon') === 1 ? 'nullable' : $isAddon,
            'brand_id'              => ['nullable', Rule::exists('brands', 'id')
            ],
            'unit_id'               => ['nullable', Rule::exists('units', 'id')->where('active', true)
            ],
            'kitchen_id'            => [Rule::exists('kitchens', 'id')],
            'keywords'              => 'string',
            'images'                => ['array'],
            'images.*'              => ['string'],
            'title'                 => ['required', 'array'],
            'title.*'               => ['required', 'string', 'min:1', 'max:191'],
            'description'           => ['array'],
            'description.*'         => ['string', 'min:1'],
            'tax'                   => 'numeric',
            'qr_code'               => ['string', Rule::unique('products','qr_code')
                ->ignore(request()->route('product'),'uuid')
            ],
            'active'                => 'boolean',
            'addon'                 => 'boolean',
            'vegetarian'            => 'boolean',
            'interval'              => 'numeric',
            'is_bogo'               => 'numeric',
            'kcal'                  => 'string|max:10',
            'carbs'                 => 'string|max:10',
            'protein'               => 'string|max:10',
            'fats'                  => 'string|max:10',
            'min_qty'               => 'numeric',
            'max_qty'               => 'numeric',

//			'inventory_items' 	   					=> 'required|array',
//			'inventory_items.*.inventory_item_id' 	=> 'required|string',
//			'inventory_items.*.interval' 			=> 'required|string',

            'meta'                  => ['array'],
            'meta.*'                => ['array'],
            'meta.*.path'           => 'string',
            'meta.*.title'          => 'required|string',
            'meta.*.keywords'       => 'string',
            'meta.*.description'    => 'string',
            'meta.*.h1'             => 'string',
            'meta.*.seo_text'       => 'string',
            'meta.*.canonical'      => 'string',
            'meta.*.robots'         => 'string',
            'meta.*.change_freq'    => 'string',
            'meta.*.priority'       => 'string',
        ];
    }
}
