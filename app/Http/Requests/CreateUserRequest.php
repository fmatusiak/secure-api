<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'unique:users,login'],
            'first_name' => ['string', 'nullable'],
            'last_name' => ['string', 'nullable'],
            'email' => ['string', 'nullable'],
            'is_admin' => ['boolean', 'nullable'],
        ];
    }
}
