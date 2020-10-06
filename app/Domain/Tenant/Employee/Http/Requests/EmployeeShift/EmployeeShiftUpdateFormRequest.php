<?php

namespace App\Domain\Tenant\Employee\Http\Requests\EmployeeShift;
use App\Domain\Tenant\Employee\Http\Requests\EmployeeShift\EmployeeShiftStoreFormRequest;

class EmployeeShiftUpdateFormRequest extends EmployeeShiftStoreFormRequest
{
    /**
     * Determine if the employeeshift is authorized to make this request.
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
        // 'email'    => ['required','unique:employeeshifts,name,'.$this->route()->parameter('employeeshift').',id'],
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
