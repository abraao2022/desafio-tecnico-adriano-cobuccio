<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'user.name.required' => 'O nome do usuário é obrigatório.',
            'user.email.required' => 'O email do usuário é obrigatório.',
            'user.email.email' => 'O email do usuário deve ser um email válido.',
            'user.email.unique' => 'O email do usuário já existe.',
            'user.cpf.required' => 'O cpf do usuário é obrigatório.',
            'user.cpf.digits' => 'O cpf do usuário deve ter 11 dígitos.',
            'user.cpf.unique' => 'O cpf do usuário já existe.',
            'user.password.required' => 'A senha do usuário é obrigatória.',
            'user.password.min' => 'A senha do usuário deve ter no mínimo 6 caracteres.',
            'customer.balance.numeric' => 'O saldo do cliente deve ser um número.',
            'customer.balance.min' => 'O saldo do cliente deve ser maior ou igual a 0.',
            'customer.phone_number.string' => 'O telefone do cliente deve ser uma string.',
            'customer.phone_number.max' => 'O telefone do cliente deve ter no máximo 20 caracteres.',
        ];
    }

    public function rules(): array
    {
        return [
            'user.name' => ['required', 'string', 'max:255'],
            'user.email' => ['required', 'email', 'unique:users,email'],
            'user.cpf' => ['required', 'digits:11', 'unique:users,cpf'],
            'user.password' => ['required', 'string', 'min:6'],

            'customer.balance' => ['nullable', 'numeric', 'min:0'],
            'customer.phone_number' => ['nullable', 'string', 'max:20']
        ];
    }
}
