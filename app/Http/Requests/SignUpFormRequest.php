<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Worksome\RequestFactories\Concerns\HasFactory;

class SignUpFormRequest extends FormRequest
{
    use HasFactory;

    public function authorize()
    {
        return auth()->guest();
    }

    public function rules()
    {
        return [
            'email' => ['required', 'email:dns', 'unique:users'],
            'name' => ['required', 'string', 'min:1'],
            'password' => ['required', 'confirmed', Password::default()],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'email' => str(request('email'))
                ->squish()
                ->lower()
                ->value()
        ]);
    }
}
