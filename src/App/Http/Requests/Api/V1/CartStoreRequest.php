<?php

namespace Callmeaf\Cart\App\Http\Requests\Api\V1;

use Callmeaf\Cart\App\Enums\CartType;
use Callmeaf\Cart\App\Exceptions\CartAlreadyExistsException;
use Callmeaf\Cart\App\Repo\Contracts\CartRepoInterface;
use Callmeaf\User\App\Repo\Contracts\UserRepoInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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

        if($cartRepo->getQuery()->where([
            'user_identifier' => $this->user()->identifier(),
            'type' => $this->get('type'),
        ])->exists()) {
            throw new CartAlreadyExistsException();
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(UserRepoInterface $userRepo): array
    {
        return [
            'user_identifier' => ['required',Rule::exists($userRepo->getTable(),$userRepo->getModel()->identifierKey())],
            'type' => ['required',new Enum(CartType::class)],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_identifier' => $this->user()->identifier(),
        ]);
    }
}
