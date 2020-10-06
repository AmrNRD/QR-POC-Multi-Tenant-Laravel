<?php

namespace App\Domain\Tenant\Employee\Http\Requests\EmployeeShift;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class EmployeeShiftStoreFormRequest extends FormRequest
{
    /**
     * Determine if the EmployeeShift is authorized to make this request.
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
            'employee_id'        => ['required'],
            'shift_id'        => ['required'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date','after:from'],
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
