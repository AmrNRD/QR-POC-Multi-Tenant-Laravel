<?php

namespace App\Domain\Tenant\Attendance\Http\Requests\Devices;
use App\Domain\Tenant\Attendance\Http\Requests\Devices\DevicesStoreFormRequest;

class DevicesUpdateFormRequest extends DevicesStoreFormRequest
{
    /**
     * Determine if the devices is authorized to make this request.
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
        // 'email'    => ['required','unique:devices,name,'.$this->route()->parameter('devices').',id'],
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
