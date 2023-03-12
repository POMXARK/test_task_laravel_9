<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users',
            'password' =>  ['required', 'confirmed','regex:/([a-zA-Z0-9]*)([$%&!:]{1,})([a-zA-Z0-9]*)/u', Password::min(6)->mixedCase()],
            'phone' => 'required|unique:users|regex:/^[\+]7{1}?[-\s\.]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{2}[-\s\.]?[0-9]{2}$/u',
        ];
    }

    public function messages(): array
    {
        return [
            'password.regex' => ' Пароль должен быть не менее 6 символов, только латиница, минимум 1 символ верхнего регистра, минимум 1 символ нижнего регистра, минимум 1 спец символ $%&!:.',
            'phone.regex' => 'Телефон должен удовлетворять маске: начинаться с +7 после чего идет 10 цифр.',
            'unique' => ':attribute уже занят.'
        ];
    }
}
