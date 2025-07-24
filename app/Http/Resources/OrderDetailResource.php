<?php

namespace App\Http\Resources;

use Log;
use App\Models\OrderDetail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {



        /** @var OrderDetail|JsonResource $this */

        $totalPrice = $this->rate_total_price;
        $originPrice = $this->rate_origin_price;
        $rate_tax = $this->rate_tax;
        $authUser = auth('sanctum')->user();

        if ($authUser && method_exists($authUser, 'hasRole')) {


            if ($authUser->hasRole('user') || $authUser->hasRole('seller') || $authUser->hasRole('deliveryman') || $authUser->hasRole('admin')) {


                if (!empty($this->note) && Str::contains($this->note, 'BOGO free item')) {
                    $totalPrice = 0;
                    $originPrice = 0;
                    $rate_tax = 0;
                }
            }
        }

        return [
            'id'            => $this->when($this->id, $this->id),
            'order_id'      => $this->when($this->order_id, $this->order_id),
            'stock_id'      => $this->when($this->stock_id, $this->stock_id),
            'kitchen_id'    => $this->when($this->kitchen_id, $this->kitchen_id),
            'cook_id'       => $this->when($this->cook_id, $this->cook_id),
            'note'          => $this->when($this->note, $this->note),
            'origin_price'  => $this->when($originPrice, $originPrice),
            'total_price'   => $totalPrice,
            'tax'           => $this->when($rate_tax, $rate_tax),
            'discount'      => $this->when($this->rate_discount, $this->rate_discount),
            'quantity'      => $this->when($this->quantity, $this->quantity),
            'status'        => $this->when($this->status, $this->status),
            'bonus'         => (bool)$this->bonus,
            'created_at'    => $this->when($this->created_at, $this->created_at?->format('Y-m-d H:i:s') . 'Z'),
            'updated_at'    => $this->when($this->updated_at, $this->updated_at?->format('Y-m-d H:i:s') . 'Z'),

            // Relations
            'kitchen'       => KitchenResource::make($this->whenLoaded('kitchen')),
            'cooker'        => UserResource::make($this->whenLoaded('cooker')),
            'stock' => $this->relationLoaded('stock')
                ? new OrderStockResource($this->stock, $this->note)
                : null,
            'parent'        => OrderDetailResource::make($this->whenLoaded('parent')),
            'addons'        => OrderDetailResource::collection($this->whenLoaded('children')),
        ];
    }
}
