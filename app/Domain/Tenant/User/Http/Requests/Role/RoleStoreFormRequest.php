<?php

namespace App\Domain\Tenant\User\Http\Requests\Role;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class RoleStoreFormRequest extends FormRequest
{
    /**
     * Determine if the Role is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name'        => ['required', 'string', 'max:255'],
            'active' => ['nullable', 'in:active,inactive'],
        ];
        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name'        =>  __('main.name'),
        ];
    }
}
