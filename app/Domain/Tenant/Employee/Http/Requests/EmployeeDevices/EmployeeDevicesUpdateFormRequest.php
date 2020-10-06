<?php

namespace App\Domain\Tenant\Employee\Http\Requests\EmployeeDevices;
use App\Domain\Tenant\Employee\Http\Requests\EmployeeDevices\EmployeeDevicesStoreFormRequest;

class EmployeeDevicesUpdateFormRequest extends EmployeeDevicesStoreFormRequest
{
    /**
     * Determine if the employeedevices is authorized to make this request.
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
        // 'email'    => ['required','unique:employeedevices,name,'.$this->route()->parameter('employeedevices').',id'],
        ];

        return array_merge(parent::rules(), $rules);
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return parent::attributes();
    }
}
