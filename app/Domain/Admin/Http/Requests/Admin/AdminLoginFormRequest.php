<?php

namespace App\Domain\Admin\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email|max:255',
            'password' => 'required|min:8|max:32',
        ];
    }
}
