<?php

namespace App\Domain\Tenant\Attendance\Http\Requests\Attendance;
use App\Domain\Tenant\Attendance\Http\Requests\Attendance\AttendanceStoreFormRequest;

class AttendanceUpdateFormRequest extends AttendanceStoreFormRequest
{
    /**
     * Determine if the attendance is authorized to make this request.
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
        // 'email'    => ['required','unique:attendances,name,'.$this->route()->parameter('attendance').',id'],
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
