<?php

namespace App\Domain\Tenant\Shift\Http\Requests\Shift;
use App\Domain\Tenant\Shift\Http\Requests\Shift\ShiftStoreFormRequest;

class ShiftUpdateFormRequest extends ShiftStoreFormRequest
{
    /**
     * Determine if the shift is authorized to make this request.
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
        // 'email'    => ['required','unique:shifts,name,'.$this->route()->parameter('shift').',id'],
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
