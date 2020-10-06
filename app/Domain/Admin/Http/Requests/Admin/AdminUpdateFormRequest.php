<?php

namespace App\Domain\Admin\Http\Requests\Admin;
use App\Domain\Admin\Http\Requests\Admin\AdminStoreFormRequest;
use Illuminate\Support\Facades\Auth;

class AdminUpdateFormRequest extends AdminStoreFormRequest
{
    /**
     * Determine if the User is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->hasRole('update-admins');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'email' => 'required|unique:admins,email,' . ( $this->route()->parameter('admin') ?? (string) auth()->user()->id ) . ',id',
            'password' => 'sometimes|nullable|min:6',
        ];

        return array_merge(parent::rules(), $rules);
    }


}
