<?php

namespace Callmeaf\Cart\App\Http\Requests\Api\V1;

use Callmeaf\Cart\App\Enums\CartType;
use Callmeaf\Cart\App\Repo\Contracts\CartRepoInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CartStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /**
         * @var CartRepoInterface $cartRepo
         */
        $cartRepo = app(CartRepoInterface::class);
        return ! $cartRepo->getQuery()->where([
            'user_identifier' => $this->user()->identifier(),
            'type' => $this->get('type'),
        ])->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required',new Enum(CartType::class)],
        ];
    }
}
