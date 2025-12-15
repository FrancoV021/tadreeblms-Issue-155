<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssessmentAccountsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
        return [
            'assignment_id' => 'required|numeric',
            // 'teachers' => 'required',
            // 'last_name' => 'required',
            // 'email' => 'required|email|unique:assessment_accounts,email',
            // 'phone' => 'required|unique:assessment_accounts,phone',
            // 'email' => 'required|email',
            // 'phone' => 'required',
        ];
    }
}
