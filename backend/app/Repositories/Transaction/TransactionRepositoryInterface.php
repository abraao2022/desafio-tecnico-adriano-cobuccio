<?php

namespace App\Repositories\Transaction;
use App\Repositories\BaseRepositoryInterface;

interface TransactionRepositoryInterface extends BaseRepositoryInterface
{
    public function getMyTransactions(int $to_customer_id, int $from_customer_id, int $limit, string $search = '');
}
