<?php

namespace App\Domain\Subscription\Http\Requests\Plan;
use App\Domain\Subscription\Http\Requests\Plan\PlanStoreFormRequest;

class PlanUpdateFormRequest extends PlanStoreFormRequest
{
    /**
     * Determine if the plan is authorized to make this request.
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
        // 'email'    => ['required','unique:plans,name,'.$this->route()->parameter('plan').',id'],
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
