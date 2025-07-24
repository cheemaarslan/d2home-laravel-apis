<?php

namespace App\Http\Resources;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Bonus\SimpleBonusResource;

class OrderStockResource extends JsonResource
{
    protected $note;

    public function __construct($resource, $note = null)
    {
        parent::__construct($resource);
        $this->note = $note;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */



    public function toArray($request): array
    {


        $price = $this->rate_price;
        $total_price = $this->rate_total_price;

        //make conditon if the note contains 'BOGO free item' then set price to 0
        if (!empty($this->note) && Str::contains($this->note, 'BOGO free item')) {

            $price = 0;
            $total_price = 0;
        }

        /** @var Stock|JsonResource $this */
        return [
            'id'                => $this->id,
            'countable_id'      => $this->when($this->countable_id, $this->countable_id),
            'price'             => $this->when($price, $price),
            'quantity'          => $this->when($this->quantity, $this->quantity),
            'discount'          => $this->when($this->rate_actual_discount, (float) $this->rate_actual_discount),
            'tax'               => $this->when($this->rate_tax_price, $this->rate_tax_price),
            'total_price'       => $this->when($total_price, $total_price),
            'addon'             => (bool)$this->addon,
            'deleted_at'        => $this->when($this->deleted_at, $this->deleted_at?->format('Y-m-d H:i:s') . 'Z'),
            'addons'            => StockAddonResource::collection($this->whenLoaded('addons')),

            // Relation
            'extras'            => ExtraValueResource::collection($this->whenLoaded('stockExtras')),
            'product'           => ProductResource::make($this->whenLoaded('countable')),
            'bonus'             => SimpleBonusResource::make($this->whenLoaded('bonus')),
        ];
    }
}
