<?php

namespace Callmeaf\Cart\App\Http\Controllers\Admin\V1;


use Callmeaf\Base\App\Http\Controllers\Admin\V1\AdminController;
use Callmeaf\Cart\App\Repo\Contracts\CartRepoInterface;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CartController extends AdminController implements HasMiddleware
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
        return $this->cartRepo->latest()->search()->paginate();
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
