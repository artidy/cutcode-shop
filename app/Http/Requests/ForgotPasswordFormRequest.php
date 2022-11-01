<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordFormRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->guest();
    }

    public function rules()
    {
        return [
            'email' => ['required', 'email:dns'],
        ];
    }
}
