<?php

namespace App\Domain\Tenant\Shift\Http\Requests\Shift;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class ShiftStoreFormRequest extends FormRequest
{
    /**
     * Determine if the Shift is authorized to make this request.
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
            'name'        => ['required', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date','after:start_date'],
            'start_at' => ['required'],
            'end_at' => ['nullable'],
            'threshold' => ['nullable'],
            'type' => ['required', 'in:fixed,flexible'],
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
