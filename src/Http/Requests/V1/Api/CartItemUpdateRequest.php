<?php

namespace Callmeaf\Cart\Http\Requests\V1\Api;

use Callmeaf\Cart\Enums\CartType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class CartItemUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return app(config('callmeaf-cart-items.form_request_authorizers.cart_item'))->store();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return validationManager(rules: [
            'type' => [new Enum(CartType::class)],
            'user_id' => [Rule::exists(config('callmeaf-user.model'))],
            'variation_ids' => ['array'],
            'variation_ids.*.id' => [Rule::exists(config('callmeaf-variation.model'))],
            'variation_ids.*.qty' => ['integer'],
        ],filters: app(config("callmeaf-cart-items.validations.cart_item"))->store());
    }

}
