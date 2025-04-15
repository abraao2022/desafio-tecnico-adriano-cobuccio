<?php

namespace App\Services\Transaction;

use App\Repositories\Transaction\TransactionRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class GetMyTransactionsService
{
    protected TransactionRepositoryInterface $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function execute()
    {
        try {
            $customer_id = auth()->user()->customer->id;
            return $this->transactionRepository->getMyTransactions($customer_id, $customer_id, 10);
        } catch (ModelNotFoundException $e) {
            Log::warning('Transação não encontrada para reversão.');
            throw new Exception("Transação não encontrada.");
        } catch (Exception $e) {
            Log::error('Erro ao reverter transação.', [
                'error' => $e->getMessage(),
            ]);
            throw new Exception("Erro ao reverter transação.");
        }
    }
}
