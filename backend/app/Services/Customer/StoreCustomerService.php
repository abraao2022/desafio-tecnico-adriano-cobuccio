<?php

namespace App\Services\Customer;

use App\Models\User;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\User\StoreUserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;

class StoreCustomerService
{

    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
        private UserRepositoryInterface $userRepository,
        private StoreUserService $storeUserService
    ) {
    }

    public function execute(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {
                $userData = $data['user'];
                $customerData = $data['customer'] ?? [];

                $user = $this->storeUserService->execute($userData);

                $customerData['user_id'] = $user->id;
                $customerData['balance'] = $customerData['balance'] ?? 0.0;

                return $this->customerRepository->create($customerData)->load('user');

            });
        } catch (Exception $e) {
            throw new Exception('Erro ao criar o cliente: ' . $e->getMessage());
        }
    }
}
