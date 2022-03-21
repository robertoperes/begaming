<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class AuthCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function all($keys = null)
    {
        return array_replace_recursive(parent::all(), $this->route()->parameters());
    }

    public function rules()
    {
        return [
            'name'     => 'required|string',
            'email'    => 'required|email',
            'password' => 'required|string'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response['mensagem'] = $validator->errors()->all()[0];

        throw new HttpResponseException(response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY));
    }

}