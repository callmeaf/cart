<?php

namespace Callmeaf\Cart\App\Http\Controllers\Api\V1;

use App\Models\User;
use Callmeaf\Base\App\Http\Controllers\Api\V1\ApiController;
use Callmeaf\Cart\App\Repo\Contracts\CartRepoInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CartController extends ApiController implements HasMiddleware
{
    public function __construct(protected CartRepoInterface $cartRepo)
    {
        parent::__construct($this->cartRepo->config);
    }

    public static function middleware(): array
    {
        return [
           //
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /**
         * @var User $user
         */
        $user = $this->request->user();
        return $this->cartRepo->latest()->builder(fn(Builder $query) => $query->where('user_identifier',$user->identifier())->with([
            'items.variant'
        ]))->search()->paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        return $this->cartRepo->create(data: $this->request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->cartRepo->findById(value: $id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id)
    {
        return $this->cartRepo->update(id: $id, data: $this->request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->cartRepo->delete(id: $id);
    }

    public function statusUpdate(string $id)
    {
        return $this->cartRepo->update(id: $id, data: $this->request->validated());
    }

    public function typeUpdate(string $id)
    {
        return $this->cartRepo->update(id: $id, data: $this->request->validated());
    }

    public function trashed()
    {
        return $this->cartRepo->trashed()->latest()->search()->paginate();
    }

    public function restore(string $id)
    {
        return $this->cartRepo->restore(id: $id);
    }

    public function forceDestroy(string $id)
    {
        return $this->cartRepo->forceDelete(id: $id);
    }


}
