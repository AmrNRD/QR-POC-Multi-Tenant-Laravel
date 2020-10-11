<?php

namespace App\Domain\Company\Http\Requests\Company;
use App\Domain\Company\Http\Requests\Company\CompanyStoreFormRequest;
use Illuminate\Support\Facades\Auth;

class CompanyUpdateFormRequest extends CompanyStoreFormRequest
{
    /**
     * Determine if the company is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->hasRole('update-companies');
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
            'email' => ['required', 'email', 'max:255', 'unique:admins,email'],
            'address' => ['required','string','max:255'],
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
        return parent::attributes();
    }
}
