<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminEditUserRequest extends Request
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
            'id' => "required|exists:users,id",
            'birthdate' => "required|date_format:d/m/Y",
            'country' => "required|exists:country,id",
            'email' => "required|email|unique:users,email," . $this->get('id'),
            'firstName' => "required",
            'lastName' => "required",
            'gender' => "required|in:female,male",
            'language' => "required|exists:language,id",
            'mobilePhone' => "required|numeric",
            'occupation' => "required|exists:occupation,id",
            'roles' => "required|array",
            'password' => "required|confirmed"
        ];
    }
}
