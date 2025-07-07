<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\ActiveReferral
 *
 * @property int $id
 * @property int $referral_id
 * @property int $from_id
 * @property int $to_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Referral|null $referral
 * @property-read User|null $from
 * @property-read User|null $to
 * @method static Builder|ActiveReferral newModelQuery()
 * @method static Builder|ActiveReferral newQuery()
 * @method static Builder|ActiveReferral query()
 * @method static Builder|ActiveReferral whereCreatedAt($value)
 * @method static Builder|ActiveReferral whereUpdatedAt($value)
 * @method static Builder|ActiveReferral whereDeletedAt($value)
 * @method static Builder|ActiveReferral whereId($value)
 * @method static Builder|ActiveReferral whereReferralId($value)
 * @method static Builder|ActiveReferral whereFromId($value)
 * @method static Builder|ActiveReferral whereToId($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ActiveReferral onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ActiveReferral withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ActiveReferral withoutTrashed()
 */
	class ActiveReferral extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AdsPackage
 *
 * @property int $id
 * @property boolean $active
 * @property string $time_type
 * @property int $time
 * @property double $price
 * @property int $banner_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property Collection|AdsPackageTranslation[] $translations
 * @property AdsPackageTranslation|null $translation
 * @property Banner|null $banner
 * @property ShopAdsPackage|null $shopAdsPackage
 * @property Collection|ShopAdsPackage[] $shopAdsPackages
 * @property int|null $translations_count
 * @method static Builder|self active()
 * @method static Builder|self filter(array $filter)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereId($value)
 * @mixin Eloquent
 * @property int $input
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gallery> $galleries
 * @property-read int|null $galleries_count
 * @property-read \App\Models\Gallery|null $gallery
 * @property-read int|null $shop_ads_packages_count
 * @method static \Illuminate\Database\Eloquent\Builder|AdsPackage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AdsPackage whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsPackage whereBannerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsPackage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsPackage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsPackage whereInput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsPackage wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsPackage whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsPackage whereTimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsPackage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsPackage withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AdsPackage withoutTrashed()
 */
	class AdsPackage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AdsPackageTranslation
 *
 * @property int $id
 * @property int $ads_package_id
 * @property string $locale
 * @property string $title
 * @property Carbon|null $deleted_at
 * @property AdsPackage|null adsPackage
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereAreaId($value)
 * @method static Builder|self whereTitle($value)
 * @mixin Eloquent
 * @property-read \App\Models\AdsPackage|null $adsPackage
 * @method static \Illuminate\Database\Eloquent\Builder|AdsPackageTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AdsPackageTranslation whereAdsPackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsPackageTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsPackageTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdsPackageTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AdsPackageTranslation withoutTrashed()
 */
	class AdsPackageTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShopTag
 *
 * @property int $shop_tag_id
 * @property int $shop_id
 * @property Shop|null $shop
 * @property ShopTag|null $shop_tag
 * @method static Builder|AssignShopTag newModelQuery()
 * @method static Builder|AssignShopTag newQuery()
 * @method static Builder|AssignShopTag query()
 * @method static Builder|AssignShopTag whereId($value)
 * @method static Builder|AssignShopTag whereShopId($value)
 * @method static Builder|AssignShopTag whereShopTagId($value)
 * @mixin Eloquent
 * @property-read \App\Models\ShopTag $shopTag
 */
	class AssignShopTag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BackupHistory
 *
 * @property int $id
 * @property string $title
 * @property int $status
 * @property string|null $path
 * @property int $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $deleted_at
 * @property-read User $user
 * @method static Builder|BackupHistory newModelQuery()
 * @method static Builder|BackupHistory newQuery()
 * @method static Builder|BackupHistory query()
 * @method static Builder|BackupHistory whereCreatedAt($value)
 * @method static Builder|BackupHistory whereCreatedBy($value)
 * @method static Builder|BackupHistory whereId($value)
 * @method static Builder|BackupHistory wherePath($value)
 * @method static Builder|BackupHistory whereStatus($value)
 * @method static Builder|BackupHistory whereTitle($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|BackupHistory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BackupHistory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BackupHistory withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BackupHistory withoutTrashed()
 */
	class BackupHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Banner
 *
 * @property int $id
 * @property string|null $url
 * @property string|null $img
 * @property int $active
 * @property string $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property bool $clickable
 * @property bool $input
 * @property-read Collection|Gallery[] $galleries
 * @property-read int|null $galleries_count
 * @property-read Collection|Shop[] $shops
 * @property-read int|null $shops_count
 * @property-read BannerTranslation|null $translation
 * @property-read Collection|BannerTranslation[] $translations
 * @property-read int|null $translations_count
 * @property-read ShopAdsPackage|null $shopAdsPackage
 * @property-read Collection|ShopAdsPackage[] $shopAdsPackages
 * @property-read int|null $shop_ads_packages_count
 * @method static BannerFactory factory(...$parameters)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereActive($value)
 * @method static Builder|self whereClickable($value)
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereDeletedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereImg($value)
 * @method static Builder|self whereProducts($value)
 * @method static Builder|self whereShopId($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereUrl($value)
 * @mixin Eloquent
 * @property-read \App\Models\Gallery|null $gallery
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Like> $likes
 * @property-read int|null $likes_count
 * @method static \Illuminate\Database\Eloquent\Builder|Banner onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereInput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner withoutTrashed()
 */
	class Banner extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BannerShop
 *
 * @property int $id
 * @property int $shop_id
 * @property int $banner_id
 * @property Banner $banner
 * @property Shop $shop
 * @method static Builder|Banner newModelQuery()
 * @method static Builder|Banner newQuery()
 * @method static Builder|Banner query()
 * @method static Builder|Banner whereBannerId($value)
 * @method static Builder|Banner whereShopId($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|BannerShop onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BannerShop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannerShop whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannerShop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannerShop whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannerShop withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BannerShop withoutTrashed()
 */
	class BannerShop extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BannerTranslation
 *
 * @property int $id
 * @property int $banner_id
 * @property string $locale
 * @property string $title
 * @property string|null $description
 * @property string|null $button_text
 * @method static BannerTranslationFactory factory(...$parameters)
 * @method static Builder|BannerTranslation newModelQuery()
 * @method static Builder|BannerTranslation newQuery()
 * @method static Builder|BannerTranslation query()
 * @method static Builder|BannerTranslation whereBannerId($value)
 * @method static Builder|BannerTranslation whereButtonText($value)
 * @method static Builder|BannerTranslation whereDescription($value)
 * @method static Builder|BannerTranslation whereId($value)
 * @method static Builder|BannerTranslation whereLocale($value)
 * @method static Builder|BannerTranslation whereTitle($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|BannerTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BannerTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannerTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BannerTranslation withoutTrashed()
 */
	class BannerTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Blog
 *
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property int $type
 * @property string|null $published_at
 * @property int $active
 * @property string|null $img
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read Collection|Gallery[] $galleries
 * @property-read int|null $galleries_count
 * @property-read Collection|Review[] $reviews
 * @property-read int|null $reviews_count
 * @property-read BlogTranslation|null $translation
 * @property-read Collection|BlogTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static BlogFactory factory(...$parameters)
 * @method static Builder|Blog newModelQuery()
 * @method static Builder|Blog newQuery()
 * @method static Builder|Blog query()
 * @method static Builder|Blog whereActive($value)
 * @method static Builder|Blog whereCreatedAt($value)
 * @method static Builder|Blog whereDeletedAt($value)
 * @method static Builder|Blog whereId($value)
 * @method static Builder|Blog whereImg($value)
 * @method static Builder|Blog wherePublishedAt($value)
 * @method static Builder|Blog whereType($value)
 * @method static Builder|Blog whereUpdatedAt($value)
 * @method static Builder|Blog whereUserId($value)
 * @method static Builder|Blog whereUuid($value)
 * @mixin Eloquent
 * @property-read \App\Models\Gallery|null $gallery
 * @property-read \App\Models\Review|null $review
 * @method static \Illuminate\Database\Eloquent\Builder|Blog onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog withoutTrashed()
 */
	class Blog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BlogTranslation
 *
 * @property int $id
 * @property int $blog_id
 * @property string $locale
 * @property string $title
 * @property string|null $short_desc
 * @property string|null $description
 * @method static BlogTranslationFactory factory(...$parameters)
 * @method static Builder|BlogTranslation newModelQuery()
 * @method static Builder|BlogTranslation newQuery()
 * @method static Builder|BlogTranslation query()
 * @method static Builder|BlogTranslation whereBlogId($value)
 * @method static Builder|BlogTranslation whereDescription($value)
 * @method static Builder|BlogTranslation whereId($value)
 * @method static Builder|BlogTranslation whereLocale($value)
 * @method static Builder|BlogTranslation whereShortDesc($value)
 * @method static Builder|BlogTranslation whereTitle($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation withoutTrashed()
 */
	class BlogTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Bonus
 *
 * @property int $id
 * @property string|null $bonusable_type
 * @property int|null $bonusable_id
 * @property int $bonus_quantity
 * @property int|null $bonus_stock_id
 * @property int|null $value
 * @property int|null $rate_value
 * @property string|null $type
 * @property Carbon|null $expired_at
 * @property int $status
 * @property int $shop_id
 * @property Shop $shop
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Shop|Product|null $bonusable
 * @property-read Stock|null $stock
 * @method static Builder|Bonus active()
 * @method static Builder|Bonus filter(array $filter)
 * @method static Builder|Bonus newModelQuery()
 * @method static Builder|Bonus newQuery()
 * @method static Builder|Bonus query()
 * @method static Builder|Bonus whereStocksId($value)
 * @method static Builder|Bonus whereBonusQuantity($value)
 * @method static Builder|Bonus whereCreatedAt($value)
 * @method static Builder|Bonus whereExpiredAt($value)
 * @method static Builder|Bonus whereId($value)
 * @method static Builder|Bonus whereOrderAmount($value)
 * @method static Builder|Bonus whereShopId($value)
 * @method static Builder|Bonus whereStatus($value)
 * @method static Builder|Bonus whereUpdatedAt($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Database\Factories\BonusFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus whereBonusStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus whereBonusableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus whereBonusableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Bonus withoutTrashed()
 */
	class Bonus extends \Eloquent {}
}

namespace App\Models\Booking{
/**
 * App\Models\Booking
 *
 * @property int $id
 * @property int|null $shop_id
 * @property int|null $max_time
 * @property string|null $start_time
 * @property string|null $end_time
 * @property bool|null $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property Shop|null $shop
 * @property Collection|User[] $users
 * @property int $users_count
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self filter($filter)
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereDeletedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Booking onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereMaxTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking withoutTrashed()
 */
	class Booking extends \Eloquent {}
}

namespace App\Models\Booking{
/**
 * App\Models\BookingShop
 *
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property float $tax
 * @property float $rate_tax
 * @property float $percentage
 * @property array|null $location
 * @property string|null $phone
 * @property int|null $show_type
 * @property boolean $open
 * @property boolean $visibility
 * @property string|null $background_img
 * @property string|null $logo_img
 * @property float $min_amount
 * @property string $status
 * @property integer $price
 * @property integer $price_per_km
 * @property integer $rate_price
 * @property integer $rate_price_per_km
 * @property string|null $status_note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property array|null $delivery_time
 * @property-read Collection|Gallery[] $galleries
 * @property-read int|null $galleries_count
 * @property-read Collection|Discount[] $discounts
 * @property-read int|null $discounts_count
 * @property-read Collection|Invitation[] $invitations
 * @property-read int|null $invitations_count
 * @property-read Collection|OrderDetail[] $orders
 * @property-read int|null $orders_count
 * @property-read Collection|Product[] $products
 * @property-read int|null $products_count
 * @property-read Collection|ShopPayment[] $shopPayments
 * @property-read int|null $shop_payments_count
 * @property-read Collection|Review[] $reviews
 * @property-read DeliveryZone|null $deliveryZone
 * @property-read int|null $reviews_count
 * @property-read int|null $reviews_avg_rating
 * @property-read User $seller
 * @property-read ShopSubscription|null $subscription
 * @property-read ShopTranslation|null $translation
 * @property-read Collection|ShopTranslation[] $translations
 * @property-read int|null $translations_count
 * @property-read Collection|User[] $users
 * @property-read int|null $users_count
 * @property-read Collection|ShopBookingWorkingDay[] $bookingWorkingDays
 * @property-read int|null $booking_working_days_count
 * @property-read Collection|ShopSection[] $shopSections
 * @property-read int|null $shop_sections_count
 * @property-read Collection|ShopBookingClosedDate[] $bookingClosedDates
 * @property-read int|null $booking_closed_dates_count
 * @property-read Collection|ShopTag[] $tags
 * @property-read int|null $tags_count
 * @property float|null $avg_rate
 * @property-read Bonus|null $bonus
 * @property-read ShopDeliverymanSetting|null $shopDeliverymanSetting
 * @property-read Collection|ModelLog[] $logs
 * @property-read int|null $logs_count
 * @method static ShopFactory factory(...$parameters)
 * @method static Builder|self filter($filter)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self onlyTrashed()
 * @method static Builder|self query()
 * @method static Builder|self whereBackgroundImg($value)
 * @method static Builder|self whereCloseTime($value)
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereDeletedAt($value)
 * @method static Builder|self whereDeliveryRange($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereLocation($value)
 * @method static Builder|self whereLogoImg($value)
 * @method static Builder|self whereMinAmount($value)
 * @method static Builder|self whereOpen($value)
 * @method static Builder|self whereOpenTime($value)
 * @method static Builder|self wherePercentage($value)
 * @method static Builder|self wherePhone($value)
 * @method static Builder|self whereShowType($value)
 * @method static Builder|self whereStatus($value)
 * @method static Builder|self whereStatusNote($value)
 * @method static Builder|self whereTax($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereUserId($value)
 * @method static Builder|self whereUuid($value)
 * @method static Builder|self withTrashed()
 * @method static Builder|self withoutTrashed()
 * @mixin Eloquent
 * @property string|null $slug
 * @property int|null $service_fee
 * @property int $verify
 * @property string $order_payment
 * @property string|null $email_statuses
 * @property string|null $wifi_password
 * @property string|null $wifi_name
 * @property int $new_order_after_payment
 * @property int|null $pos_access
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \App\Models\Gallery|null $gallery
 * @method static \Illuminate\Database\Eloquent\Builder|BookingShop whereDeliveryTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingShop whereEmailStatuses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingShop whereNewOrderAfterPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingShop whereOrderPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingShop wherePosAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingShop wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingShop wherePricePerKm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingShop whereServiceFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingShop whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingShop whereVerify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingShop whereVisibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingShop whereWifiName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BookingShop whereWifiPassword($value)
 */
	class BookingShop extends \Eloquent {}
}

namespace App\Models\Booking{
/**
 * App\Models\ShopBookingClosedDate
 *
 * @property int $id
 * @property int $shop_id
 * @property Carbon|null $date
 * @property BookingShop|null $shop
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @method static Builder|self filter($query, $filter)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereShopId($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ShopBookingClosedDate onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopBookingClosedDate whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopBookingClosedDate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopBookingClosedDate withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopBookingClosedDate withoutTrashed()
 */
	class ShopBookingClosedDate extends \Eloquent {}
}

namespace App\Models\Booking{
/**
 * App\Models\ShopBookingWorkingDay
 *
 * @property int $id
 * @property int $shop_id
 * @property string $day
 * @property string|null $from
 * @property string|null $to
 * @property boolean|null $disabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|self filter($array = [])
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereShopId($value)
 * @method static Builder|self whereDay($value)
 * @method static Builder|self whereFrom($value)
 * @method static Builder|self whereTo($value)
 * @mixin Eloquent
 * @property-read \App\Models\Booking\BookingShop $shop
 * @method static \Illuminate\Database\Eloquent\Builder|ShopBookingWorkingDay onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopBookingWorkingDay whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopBookingWorkingDay whereDisabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopBookingWorkingDay withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopBookingWorkingDay withoutTrashed()
 */
	class ShopBookingWorkingDay extends \Eloquent {}
}

namespace App\Models\Booking{
/**
 * App\Models\ShopSection
 *
 * @property int $id
 * @property int $shop_id
 * @property string $area
 * @property string $img
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property Shop|null $shop
 * @property ShopTranslation|null $translation
 * @property int|null $translations_count
 * @property Collection|Table[] $tables
 * @property int|null $tables_count
 * @property Collection|ShopTranslation[] $translations
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self filter(array $filter)
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereDeletedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gallery> $galleries
 * @property-read int|null $galleries_count
 * @property-read \App\Models\Gallery|null $gallery
 * @method static \Illuminate\Database\Eloquent\Builder|ShopSection onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopSection whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopSection whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopSection whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopSection withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopSection withoutTrashed()
 */
	class ShopSection extends \Eloquent {}
}

namespace App\Models\Booking{
/**
 * App\Models\ShopSectionTranslation
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $locale
 * @property int $shop_section_id
 * @property ShopSection|null $shopSection
 * @property string|null $deleted_at
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereId($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ShopSectionTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopSectionTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopSectionTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopSectionTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopSectionTranslation whereShopSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopSectionTranslation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopSectionTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopSectionTranslation withoutTrashed()
 */
	class ShopSectionTranslation extends \Eloquent {}
}

namespace App\Models\Booking{
/**
 * App\Models\Table
 *
 * @property int $id
 * @property string $name
 * @property int $shop_section_id
 * @property double $tax
 * @property int $chair_count
 * @property boolean $active
 * @property ShopSection|null $shopSection
 * @property Collection|User[] $waiters
 * @property Collection|UserBooking[] $users
 * @property int $users_count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self filter(array $filter)
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereDeletedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read \App\Models\User|null $waiter
 * @property-read int|null $waiters_count
 * @method static \Illuminate\Database\Eloquent\Builder|Table onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereChairCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereShopSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Table withoutTrashed()
 */
	class Table extends \Eloquent {}
}

namespace App\Models\Booking{
/**
 * App\Models\UserBooking
 *
 * @property int $id
 * @property int|null $booking_id
 * @property int|null $user_id
 * @property int|null $table_id
 * @property string $status
 * @property string|null $note
 * @property int|null $guest
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property Carbon|null $deleted_at
 * @property Booking|null $booking
 * @property User|null $user
 * @property Table|null $table
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self filter($filter)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|UserBooking onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBooking whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBooking whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBooking whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBooking whereGuest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBooking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBooking whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBooking whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBooking whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBooking whereTableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBooking whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBooking withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBooking withoutTrashed()
 */
	class UserBooking extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Branch
 *
 * @property int $id
 * @property int $shop_id
 * @property int $address
 * @property int $location
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property Shop|null $shop
 * @property Collection|BranchTranslation[] $translations
 * @property BranchTranslation|null $translation
 * @property int|null $translations_count
 * @method static Builder|self filter(array $filter)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereId($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Branch onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Branch withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch withoutTrashed()
 */
	class Branch extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BranchTranslation
 *
 * @property int $id
 * @property int $branch_id
 * @property string $locale
 * @property string $title
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereAddress($value)
 * @method static Builder|self whereDescription($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereLocale($value)
 * @method static Builder|self whereCareerId($value)
 * @method static Builder|self whereTitle($value)
 * @mixin Eloquent
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|BranchTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BranchTranslation whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BranchTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BranchTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BranchTranslation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BranchTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BranchTranslation withoutTrashed()
 */
	class BranchTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Brand
 *
 * @property int $id
 * @property string $slug
 * @property string $uuid
 * @property string $title
 * @property int $active
 * @property string|null $img
 * @property string|null $shop_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read Shop|null $shop
 * @property-read Collection|Gallery[] $galleries
 * @property-read int|null $galleries_count
 * @property-read Collection|Product[] $products
 * @property-read int|null $products_count
 * @property-read Collection|ModelLog[] $logs
 * @property-read int|null $logs_count
 * @method static BrandFactory factory(...$parameters)
 * @method static Builder|self filter($array)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereActive($value)
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereDeletedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereImg($value)
 * @method static Builder|self whereShopId($value)
 * @method static Builder|self whereTitle($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereUuid($value)
 * @mixin Eloquent
 * @property-read \App\Models\Gallery|null $gallery
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MetaTag> $metaTags
 * @property-read int|null $meta_tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Brand onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand withoutTrashed()
 */
	class Brand extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Career
 *
 * @property int $id
 * @property int $category_id
 * @property array $location
 * @property boolean $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property Category $category
 * @property Collection|CareerTranslation[] $translations
 * @property CareerTranslation|null $translation
 * @property int|null $translations_count
 * @method static Builder|self active()
 * @method static Builder|self filter(array $filter)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereId($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Career onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Career whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Career whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Career whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Career whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Career whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Career whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Career withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Career withoutTrashed()
 */
	class Career extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CareerTranslation
 *
 * @property int $id
 * @property int $career_id
 * @property string $locale
 * @property string $title
 * @property string|null $description
 * @property array|null $address
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereAddress($value)
 * @method static Builder|self whereDescription($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereLocale($value)
 * @method static Builder|self whereCareerId($value)
 * @method static Builder|self whereTitle($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|CareerTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CareerTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CareerTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CareerTranslation withoutTrashed()
 */
	class CareerTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Cart
 *
 * @property int $id
 * @property int $shop_id
 * @property int $owner_id
 * @property double $total_price
 * @property double|null $rate_total_price
 * @property double $receipt_discount
 * @property double $receipt_count
 * @property int $status
 * @property int $currency_id
 * @property int $rate
 * @property boolean $group
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read UserCart $userCart
 * @property-read User|BelongsTo $user
 * @property-read Shop|BelongsTo $shop
 * @property-read Currency|BelongsTo $currency
 * @property-read UserCart[]|HasMany|Collection $userCarts
 * @property-read int|null $user_carts_count
 * @method static Builder|Cart newModelQuery()
 * @method static Builder|Cart newQuery()
 * @method static Builder|Cart query()
 * @method static Builder|Cart whereCreatedAt($value)
 * @method static Builder|Cart whereId($value)
 * @method static Builder|Cart whereOwnerId($value)
 * @method static Builder|Cart whereStatus($value)
 * @method static Builder|Cart whereStockId($value)
 * @method static Builder|Cart whereTotalPrice($value)
 * @method static Builder|Cart whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Database\Factories\CartFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereShopId($value)
 */
	class Cart extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CartDetail
 *
 * @property int $id
 * @property int $stock_id
 * @property int $user_cart_id
 * @property int $parent_id
 * @property int $quantity
 * @property float|null $price
 * @property float|null $discount
 * @property int $bonus
 * @property string|null $bonus_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property double $rate_price
 * @property double $rate_discount
 * @property-read Stock|null $stock
 * @property-read CartDetail|null $parent
 * @property-read Collection|CartDetail[] $children
 * @property-read UserCart $userCart
 * @method static Builder|CartDetail newModelQuery()
 * @method static Builder|CartDetail newQuery()
 * @method static Builder|CartDetail query()
 * @method static Builder|CartDetail whereBonus($value)
 * @method static Builder|CartDetail whereCreatedAt($value)
 * @method static Builder|CartDetail whereId($value)
 * @method static Builder|CartDetail wherePrice($value)
 * @method static Builder|CartDetail whereQuantity($value)
 * @method static Builder|CartDetail whereStockId($value)
 * @method static Builder|CartDetail whereUpdatedAt($value)
 * @method static Builder|CartDetail whereUserCartId($value)
 * @mixin Eloquent
 * @property-read int|null $children_count
 * @method static \Database\Factories\CartDetailFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CartDetail whereBonusType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartDetail whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartDetail whereParentId($value)
 */
	class CartDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $slug
 * @property string $uuid
 * @property string|null $keywords
 * @property int|null $parent_id
 * @property int $type
 * @property string|null $img
 * @property integer|null $input
 * @property int $active
 * @property string $status
 * @property int|null $shop_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection|self[] $children
 * @property-read int|null $children_count
 * @property-read Collection|Gallery[] $galleries
 * @property-read int|null $galleries_count
 * @property-read Shop|null $shop
 * @property-read Category|null $parent
 * @property-read Collection|Product[] $products
 * @property-read Collection|Stock[] $stocks
 * @property-read int|null $products_count
 * @property-read int|null $stocks_count
 * @property-read CategoryTranslation|null $translation
 * @property-read Collection|CategoryTranslation[] $translations
 * @property-read int|null $translations_count
 * @property-read Collection|ModelLog[] $logs
 * @property-read int|null $logs_count
 * @property-read Collection|Receipt[] $receipts
 * @property-read int|null $receipts_count
 * @method static CategoryFactory factory(...$parameters)
 * @method static Builder|self filter($array)
 * @method static Builder|self withThreeChildren($array)
 * @method static Builder|self withTrashedThreeChildren($array)
 * @method static Builder|self withSecondChildren($array)
 * @method static Builder|self withParent($array)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self onlyTrashed()
 * @method static Builder|self query()
 * @method static Builder|self whereActive($value)
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereDeletedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereImg($value)
 * @method static Builder|self whereKeywords($value)
 * @method static Builder|self whereParentId($value)
 * @method static Builder|self whereType($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereUuid($value)
 * @method static Builder|self withTrashed()
 * @method static Builder|self withoutTrashed()
 * @mixin Eloquent
 * @property-read \App\Models\Gallery|null $gallery
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MetaTag> $metaTags
 * @property-read int|null $meta_tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ShopCategory> $shopCategory
 * @property-read int|null $shop_category_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereInput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereStatus($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CategoryTranslation
 *
 * @property int $id
 * @property int $category_id
 * @property string $locale
 * @property string $title
 * @property string|null $description
 * @method static CategoryTranslationFactory factory(...$parameters)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereCategoryId($value)
 * @method static Builder|self whereDescription($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereLocale($value)
 * @method static Builder|self whereTitle($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation withoutTrashed()
 */
	class CategoryTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Chat
 *
 * @property int $id
 * @property int $from_user_id
 * @property int $to_user_id
 * @property int $chat_message
 * @property int $message_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property User|null $fromUser
 * @property User|null $toUser
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereId($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Chat onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereChatMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereFromUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereMessageStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereToUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat withoutTrashed()
 */
	class Chat extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ChatRequest
 *
 * @property int $id
 * @property int $from_user_id
 * @property int $to_user_id
 * @property int $chat_message
 * @property int $message_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property User|null $fromUser
 * @property User|null $toUser
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereId($value)
 * @mixin Eloquent
 * @property string $status
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRequest onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRequest whereFromUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRequest whereToUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRequest withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatRequest withoutTrashed()
 */
	class ChatRequest extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Combo
 *
 * @property int $id
 * @property int $shop_id
 * @property string $img
 * @property int $active
 * @property int $expired_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Shop|null $shop
 * @property-read Collection|HasManyThrough|ComboStock[] $stocks
 * @property-read int $stocks_count
 * @property-read ComboTranslation|null $translation
 * @property-read Collection|ComboTranslation $translations
 * @property-read int $translations_count
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self filter(array $filter)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gallery> $galleries
 * @property-read int|null $galleries_count
 * @property-read \App\Models\Gallery|null $gallery
 * @method static \Illuminate\Database\Eloquent\Builder|Combo whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Combo whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Combo whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Combo whereShopId($value)
 */
	class Combo extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ComboStock
 *
 * @property int $combo_id
 * @property int $stock_id
 * @property-read Combo|null $combo
 * @property-read Stock|null $stock
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereId($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ComboStock whereComboId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComboStock whereStockId($value)
 */
	class ComboStock extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ComboTranslation
 *
 * @property int $id
 * @property int $combo_id
 * @property string $locale
 * @property string $title
 * @property string|null $description
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereComboId($value)
 * @method static Builder|self whereDescription($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereLocale($value)
 * @method static Builder|self whereTitle($value)
 * @mixin Eloquent
 */
	class ComboTranslation extends \Eloquent {}
}

namespace App\Models{
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
 * @property int $is_for_new_users
 * @property-read \App\Models\Gallery|null $gallery
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereIsForNewUsers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon withoutTrashed()
 */
	class Coupon extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CouponTranslation
 *
 * @property int $id
 * @property int $coupon_id
 * @property string $locale
 * @property string $title
 * @property string|null $description
 * @method static CouponTranslationFactory factory(...$parameters)
 * @method static Builder|CouponTranslation newModelQuery()
 * @method static Builder|CouponTranslation newQuery()
 * @method static Builder|CouponTranslation query()
 * @method static Builder|CouponTranslation whereCouponId($value)
 * @method static Builder|CouponTranslation whereDescription($value)
 * @method static Builder|CouponTranslation whereId($value)
 * @method static Builder|CouponTranslation whereLocale($value)
 * @method static Builder|CouponTranslation whereTitle($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|CouponTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponTranslation withoutTrashed()
 */
	class CouponTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Currency
 *
 * @property int $id
 * @property string|null $symbol
 * @property string $title
 * @property double $rate
 * @property string $position
 * @property int $default
 * @property int $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static CurrencyFactory factory(...$parameters)
 * @method static Builder|Currency newModelQuery()
 * @method static Builder|Currency newQuery()
 * @method static Builder|Currency query()
 * @method static Builder|Currency whereActive($value)
 * @method static Builder|Currency whereCreatedAt($value)
 * @method static Builder|Currency whereDefault($value)
 * @method static Builder|Currency whereId($value)
 * @method static Builder|Currency wherePosition($value)
 * @method static Builder|Currency whereRate($value)
 * @method static Builder|Currency whereSymbol($value)
 * @method static Builder|Currency whereTitle($value)
 * @method static Builder|Currency whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Currency onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency withoutTrashed()
 */
	class Currency extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DeliveryZone
 *
 * @property int $id
 * @property int $user_id
 * @property array $address
 * @property User|null $user
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self filter(array $filter = [])
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereShopId($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManDeliveryZone whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManDeliveryZone whereUserId($value)
 */
	class DeliveryManDeliveryZone extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DeliveryManSetting
 *
 * @property int $id
 * @property int $user_id
 * @property string $type_of_technique
 * @property string $brand
 * @property string $model
 * @property string $number
 * @property string $color
 * @property boolean $online
 * @property array $location
 * @property integer|null $width
 * @property integer|null $height
 * @property integer|null $length
 * @property integer|null $kg
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User|null $deliveryMan
 * @property-read Collection|Gallery[] $galleries
 * @property-read int|null $galleries_count
 * @method static DeliveryManSettingFactory factory(...$parameters)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereUserId($value)
 * @method static Builder|self whereTypeOfTechnique($value)
 * @method static Builder|self whereBrand($value)
 * @method static Builder|self whereModel($value)
 * @method static Builder|self whereNumber($value)
 * @method static Builder|self whereColor($value)
 * @method static Builder|self whereOnline($value)
 * @mixin Eloquent
 * @property-read \App\Models\Gallery|null $gallery
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManSetting onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManSetting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManSetting whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManSetting whereKg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManSetting whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManSetting whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManSetting whereWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManSetting withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManSetting withoutTrashed()
 */
	class DeliveryManSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DeliveryManWeeklyReport
 *
 * @property int $id
 * @property int $delivery_man_id
 * @property string $week_identifier
 * @property array $order_ids
 * @property float $total_price
 * @property int $orders_count
 * @property float $total_commission
 * @property float $total_discounts
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $status
 * @property-read \App\Models\User $deliveryMan
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManWeeklyReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManWeeklyReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManWeeklyReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManWeeklyReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManWeeklyReport whereDeliveryManId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManWeeklyReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManWeeklyReport whereOrderIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManWeeklyReport whereOrdersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManWeeklyReport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManWeeklyReport whereTotalCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManWeeklyReport whereTotalDiscounts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManWeeklyReport whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManWeeklyReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryManWeeklyReport whereWeekIdentifier($value)
 */
	class DeliveryManWeeklyReport extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DeliveryPoint
 *
 * @property int $id
 * @property int|null $active
 * @property float|null $price
 * @property array|null $address
 * @property string|null $location
 * @property string|null $img
 * @property int|null $r_count
 * @property float|null $r_avg
 * @property float|null $r_sum
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Collection|DeliveryPointWorkingDay[] $workingDays
 * @property Collection|DeliveryPointClosedDate[] $closedDates
 * @property int|null $working_days_count
 * @property int|null $closed_dates_count
 * @property-read DeliveryPointTranslation|null $translation
 * @property-read Collection|DeliveryPointTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self filter(array $filter)
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereImg($value)
 * @method static Builder|self whereActive($value)
 * @method static Builder|self active($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gallery> $galleries
 * @property-read int|null $galleries_count
 * @property-read \App\Models\Gallery|null $gallery
 * @property-read \App\Models\Review|null $review
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryPoint whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryPoint whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryPoint wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryPoint whereRAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryPoint whereRCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryPoint whereRSum($value)
 */
	class DeliveryPoint extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DeliveryPointClosedDate
 *
 * @property int $id
 * @property int $delivery_point_id
 * @property Carbon|null $date
 * @property Shop|null $shop
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property DeliveryPoint|null $deliveryPoint
 * @method static Builder|self filter(array $filter)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereDeliveryPointId($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryPointClosedDate whereDate($value)
 */
	class DeliveryPointClosedDate extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DeliveryPointTranslation
 *
 * @property int $id
 * @property int $delivery_point_id
 * @property string $locale
 * @property string $title
 * @property string|null $description
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereCategoryId($value)
 * @method static Builder|self whereDescription($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereLocale($value)
 * @method static Builder|self whereTitle($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryPointTranslation whereDeliveryPointId($value)
 */
	class DeliveryPointTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DeliveryPointWorkingDay
 *
 * @property int $id
 * @property int $delivery_point_id
 * @property string $day
 * @property string|null $from
 * @property string|null $to
 * @property boolean|null $disabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property DeliveryPoint|null $deliveryPoint
 * @method static Builder|self filter($filter = [])
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereDeliveryPointId($value)
 * @method static Builder|self whereDay($value)
 * @method static Builder|self whereFrom($value)
 * @method static Builder|self whereTo($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryPointWorkingDay whereDisabled($value)
 */
	class DeliveryPointWorkingDay extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DeliveryTranslation
 *
 * @property int $id
 * @property int $delivery_id
 * @property string $locale
 * @property string $title
 * @method static Builder|DeliveryTranslation newModelQuery()
 * @method static Builder|DeliveryTranslation newQuery()
 * @method static Builder|DeliveryTranslation query()
 * @method static Builder|DeliveryTranslation whereDeliveryId($value)
 * @method static Builder|DeliveryTranslation whereId($value)
 * @method static Builder|DeliveryTranslation whereLocale($value)
 * @method static Builder|DeliveryTranslation whereTitle($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryTranslation withoutTrashed()
 */
	class DeliveryTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DeliveryZone
 *
 * @property int $id
 * @property int $shop_id
 * @property array $address
 * @property Shop|null $shop
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereShopId($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Database\Factories\DeliveryZoneFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryZone onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryZone whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryZone whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryZone withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryZone withoutTrashed()
 */
	class DeliveryZone extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Discount
 *
 * @property int $id
 * @property int $shop_id
 * @property string $type
 * @property float $price
 * @property string $start
 * @property string|null $end
 * @property int $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property string|null $img
 * @property-read Collection|Gallery[] $galleries
 * @property-read int|null $galleries_count
 * @property-read Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static DiscountFactory factory(...$parameters)
 * @method static Builder|Discount filter($array)
 * @method static Builder|Discount newModelQuery()
 * @method static Builder|Discount newQuery()
 * @method static Builder|Discount query()
 * @method static Builder|Discount whereActive($value)
 * @method static Builder|Discount whereCreatedAt($value)
 * @method static Builder|Discount whereEnd($value)
 * @method static Builder|Discount whereId($value)
 * @method static Builder|Discount whereImg($value)
 * @method static Builder|Discount wherePrice($value)
 * @method static Builder|Discount whereShopId($value)
 * @method static Builder|Discount whereStart($value)
 * @method static Builder|Discount whereType($value)
 * @method static Builder|Discount whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read \App\Models\Gallery|null $gallery
 * @method static \Illuminate\Database\Eloquent\Builder|Discount onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount withoutTrashed()
 */
	class Discount extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DriverShopBans
 *
 * @property int $id
 * @property int $user_id
 * @property int $shop_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 * @property-read Shop|null $shop
 * @method static Builder|self filter($filter)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self onlyTrashed()
 * @method static Builder|self query()
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|DriverShopBans whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DriverShopBans whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DriverShopBans whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DriverShopBans whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DriverShopBans whereUserId($value)
 */
	class DriverShopBans extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmailSetting
 *
 * @property int $id
 * @property boolean $smtp_auth
 * @property boolean $smtp_debug
 * @property string $host
 * @property int $port
 * @property string $password
 * @property string $from_to
 * @property string $from_site
 * @property array $ssl
 * @property boolean $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read FaqTranslation|null $translation
 * @property-read Collection|FaqTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static FaqFactory factory(...$parameters)
 * @method static Builder|Faq newModelQuery()
 * @method static Builder|Faq newQuery()
 * @method static Builder|Faq query()
 * @method static Builder|Faq whereActive($value)
 * @method static Builder|Faq whereCreatedAt($value)
 * @method static Builder|Faq whereId($value)
 * @method static Builder|Faq whereType($value)
 * @method static Builder|Faq whereUpdatedAt($value)
 * @method static Builder|Faq whereUuid($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereFromSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereFromTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereSmtpAuth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereSmtpDebug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting whereSsl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSetting withoutTrashed()
 */
	class EmailSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmailSubscription
 *
 * @property int $id
 * @property string $user_id
 * @property int $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User $user
 * @method static Builder|EmailSubscription newModelQuery()
 * @method static Builder|EmailSubscription newQuery()
 * @method static Builder|EmailSubscription query()
 * @method static Builder|EmailSubscription whereCreatedAt($value)
 * @method static Builder|EmailSubscription whereId($value)
 * @method static Builder|EmailSubscription whereUpdatedAt($value)
 * @method static Builder|EmailSubscription whereUserId($value)
 * @mixin Eloquent
 * @method static \Database\Factories\EmailSubscriptionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSubscription onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSubscription whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSubscription whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSubscription withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSubscription withoutTrashed()
 */
	class EmailSubscription extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmailTemplate
 *
 * @property int $id
 * @property int $email_setting_id
 * @property string $subject
 * @property string $body
 * @property string $alt_body
 * @property string|null $type
 * @property int|null $status
 * @property Carbon|null $send_to
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property EmailSetting|null $emailSetting
 * @property Collection|Gallery[] $galleries
 * @property-read int|null $galleries_count
 * @method static BannerFactory factory(...$parameters)
 * @method static Builder|EmailTemplate newModelQuery()
 * @method static Builder|EmailTemplate newQuery()
 * @method static Builder|EmailTemplate query()
 * @method static Builder|EmailTemplate whereSubject($value)
 * @method static Builder|EmailTemplate whereLikeBody($value)
 * @method static Builder|EmailTemplate whereLikeAltBody($value)
 * @method static Builder|EmailTemplate whereCreatedAt($value)
 * @method static Builder|EmailTemplate whereId($value)
 * @method static Builder|EmailTemplate whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read \App\Models\Gallery|null $gallery
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereAltBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereEmailSettingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereSendTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate withoutTrashed()
 */
	class EmailTemplate extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExtraGroup
 *
 * @property int $id
 * @property string|null $type
 * @property int $active
 * @property int $shop_id
 * @property Carbon|null $deleted_at
 * @property Shop|null $shop
 * @property-read Collection|ExtraValue[] $extraValues
 * @property-read int|null $extra_values_count
 * @property-read ExtraGroupTranslation|null $translation
 * @property-read Collection|ExtraGroupTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static ExtraGroupFactory factory(...$parameters)
 * @method static Builder|ExtraGroup newModelQuery()
 * @method static Builder|ExtraGroup newQuery()
 * @method static Builder|ExtraGroup query()
 * @method static Builder|ExtraGroup whereActive($value)
 * @method static Builder|ExtraGroup whereId($value)
 * @method static Builder|ExtraGroup whereType($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraGroup onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraGroup whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraGroup withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraGroup withoutTrashed()
 */
	class ExtraGroup extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExtraGroupTranslation
 *
 * @property int $id
 * @property int $extra_group_id
 * @property string $locale
 * @property string $title
 * @method static ExtraGroupTranslationFactory factory(...$parameters)
 * @method static Builder|ExtraGroupTranslation newModelQuery()
 * @method static Builder|ExtraGroupTranslation newQuery()
 * @method static Builder|ExtraGroupTranslation query()
 * @method static Builder|ExtraGroupTranslation whereExtraGroupId($value)
 * @method static Builder|ExtraGroupTranslation whereId($value)
 * @method static Builder|ExtraGroupTranslation whereLocale($value)
 * @method static Builder|ExtraGroupTranslation whereTitle($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraGroupTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraGroupTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraGroupTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraGroupTranslation withoutTrashed()
 */
	class ExtraGroupTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExtraValue
 *
 * @property int $id
 * @property int $extra_group_id
 * @property string $value
 * @property int $active
 * @property Carbon|null $deleted_at
 * @property-read Collection|Gallery[] $galleries
 * @property-read int|null $galleries_count
 * @property-read ExtraGroup $group
 * @property-read Collection|Stock[] $stocks
 * @property-read int|null $stocks_count
 * @method static ExtraValueFactory factory(...$parameters)
 * @method static Builder|ExtraValue newModelQuery()
 * @method static Builder|ExtraValue newQuery()
 * @method static Builder|ExtraValue query()
 * @method static Builder|ExtraValue whereActive($value)
 * @method static Builder|ExtraValue whereExtraGroupId($value)
 * @method static Builder|ExtraValue whereId($value)
 * @method static Builder|ExtraValue whereValue($value)
 * @mixin Eloquent
 * @property-read \App\Models\Gallery|null $gallery
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraValue onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraValue whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraValue withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraValue withoutTrashed()
 */
	class ExtraValue extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Faq
 *
 * @property int $id
 * @property string $uuid
 * @property string|null $type
 * @property int $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read FaqTranslation|null $translation
 * @property-read Collection|FaqTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static FaqFactory factory(...$parameters)
 * @method static Builder|Faq newModelQuery()
 * @method static Builder|Faq newQuery()
 * @method static Builder|Faq query()
 * @method static Builder|Faq whereActive($value)
 * @method static Builder|Faq whereCreatedAt($value)
 * @method static Builder|Faq whereId($value)
 * @method static Builder|Faq whereType($value)
 * @method static Builder|Faq whereUpdatedAt($value)
 * @method static Builder|Faq whereUuid($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Faq onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Faq whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Faq withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Faq withoutTrashed()
 */
	class Faq extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FaqTranslation
 *
 * @property int $id
 * @property int $faq_id
 * @property string $locale
 * @property string $question
 * @property string|null $answer
 * @method static FaqTranslationFactory factory(...$parameters)
 * @method static Builder|FaqTranslation newModelQuery()
 * @method static Builder|FaqTranslation newQuery()
 * @method static Builder|FaqTranslation query()
 * @method static Builder|FaqTranslation whereAnswer($value)
 * @method static Builder|FaqTranslation whereFaqId($value)
 * @method static Builder|FaqTranslation whereId($value)
 * @method static Builder|FaqTranslation whereLocale($value)
 * @method static Builder|FaqTranslation whereQuestion($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|FaqTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FaqTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FaqTranslation withoutTrashed()
 */
	class FaqTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Gallery
 *
 * @property int $id
 * @property string $title
 * @property string $loadable_type
 * @property int $loadable_id
 * @property string|null $type
 * @property string|null $path
 * @property string|null $mime
 * @property string|null $size
 * @property-read Model|Eloquent $loadable
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereLoadableId($value)
 * @method static Builder|self whereLoadableType($value)
 * @method static Builder|self whereMime($value)
 * @method static Builder|self wherePath($value)
 * @method static Builder|self whereSize($value)
 * @method static Builder|self whereTitle($value)
 * @method static Builder|self whereType($value)
 * @mixin Eloquent
 * @method static \Database\Factories\GalleryFactory factory(...$parameters)
 */
	class Gallery extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Inventory
 *
 * @property int $id
 * @property int $shop_id
 * @property string $latitude
 * @property string $longitude
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Shop|null $shop
 * @property-read Collection|InventoryItem[] $inventoryItems
 * @property-read InventoryItem|null $inventory_items_count
 * @property-read InventoryTranslation|null $translation
 * @property-read Collection|InventoryTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static Builder|self filter($array)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereShopId($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory withoutTrashed()
 */
	class Inventory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\InventoryItem
 *
 * @property int $id
 * @property int $inventory_id
 * @property string $name
 * @property int $quantity
 * @property int $price
 * @property string $bar_code
 * @property int $unit_id
 * @property string $interval
 * @property Carbon|null $expired_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Inventory $inventory
 * @property-read Unit $unit
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self filter(array $filter)
 * @method static Builder|self whereId($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gallery> $galleries
 * @property-read int|null $galleries_count
 * @property-read \App\Models\Gallery|null $gallery
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereBarCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereInventoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItem withoutTrashed()
 */
	class InventoryItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\InventoryItemHistory
 *
 * @property int $id
 * @property int $inventory_id
 * @property string $name
 * @property int $quantity
 * @property int $price
 * @property string $bar_code
 * @property int $unit_id
 * @property string $interval
 * @property Carbon|null $expired_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Inventory $inventory
 * @property-read Unit $unit
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self filter(array $filter)
 * @method static Builder|self whereId($value)
 * @mixin Eloquent
 * @property int $inventory_item_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gallery> $galleries
 * @property-read int|null $galleries_count
 * @property-read \App\Models\Gallery|null $gallery
 * @property-read \App\Models\InventoryItem $inventoryItem
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemHistory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemHistory whereBarCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemHistory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemHistory whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemHistory whereInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemHistory whereInventoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemHistory whereInventoryItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemHistory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemHistory wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemHistory whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemHistory whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemHistory withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryItemHistory withoutTrashed()
 */
	class InventoryItemHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\InventoryTranslation
 *
 * @property int $id
 * @property int $inventory_id
 * @property string $locale
 * @property string $title
 * @property Carbon|null $deleted_at
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereLocale($value)
 * @method static Builder|self whereInventoryId($value)
 * @method static Builder|self whereTitle($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryTranslation withoutTrashed()
 */
	class InventoryTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Invitation
 *
 * @property int $id
 * @property int $shop_id
 * @property int $user_id
 * @property string|null $role
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Shop $shop
 * @property-read User $user
 * @method static InvitationFactory factory(...$parameters)
 * @method static Builder|Invitation filter($array)
 * @method static Builder|Invitation newModelQuery()
 * @method static Builder|Invitation newQuery()
 * @method static Builder|Invitation query()
 * @method static Builder|Invitation withTrashed()
 * @method static Builder|Invitation whereCreatedAt($value)
 * @method static Builder|Invitation whereId($value)
 * @method static Builder|Invitation whereRole($value)
 * @method static Builder|Invitation whereShopId($value)
 * @method static Builder|Invitation whereStatus($value)
 * @method static Builder|Invitation whereUpdatedAt($value)
 * @method static Builder|Invitation whereUserId($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Invitation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Invitation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invitation withoutTrashed()
 */
	class Invitation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Kitchen
 *
 * @property int $id
 * @property int $active
 * @property integer|null $shop_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Shop|null $shop
 * @method static Builder|self filter($array)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereActive($value)
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereDeletedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereImg($value)
 * @method static Builder|self whereShopId($value)
 * @method static Builder|self whereTitle($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereUuid($value)
 * @mixin Eloquent
 * @property-read \App\Models\KitchenTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\KitchenTranslation> $translations
 * @property-read int|null $translations_count
 */
	class Kitchen extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\KitchenTranslation
 *
 * @property int $id
 * @property int $kitchen_id
 * @property string $locale
 * @property string $title
 * @property string $description
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereAddress($value)
 * @method static Builder|self whereDescription($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereLocale($value)
 * @method static Builder|self whereCareerId($value)
 * @method static Builder|self whereTitle($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|KitchenTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KitchenTranslation whereKitchenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KitchenTranslation whereUpdatedAt($value)
 */
	class KitchenTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LandingPage
 *
 * @property int $id
 * @property array $data
 * @property string $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static Builder|self filter($array)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereActive($value)
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereDeletedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gallery> $galleries
 * @property-read int|null $galleries_count
 * @property-read \App\Models\Gallery|null $gallery
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|LandingPage withoutTrashed()
 */
	class LandingPage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Language
 *
 * @property int $id
 * @property string|null $title
 * @property string $locale
 * @property int $backward
 * @property int $default
 * @property int $active
 * @property string|null $img
 * @property Carbon|null $deleted_at
 * @property-read Collection|Gallery[] $galleries
 * @property-read int|null $galleries_count
 * @method static LanguageFactory factory(...$parameters)
 * @method static Builder|Language newModelQuery()
 * @method static Builder|Language newQuery()
 * @method static Builder|Language query()
 * @method static Builder|Language whereActive($value)
 * @method static Builder|Language whereBackward($value)
 * @method static Builder|Language whereDefault($value)
 * @method static Builder|Language whereId($value)
 * @method static Builder|Language whereImg($value)
 * @method static Builder|Language whereLocale($value)
 * @method static Builder|Language whereTitle($value)
 * @mixin Eloquent
 * @property-read \App\Models\Gallery|null $gallery
 * @method static \Illuminate\Database\Eloquent\Builder|Language onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Language withoutTrashed()
 */
	class Language extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Like
 *
 * @property int $id
 * @property string $likable_type
 * @property int $likable_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @method static Builder|Like newModelQuery()
 * @method static Builder|Like newQuery()
 * @method static Builder|Like query()
 * @method static Builder|Like whereCreatedAt($value)
 * @method static Builder|Like whereId($value)
 * @method static Builder|Like whereLikableId($value)
 * @method static Builder|Like whereLikableType($value)
 * @method static Builder|Like whereUpdatedAt($value)
 * @method static Builder|Like whereUserId($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Like onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Like whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Like withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Like withoutTrashed()
 */
	class Like extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Menu
 *
 * @property int $id
 * @property int $category_id
 * @property int $shop_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Category|null $category
 * @property-read Shop|null $shop
 * @property-read Collection|Product[] $products
 * @property-read MenuTranslation|null $translation
 * @property-read Collection|MenuTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static Builder|self filter($array)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self onlyTrashed()
 * @method static Builder|self query()
 * @method static Builder|self whereCategoryId($value)
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereDeletedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self withTrashed()
 * @method static Builder|self withoutTrashed()
 * @mixin Eloquent
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereShopId($value)
 */
	class Menu extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MenuProduct
 *
 * @property int $menu_id
 * @property int $product_id
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereMenuId($value)
 * @method static Builder|self whereProductId($value)
 * @mixin Eloquent
 * @property-read \App\Models\Menu $menu
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|MenuProduct onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuProduct withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuProduct withoutTrashed()
 */
	class MenuProduct extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MenuTranslation
 *
 * @property int $id
 * @property int $menu_id
 * @property string $locale
 * @property string $title
 * @property string|null $description
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereDescription($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereLocale($value)
 * @method static Builder|self whereMenuId($value)
 * @method static Builder|self whereTitle($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|MenuTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuTranslation withoutTrashed()
 */
	class MenuTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MetaTag
 *
 * @property int $id
 * @property string $path
 * @property int $model_id
 * @property string $model_type
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $h1
 * @property string $seo_text
 * @property string $canonical
 * @property string $robots
 * @property string $change_freq
 * @property string $priority
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static ReviewFactory factory(...$parameters)
 * @method static Builder|MetaTag newModelQuery()
 * @method static Builder|MetaTag newQuery()
 * @method static Builder|MetaTag query()
 * @method static Builder|MetaTag whereCreatedAt($value)
 * @method static Builder|MetaTag whereId($value)
 * @method static Builder|MetaTag whereModelId($value)
 * @method static Builder|MetaTag whereModelType($value)
 * @method static Builder|MetaTag whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $model
 * @method static \Illuminate\Database\Eloquent\Builder|MetaTag onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MetaTag whereCanonical($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaTag whereChangeFreq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaTag whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaTag whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaTag whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaTag whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaTag wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaTag wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaTag whereRobots($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaTag whereSeoText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaTag whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaTag withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MetaTag withoutTrashed()
 */
	class MetaTag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ModelLog
 *
 * @property int $id
 * @property string $model_type
 * @property int $model_id
 * @property array $data
 * @property string $type
 * @property int $created_by
 * @property Carbon|null $created_at
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self filter(array $filter)
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereId($value)
 * @property-read User|null $createdBy
 * @property-read Model|null $modelType
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ModelLog whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelLog whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelLog whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelLog whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelLog whereType($value)
 */
	class ModelLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Notification
 *
 * @property int $id
 * @property string $type
 * @property array $payload
 * @property boolean $active - Внутри таблицы notification_user
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @method static Builder|Tag newModelQuery()
 * @method static Builder|Tag newQuery()
 * @method static Builder|Tag query()
 * @method static Builder|Tag whereCreatedAt($value)
 * @method static Builder|Tag whereId($value)
 * @method static Builder|Tag whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\NotificationFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification withoutTrashed()
 */
	class Notification extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserNotification
 *
 * @property int $id
 * @property int $notification_id
 * @property boolean $active
 * @property int $user_id
 * @property Notification|null $notification
 * @property User|null $user
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static Builder|Tag newModelQuery()
 * @method static Builder|Tag newQuery()
 * @method static Builder|Tag query()
 * @method static Builder|Tag whereCreatedAt($value)
 * @method static Builder|Tag whereId($value)
 * @method static Builder|Tag whereUpdatedAt($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Database\Factories\NotificationUserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser whereNotificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationUser withoutTrashed()
 */
	class NotificationUser extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $user_id
 * @property string $delivery_type
 * @property int $rate_delivery_fee
 * @property int $rate_waiter_fee
 * @property double $total_price
 * @property int $currency_id
 * @property int $rate
 * @property string|null $note
 * @property string|null $image_after_delivered
 * @property int $shop_id
 * @property float $tax
 * @property float|null $commission_fee
 * @property float|null $service_fee
 * @property float|null $rate_commission_fee
 * @property float|null $rate_service_fee
 * @property string $status
 * @property array|null $location
 * @property string|null $address
 * @property float $delivery_fee
 * @property int|null $deliveryman
 * @property string|null $delivery_date
 * @property string|null $delivery_time
 * @property double|null $total_discount
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $username
 * @property string|null $img
 * @property array|null $tip_for
 * @property double|null $tips
 * @property double|null $rate_tips
 * @property double|null $shop_tip
 * @property double|null $rate_shop_tip
 * @property double|null $driver_tip
 * @property double|null $rate_driver_tip
 * @property double|null $waiter_tip
 * @property double|null $rate_waiter_tip
 * @property double|null $system_tip
 * @property double|null $rate_system_tip
 * @property double|null $origin_price
 * @property double|null $seller_fee
 * @property double|null $coupon_price
 * @property double|null $rate_coupon_price
 * @property double|null $coupon_sum_price
 * @property double|null $point_histories_sum_price
 * @property double|null $rate_coupon_sum_price
 * @property double|null $rate_point_histories_sum_price
 * @property boolean|null $current
 * @property float|null $waiter_fee
 * @property int|null $waiter_id
 * @property int|null $table_id
 * @property int|null $booking_id
 * @property int|null $otp
 * @property int|null $user_booking_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read int $rate_total_price
 * @property-read double $rate_total_discount
 * @property-read double $order_details_sum_total_price
 * @property-read double $order_details_sum_discount
 * @property-read int $rate_tax
 * @property-read Currency|null $currency
 * @property-read UserAddress|null $myAddress
 * @property-read OrderCoupon|null $coupon
 * @property-read Collection|OrderDetail[] $orderDetails
 * @property-read int|null $order_details_count
 * @property-read Collection|OrderDetail[] $orderRefunds
 * @property-read int|null $order_refunds_count
 * @property-read int|null $order_details_sum_quantity
 * @property-read PointHistory|null $pointHistory
 * @property-read PointHistory|null $pointHistories
 * @property-read Review|null $review
 * @property-read PaymentProcess|null $paymentProcess
 * @property-read Collection|PaymentProcess[] $paymentProcesses
 * @property-read PaymentToPartner|null $paymentToPartner
 * @property-read int $payment_process_count
 * @property-read User|null $user
 * @property-read Shop|null $shop
 * @property-read OrderRepeat|null $repeat
 * @property-read User|Builder|null $deliveryMan
 * @property-read User|null $waiter
 * @property-read Table|null $table
 * @property-read Collection|Gallery[] $galleries
 * @property-read int|null $galleries_count
 * @property-read Collection|ModelLog[] $logs
 * @property-read int|null $logs_count
 * @method static OrderFactory factory(...$parameters)
 * @method static Builder|self filter($array)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereCommissionFee($value)
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereCurrencyId($value)
 * @method static Builder|self whereAddressId($value)
 * @method static Builder|self whereDeliveryDate($value)
 * @method static Builder|self whereDeliveryFee($value)
 * @method static Builder|self whereDeliveryTime($value)
 * @method static Builder|self whereDeliveryman($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereNote($value)
 * @method static Builder|self whereTotalPrice($value)
 * @method static Builder|self whereRate($value)
 * @method static Builder|self whereShopId($value)
 * @method static Builder|self whereStatus($value)
 * @method static Builder|self whereTax($value)
 * @method static Builder|self whereTotalDiscount($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereUserId($value)
 * @mixin Eloquent
 * @property int|null $address_id
 * @property float|null $small_order_fee
 * @property int|null $cart_id
 * @property-read \App\Models\Gallery|null $gallery
 * @property-read float|null $rate_point_history_sum_price
 * @property-read int|null $payment_processes_count
 * @property-read int|null $point_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @property-read \App\Models\Transaction|null $transaction
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCurrent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliveryType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereImageAfterDelivered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereServiceFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSmallOrderFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTips($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereWaiterFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereWaiterId($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderCoupon
 *
 * @property int $id
 * @property int $order_id
 * @property int $user_id
 * @property string $name
 * @property float|null $price
 * @method static OrderCouponFactory factory(...$parameters)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereName($value)
 * @method static Builder|self whereOrderId($value)
 * @method static Builder|self wherePrice($value)
 * @method static Builder|self whereUserId($value)
 * @mixin Eloquent
 */
	class OrderCoupon extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderDetail
 *
 * @property int $id
 * @property int $order_id
 * @property int $stock_id
 * @property int $parent_id
 * @property int $kitchen_id
 * @property int $cook_id
 * @property int $combo_id
 * @property float $origin_price
 * @property float $total_price
 * @property float $tax
 * @property float $discount
 * @property float $rate_discount
 * @property int $quantity
 * @property string $note
 * @property string $status
 * @property string $transaction_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Order $order
 * @property-read Stock $stock
 * @property-read int $rate_total_price
 * @property-read int $rate_origin_price
 * @property-read int $rate_tax
 * @property-read boolean $bonus
 * @property-read self $parent
 * @property-read Collection|self[] $children
 * @property-read User|null $cooker
 * @method static OrderDetailFactory factory(...$parameters)
 * @method static Builder|self filter($array)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereDiscount($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereOrderId($value)
 * @method static Builder|self whereOriginPrice($value)
 * @method static Builder|self whereQuantity($value)
 * @method static Builder|self whereStockId($value)
 * @method static Builder|self whereTax($value)
 * @method static Builder|self whereTotalPrice($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read int|null $children_count
 * @property-read \App\Models\Kitchen|null $kitchen
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereComboId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereCookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereKitchenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderDetail whereTransactionStatus($value)
 */
	class OrderDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Payout
 *
 * @property int $id
 * @property string $status
 * @property string $cause
 * @property string $answer
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Order|null $order
 * @property Collection|Gallery[] $galleries
 * @method static TransactionFactory factory(...$parameters)
 * @method static Builder|OrderRefund filter($array = [])
 * @method static Builder|OrderRefund newModelQuery()
 * @method static Builder|OrderRefund newQuery()
 * @method static Builder|OrderRefund query()
 * @method static Builder|OrderRefund whereCreatedAt($value)
 * @method static Builder|OrderRefund whereUpdatedAt($value)
 * @method static Builder|OrderRefund whereId($value)
 * @method static Builder|OrderRefund whereCause($value)
 * @method static Builder|OrderRefund whereAnswer($value)
 * @method static Builder|OrderRefund whereStatus($value)
 * @mixin Eloquent
 * @property int $order_id
 * @property-read int|null $galleries_count
 * @property-read \App\Models\Gallery|null $gallery
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRefund whereOrderId($value)
 */
	class OrderRefund extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderRepeat
 *
 * @property int $id
 * @property int $order_id
 * @property string $from
 * @property string $to
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Order|null $order
 * @method static Builder|self filter($array)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRepeat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRepeat whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRepeat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRepeat whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRepeat whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRepeat whereUpdatedAt($value)
 */
	class OrderRepeat extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderStatus
 *
 * @property int $id
 * @property array $name
 * @property boolean $active
 * @property int|null $sort
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @method static Builder|OrderStatus newModelQuery()
 * @method static Builder|OrderStatus newQuery()
 * @method static Builder|OrderStatus query()
 * @method static Builder|OrderStatus whereCreatedAt($value)
 * @method static Builder|OrderStatus whereId($value)
 * @method static Builder|OrderStatus whereStockId($value)
 * @method static Builder|OrderStatus whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Database\Factories\OrderStatusFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatus withoutTrashed()
 */
	class OrderStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Page
 *
 * @property int $id
 * @property boolean $active
 * @property string $type
 * @property string $img
 * @property string $bg_img
 * @property array $buttons
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property Collection|CareerTranslation[] $translations
 * @property CareerTranslation|null $translation
 * @property int|null $translations_count
 * @method static Builder|self active()
 * @method static Builder|self filter(array $filter)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereId($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gallery> $galleries
 * @property-read int|null $galleries_count
 * @property-read \App\Models\Gallery|null $gallery
 * @method static \Illuminate\Database\Eloquent\Builder|Page onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereBgImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereButtons($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Page withoutTrashed()
 */
	class Page extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PageTranslation
 *
 * @property int $id
 * @property int $page_id
 * @property string $locale
 * @property string $title
 * @property string|null $description
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereAddress($value)
 * @method static Builder|self whereDescription($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereLocale($value)
 * @method static Builder|self wherePageId($value)
 * @method static Builder|self whereTitle($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|PageTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PageTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PageTranslation withoutTrashed()
 */
	class PageTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ParcelOption
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ParcelOptionTranslation|null $translation
 * @property-read Collection|ParcelOptionTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static Builder|self filter($value)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereId($value)
 * @mixin Eloquent
 */
	class ParcelOption extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ParcelOptionTranslation
 *
 * @property int $id
 * @property integer $parcel_option_id
 * @property string $locale
 * @property string $title
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|self filter($value)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereId($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOptionTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOptionTranslation whereParcelOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOptionTranslation whereTitle($value)
 */
	class ParcelOptionTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ParcelOrder
 *
 * @property int $id
 * @property int|null $user_id
 * @property double|null $total_price
 * @property int|null $currency_id
 * @property string|null $type_id
 * @property float|null $rate
 * @property string|null $note
 * @property double|null $tax
 * @property string|null $status
 * @property array|null $address_from
 * @property string|null $phone_from
 * @property string|null $username_from
 * @property array|null $address_to
 * @property string|null $phone_to
 * @property string|null $username_to
 * @property double|null $delivery_fee
 * @property double|null $km
 * @property int|null $deliveryman_id
 * @property Carbon|null $delivery_date
 * @property string|null $delivery_time
 * @property boolean|null $current
 * @property string|null $img
 * @property double|null $rate_total_price
 * @property double|null $rate_delivery_fee
 * @property double|null $rate_tax
 * @property string|null $qr_value
 * @property string|null $instruction
 * @property string|null $description
 * @property boolean|null $notify
 * @property array|null $option
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property User|null $user
 * @property Currency|null $currency
 * @property ParcelOrderSetting|null $type
 * @property User|null $deliveryman
 * @method static Builder|self filter($value)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereId($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gallery> $galleries
 * @property-read int|null $galleries_count
 * @property-read \App\Models\Gallery|null $gallery
 * @property-read \App\Models\Review|null $review
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @property-read \App\Models\Transaction|null $transaction
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder whereAddressFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder whereAddressTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder whereCurrent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder whereDeliveryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder whereDeliveryFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder whereDeliveryTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder whereDeliverymanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder whereInstruction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder whereKm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder whereNotify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder wherePhoneFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder wherePhoneTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder whereQrValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder whereUsernameFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrder whereUsernameTo($value)
 */
	class ParcelOrder extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ParcelOrderSetting
 *
 * @property int $id
 * @property string $type
 * @property string $img
 * @property int $min_width
 * @property int $min_height
 * @property int $min_length
 * @property int $max_width
 * @property int $max_height
 * @property int $max_length
 * @property int $max_range
 * @property int $min_g
 * @property int $max_g
 * @property int $price
 * @property int $price_per_km
 * @property int $special
 * @property int $special_price
 * @property int $special_price_per_km
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Collection|ParcelOption[] $parcelOptions
 * @method static Builder|self filter($value)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereId($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gallery> $galleries
 * @property-read int|null $galleries_count
 * @property-read \App\Models\Gallery|null $gallery
 * @property-read int|null $parcel_options_count
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrderSetting whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrderSetting whereMaxG($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrderSetting whereMaxHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrderSetting whereMaxLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrderSetting whereMaxRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrderSetting whereMaxWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrderSetting whereMinG($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrderSetting whereMinHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrderSetting whereMinLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrderSetting whereMinWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrderSetting wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrderSetting wherePricePerKm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrderSetting whereSpecial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrderSetting whereSpecialPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrderSetting whereSpecialPricePerKm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParcelOrderSetting whereType($value)
 */
	class ParcelOrderSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Payment
 *
 * @property int $id
 * @property string|null $tag
 * @property int $input
 * @property int $sandbox
 * @property int $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read ShopPayment|null $shopPayment
 * @property-read PaymentPayload|null $paymentPayload
 * @method static PaymentFactory factory(...$parameters)
 * @method static Builder|Payment newModelQuery()
 * @method static Builder|Payment newQuery()
 * @method static Builder|Payment query()
 * @method static Builder|Payment whereActive($value)
 * @method static Builder|Payment whereCreatedAt($value)
 * @method static Builder|Payment whereId($value)
 * @method static Builder|Payment whereInput($value)
 * @method static Builder|Payment whereSandbox($value)
 * @method static Builder|Payment whereTag($value)
 * @method static Builder|Payment whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Payment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment withoutTrashed()
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PaymentPayload
 *
 * @property int|null $payment_id
 * @property Payment|null $payment
 * @property array|null $payload
 * @property string|null $deleted_at
 * @method static PaymentPayloadFactory factory(...$parameters)
 * @method static Builder|PaymentPayload newModelQuery()
 * @method static Builder|PaymentPayload newQuery()
 * @method static Builder|PaymentPayload query()
 * @method static Builder|PaymentPayload whereDeletedAt($value)
 * @method static Builder|PaymentPayload whereId($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentPayload onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentPayload wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentPayload wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentPayload withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentPayload withoutTrashed()
 */
	class PaymentPayload extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PaymentProcess
 *
 * @property string $id
 * @property array $data
 * @property string $model_type
 * @property int $model_id
 * @property int $user_id
 * @property User|null $user
 * @property Order|ParcelOrder|Subscription $model
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self filter($filter)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereUserId($value)
 * @method static Builder|self whereOrderId($value)
 * @method static Builder|self whereData($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentProcess whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentProcess whereModelType($value)
 */
	class PaymentProcess extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PaymentToPartner
 *
 * @property int $id
 * @property int $user_id
 * @property int $order_id
 * @property string $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User|null $user
 * @property-read Order|null $order
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereDeletedAt($value)
 * @method static Builder|self whereId($value)
 * @mixin Eloquent
 * @property-read \App\Models\Transaction|null $transaction
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentToPartner filter(array $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentToPartner onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentToPartner whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentToPartner whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentToPartner whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentToPartner withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentToPartner withoutTrashed()
 */
	class PaymentToPartner extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Payout
 *
 * @property int $id
 * @property string $status
 * @property int $created_by
 * @property int $approved_by
 * @property int $currency_id
 * @property int $payment_id
 * @property string $cause
 * @property string $answer
 * @property double $price
 * @property User|null $createdBy
 * @property User|null $approvedBy
 * @property Currency|null $currency
 * @property Payment|null $payment
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static PayoutFactory factory(...$parameters)
 * @method static Builder|OrderRefund filter($array = [])
 * @method static Builder|OrderRefund newModelQuery()
 * @method static Builder|OrderRefund newQuery()
 * @method static Builder|OrderRefund query()
 * @method static Builder|OrderRefund whereCreatedAt($value)
 * @method static Builder|OrderRefund whereDeletedAt($value)
 * @method static Builder|OrderRefund whereUpdatedAt($value)
 * @method static Builder|OrderRefund whereId($value)
 * @method static Builder|OrderRefund whereCause($value)
 * @method static Builder|OrderRefund whereAnswer($value)
 * @method static Builder|OrderRefund whereStatus($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gallery> $galleries
 * @property-read int|null $galleries_count
 * @property-read \App\Models\Gallery|null $gallery
 * @method static \Illuminate\Database\Eloquent\Builder|Payout onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Payout whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payout whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payout whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payout wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payout wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payout withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Payout withoutTrashed()
 */
	class Payout extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Point
 *
 * @property int $id
 * @property int|null $shop_id
 * @property Shop|null $shop
 * @property string $type
 * @property float $price
 * @property int $value
 * @property int $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereActive($value)
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self wherePrice($value)
 * @method static Builder|self whereShopId($value)
 * @method static Builder|self whereType($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereValue($value)
 * @mixin Eloquent
 * @method static \Database\Factories\PointFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Point onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Point whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Point withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Point withoutTrashed()
 */
	class Point extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PointHistory
 *
 * @property int $id
 * @property int $user_id
 * @property int $order_id
 * @property float $price
 * @property string|null $note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|PointHistory newModelQuery()
 * @method static Builder|PointHistory newQuery()
 * @method static Builder|PointHistory query()
 * @method static Builder|PointHistory whereCreatedAt($value)
 * @method static Builder|PointHistory whereId($value)
 * @method static Builder|PointHistory whereNote($value)
 * @method static Builder|PointHistory whereOrderId($value)
 * @method static Builder|PointHistory wherePrice($value)
 * @method static Builder|PointHistory whereUpdatedAt($value)
 * @method static Builder|PointHistory whereUserId($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|PointHistory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PointHistory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PointHistory withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PointHistory withoutTrashed()
 */
	class PointHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PrivacyPolicy
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read PrivacyPolicyTranslation|null $translation
 * @property-read Collection|PrivacyPolicyTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static Builder|PrivacyPolicy newModelQuery()
 * @method static Builder|PrivacyPolicy newQuery()
 * @method static Builder|PrivacyPolicy query()
 * @method static Builder|PrivacyPolicy whereCreatedAt($value)
 * @method static Builder|PrivacyPolicy whereId($value)
 * @method static Builder|PrivacyPolicy whereUpdatedAt($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|PrivacyPolicy onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PrivacyPolicy whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrivacyPolicy withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PrivacyPolicy withoutTrashed()
 */
	class PrivacyPolicy extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PrivacyPolicyTranslation
 *
 * @property int $id
 * @property int $privacy_policy_id
 * @property string $title
 * @property string $description
 * @property string $locale
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static Builder|PrivacyPolicyTranslation newModelQuery()
 * @method static Builder|PrivacyPolicyTranslation newQuery()
 * @method static Builder|PrivacyPolicyTranslation query()
 * @method static Builder|PrivacyPolicyTranslation whereCreatedAt($value)
 * @method static Builder|PrivacyPolicyTranslation whereDescription($value)
 * @method static Builder|PrivacyPolicyTranslation whereId($value)
 * @method static Builder|PrivacyPolicyTranslation whereLocale($value)
 * @method static Builder|PrivacyPolicyTranslation wherePrivacyPolicyId($value)
 * @method static Builder|PrivacyPolicyTranslation whereTitle($value)
 * @method static Builder|PrivacyPolicyTranslation whereUpdatedAt($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|PrivacyPolicyTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PrivacyPolicyTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrivacyPolicyTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PrivacyPolicyTranslation withoutTrashed()
 */
	class PrivacyPolicyTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $slug
 * @property string $uuid
 * @property int $category_id
 * @property int $brand_id
 * @property int|null $unit_id
 * @property string|null $keywords
 * @property string|null $img
 * @property integer|null $min_qty
 * @property integer|null $max_qty
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property string|null $qr_code
 * @property int|null $stocks_sum_quantity
 * @property double $tax
 * @property int $shop_id
 * @property int $kitchen_id
 * @property boolean $active
 * @property boolean $addon
 * @property string $status
 * @property string $status_note
 * @property string $vegetarian
 * @property string $kcal
 * @property string $carbs
 * @property string $protein
 * @property string $fats
 * @property double $interval
 * @property float $is_bogo
 * @property-read Brand $brand
 * @property-read Collection|Tag[] $tags
 * @property-read Category $category
 * @property-read Discount|null $discount
 * @property-read Collection|Discount[] $discounts
 * @property-read int|null $discounts_count
 * @property-read Collection|ExtraGroup[] $extras
 * @property-read int|null $extras_count
 * @property-read Collection|Gallery[] $galleries
 * @property-read int|null $galleries_count
 * @property-read Collection|Story[] $stories
 * @property-read int|null $stories_count
 * @property-read Collection|OrderDetail[] $order_details
 * @property-read int|null $order_details_count
 * @property-read int|null $product_sales_count
 * @property-read Collection|ProductProperties[] $properties
 * @property-read int|null $properties_count
 * @property-read Collection|StockAddon[] $addons
 * @property-read int|null $addons_count
 * @property-read Collection|Review[] $reviews
 * @property-read int|null $reviews_count
 * @property-read int|null $reviews_avg_rating
 * @property-read Shop $shop
 * @property-read Collection|Stock[] $stocks
 * @property-read Stock|null $stock
 * @property-read int|null $stocks_count
 * @property-read ProductTranslation|null $translation
 * @property-read Collection|ProductTranslation[] $translations
 * @property-read int|null $translations_count
 * @property-read Unit|null $unit
 * @property-read Collection|ModelLog[] $logs
 * @property-read int|null $logs_count
 * @property-read Collection|ProductInventoryItem[] $inventoryItems
 * @property-read int|null $inventory_items_count
 * @method static ProductFactory factory(...$parameters)
 * @method static Builder|Product filter($array)
 * @method static Builder|Product active($active)
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product onlyTrashed()
 * @method static Builder|Product query()
 * @method static Builder|Product whereBrandId($value)
 * @method static Builder|Product whereAddon($value)
 * @method static Builder|Product whereCategoryId($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDeletedAt($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereImg($value)
 * @method static Builder|Product whereKeywords($value)
 * @method static Builder|Product whereQrCode($value)
 * @method static Builder|Product whereUnitId($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static Builder|Product whereUuid($value)
 * @method static Builder|Product withTrashed()
 * @method static Builder|Product withoutTrashed()
 * @mixin Eloquent
 * @property-read \App\Models\Gallery|null $gallery
 * @property-read \App\Models\Kitchen|null $kitchen
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MetaTag> $metaTags
 * @property-read int|null $meta_tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderDetail> $orderDetails
 * @property-read \App\Models\Review|null $review
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCarbs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereFats($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsBogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereKcal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereKitchenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMaxQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMinQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProtein($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatusNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereVegetarian($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property int $product_id
 * @property int $addon_id
 * @property Product|null $addon
 * @property Product|null $product
 * @method static ProductFactory factory(...$parameters)
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product whereAddonId($value)
 * @method static Builder|Product whereProductId($value)
 * @mixin Eloquent
 */
	class ProductAddon extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductDiscount
 *
 * @property int $id
 * @property int $discount_id
 * @property int $product_id
 * @method static ProductDiscountFactory factory(...$parameters)
 * @method static Builder|ProductDiscount newModelQuery()
 * @method static Builder|ProductDiscount newQuery()
 * @method static Builder|ProductDiscount query()
 * @method static Builder|ProductDiscount whereDiscountId($value)
 * @method static Builder|ProductDiscount whereId($value)
 * @method static Builder|ProductDiscount whereShopProductId($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDiscount onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDiscount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDiscount whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDiscount withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDiscount withoutTrashed()
 */
	class ProductDiscount extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductExtra
 *
 * @property int $id
 * @property int $product_id
 * @property int $extra_group_id
 * @property-read ExtraGroup $extras
 * @method static ProductExtraFactory factory(...$parameters)
 * @method static Builder|ProductExtra newModelQuery()
 * @method static Builder|ProductExtra newQuery()
 * @method static Builder|ProductExtra query()
 * @method static Builder|ProductExtra whereExtraGroupId($value)
 * @method static Builder|ProductExtra whereId($value)
 * @method static Builder|ProductExtra whereProductId($value)
 * @mixin Eloquent
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProductExtra whereDeletedAt($value)
 */
	class ProductExtra extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductInventoryItem
 *
 * @property int $id
 * @property int $inventory_item_id
 * @property int $product_id
 * @property string $interval
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read InventoryItem $inventoryItem
 * @property-read Product $product
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self filter(array $filter)
 * @method static Builder|self whereId($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ProductInventoryItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductInventoryItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductInventoryItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductInventoryItem whereInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductInventoryItem whereInventoryItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductInventoryItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductInventoryItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductInventoryItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductInventoryItem withoutTrashed()
 */
	class ProductInventoryItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductProperties
 *
 * @property int $id
 * @property int $product_id
 * @property string $locale
 * @property string $key
 * @property string|null $value
 * @property string|null $deleted_at
 * @method static ProductPropertiesFactory factory(...$parameters)
 * @method static Builder|ProductProperties newModelQuery()
 * @method static Builder|ProductProperties newQuery()
 * @method static Builder|ProductProperties query()
 * @method static Builder|ProductProperties whereId($value)
 * @method static Builder|ProductProperties whereKey($value)
 * @method static Builder|ProductProperties whereLocale($value)
 * @method static Builder|ProductProperties whereProductId($value)
 * @method static Builder|ProductProperties whereValue($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ProductProperties onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductProperties whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductProperties withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductProperties withoutTrashed()
 */
	class ProductProperties extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductTranslation
 *
 * @property int $id
 * @property int $product_id
 * @property string $locale
 * @property string $title
 * @property string|null $description
 * @method static ProductTranslationFactory factory(...$parameters)
 * @method static Builder|ProductTranslation newModelQuery()
 * @method static Builder|ProductTranslation newQuery()
 * @method static Builder|ProductTranslation query()
 * @method static Builder|ProductTranslation whereDescription($value)
 * @method static Builder|ProductTranslation whereId($value)
 * @method static Builder|ProductTranslation whereLocale($value)
 * @method static Builder|ProductTranslation whereProductId($value)
 * @method static Builder|ProductTranslation whereTitle($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductTranslation withoutTrashed()
 */
	class ProductTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PushNotification
 *
 * @property int $id
 * @property string $type
 * @property string $title
 * @property string $body
 * @property array $data
 * @property int $user_id
 * @property User $user
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $read_at
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|PushNotification whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PushNotification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PushNotification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PushNotification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PushNotification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PushNotification whereUserId($value)
 */
	class PushNotification extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Receipt
 *
 * @property int $id
 * @property int $shop_id
 * @property string $img
 * @property string $bg_img
 * @property string $discount_type
 * @property int $discount_price
 * @property int $category_id
 * @property string $active_time
 * @property string $total_time
 * @property int $calories
 * @property int $servings
 * @property Shop|null $shop
 * @property Collection|Stock[] $stocks
 * @property Collection|ReceiptStock[] $receiptStock
 * @property int $stocks_count
 * @property Collection|ReceiptTranslation[] $translations
 * @property ReceiptTranslation|null $translation
 * @property int $translations_count
 * @property Collection|ReceiptIngredient[] $ingredients
 * @property ReceiptIngredient|null $ingredient
 * @property int $ingredients_count
 * @property Collection|ReceiptInstruction[] $instructions
 * @property ReceiptInstruction|null $instruction
 * @property int $instructions_count
 * @property Collection|ReceiptNutrition[] $nutritions
 * @property int $nutritions_count
 * @property Collection|Gallery[] $galleries
 * @property int $galleries_count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self filter($filter)
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\Gallery|null $gallery
 * @property-read int|null $receipt_stock_count
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereActiveTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereBgImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereCalories($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereDiscountPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereServings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt whereTotalTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Receipt withoutTrashed()
 */
	class Receipt extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReceiptIngredient
 *
 * @property int $id
 * @property int $receipt_id
 * @property Receipt|null $receipt
 * @property string $locale
 * @property string $title
 * @property Carbon|null $deleted_at
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptIngredient onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptIngredient whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptIngredient whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptIngredient whereReceiptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptIngredient whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptIngredient withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptIngredient withoutTrashed()
 */
	class ReceiptIngredient extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReceiptInstruction
 *
 * @property int $id
 * @property int $receipt_id
 * @property Receipt|null $receipt
 * @property string $locale
 * @property string $title
 * @property Carbon|null $deleted_at
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptInstruction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptInstruction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptInstruction whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptInstruction whereReceiptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptInstruction whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptInstruction withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptInstruction withoutTrashed()
 */
	class ReceiptInstruction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReceiptNutrition
 *
 * @property int $id
 * @property int $receipt_id
 * @property Receipt|null $receipt
 * @property Collection|Translation[] $translations
 * @property Translation|null $translation
 * @property ReceiptTranslation|null $translations_count
 * @property string $weight
 * @property int $percentage
 * @property Carbon|null $deleted_at
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereId($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptNutrition onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptNutrition whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptNutrition wherePercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptNutrition whereReceiptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptNutrition whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptNutrition withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptNutrition withoutTrashed()
 */
	class ReceiptNutrition extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReceiptNutritionTranslation
 *
 * @property int $id
 * @property string $locale
 * @property int $receipt_nutrition_id
 * @property ReceiptNutrition|null $receiptNutrition
 * @property string $title
 * @property Carbon|null $deleted_at
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @mixin Eloquent
 * @property int $nutrition_id
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptNutritionTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptNutritionTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptNutritionTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptNutritionTranslation whereNutritionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptNutritionTranslation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptNutritionTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptNutritionTranslation withoutTrashed()
 */
	class ReceiptNutritionTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReceiptStock
 *
 * @property int $receipt_id
 * @property int $stock_id
 * @property int $min_quantity
 * @property Receipt|null $receipt
 * @property Stock|null $stock
 * @property Carbon|null $deleted_at
 * @method static Builder|ReceiptStock newModelQuery()
 * @method static Builder|ReceiptStock newQuery()
 * @method static Builder|ReceiptStock query()
 * @method static Builder|ReceiptStock whereCreatedAt($value)
 * @method static Builder|ReceiptStock whereId($value)
 * @method static Builder|ReceiptStock whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptStock onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptStock whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptStock whereMinQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptStock whereReceiptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptStock whereStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptStock withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptStock withoutTrashed()
 */
	class ReceiptStock extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReceiptTranslation
 *
 * @property int $id
 * @property int $receipt_id
 * @property Receipt|null $receipt
 * @property string $locale
 * @property string $title
 * @property string $description
 * @property Carbon|null $deleted_at
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptTranslation whereReceiptId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptTranslation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceiptTranslation withoutTrashed()
 */
	class ReceiptTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Referral
 *
 * @property int $id
 * @property double $price_from
 * @property double $price_to
 * @property Carbon|null $expired_at
 * @property string $img
 * @property Translation|null $translation
 * @property Collection|Translation[] $translations
 * @property int $translations_count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|Referral newModelQuery()
 * @method static Builder|Referral newQuery()
 * @method static Builder|Referral query()
 * @method static Builder|Referral whereCreatedAt($value)
 * @method static Builder|Referral whereId($value)
 * @method static Builder|Referral whereUpdatedAt($value)
 * @method static Builder|Referral whereDeletedAt($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gallery> $galleries
 * @property-read int|null $galleries_count
 * @property-read \App\Models\Gallery|null $gallery
 * @method static \Illuminate\Database\Eloquent\Builder|Referral onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Referral whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Referral whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Referral wherePriceFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Referral wherePriceTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Referral withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Referral withoutTrashed()
 */
	class Referral extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReferralTranslation
 *
 * @property int $id
 * @property int $referral_id
 * @property string $locale
 * @property string $title
 * @property string|null $description
 * @property string|null $faq
 * @property Carbon|null $deleted_at
 * @property Referral|null $referral
 * @method static Builder|ReferralTranslation newModelQuery()
 * @method static Builder|ReferralTranslation newQuery()
 * @method static Builder|ReferralTranslation query()
 * @method static Builder|ReferralTranslation whereDescription($value)
 * @method static Builder|ReferralTranslation whereFaq($value)
 * @method static Builder|ReferralTranslation whereId($value)
 * @method static Builder|ReferralTranslation whereLocale($value)
 * @method static Builder|ReferralTranslation whereReferralId($value)
 * @method static Builder|ReferralTranslation whereTitle($value)
 * @method static Builder|ReferralTranslation whereDeletedAt($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralTranslation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ReferralTranslation withoutTrashed()
 */
	class ReferralTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RequestModel
 *
 * @property int $id
 * @property int $model_id
 * @property string $model_type
 * @property array $data
 * @property int $created_by
 * @property string $status
 * @property string $status_note
 * @property Category|Product|User $model
 * @property User $createdBy
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|self active()
 * @method static Builder|self filter(array $filter)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereId($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|RequestModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestModel whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestModel whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestModel whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestModel whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestModel whereStatusNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RequestModel whereUpdatedAt($value)
 */
	class RequestModel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Review
 *
 * @property int $id
 * @property string $reviewable_type
 * @property int $reviewable_id
 * @property string $assignable_type
 * @property int $assignable_id
 * @property int $user_id
 * @property float $rating
 * @property string|null $comment
 * @property string|null $img
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection|Gallery[] $galleries
 * @property-read int|null $galleries_count
 * @property-read Model|Eloquent $reviewable
 * @property-read Model|Eloquent $assignable
 * @property-read User $user
 * @method static ReviewFactory factory(...$parameters)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereComment($value)
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereImg($value)
 * @method static Builder|self whereRating($value)
 * @method static Builder|self whereReviewableId($value)
 * @method static Builder|self whereReviewableType($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereUserId($value)
 * @mixin Eloquent
 * @property-read \App\Models\Gallery|null $gallery
 * @method static \Illuminate\Database\Eloquent\Builder|Review onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereAssignableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereAssignableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Review withoutTrashed()
 */
	class Review extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Settings
 *
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereKey($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereValue($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Database\Factories\SettingsFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Settings withoutTrashed()
 */
	class Settings extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Shop
 *
 * @property int $id
 * @property string $slug
 * @property string $uuid
 * @property int $user_id
 * @property int $pos_access
 * @property float $tax
 * @property float $rate_tax
 * @property float $percentage
 * @property array|null $location
 * @property string|null $phone
 * @property int|null $show_type
 * @property boolean $open
 * @property boolean $visibility
 * @property boolean $verify
 * @property string|null $background_img
 * @property string|null $logo_img
 * @property float $min_amount
 * @property string $status
 * @property array $email_statuses
 * @property string $order_payment
 * @property bool $new_order_after_payment
 * @property integer $price
 * @property integer $price_per_km
 * @property integer $rate_price
 * @property integer $rate_price_per_km
 * @property integer $rate_min_amount
 * @property string|null $status_note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property int|null $service_fee
 * @property string $wifi_password
 * @property string $wifi_name
 * @property array|null $delivery_time
 * @property-read Collection|Gallery[] $galleries
 * @property-read int|null $galleries_count
 * @property-read Collection|Discount[] $discounts
 * @property-read int|null $discounts_count
 * @property-read Collection|Invitation[] $invitations
 * @property-read int|null $invitations_count
 * @property-read Collection|OrderDetail[] $orders
 * @property-read int|null $orders_count
 * @property-read Collection|Product[] $products
 * @property-read int|null $products_count
 * @property-read Collection|ShopPayment[] $shopPayments
 * @property-read int|null $shop_payments_count
 * @property-read Collection|Review[] $reviews
 * @property-read DeliveryZone|null $deliveryZone
 * @property-read Collection|DeliveryZone[] $deliveryZones
 * @property-read int|double $delivery_zones_count
 * @property-read int|null $reviews_count
 * @property-read int|null $reviews_avg_rating
 * @property-read User|null $seller
 * @property-read ShopSubscription|null $subscription
 * @property-read ShopTranslation|null $translation
 * @property-read Collection|ShopTranslation[] $translations
 * @property-read int|null $translations_count
 * @property-read Collection|User[] $users
 * @property-read int|null $users_count
 * @property-read Collection|ShopWorkingDay[] $workingDays
 * @property-read int|null $working_days_count
 * @property-read Collection|ShopClosedDate[] $closedDates
 * @property-read int|null $closed_dates_count
 * @property-read Collection|ShopTag[] $tags
 * @property-read int|null $tags_count
 * @property float|null $avg_rate
 * @property-read Bonus|null $bonus
 * @property-read ShopDeliverymanSetting|null $shopDeliverymanSetting
 * @property-read Collection|ModelLog[] $logs
 * @property-read int|null $logs_count
 * @property-read Collection|Gallery[] $documents
 * @property-read int|null $documents_count
 * @method static ShopFactory factory(...$parameters)
 * @method static Builder|self filter($filter)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self onlyTrashed()
 * @method static Builder|self query()
 * @method static Builder|self whereBackgroundImg($value)
 * @method static Builder|self whereCloseTime($value)
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereDeletedAt($value)
 * @method static Builder|self whereDeliveryRange($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereLocation($value)
 * @method static Builder|self whereLogoImg($value)
 * @method static Builder|self whereMinAmount($value)
 * @method static Builder|self whereOpen($value)
 * @method static Builder|self whereOpenTime($value)
 * @method static Builder|self wherePercentage($value)
 * @method static Builder|self wherePhone($value)
 * @method static Builder|self whereShowType($value)
 * @method static Builder|self whereStatus($value)
 * @method static Builder|self whereStatusNote($value)
 * @method static Builder|self whereTax($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereUserId($value)
 * @method static Builder|self whereUuid($value)
 * @method static Builder|self withTrashed()
 * @method static Builder|self withoutTrashed()
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \App\Models\Gallery|null $gallery
 * @property-read \App\Models\Review|null $review
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereDeliveryTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereEmailStatuses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereNewOrderAfterPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereOrderPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop wherePosAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop wherePricePerKm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereServiceFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereVerify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereVisibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereWifiName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereWifiPassword($value)
 */
	class Shop extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShopAdsPackage
 *
 * @property int $id
 * @property boolean $active
 * @property int $ads_package_id
 * @property int $position_page
 * @property int $shop_id
 * @property int $banner_id
 * @property string $status
 * @property Carbon|null $expired_at
 * @property AdsPackage|null $adsPackage
 * @property Shop|null $shop
 * @property Banner|null $banner
 * @property Carbon|null $deleted_at
 * @method static Builder|self active()
 * @method static Builder|self filter(array $filter)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereId($value)
 * @mixin Eloquent
 * @property-read \App\Models\Transaction|null $transaction
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|ShopAdsPackage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopAdsPackage whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopAdsPackage whereAdsPackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopAdsPackage whereBannerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopAdsPackage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopAdsPackage whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopAdsPackage wherePositionPage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopAdsPackage whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopAdsPackage whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopAdsPackage withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopAdsPackage withoutTrashed()
 */
	class ShopAdsPackage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShopCategory
 *
 * @property int $id
 * @property int $shop_id
 * @property int $category_id
 * @property Carbon|null $deleted_at
 * @property-read Collection|Category[] $categories
 * @property-read Collection|Shop[] $shops
 * @property-read int|null $categories_count
 * @property-read int|null $shops_count
 * @method static Builder|ShopCategory newModelQuery()
 * @method static Builder|ShopCategory newQuery()
 * @method static Builder|ShopCategory query()
 * @method static Builder|ShopCategory whereCategoryId($value)
 * @method static Builder|ShopCategory whereId($value)
 * @method static Builder|ShopCategory whereShopId($value)
 * @mixin Eloquent
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\Shop $shop
 * @method static \Illuminate\Database\Eloquent\Builder|ShopCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopCategory withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopCategory withoutTrashed()
 */
	class ShopCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShopClosedDate
 *
 * @property int $id
 * @property int $shop_id
 * @property Carbon|null $date
 * @property Shop|null $shop
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @method static Builder|self filter($query, $filter)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereShopId($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Database\Factories\ShopClosedDateFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopClosedDate onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopClosedDate whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopClosedDate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopClosedDate withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopClosedDate withoutTrashed()
 */
	class ShopClosedDate extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShopDeliverymanSetting
 *
 * @property int $id
 * @property string|null $shop_id
 * @property string|null $type
 * @property string|null $value
 * @property string|null $period
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|self filter($filter)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereId($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ShopDeliverymanSetting wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopDeliverymanSetting whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopDeliverymanSetting whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopDeliverymanSetting whereValue($value)
 */
	class ShopDeliverymanSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShopGallery
 *
 * @property int $id
 * @property int $shop_id
 * @property boolean $active
 * @property Shop|null $shop
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereLoadableId($value)
 * @method static Builder|self whereLoadableType($value)
 * @method static Builder|self whereMime($value)
 * @method static Builder|self wherePath($value)
 * @method static Builder|self whereSize($value)
 * @method static Builder|self whereTitle($value)
 * @method static Builder|self whereType($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gallery> $galleries
 * @property-read int|null $galleries_count
 * @property-read \App\Models\Gallery|null $gallery
 * @method static \Illuminate\Database\Eloquent\Builder|ShopGallery whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopGallery whereShopId($value)
 */
	class ShopGallery extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShopPayment
 *
 * @property int $id
 * @property int $payment_id
 * @property int $shop_id
 * @property int $status
 * @property string|null $client_id
 * @property string|null $secret_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property string|null $merchant_email
 * @property string|null $payment_key
 * @property-read Payment|null $payment
 * @property-read Shop|null $shop
 * @method static Builder|ShopPayment newModelQuery()
 * @method static Builder|ShopPayment newQuery()
 * @method static Builder|ShopPayment query()
 * @method static Builder|ShopPayment filter(array $filter)
 * @method static Builder|ShopPayment whereClientId($value)
 * @method static Builder|ShopPayment whereCreatedAt($value)
 * @method static Builder|ShopPayment whereId($value)
 * @method static Builder|ShopPayment whereMerchantEmail($value)
 * @method static Builder|ShopPayment wherePaymentId($value)
 * @method static Builder|ShopPayment wherePaymentKey($value)
 * @method static Builder|ShopPayment whereSecretId($value)
 * @method static Builder|ShopPayment whereShopId($value)
 * @method static Builder|ShopPayment whereStatus($value)
 * @method static Builder|ShopPayment whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Database\Factories\ShopPaymentFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopPayment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopPayment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopPayment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopPayment withoutTrashed()
 */
	class ShopPayment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShopSubscription
 *
 * @property int $id
 * @property int $shop_id
 * @property int $subscription_id
 * @property string|null $expired_at
 * @property float|null $price
 * @property string|null $type
 * @property int $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Shop $shop
 * @property-read Subscription|null $subscription
 * @property-read Transaction|null $transaction
 * @property-read Collection|Transaction[] $transactions
 * @property-read int|null $transactions_count
 * @method static Builder|self actualSubscription()
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereActive($value)
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereExpiredAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self wherePrice($value)
 * @method static Builder|self whereShopId($value)
 * @method static Builder|self whereSubscriptionId($value)
 * @method static Builder|self whereType($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|ShopSubscription onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopSubscription whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopSubscription withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopSubscription withoutTrashed()
 */
	class ShopSubscription extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShopTag
 *
 * @property int $id
 * @property int $img
 * @property Collection|Gallery[] $galleries
 * @property int $galleries_count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read ShopTagTranslation|null $translation
 * @property-read Collection|ShopTagTranslation[] $translations
 * @property-read int|null $translations_count
 * @property-read Collection|ShopTagTranslation[] $assignShopTags
 * @property-read int|null $assign_shop_tags_count
 * @method static Builder|ShopTag newModelQuery()
 * @method static Builder|ShopTag newQuery()
 * @method static Builder|ShopTag query()
 * @method static Builder|ShopTag whereCreatedAt($value)
 * @method static Builder|ShopTag whereUpdatedAt($value)
 * @method static Builder|ShopTag whereDeletedAt($value)
 * @method static Builder|ShopTag whereId($value)
 * @method static Builder|ShopTag whereShopId($value)
 * @mixin Eloquent
 * @property-read \App\Models\Gallery|null $gallery
 * @method static \Illuminate\Database\Eloquent\Builder|ShopTag onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopTag whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopTag withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopTag withoutTrashed()
 */
	class ShopTag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShopTagTranslation
 *
 * @property int $id
 * @property int $shop_tag_id
 * @property string $locale
 * @property string $title
 * @method static Builder|ShopTagTranslation newModelQuery()
 * @method static Builder|ShopTagTranslation newQuery()
 * @method static Builder|ShopTagTranslation query()
 * @method static Builder|ShopTagTranslation whereId($value)
 * @method static Builder|ShopTagTranslation whereLocale($value)
 * @method static Builder|ShopTagTranslation whereTitle($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ShopTagTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopTagTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopTagTranslation whereShopTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopTagTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopTagTranslation withoutTrashed()
 */
	class ShopTagTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShopTranslation
 *
 * @property int $id
 * @property int $shop_id
 * @property string $locale
 * @property string $title
 * @property string|null $description
 * @property string|null $address
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereAddress($value)
 * @method static Builder|self whereDescription($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereLocale($value)
 * @method static Builder|self whereShopId($value)
 * @method static Builder|self whereTitle($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ShopTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopTranslation withoutTrashed()
 */
	class ShopTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShopWeeklyReport
 *
 * @property int $id
 * @property int $shop_id
 * @property string $week_identifier
 * @property string $order_ids
 * @property string $total_price
 * @property-read int|null $orders_count
 * @property string $total_commission
 * @property string $total_discounts
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read \App\Models\Shop $shop
 * @method static \Illuminate\Database\Eloquent\Builder|ShopWeeklyReport byShopAndWeek($shopId, $weekIdentifier)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopWeeklyReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopWeeklyReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopWeeklyReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopWeeklyReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopWeeklyReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopWeeklyReport whereOrderIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopWeeklyReport whereOrdersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopWeeklyReport whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopWeeklyReport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopWeeklyReport whereTotalCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopWeeklyReport whereTotalDiscounts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopWeeklyReport whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopWeeklyReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopWeeklyReport whereWeekIdentifier($value)
 */
	class ShopWeeklyReport extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShopWorkingDay
 *
 * @property int $id
 * @property int $shop_id
 * @property string $day
 * @property string|null $from
 * @property string|null $to
 * @property boolean|null $disabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static ShopWorkingDayFactory factory(...$parameters)
 * @method static Builder|self filter($array = [])
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereShopId($value)
 * @method static Builder|self whereDay($value)
 * @method static Builder|self whereFrom($value)
 * @method static Builder|self whereTo($value)
 * @mixin Eloquent
 * @property-read \App\Models\Shop $shop
 * @method static \Illuminate\Database\Eloquent\Builder|ShopWorkingDay onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopWorkingDay whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopWorkingDay whereDisabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopWorkingDay withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopWorkingDay withoutTrashed()
 */
	class ShopWorkingDay extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SmsGateway
 *
 * @property int $id
 * @property string $title
 * @property string $from
 * @property string $type
 * @property string|null $api_key
 * @property string|null $secret_key
 * @property string|null $service_id
 * @property string|null $text
 * @property int $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static SmsGatewayFactory factory(...$parameters)
 * @method static Builder|SmsGateway newModelQuery()
 * @method static Builder|SmsGateway newQuery()
 * @method static Builder|SmsGateway query()
 * @method static Builder|SmsGateway whereActive($value)
 * @method static Builder|SmsGateway whereApiKey($value)
 * @method static Builder|SmsGateway whereCreatedAt($value)
 * @method static Builder|SmsGateway whereFrom($value)
 * @method static Builder|SmsGateway whereId($value)
 * @method static Builder|SmsGateway whereSecretKey($value)
 * @method static Builder|SmsGateway whereServiceId($value)
 * @method static Builder|SmsGateway whereText($value)
 * @method static Builder|SmsGateway whereTitle($value)
 * @method static Builder|SmsGateway whereType($value)
 * @method static Builder|SmsGateway whereUpdatedAt($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|SmsGateway onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SmsGateway whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsGateway withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SmsGateway withoutTrashed()
 */
	class SmsGateway extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SmsPayload
 *
 * @property string|null $type
 * @property array|null $payload
 * @property boolean|null $default
 * @property string|null $deleted_at
 * @method static SmsPayloadFactory factory(...$parameters)
 * @method static Builder|SmsPayload newModelQuery()
 * @method static Builder|SmsPayload newQuery()
 * @method static Builder|SmsPayload query()
 * @method static Builder|SmsPayload whereDeletedAt($value)
 * @method static Builder|SmsPayload whereId($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|SmsPayload onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SmsPayload whereDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsPayload wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsPayload whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsPayload withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SmsPayload withoutTrashed()
 */
	class SmsPayload extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SocialProvider
 *
 * @property int $id
 * @property int $user_id
 * @property string $provider
 * @property string $provider_id
 * @property string|null $avatar
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|SocialProvider newModelQuery()
 * @method static Builder|SocialProvider newQuery()
 * @method static Builder|SocialProvider query()
 * @method static Builder|SocialProvider whereAvatar($value)
 * @method static Builder|SocialProvider whereCreatedAt($value)
 * @method static Builder|SocialProvider whereId($value)
 * @method static Builder|SocialProvider whereProvider($value)
 * @method static Builder|SocialProvider whereProviderId($value)
 * @method static Builder|SocialProvider whereUpdatedAt($value)
 * @method static Builder|SocialProvider whereUserId($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProvider onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProvider whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProvider withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialProvider withoutTrashed()
 */
	class SocialProvider extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Stock
 *
 * @property int $id
 * @property string $countable_type
 * @property int $countable_id
 * @property float $price
 * @property int $quantity
 * @property string $sku
 * @property boolean $addon
 * @property string $img
 * @property Carbon|null $deleted_at
 * @property-read Product $product
 * @property-read Product $countable
 * @property-read mixed $actual_discount
 * @property-read mixed $rate_actual_discount
 * @property-read mixed $tax_price
 * @property-read mixed $rate_tax_price
 * @property-read mixed $total_price
 * @property-read mixed $rate_total_price
 * @property-read mixed $rate_price
 * @property-read Bonus|null $bonus
 * @property-read Collection|OrderDetail[] $orderDetails
 * @property-read int $order_details_count
 * @property-read Collection|OrderDetail[] $receipts
 * @property-read int $receipts_count
 * @property-read int $order_details_sum_quantity
 * @property-read Collection|StockAddon[] $addons
 * @property-read int $addons_count
 * @property-read Collection|CartDetail[] $cartDetails
 * @property-read int $cart_details_count
 * @property-read Collection|Bonus[] $bonusByShop
 * @property-read int $bonus_by_shop_count
 * @property-read Collection|ExtraValue[] $stockExtras
 * @property-read int|null $stock_extras_count
 * @property-read Collection|ExtraValue[] $stockExtrasTrashed
 * @property-read int|null $stock_extras_trashed_count
 * @property-read Collection|ModelLog[] $logs
 * @property-read int|null $logs_count
 * @property-read Collection|StockInventoryItem[] $inventoryItems
 * @property-read int|null $inventory_items_count
 * @method static StockFactory factory(...$parameters)
 * @method static Builder|Stock newModelQuery()
 * @method static Builder|Stock newQuery()
 * @method static Builder|Stock onlyTrashed()
 * @method static Builder|Stock query()
 * @method static Builder|Stock increment($column, $amount = 1, array $extra = [])
 * @method static Builder|Stock decrement($column, $amount = 1, array $extra = [])
 * @method static Builder|Stock whereCountableId($value)
 * @method static Builder|Stock whereCountableType($value)
 * @method static Builder|Stock whereDeletedAt($value)
 * @method static Builder|Stock whereId($value)
 * @method static Builder|Stock wherePrice($value)
 * @method static Builder|Stock whereQuantity($value)
 * @method static Builder|Stock whereSku($value)
 * @method static Builder|Stock withTrashed()
 * @method static Builder|Stock withoutTrashed()
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gallery> $galleries
 * @property-read int|null $galleries_count
 * @property-read \App\Models\Gallery|null $gallery
 * @property-read string|null $discount_expired
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereAddon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereImg($value)
 */
	class Stock extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\StockAddon
 *
 * @property int $id
 * @property int $stock_id
 * @property int $addon_id
 * @property Product|null $addon
 * @property Stock|null $stock
 * @method static Builder|StockAddon newModelQuery()
 * @method static Builder|StockAddon newQuery()
 * @method static Builder|StockAddon query()
 * @method static Builder|StockAddon whereAddonId($value)
 * @method static Builder|StockAddon whereProductId($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|StockAddon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockAddon whereStockId($value)
 */
	class StockAddon extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\StockExtra
 *
 * @property int $id
 * @property int $stock_id
 * @property int $extra_value_id
 * @property ExtraValue|null $extraValue
 * @method static StockExtraFactory factory(...$parameters)
 * @method static Builder|StockExtra newModelQuery()
 * @method static Builder|StockExtra newQuery()
 * @method static Builder|StockExtra query()
 * @method static Builder|StockExtra whereExtraValueId($value)
 * @method static Builder|StockExtra whereId($value)
 * @method static Builder|StockExtra whereStockId($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|StockExtra onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|StockExtra whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockExtra withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|StockExtra withoutTrashed()
 */
	class StockExtra extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\StockInventoryItem
 *
 * @property int $id
 * @property int $inventory_item_id
 * @property int $stock_id
 * @property string $interval
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read InventoryItem $inventoryItem
 * @property-read Stock $stock
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self filter(array $filter)
 * @method static Builder|self whereId($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|StockInventoryItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|StockInventoryItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockInventoryItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockInventoryItem whereInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockInventoryItem whereInventoryItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockInventoryItem whereStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockInventoryItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockInventoryItem withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|StockInventoryItem withoutTrashed()
 */
	class StockInventoryItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Story
 *
 * @property int $id
 * @property array $file_urls
 * @property int $product_id
 * @property int $shop_id
 * @property boolean $active
 * @property Product|null $product
 * @property Shop|null $shop
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static Builder|Story newModelQuery()
 * @method static Builder|Story newQuery()
 * @method static Builder|Story query()
 * @method static Builder|Story whereCreatedAt($value)
 * @method static Builder|Story whereId($value)
 * @method static Builder|Story whereStockId($value)
 * @method static Builder|Story whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Database\Factories\StoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Story whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Story whereFileUrls($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Story whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Story whereShopId($value)
 */
	class Story extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Subscription
 *
 * @property int $id
 * @property string $type
 * @property float $price
 * @property int $month
 * @property int $active
 * @property string $title
 * @property int $product_limit
 * @property int $order_limit
 * @property boolean $with_report
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|Subscription newModelQuery()
 * @method static Builder|Subscription newQuery()
 * @method static Builder|Subscription onlyTrashed()
 * @method static Builder|Subscription query()
 * @method static Builder|Subscription whereActive($value)
 * @method static Builder|Subscription whereCreatedAt($value)
 * @method static Builder|Subscription whereDeletedAt($value)
 * @method static Builder|Subscription whereId($value)
 * @method static Builder|Subscription whereMonth($value)
 * @method static Builder|Subscription wherePrice($value)
 * @method static Builder|Subscription whereType($value)
 * @method static Builder|Subscription whereUpdatedAt($value)
 * @method static Builder|Subscription withTrashed()
 * @method static Builder|Subscription withoutTrashed()
 * @mixin Eloquent
 * @method static \Database\Factories\SubscriptionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereOrderLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereProductLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereWithReport($value)
 */
	class Subscription extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tag
 *
 * @property int $id
 * @property int $product_id
 * @property boolean $active
 * @property Product|null $product
 * @property Collection|TagTranslation[] $translations
 * @property TagTranslation|null $translation
 * @property-read int|null $translations_count
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @method static Builder|Tag newModelQuery()
 * @method static Builder|Tag newQuery()
 * @method static Builder|Tag query()
 * @method static Builder|Tag whereCreatedAt($value)
 * @method static Builder|Tag whereId($value)
 * @method static Builder|Tag whereStockId($value)
 * @method static Builder|Tag whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Database\Factories\TagFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag withoutTrashed()
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TagTranslation
 *
 * @property int $id
 * @property int $tag_id
 * @property string $locale
 * @property string $title
 * @property string|null $description
 * @method static Builder|TagTranslation newModelQuery()
 * @method static Builder|TagTranslation newQuery()
 * @method static Builder|TagTranslation query()
 * @method static Builder|TagTranslation whereAddress($value)
 * @method static Builder|TagTranslation whereDescription($value)
 * @method static Builder|TagTranslation whereId($value)
 * @method static Builder|TagTranslation whereLocale($value)
 * @method static Builder|TagTranslation whereShopId($value)
 * @method static Builder|TagTranslation whereTitle($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Database\Factories\TagTranslationFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|TagTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TagTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TagTranslation whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TagTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TagTranslation withoutTrashed()
 */
	class TagTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TermCondition
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read TermConditionTranslation|null $translation
 * @property-read Collection|TermConditionTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static TermConditionFactory factory(...$parameters)
 * @method static Builder|TermCondition newModelQuery()
 * @method static Builder|TermCondition newQuery()
 * @method static Builder|TermCondition query()
 * @method static Builder|TermCondition whereCreatedAt($value)
 * @method static Builder|TermCondition whereId($value)
 * @method static Builder|TermCondition whereUpdatedAt($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|TermCondition onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TermCondition whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermCondition withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TermCondition withoutTrashed()
 */
	class TermCondition extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TermConditionTranslation
 *
 * @property int $id
 * @property int $term_condition_id
 * @property string $title
 * @property string $description
 * @property string $locale
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static Builder|TermConditionTranslation newModelQuery()
 * @method static Builder|TermConditionTranslation newQuery()
 * @method static Builder|TermConditionTranslation query()
 * @method static Builder|TermConditionTranslation whereCreatedAt($value)
 * @method static Builder|TermConditionTranslation whereDescription($value)
 * @method static Builder|TermConditionTranslation whereId($value)
 * @method static Builder|TermConditionTranslation whereLocale($value)
 * @method static Builder|TermConditionTranslation whereTermConditionId($value)
 * @method static Builder|TermConditionTranslation whereTitle($value)
 * @method static Builder|TermConditionTranslation whereUpdatedAt($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|TermConditionTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TermConditionTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermConditionTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TermConditionTranslation withoutTrashed()
 */
	class TermConditionTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Ticket
 *
 * @property int $id
 * @property string $uuid
 * @property int $created_by
 * @property int|null $user_id
 * @property int|null $order_id
 * @property int $parent_id
 * @property string $type
 * @property string $subject
 * @property string $content
 * @property string $status
 * @property int $read
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Ticket[] $children
 * @property-read int|null $children_count
 * @property-read Collection|ModelLog[] $logs
 * @property-read int|null $logs_count
 * @method static TicketFactory factory(...$parameters)
 * @method static Builder|Ticket filter($array)
 * @method static Builder|Ticket newModelQuery()
 * @method static Builder|Ticket newQuery()
 * @method static Builder|Ticket query()
 * @method static Builder|Ticket whereContent($value)
 * @method static Builder|Ticket whereCreatedAt($value)
 * @method static Builder|Ticket whereCreatedBy($value)
 * @method static Builder|Ticket whereId($value)
 * @method static Builder|Ticket whereOrderId($value)
 * @method static Builder|Ticket whereParentId($value)
 * @method static Builder|Ticket whereRead($value)
 * @method static Builder|Ticket whereStatus($value)
 * @method static Builder|Ticket whereSubject($value)
 * @method static Builder|Ticket whereType($value)
 * @method static Builder|Ticket whereUpdatedAt($value)
 * @method static Builder|Ticket whereUserId($value)
 * @method static Builder|Ticket whereUuid($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket withoutTrashed()
 */
	class Ticket extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property string $payable_type
 * @property int $payable_id
 * @property float $price
 * @property int|null $user_id
 * @property int|null $payment_sys_id
 * @property string|null $payment_trx_id
 * @property string|null $note
 * @property string|null $request
 * @property string|null $perform_time
 * @property string|null $refund_time
 * @property int|null $parent_id
 * @property string $status
 * @property string $type
 * @property string $status_description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read Order|Wallet|null $payable
 * @property-read Payment|null $paymentSystem
 * @property-read PaymentProcess|null $paymentProcess
 * @property-read User|null $user
 * @property-read self|null $parent
 * @property-read Collection|self[] $children
 * @method static TransactionFactory factory(...$parameters)
 * @method static Builder|self filter($array = [])
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereDeletedAt($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereNote($value)
 * @method static Builder|self wherePayableId($value)
 * @method static Builder|self wherePayableType($value)
 * @method static Builder|self wherePaymentSysId($value)
 * @method static Builder|self wherePaymentTrxId($value)
 * @method static Builder|self wherePerformTime($value)
 * @method static Builder|self wherePrice($value)
 * @method static Builder|self whereRefundTime($value)
 * @method static Builder|self whereStatus($value)
 * @method static Builder|self whereStatusDescription($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereUserId($value)
 * @mixin Eloquent
 * @property-read int|null $children_count
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction withoutTrashed()
 */
	class Transaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Translation
 *
 * @property int $id
 * @property int $status
 * @property string $locale
 * @property string $group
 * @property string $key
 * @property string|null $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|Translation filter($array = [])
 * @method static Builder|Translation newModelQuery()
 * @method static Builder|Translation newQuery()
 * @method static Builder|Translation query()
 * @method static Builder|Translation whereCreatedAt($value)
 * @method static Builder|Translation whereGroup($value)
 * @method static Builder|Translation whereId($value)
 * @method static Builder|Translation whereKey($value)
 * @method static Builder|Translation whereLocale($value)
 * @method static Builder|Translation whereStatus($value)
 * @method static Builder|Translation whereUpdatedAt($value)
 * @method static Builder|Translation whereValue($value)
 * @mixin Eloquent
 * @method static \Database\Factories\TranslationFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation withoutTrashed()
 */
	class Translation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Unit
 *
 * @property int $id
 * @property int $active
 * @property string $position
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read UnitTranslation|null $translation
 * @property-read Collection|UnitTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static UnitFactory factory(...$parameters)
 * @method static Builder|Unit newModelQuery()
 * @method static Builder|Unit newQuery()
 * @method static Builder|Unit query()
 * @method static Builder|Unit whereActive($value)
 * @method static Builder|Unit whereCreatedAt($value)
 * @method static Builder|Unit whereId($value)
 * @method static Builder|Unit wherePosition($value)
 * @method static Builder|Unit whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Unit onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unit withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Unit withoutTrashed()
 */
	class Unit extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UnitTranslation
 *
 * @property int $id
 * @property int $unit_id
 * @property string $locale
 * @property string $title
 * @property-read Unit|null $unit
 * @method static UnitTranslationFactory factory(...$parameters)
 * @method static Builder|UnitTranslation newModelQuery()
 * @method static Builder|UnitTranslation newQuery()
 * @method static Builder|UnitTranslation query()
 * @method static Builder|UnitTranslation whereId($value)
 * @method static Builder|UnitTranslation whereLocale($value)
 * @method static Builder|UnitTranslation whereTitle($value)
 * @method static Builder|UnitTranslation whereUnitId($value)
 * @mixin Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|UnitTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnitTranslation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitTranslation withoutTrashed()
 */
	class UnitTranslation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $uuid
 * @property string $firstname
 * @property string|null $lastname
 * @property string|null $email
 * @property string|null $phone
 * @property Carbon|null $birthday
 * @property string $gender
 * @property Carbon|null $email_verified_at
 * @property Carbon|null $phone_verified_at
 * @property string|null $ip_address
 * @property int|null $kitchen_id
 * @property boolean $isWork
 * @property int $active
 * @property string|null $img
 * @property array|null $firebase_token
 * @property string|null $password
 * @property string|null $remember_token
 * @property string|null $name_or_email
 * @property string|null $verify_token
 * @property string|null $referral
 * @property string|null $my_referral
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property Carbon|null $language_id
 * @property Carbon|null $currency_id
 * @property Language|null $language
 * @property Currency|null $currency
 * @property-read Collection|Gallery[] $galleries
 * @property-read int|null $galleries_count
 * @property-read mixed $role
 * @property-read Collection|Invitation[] $invitations
 * @property-read int|null $invitations_count
 * @property-read Invitation|null $invite
 * @property-read Collection|Banner[] $likes
 * @property-read int|null $likes_count
 * @property-read Shop|null $moderatorShop
 * @property-read Collection|Review[] $reviews
 * @property-read int|null $reviews_count
 * @property-read Collection|UserAddress[] $addresses
 * @property-read int|null $addresses_count
 * @property-read Collection|Review[] $assignReviews
 * @property-read int|null $assign_reviews_count
 * @property-read Collection|Notification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|OrderDetail[] $orderDetails
 * @property-read int|null $order_details_count
 * @property-read int|null $orders_sum_total_price
 * @property-read Collection|Order[] $orders
 * @property-read int|null $orders_count
 * @property-read Collection|Order[] $deliveryManOrders
 * @property-read DeliveryManDeliveryZone|null $deliveryManDeliveryZone
 * @property-read int|null $delivery_man_orders_count
 * @property-read int|null $delivery_man_orders_sum_total_price
 * @property-read int|null $reviews_avg_rating
 * @property-read int|null $assign_reviews_avg_rating
 * @property-read Collection|Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection|Permission[] $transactions
 * @property-read int|null $transactions_count
 * @property-read UserPoint|null $point
 * @property-read Collection|PointHistory[] $pointHistory
 * @property-read int|null $point_history_count
 * @property-read Collection|Role[] $roles
 * @property-read int|null $roles_count
 * @property-read Shop|null $shop
 * @property-read DeliveryManSetting|null $deliveryManSetting
 * @property-read EmailSubscription|null $emailSubscription
 * @property-read Collection|SocialProvider[] $socialProviders
 * @property-read int|null $social_providers_count
 * @property-read Collection|PersonalAccessToken[] $tokens
 * @property-read Collection|PaymentProcess[] $paymentProcess
 * @property-read int $payment_process_count
 * @property-read int|null $tokens_count
 * @property-read Wallet|Builder|null $wallet
 * @property-read static|void $create
 * @property-read Collection|Activity[] $activities
 * @property-read int $activities_count
 * @property-read Collection|Table[] $waiterTables
 * @property-read Collection|WaiterTable[] $waiterTableAssigned
 * @property-read int $waiter_tables_count
 * @property-read Collection|ModelLog[] $logs
 * @property-read int|null $logs_count
 * @property-read int|null $tg_user_id
 * @property-read int|null $location
 * @property-read int|null $referral_from_topup_price
 * @property-read int|null $referral_from_withdraw_price
 * @property-read int|null $referral_to_withdraw_price
 * @property-read int|null $referral_to_topup_price
 * @property-read int|null $referral_from_topup_count
 * @property-read int|null $referral_from_withdraw_count
 * @property-read int|null $referral_to_withdraw_count
 * @property-read int|null $referral_to_topup_count
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self onlyTrashed()
 * @method static Builder|self permission($permissions)
 * @method static Builder|self query()
 * @method static Builder|self filter($filter)
 * @method static Builder|self role($roles, $guard = null)
 * @method static Builder|self whereActive($value)
 * @method static Builder|self whereBirthday($value)
 * @method static Builder|self whereCreatedAt($value)
 * @method static Builder|self whereDeletedAt($value)
 * @method static Builder|self whereEmail($value)
 * @method static Builder|self whereEmailVerifiedAt($value)
 * @method static Builder|self whereFirebaseToken($value)
 * @method static Builder|self whereFirstname($value)
 * @method static Builder|self whereGender($value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereImg($value)
 * @method static Builder|self whereIpAddress($value)
 * @method static Builder|self whereLastname($value)
 * @method static Builder|self wherePassword($value)
 * @method static Builder|self wherePhone($value)
 * @method static Builder|self wherePhoneVerifiedAt($value)
 * @method static Builder|self whereRememberToken($value)
 * @method static Builder|self whereUpdatedAt($value)
 * @method static Builder|self whereUuid($value)
 * @method static Builder|self withTrashed()
 * @method static Builder|self withoutTrashed()
 * @mixin Eloquent
 * @property-read \App\Models\UserActivity|null $activity
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Coupon> $coupons
 * @property-read int|null $coupons_count
 * @property-read \App\Models\Gallery|null $gallery
 * @property-read \App\Models\Kitchen|null $kitchen
 * @property-read \App\Models\RequestModel|null $model
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RequestModel> $models
 * @property-read int|null $models_count
 * @property-read int|null $waiter_table_assigned_count
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsWork($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereKitchenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMyReferral($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereReferral($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTgUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereVerifyToken($value)
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace App\Models{
/**
 * App\Models\UserActivity
 *
 * @property int $id
 * @property int $user_id
 * @property string $model_type
 * @property int $model_id
 * @property int $type
 * @property int $value
 * @property int $ip
 * @property int $device
 * @property int $agent
 * @property int $created_at
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self filter(array $value)
 * @method static Builder|self whereId($value)
 * @method static Builder|self whereUserId($value)
 * @method static Builder|self whereType($value)
 * @method static Builder|self whereValue($value)
 * @method static Builder|self whereIp($value)
 * @method static Builder|self whereDevice($value)
 * @method static Builder|self whereAgent($value)
 * @method static Builder|self whereCreatedAt($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $model
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserActivity whereModelType($value)
 */
	class UserActivity extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserAddress
 *
 * @property int $id
 * @property string $title
 * @property int $user_id
 * @property array $address
 * @property array $location
 * @property bool $active
 * @property User|null $user
 * @property Order[]|Collection $orders
 * @property int $orders_count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|self active()
 * @method static Builder|self filter(array $filter)
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self whereId($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gallery> $galleries
 * @property-read int|null $galleries_count
 * @property-read \App\Models\Gallery|null $gallery
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress withoutTrashed()
 */
	class UserAddress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserCart
 *
 * @property int $id
 * @property int $cart_id
 * @property int|null $user_id
 * @property int $status
 * @property string|null $name
 * @property string|null $uuid
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Cart $cart
 * @property-read User $user
 * @property-read CartDetail[]|Collection|HasMany $cartDetails
 * @method static Builder|UserCart newModelQuery()
 * @method static Builder|UserCart newQuery()
 * @method static Builder|UserCart query()
 * @method static Builder|UserCart whereCartId($value)
 * @method static Builder|UserCart whereCreatedAt($value)
 * @method static Builder|UserCart whereId($value)
 * @method static Builder|UserCart whereName($value)
 * @method static Builder|UserCart whereStatus($value)
 * @method static Builder|UserCart whereUpdatedAt($value)
 * @method static Builder|UserCart whereUserId($value)
 * @method static Builder|UserCart whereUuid($value)
 * @mixin Eloquent
 * @property-read int|null $cart_details_count
 * @method static \Database\Factories\UserCartFactory factory(...$parameters)
 */
	class UserCart extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserPoint
 *
 * @property int $id
 * @property int $user_id
 * @property float $price
 * @property Carbon|null $deleted_at
 * @property-read User $user
 * @method static Builder|UserPoint newModelQuery()
 * @method static Builder|UserPoint newQuery()
 * @method static Builder|UserPoint query()
 * @method static Builder|UserPoint whereId($value)
 * @method static Builder|UserPoint wherePrice($value)
 * @method static Builder|UserPoint whereUserId($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|UserPoint onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPoint whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPoint withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPoint withoutTrashed()
 */
	class UserPoint extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\WaiterTable
 *
 * @property int $id
 * @property int $user_id
 * @property int $table_id
 * @method static Builder|self newModelQuery()
 * @method static Builder|self newQuery()
 * @method static Builder|self query()
 * @method static Builder|self filter($filter)
 * @method static Builder|self whereActive($value)
 * @method static Builder|self whereId($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|WaiterTable whereTableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WaiterTable whereUserId($value)
 */
	class WaiterTable extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Wallet
 *
 * @property int $id
 * @property string $uuid
 * @property int $user_id
 * @property int $currency_id
 * @property float $price
 * @property float $price_rate
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Currency $currency
 * @property-read mixed $symbol
 * @property-read Collection|WalletHistory[] $histories
 * @property-read int|null $histories_count
 * @property-read Collection|Transaction[] $transactions
 * @property-read int|null $transactions_count
 * @property-read User $user
 * @method static WalletFactory factory(...$parameters)
 * @method static Builder|Wallet newModelQuery()
 * @method static Builder|Wallet newQuery()
 * @method static Builder|Wallet onlyTrashed()
 * @method static Builder|Wallet query()
 * @method static Builder|Wallet whereCreatedAt($value)
 * @method static Builder|Wallet whereCurrencyId($value)
 * @method static Builder|Wallet whereDeletedAt($value)
 * @method static Builder|Wallet whereId($value)
 * @method static Builder|Wallet wherePrice($value)
 * @method static Builder|Wallet whereUpdatedAt($value)
 * @method static Builder|Wallet whereUserId($value)
 * @method static Builder|Wallet whereUuid($value)
 * @method static Builder|Wallet withTrashed()
 * @method static Builder|Wallet withoutTrashed()
 * @mixin Eloquent
 * @property-read \App\Models\Transaction|null $transaction
 */
	class Wallet extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\WalletHistory
 *
 * @property int $id
 * @property string $uuid
 * @property string $wallet_uuid
 * @property int|null $transaction_id
 * @property string $type
 * @property float $price
 * @property float $price_rate
 * @property string|null $note
 * @property string $status
 * @property int $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User $author
 * @property-read User|null $user
 * @property-read Wallet|null $wallet
 * @property-read Transaction|null $transaction
 * @method static WalletHistoryFactory factory(...$parameters)
 * @method static Builder|WalletHistory newModelQuery()
 * @method static Builder|WalletHistory newQuery()
 * @method static Builder|WalletHistory query()
 * @method static Builder|WalletHistory whereCreatedAt($value)
 * @method static Builder|WalletHistory whereCreatedBy($value)
 * @method static Builder|WalletHistory whereId($value)
 * @method static Builder|WalletHistory whereNote($value)
 * @method static Builder|WalletHistory wherePrice($value)
 * @method static Builder|WalletHistory whereStatus($value)
 * @method static Builder|WalletHistory whereTransactionId($value)
 * @method static Builder|WalletHistory whereType($value)
 * @method static Builder|WalletHistory whereUpdatedAt($value)
 * @method static Builder|WalletHistory whereUuid($value)
 * @method static Builder|WalletHistory whereWalletUuid($value)
 * @mixin Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|WalletHistory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|WalletHistory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WalletHistory withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|WalletHistory withoutTrashed()
 */
	class WalletHistory extends \Eloquent {}
}

