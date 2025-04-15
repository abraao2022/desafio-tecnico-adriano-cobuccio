<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;
use App\Repositories\BaseRepository;

class TransactionRepository extends BaseRepository implements TransactionRepositoryInterface
{
    public function __construct(Transaction $model)
    {
        parent::__construct($model);
    }

    public function getMyTransactions(int $to_customer_id, int $from_customer_id, int $limit, string $search = '')
    {
        return $this->model
            ->where(function ($query) use ($to_customer_id, $from_customer_id) {
                $query->where('to_customer_id', $to_customer_id)
                        ->orWhere('from_customer_id', $from_customer_id);
            })
            ->where('reference', 'like', "%{$search}%")
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
