<?php

namespace App\Domain\Tenant\User\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserAPILoginFormRequest extends FormRequest
{

    public function rules()
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'firebase_token' => 'nullable|string',
            'platform' => 'nullable|string',
            'type' => 'nullable|string',
        ];
    }
}
