<?php

namespace App\Models;

use Eloquent;
use App\Models\User;
use App\Traits\Loadable;
use Illuminate\Support\Carbon;
use Database\Factories\CouponFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Coupon
 *
 * @property int $id
 * @property int $shop_id
 * @property string $name
 * @property string $type
 * @property string $for
 * @property int $qty
 * @property float $price
 * @property string $expired_at
 * @property string|null $img
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection|Gallery[] $galleries
 * @property-read int|null $galleries_count
 * @property-read Collection|OrderCoupon[] $orderCoupon
 * @property-read int|null $order_coupon_count
 * @property-read Shop $shop
 * @property-read CouponTranslation|null $translation
 * @property-read Collection|CouponTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static Builder|self checkCoupon($coupon, $shopId)
 * @method static CouponFactory factory(...$parameters)
 * @method static Builder|self filter($array)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self increment($column, $amount = 1, array $extra = [])
 * @method static Builder|self decrement($column, $amount = 1, array $extra = [])
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereExpiredAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereImg($value)
 * @method static Builder|self whereName($value)
 * @method static Builder|self wherePrice($value)
 * @method static Builder|self whereQty($value)
 * @method static Builder|self whereShopId($value)
 * @method static Builder|self whereType($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Coupon extends Model
{
    use HasFactory, Loadable, SoftDeletes;

    protected $guarded = ['id'];

    public function translations(): HasMany
    {
        return $this->hasMany(CouponTranslation::class);
    }

    public function translation(): HasOne
    {
        return $this->hasOne(CouponTranslation::class);
    }

    public function orderCoupon(): HasMany
    {
        return $this->hasMany(OrderCoupon::class, 'name', 'name');
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function users()
{
    return $this->belongsToMany(User::class, 'coupon_user');
}

    public static function scopeCheckCoupon($query, $coupon, $shopId) {
        return $query
            ->where('name', '=', $coupon)
            ->where('shop_id', $shopId)
            ->where('qty', '>', 0)
            ->whereDate('expired_at', '>', now());
    }

    public function scopeFilter($query, $array)
    {
        $query
            ->when(data_get($array, 'shop_id'), function ($q, $shopId) {
                $q->where('shop_id', $shopId);
            })
            ->when(data_get($array, 'type'), function ($q, $type) {
                $q->where('type', $type);
            })
            ->when(data_get($array, 'for'), function ($q, $for) {
                $q->where('for', $for);
            })
            ->when(data_get($array, 'price'), function ($q, $price) {
                $q->where('price', $price);
            })
            ->when(data_get($array, 'qty'), function ($q, $qty) {
                $q->where('qty', $qty);
            })
            ->when(data_get($array, 'expired_from'), function ($q, $expiredFrom) use ($array) {
                $expiredFrom = date('Y-m-d', strtotime($expiredFrom));

                $expiredTo = data_get($array, 'expired_to', date('Y-m-d'));

                $expiredTo = date('Y-m-d', strtotime($expiredTo));

                $q->where([
                    ['expired_at', '>=', $expiredFrom],
                    ['expired_at', '<=', $expiredTo],
                ]);
            });
    }
}
