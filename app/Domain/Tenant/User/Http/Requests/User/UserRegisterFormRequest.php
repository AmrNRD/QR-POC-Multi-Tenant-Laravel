<?php

namespace App\Domain\Tenant\User\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required','string','max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:tenant.users,email'],
            'password' => 'required|min:8|max:32|confirmed',
        ];
    }
}
