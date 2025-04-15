<?php

namespace App\Services\Transaction;

use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class DepositService
{
    public function __construct(private TransactionRepositoryInterface $transactionRepository, private CustomerRepositoryInterface $customerRepository)
    {
    }

    public function execute(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {
                $customer = auth()->user()->customer;

                $transaction = $this->transactionRepository->create([
                    'reference' => Str::uuid(),
                    'to_customer_id' => $customer->id,
                    'amount' => $data['amount'],
                    'type' => 'deposit',
                    'status' => 'completed',
                    'description' => $data['description'] ?? null,
                    'metadata' => $data['metadata'] ?? null,
                ]);

                $customer->increment('balance', $data['amount']);

                return $transaction;
            });
        } catch (ModelNotFoundException $e) {
            Log::warning('Cliente não encontrado para depósito', ['customer_id' => $data['customer_id']]);
            throw new Exception("Cliente não encontrado.");
        } catch (Exception $e) {
            Log::error('Erro ao realizar depósito', ['error' => $e->getMessage()]);
            throw new Exception("Erro ao realizar depósito.");
        }
    }
}
