<?php

namespace App\Domain\Tenant\User\Http\Requests\User;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;
use Illuminate\Support\Facades\Auth;

class UserStoreFormRequest extends FormRequest
{

    /**
     * Determine if the User is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->hasRole('create-users');
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
            'email' => 'required|unique:tenant.users,email,' . ( (string) auth()->user()->id ) . ',id',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['nullable', 'numeric', 'max:255'],
        ];
        return $rules;
    }
}
