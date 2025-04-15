<?php

namespace Tests\Unit\Services\Transaction;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use App\Services\Transaction\TransferService;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class TransferServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_lanca_excecao_se_saldo_insuficiente()
    {
        $data = [
            'from_customer_id' => 1,
            'to_customer_id' => 2,
            'amount' => 200.00,
        ];

        $mockFromCustomer = Mockery::mock(Customer::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();
        $mockFromCustomer->id = 1;
        $mockFromCustomer->balance = 100.00;

        $mockToCustomer = Mockery::mock(Customer::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();
        $mockToCustomer->id = 2;

        $mockUser = Mockery::mock(User::class);
        $mockUser->shouldReceive('getAttribute')
            ->with('customer')
            ->andReturn($mockFromCustomer);

        app()->bind('auth', function () use ($mockUser) {
            $mockAuth = Mockery::mock();
            $mockAuth->shouldReceive('user')->andReturn($mockUser);
            return $mockAuth;
        });

        $customerRepository = Mockery::mock(CustomerRepositoryInterface::class);
        $transactionRepository = Mockery::mock(TransactionRepositoryInterface::class);

        $customerRepository->shouldReceive('findOrFail')
            ->with(1)
            ->andReturn($mockFromCustomer);
        $customerRepository->shouldReceive('findOrFail')
            ->with(2)
            ->andReturn($mockToCustomer);

        $mockTransaction = Mockery::mock(Transaction::class);
        $mockTransaction->shouldIgnoreMissing();

        $service = new TransferService($transactionRepository, $customerRepository);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Erro ao realizar transferência: Saldo insuficiente.');

        $service->execute($data);
    }
}
