<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'to_customer_id.required' => 'O campo to_customer_id é obrigatório.',
            'amount.required' => 'O campo amount é obrigatório.',
            'description.required' => 'O campo description é obrigatório.',
            'metadata.required' => 'O campo metadata é obrigatório.',
        ];
    }

    public function rules(): array
    {
        return [
            'to_customer_id' => ['required', 'integer'],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'metadata' => ['nullable'],
        ];
    }
}
