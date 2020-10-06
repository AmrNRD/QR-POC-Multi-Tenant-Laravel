<?php

namespace App\Domain\Company\Http\Requests\Company;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class CompanyStoreFormRequest extends FormRequest
{
    /**
     * Determine if the Company is authorized to make this request.
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
            'name' => ['required','string','max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:companies,email'],
            'address' => ['required','string','max:255'],
            'admin.name' => ['required','string','max:255'],
            'admin.email' => ['required', 'email', 'max:255', 'unique:admins,email'],
            'admin.password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
        return $rules;
    }


}
