<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryManWeeklyReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'delivery_man_id',
        'week_identifier',
        'order_ids',
        'total_price',
        'orders_count',
        'total_commission',
        'total_discounts',
        'status'
    ];

    protected $casts = [
        'order_ids' => 'array',
        'total_price' => 'float',
        'total_commission' => 'float',
        'total_discounts' => 'float',
    ];

    // Optional: Define relationship if needed
    public function deliveryMan()
    {
        return $this->belongsTo(User::class);
    }

}
