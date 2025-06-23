<?php

namespace App\Models;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShopWeeklyReport extends Model
{
    use HasFactory;
    protected $fillable = [
    'shop_id',
    'week_identifier',
    'order_ids',
    'total_price',
    'orders_count',
    'total_commission',
    'total_discounts',
];


    //shop
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }




}
