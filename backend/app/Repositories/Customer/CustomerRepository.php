<?php

namespace App\Repositories\Customer;

use App\Models\Customer;
use App\Repositories\BaseRepository;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    public function __construct(Customer $model)
    {
        parent::__construct($model);
    }
}
