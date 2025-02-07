<?php

namespace Callmeaf\Cart\Http\Requests\V1\Api;

use Callmeaf\Cart\Enums\CartType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class CartItemStoreInFutureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return app(config('callmeaf-cart-items.form_request_authorizers.cart_item'))->storeInFuture();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return validationManager(rules: [
            'user_id' => [Rule::exists(config('callmeaf-user.model'),'id')],
            'variation_id' => [Rule::exists(config('callmeaf-variation.model'),'id')],
            'qty' => ['integer'],
        ],filters: app(config("callmeaf-cart-items.validations.cart_item"))->storeInFuture());
    }

}
