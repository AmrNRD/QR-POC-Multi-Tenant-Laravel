<?php

namespace App\Domain\Company\Http\Requests\Company;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;
use Illuminate\Support\Facades\Auth;

class CompanyStoreFormRequest extends FormRequest
{
    /**
     * Determine if the Company is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->hasRole('create-companies');
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
            'slug' => ['required', 'string', 'max:255', 'unique:companies,slug',  function ($attribute, $value, $fail) {
                $words = explode(' ', $value);
                $words_count = count($words);
                if($words_count>1){
                    $fail($attribute.' must be one word.');
                }
            },],
            'admin.name' => ['required','string','max:255'],
            'admin.email' => ['required', 'email', 'max:255', 'unique:admins,email'],
            'admin.password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
        return $rules;
    }


}
