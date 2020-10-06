<?php

namespace App\Domain\Tenant\User\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserForgetPasswordFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|max:255|email|exists:users,email',
        ];
    }
}
