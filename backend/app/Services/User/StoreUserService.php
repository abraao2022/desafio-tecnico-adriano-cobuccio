<?php

namespace App\Services\User;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Facades\DB;
use Exception;

class StoreUserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected Hasher $hasher
    ) {}

    public function execute(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {
                $data['password'] = $this->hasher->make($data['password']);
                return $this->userRepository->create($data);
            });
        } catch (Exception $e) {
            throw new Exception('Erro ao criar o usuário: ' . $e->getMessage());
        }
    }
}
