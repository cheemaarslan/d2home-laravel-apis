<?php

namespace App\Repositories\ShopRepository;

use App\Models\Language;
use App\Models\Shop;
use App\Repositories\CoreRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;



class AdminShopRepository extends CoreRepository
{
    protected function getModelClass(): string
    {
        return Shop::class;
    }

    /**
     * Get all Shops from table
     */
    public function shopsList(array $filter = []): LengthAwarePaginator
    {
        /** @var Shop $shop */

        $shop = $this->model();

        return $shop
            ->filter($filter)
            ->with([
                'translation' => fn($q) => $q->where('locale', $this->language),
                'seller'      => fn($q) => $q->select('id', 'firstname', 'lastname', 'uuid'),
                'seller.roles',
            ])
            ->orderByDesc('id')
            ->select([
                'id',
                'background_img',
                'logo_img',
                'open',
                'verify',
                'visibility',
                'tax',
                'status',
                'deleted_at',
                'pos_access',
            ])
            ->paginate(data_get($filter, 'perPage', 10));
    }

    /**
     * Get one Shop by UUID
     * @param array $filter
     * @return LengthAwarePaginator
     */
    public function shopsPaginate(array $filter): LengthAwarePaginator
    {
        /** @var Shop $shop */
        $shop = $this->model();

        return $shop
            ->filter($filter)
            ->with([
                'translation' => function ($query) use ($filter) {

                    $query->when(
                        data_get($filter, 'not_lang'),
                        fn($q, $notLang) => $q->where('locale', '!=', data_get($filter, 'not_lang')),
                        fn($q) => $q->where('locale', '=', $this->language),
                    );
                },
                'translations:id,locale,shop_id',
                'seller:id,firstname,lastname,uuid,active',
            ])
            ->select([
                'id',
                'uuid',
                'background_img',
                'logo_img',
                'open',
                'visibility',
                'verify',
                'tax',
                'status',
                'user_id',
                'deleted_at',
                'pos_access',
            ])
            ->orderBy(data_get($filter, 'column', 'id'), data_get($filter, 'sort', 'desc'))
            ->paginate(data_get($filter, 'perPage', 10));
    }

    /**
     * @param string $uuid
     * @return Model|Builder|null
     */
    public function shopDetails(string $uuid): Model|Builder|null
    {
        $locale = data_get(Language::languagesList()->where('default', 1)->first(), 'locale');

        if (!Cache::get('tvoirifgjn.seirvjrc') || data_get(Cache::get('tvoirifgjn.seirvjrc'), 'active') != 1) {
            abort(403);
        }

        $shop = Shop::where('uuid', $uuid)->first();

        if (empty($shop) || $shop->uuid !== $uuid) {
            $shop = Shop::where('id', (int)$uuid)->first();
        }

        return $shop?->fresh([
            'translation' => fn($q) => $q->where(fn($q) => $q->where('locale', $this->language)->orWhere('locale', $locale)),
            'translations',
            'subscription' => fn($q) => $q->where('expired_at', '>=', now())->where('active', true),
            'subscription.subscription',
            'seller:id,firstname,lastname,uuid',
            'seller.roles',
            'workingDays',
            'closedDates',
            'categories:id',
            'documents',
            'categories.translation' => fn($q) => $q->select('category_id', 'id', 'locale', 'title')
                ->where(fn($q) => $q->where('locale', $this->language)->orWhere('locale', $locale)),
            'bonus' => fn($q) => $q->where('expired_at', '>', now())->where('status', true)
                ->select([
                    'bonusable_type',
                    'bonusable_id',
                    'bonus_quantity',
                    'bonus_stock_id',
                    'expired_at',
                    'value',
                    'type',
                ]),
            'bonus.stock.countable' => fn($q) => $q->select('id', 'uuid'),
            'bonus.stock.countable.translation' => fn($q) => $q->where(fn($q) => $q->where('locale', $this->language)->orWhere('locale', $locale))
                ->select('id', 'locale', 'title', 'product_id'),
            'discounts' => fn($q) => $q->where('end', '>=', now())
                ->select('id', 'shop_id', 'type', 'end', 'price', 'active', 'start'),
            'shopPayments:id,payment_id,shop_id,status,client_id,secret_id',
            'shopPayments.payment:id,tag,input,sandbox,active',
            'tags:id,img',
            'tags.translation' => fn($q) => $q->where(fn($q) => $q->where('locale', $this->language)->orWhere('locale', $locale)),
        ]);
    }

    /**
     * @param array $filter
     * @return LengthAwarePaginator
     */
    public function shopsSearch(array $filter): LengthAwarePaginator
    {
        /** @var Shop $shop */
        $shop = $this->model();

        return $shop
            ->filter($filter)
            ->with([
                'translation'   => fn($q) => $q->where('locale', $this->language),
                'discounts'     => fn($q) => $q->where('end', '>=', now())->select('id', 'shop_id', 'end'),
            ])
            ->whereHas('translation', fn($q) => $q->where('locale', $this->language))
            ->latest()
            ->select([
                'id',
                'logo_img',
                'status',
            ])
            ->paginate(data_get($filter, 'perPage', 10));
    }

    public function getAllActiveShopsWithOrders(): Collection
    {
        $locale = data_get(Language::languagesList()->where('default', 1)->first(), 'locale');

        if (!Cache::get('tvoirifgjn.seirvjrc') || data_get(Cache::get('tvoirifgjn.seirvjrc'), 'active') != 1) {
            abort(403);
        }

        // Get all active shops with their relationships
        return Shop::where('status', 'approved') // or whatever your active status field is
            ->with([
                'translation' => fn($q) => $q->where(fn($q) => $q->where('locale', $this->language)->orWhere('locale', $locale)),
                'translations',
                'subscription' => fn($q) => $q->where('expired_at', '>=', now())->where('active', true),
                'subscription.subscription',
                'seller:id,firstname,lastname,uuid',
                'seller.roles',
                'orders',
                'documents',
                'categories.translation' => fn($q) => $q->select('category_id', 'id', 'locale', 'title')
                    ->where(fn($q) => $q->where('locale', $this->language)->orWhere('locale', $locale)),
                'bonus' => fn($q) => $q->where('expired_at', '>', now())->where('status', true)
                    ->select([
                        'bonusable_type',
                        'bonusable_id',
                        'bonus_quantity',
                        'bonus_stock_id',
                        'expired_at',
                        'value',
                        'type',
                    ]),
                'bonus.stock.countable' => fn($q) => $q->select('id', 'uuid'),
                'bonus.stock.countable.translation' => fn($q) => $q->where(fn($q) => $q->where('locale', $this->language)->orWhere('locale', $locale))
                    ->select('id', 'locale', 'title', 'product_id'),
                'discounts' => fn($q) => $q->where('end', '>=', now())
                    ->select('id', 'shop_id', 'type', 'end', 'price', 'active', 'start'),
                'shopPayments:id,payment_id,shop_id,status,client_id,secret_id',
                'shopPayments.payment:id,tag,input,sandbox,active',
            ])
            ->get()
            ->each(function ($shop) {
                // Calculate total commission for each shop
                $shop->setAttribute('total_commission', $shop->orders->sum('commission_fee'));
                $shop->setAttribute('total_discounts', $shop->orders->sum('total_discount'));
            });
    }

    public function shopDetailsWithOrders(string $uuid): Model|Builder|null
    {
        $locale = data_get(Language::languagesList()->where('default', 1)->first(), 'locale');

        if (!Cache::get('tvoirifgjn.seirvjrc') || data_get(Cache::get('tvoirifgjn.seirvjrc'), 'active') != 1) {
            abort(403);
        }

        $shop = Shop::where('uuid', $uuid)->first();

        if (empty($shop) || $shop->uuid !== $uuid) {
            $shop = Shop::where('id', (int)$uuid)->first();
        }

        // Load the shop with relationships
        $shop = $shop?->fresh([
            'translation' => fn($q) => $q->where(fn($q) => $q->where('locale', $this->language)->orWhere('locale', $locale)),
            'translations',
            'subscription' => fn($q) => $q->where('expired_at', '>=', now())->where('active', true),
            'subscription.subscription',
            'seller:id,firstname,lastname,uuid',
            'seller.roles',
            'orders',
            'documents',
            'categories.translation' => fn($q) => $q->select('category_id', 'id', 'locale', 'title')
                ->where(fn($q) => $q->where('locale', $this->language)->orWhere('locale', $locale)),
            'bonus' => fn($q) => $q->where('expired_at', '>', now())->where('status', true)
                ->select([
                    'bonusable_type',
                    'bonusable_id',
                    'bonus_quantity',
                    'bonus_stock_id',
                    'expired_at',
                    'value',
                    'type',
                ]),
            'bonus.stock.countable' => fn($q) => $q->select('id', 'uuid'),
            'bonus.stock.countable.translation' => fn($q) => $q->where(fn($q) => $q->where('locale', $this->language)->orWhere('locale', $locale))
                ->select('id', 'locale', 'title', 'product_id'),
            'discounts' => fn($q) => $q->where('end', '>=', now())
                ->select('id', 'shop_id', 'type', 'end', 'price', 'active', 'start'),
            'shopPayments:id,payment_id,shop_id,status,client_id,secret_id',
            'shopPayments.payment:id,tag,input,sandbox,active',
        ]);

        // Calculate total commission if shop exists
        if ($shop) {
            $totalCommission = $shop->orders->sum('commission_fee');

            // Add the total commission to the shop object
            $shop->setAttribute('total_commission', $totalCommission);
            $shop->setAttribute('total_discounts', $shop->orders->sum('total_discount'));
        }

        return $shop;
    }
}
