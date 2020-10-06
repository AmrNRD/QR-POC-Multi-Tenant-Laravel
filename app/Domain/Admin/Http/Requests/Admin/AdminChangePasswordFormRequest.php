<?php

namespace App\Domain\Admin\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminChangePasswordFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'old_password' => 'required|min:8|max:32',
            'password' => 'required|min:8|max:32|confirmed',
        ];
    }
}
