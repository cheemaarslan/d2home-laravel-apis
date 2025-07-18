<?php

namespace App\Repositories\UserRepository;

use App\Models\Notification;
use App\Models\Order;
use App\Models\Referral;
use App\Models\Settings;
use App\Models\User;
use App\Repositories\CoreRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends CoreRepository
{
    protected function getModelClass(): string
    {
        return User::class;
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function userById(int $id): ?User
    {
        $user = $this->model()
            ->with([
                'wallet',
                'shop',
                'point',
                'emailSubscription',
                'notifications',
                'assignReviews',
                'addresses',
                'invite',
                'wallet.histories',
                'deliveryManDeliveryZone',
                'waiterTables',
                'kitchen.translation' => fn($q) => $q->where('locale', $this->language),
            ])
            ->withCount([
                'orders' => fn($q) => $q->where('status', Order::STATUS_DELIVERED)
            ])
            ->withSum([
                'orders' => fn($q) => $q->where('status', Order::STATUS_DELIVERED)
            ], 'total_price')
            ->withAvg('assignReviews', 'rating')
            ->find($id);

        if (empty($user) || empty($user->wallet?->uuid)) {
            return $user;
        }

        /** @var User $user */
        $referralActive = (int)Settings::where('key', 'referral_active')->first()?->value;

        if ($referralActive) {

			/** @var Referral $referral */
			$referral = Referral::with([
				'translation' => fn($q) => $q->where('locale', $this->language),
				'translations',
				'galleries',
			])->where([
				['expired_at', '>=', now()],
			])->first();

			if ($referral?->id) {
				$rate         = $user->wallet->currency?->rate ?? 1;

				$fromTopUp    = $user->wallet->histories?->where('type','referral_from_topup');
				$fromWithdraw = $user->wallet->histories?->where('type','referral_from_withdraw');

				$toTopUp      = $user->wallet->histories?->where('type','referral_to_topup');
				$toWithdraw   = $user->wallet->histories?->where('type','referral_to_withdraw');

				$user
					->setAttribute('referral_from_topup_price', $fromTopUp?->sum('price') * $rate)
					->setAttribute('referral_from_withdraw_price', $fromWithdraw?->sum('price') * $rate)
					->setAttribute('referral_from_topup_count', $fromTopUp?->count())
					->setAttribute('referral_from_withdraw_count', $fromWithdraw?->count())

					->setAttribute('referral_to_topup_price', $toTopUp?->sum('price') * $rate)
					->setAttribute('referral_to_withdraw_price', $toWithdraw?->sum('price') * $rate)
					->setAttribute('referral_to_topup_count', $toTopUp?->count())
					->setAttribute('referral_to_withdraw_count', $toWithdraw?->count());
			}

            // for UserResource
            request()->offsetSet('referral', 1);
        }

        return $user;
    }

    public function userByUUID(string $uuid)
    {
        return $this->model()->with([
            'shop.translation' => fn($q) => $q->where('locale', $this->language),
            'kitchen.translation' => fn($q) => $q->where('locale', $this->language),
            'waiterTables',
            'wallet',
            'point',
            'addresses',
            'deliveryManSetting',
            'deliveryManDeliveryZone',
            'invitations.shop:id',
            'waiterTables',
            'invitations.shop.translation' => fn($q) => $q->select(['id', 'shop_id', 'locale', 'title'])
                ->where('locale', $this->language),
        ])
            ->firstWhere('uuid', $uuid);
    }

    /**
     * @param array $filter
     * @return LengthAwarePaginator
     */
    public function usersPaginate(array $filter = []): LengthAwarePaginator
    {
        /** @var User $users */
        $users = $this->model();

        return $users
            ->filter($filter)
            ->with([
                'shop',
                'wallet',
                'invitations' => fn($q) => $q->when(data_get($filter, 'shop_id'), function ($query, $shopId) {
                    $query->where('shop_id', $shopId);
                }),
                'invitations.shop:id',
                'invitations.shop.translation' => fn($q) => $q
					->select(['id', 'shop_id', 'locale', 'title'])
					->where('locale', $this->language),
                'deliveryManSetting',
                'roles' => fn($q)  => $q->when(data_get($filter, 'role'), function ($q, $role) {
                    $q->where('name', $role);
                }),
        ])
            ->paginate(data_get($filter, 'perPage', 10));
    }

    public function usersSearch(array $filter): LengthAwarePaginator
    {
        /** @var User $users */
        $users = $this->model();

        return $users
            ->filter($filter)
            ->with([
                'roles' => fn($q) => $q->when(data_get($filter, 'roles'), function ($q, $roles) {
                    $q->whereIn('name', is_array($roles) ? $roles : [$roles]);
                })
            ])
            ->orderBy(data_get($filter,'column','id'), data_get($filter,'sort','desc'))
            ->paginate(data_get($filter, 'perPage', 10));
    }

	/**
	 * @param array $filter
	 * @return LengthAwarePaginator
	 */
	public function searchSending(array $filter): LengthAwarePaginator
	{
		return $this->model()
			->filter($filter)
			->whereHas('wallet')
			->select([
				'id',
				'uuid',
				'firstname',
				'lastname',
				'img',
			])
			->where('id', '!=', auth('sanctum')->id())
			->orderBy(data_get($filter, 'column', 'id'), data_get($filter, 'sort', 'desc'))
			->paginate(data_get($filter, 'perPage', 10));
	}

	/**
     * @return Collection|Notification[]
     */
    public function usersNotifications(): array|Collection
    {
        return Notification::get();
    }

    /**
     * @param array $filter
     * @return LengthAwarePaginator
     */
    public function deliveryMans(array $filter): LengthAwarePaginator
    {
        $filter['role'] = 'deliveryman';

        if (data_get($filter, 'empty-setting')) {
            $filter['online'] = false;
        }

        return User::filter($filter)
            ->with([
                'roles',
                'assignReviews',
                'deliveryManSetting',
                'deliveryManOrders' => fn($q) => $q->select([
                    'id', 'total_price', 'status', 'location', 'address',
                    'delivery_fee', 'rate', 'delivery_date', 'delivery_time', 'deliveryman', 'shop_id', 'user_id',
                    'username', 'current'
                ])->when(data_get($filter, 'statuses'), function ($query, $statuses) {

                    if (!is_array($statuses)) {
                        return $query;
                    }

                    $statuses = array_intersect($statuses, Order::STATUSES);

                    return $query->whereIn('status', $statuses);
                }),
                'deliveryManOrders.shop:id,uuid,price,price_per_km,logo_img,location',
                'deliveryManOrders.user:id,img,firstname,lastname',
                'deliveryManOrders.shop.translation' => fn($q) => $q->where('locale', $this->language),
                'wallet',
            ])
            ->withAvg('assignReviews', 'rating')
            ->withCount('deliveryManOrders')
            ->withSum('deliveryManOrders', 'total_price')
            ->withSum('wallet', 'price')
            ->paginate(data_get($filter, 'perPage', 10));
    }


    //deliveryManDetails with orders
    /**
     * @param int $id
     * @return User|null
     */
    public function deliveryManDetails(int $id): ?User
    {
        $user = $this->model()
            ->with([
                'wallet',
                'deliveryManSetting',
                'deliveryManOrders' => fn($q) => $q->select([
                    'id', 'total_price', 'status', 'location', 'address',
                    'delivery_fee', 'rate', 'delivery_date', 'delivery_time', 'deliveryman', 'shop_id', 'user_id',
                    'username', 'current'
                ]),
                'deliveryManOrders.shop:id,uuid,price,price_per_km,logo_img,location',
                'deliveryManOrders.user:id,img,firstname,lastname',
                'deliveryManOrders.shop.translation' => fn($q) => $q->where('locale', $this->language),
            ])
            ->withAvg('assignReviews', 'rating')
            ->withCount('deliveryManOrders')
            ->withSum('deliveryManOrders', 'total_price')
            ->find($id);

        return $user;
}


}
