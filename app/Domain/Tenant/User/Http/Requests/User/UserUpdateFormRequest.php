<?php

namespace App\Domain\Tenant\User\Http\Requests\User;
use App\Domain\Tenant\User\Http\Requests\User\UserStoreFormRequest;
use Illuminate\Support\Facades\Auth;

class UserUpdateFormRequest extends UserStoreFormRequest
{
    /**
     * Determine if the User is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->hasRole('update-users');
    }

    /**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {

		$rules = [
			'email' => 'required|unique:users,email,' . ( $this->route()->parameter('user') ?? (string) auth()->user()->id ) . ',id',
			'password' => 'sometimes|nullable|min:6',
			'mobile' => 'required|unique:users,mobile,' . ( $this->route()->parameter('user') ?? (string) auth()->user()->id ) . ',id',
			'permissions' => '',
		];

		return array_merge(parent::rules(), $rules);
	}

	/**
	 * Get custom attributes for validator errors.
	 *
	 * @return array
	 */
	public function attributes() {
		return parent::attributes();
	}
}
