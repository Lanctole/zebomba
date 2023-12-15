<?php
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserAuthRequest extends FormRequest
{
    public function rules()
    {
        return [
            'access_token' => 'required|string',
            'id' => 'required|integer',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'country' => 'required|string',
            'city' => 'required|string',
            'sig' => 'required|string',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'error' => "Неправильно введены данные",
            'error_key' => $validator->errors(),
        ], 422));
    }
}
