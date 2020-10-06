<?php

namespace App\Domain\Admin\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AdminRegisterFormRequest extends FormRequest
{
    /**
     * Determine if the User is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->hasRole('create-admin');
    }

    public function rules()
    {
        return [
            'name' => ['required','string','max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:admins,email'],
            'password' => 'required|min:8|max:32|confirmed',
        ];
    }
}
