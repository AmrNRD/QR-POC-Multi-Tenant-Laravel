<?php

namespace App\Domain\Tenant\Attendance\Http\Requests\Devices;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class CompanyActivateFormRequest extends FormRequest
{
    /**
     * Determine if the Devices is authorized to make this request.
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
            'active'        => ['required', 'string', 'max:255'],
        ];
        return $rules;
    }

}
