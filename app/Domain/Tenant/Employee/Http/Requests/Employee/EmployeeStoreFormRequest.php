<?php

namespace App\Domain\Tenant\Employee\Http\Requests\Employee;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class EmployeeStoreFormRequest extends FormRequest
{
    /**
     * Determine if the Employee is authorized to make this request.
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
            'user_id'        => ['required'],
            'gender'=>['nullable','string'],
            'address' => ['nullable','string'],
            'date_of_birth' => ['nullable', 'date'],
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
