<?php

namespace App\Domain\Admin\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminForgetPasswordFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|max:255|email|exists:users,email',
        ];
    }
}
