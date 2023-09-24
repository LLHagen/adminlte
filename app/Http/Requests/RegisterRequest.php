<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RegisterRequest
 *
 * @property-read string $email
 * @property-read string $password
 * @property-read string $first_name
 * @property-read string $last_name
 * @property-read null|string $birthday_at
 */
class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'confirmed'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'birthday_at' => ['nullable', 'string', 'date'],
        ];
    }
}
