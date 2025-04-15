<?php

namespace App\Services\Transaction;

use App\Repositories\Transaction\TransactionRepositoryInterface;
use App\Repositories\Customer\CustomerRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;

class TransferService
{
    public function __construct(
        private TransactionRepositoryInterface $transactionRepository,
        private CustomerRepositoryInterface $customerRepository
    ) {}

    public function execute(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {
                $from = auth()->user()->customer;
                $to = $this->customerRepository->findOrFail($data['to_customer_id']);

                if ($from->balance < $data['amount']) {
                    throw new Exception("Saldo insuficiente.");
                }

                $transaction = $this->transactionRepository->create([
                    'reference' => Str::uuid(),
                    'from_customer_id' => $from->id,
                    'to_customer_id' => $to->id,
                    'amount' => $data['amount'],
                    'type' => 'transfer',
                    'status' => 'completed',
                    'description' => $data['description'] ?? null,
                    'metadata' => $data['metadata'] ?? null,
                ]);

                $from->decrement('balance', $data['amount']);
                $to->increment('balance', $data['amount']);

                return $transaction;
            });
        } catch (Exception $e) {
            throw new Exception("Erro ao realizar transferência: " . $e->getMessage());
        }
    }
}
