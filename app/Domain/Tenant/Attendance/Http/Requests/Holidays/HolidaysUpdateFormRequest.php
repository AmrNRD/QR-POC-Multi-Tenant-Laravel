<?php

namespace App\Domain\Tenant\Attendance\Http\Requests\Holidays;
use App\Domain\Tenant\Attendance\Http\Requests\Holidays\HolidaysStoreFormRequest;

class HolidaysUpdateFormRequest extends HolidaysStoreFormRequest
{
    /**
     * Determine if the holidays is authorized to make this request.
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
        // 'email'    => ['required','unique:holidays,name,'.$this->route()->parameter('holidays').',id'],
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
