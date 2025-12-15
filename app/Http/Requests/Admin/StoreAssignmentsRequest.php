<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssignmentsRequest extends FormRequest
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
            'test_id' => '',
            // 'user_id' => 'required|numeric',
            'user_type' => '',
            'duration' => '',
            'start_time' => '',
            'end_time' => '',
            'buffer_time' => '',
            'verify_code' => '',
            'is_started' => '0'
        ];
    }
}
