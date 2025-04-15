<?php

namespace App\Services\Transaction;

use App\Models\Transaction;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class RevertTransactionService
{
    protected TransactionRepositoryInterface $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function execute(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {
                $admin_id = auth()->user()->admin->id ?? 1; //1 apenas para fins de teste ja que não foi feito o perfil admin
                $transaction = $this->transactionRepository->findOrFail($data['transaction_id']);

                if ($transaction->status === 'reversed') {
                    Log::info('Transação já revertida.', ['transaction_id' => $data['transaction_id']]);
                    throw new Exception("Transação já foi revertida.");
                }

                if ($transaction->type === 'deposit') {
                    $transaction->to->decrement('balance', $transaction->amount);
                } elseif ($transaction->type === 'transfer') {
                    $transaction->to->decrement('balance', $transaction->amount);
                    $transaction->from->increment('balance', $transaction->amount);
                }

                $record = $this->transactionRepository->update($data['transaction_id'], [
                    'status' => 'reversed',
                    'reversed_by_admin_id' => $admin_id,
                    'reversed_at' => Carbon::now(),
                ]);

                return $record;
            });
        } catch (ModelNotFoundException $e) {
            Log::warning('Transação não encontrada para reversão.', ['transaction_id' => $data['transaction_id']]);
            throw new Exception("Transação não encontrada.");
        } catch (Exception $e) {
            Log::error('Erro ao reverter transação.', [
                'transaction_id' => $data['transaction_id'],
                'admin_id' => auth()->user()->admin->id,
                'error' => $e->getMessage(),
            ]);
            throw new Exception("Erro ao reverter transação.");
        }
    }
}
