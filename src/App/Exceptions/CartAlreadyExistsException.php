<?php

namespace Callmeaf\Cart\App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class CartAlreadyExistsException extends Exception
{
    public function render(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => __('callmeaf-cart::errors.cart_already_exists')
        ], \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN);
    }

}
