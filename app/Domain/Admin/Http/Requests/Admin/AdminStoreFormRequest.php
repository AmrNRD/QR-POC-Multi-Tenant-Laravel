<?php

namespace App\Domain\Admin\Http\Requests\Admin;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;
use Illuminate\Support\Facades\Auth;

class AdminStoreFormRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => ['required','string','max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:admins,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['nullable', 'numeric', 'max:255'],
        ];
        return $rules;
    }

}
