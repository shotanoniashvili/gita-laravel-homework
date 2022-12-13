<?php

namespace App\Http\Requests;

class ProfileRequest extends BaseRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username'  => 'required|unique:users,username,' . $this->user()->id,
            'name'      => 'required',
            'is_public' => 'nullable',
            'password'  => 'nullable|confirmed|min:8'
        ];
    }
}
