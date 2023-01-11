<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWakalah extends FormRequest
{

     // // This is the wakalah form validation file; ;
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string||unique:users,email',
            'ic_number' => 'required|string|min:12|max:12',
            'phone' => 'required|string|min:10|max:11',
            'wakalah_type' => 'required|string',
            'institution_name' => 'required_unless:wakalah_type,individual',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip' => 'required|numeric',
            'bank_account' => 'required|string',
            'bank_name' => 'required|string',
            'files1' => 'required|file',
            'files2' => 'required|file',
            'files3' => 'required|file',
            'files4' => 'required|file',
            'agreement' => 'required',
             

        ];
    }
}
