<?php

namespace App\Domain\Tenant\User\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserChangePasswordFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'old_password' => 'required|min:8|max:32',
            'password' => 'required|min:8|max:32|confirmed',
        ];
    }
}
