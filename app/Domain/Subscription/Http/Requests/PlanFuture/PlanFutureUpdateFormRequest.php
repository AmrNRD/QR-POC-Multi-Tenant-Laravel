<?php

namespace App\Domain\Subscription\Http\Requests\PlanFuture;
use App\Domain\Subscription\Http\Requests\PlanFuture\PlanFutureStoreFormRequest;

class PlanFutureUpdateFormRequest extends PlanFutureStoreFormRequest
{
    /**
     * Determine if the planfuture is authorized to make this request.
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
        // 'email'    => ['required','unique:planfutures,name,'.$this->route()->parameter('planfuture').',id'],
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
