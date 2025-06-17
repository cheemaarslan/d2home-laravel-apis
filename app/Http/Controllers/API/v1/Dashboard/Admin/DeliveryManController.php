<?php

namespace App\Http\Controllers\API\v1\Dashboard\Admin;

use App\Helpers\ResponseError;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\FilterParamsRequest;
use App\Repositories\UserRepository\UserRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DeliveryManController extends AdminBaseController
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param FilterParamsRequest $request
     * @return AnonymousResourceCollection
     */
    public function paginate(FilterParamsRequest $request): AnonymousResourceCollection
    {
        $deliveryMans = $this->repository->deliveryMans($request->all());

        if (!Cache::get('tvoirifgjn.seirvjrc') || data_get(Cache::get('tvoirifgjn.seirvjrc'), 'active') != 1) {
            abort(403);
        }

        return UserResource::collection($deliveryMans);
    }

    //get details of delivery
    public function details(int $id): UserResource
    {
        $deliveryMan = $this->repository->find($id);

        if (!$deliveryMan) {
            abort(404, __('errors.' . ResponseError::USER_NOT_FOUND, locale: $this->language));
        }

        return new UserResource($deliveryMan);
    }


    



}
