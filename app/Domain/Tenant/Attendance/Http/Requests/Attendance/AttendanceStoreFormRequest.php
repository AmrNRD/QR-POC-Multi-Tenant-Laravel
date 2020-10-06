<?php

namespace App\Domain\Tenant\Attendance\Http\Requests\Attendance;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class AttendanceStoreFormRequest extends FormRequest
{
    /**
     * Determine if the Attendance is authorized to make this request.
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
            'qr_code'        => ['required', 'string', 'max:255'],
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
            'qr_code'        =>  __('main.qr_code'),
        ];
    }
}
