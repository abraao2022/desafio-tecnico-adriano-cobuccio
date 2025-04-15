<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRevertRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'transaction_id.required' => 'O campo transaction_id é obrigatório.',
            'description.required' => 'O campo description é obrigatório.',
            'metadata.required' => 'O campo metadata é obrigatório.',
        ];
    }

    public function rules(): array
    {
        return [
            'transaction_id' => ['required', 'integer'],
            'description' => ['nullable', 'string'],
            'metadata' => ['nullable'],
        ];
    }
}
