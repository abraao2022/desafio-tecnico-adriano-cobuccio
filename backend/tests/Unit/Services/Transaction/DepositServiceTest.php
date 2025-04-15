<?php

namespace Tests\Unit\Services\Transaction;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use App\Services\Transaction\DepositService;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class DepositServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_execute_realiza_deposito_com_sucesso()
    {
        $data = [
            'customer_id' => 1,
            'amount' => 100.00,
            'description' => 'Depósito inicial',
        ];

        $mockCustomer = Mockery::mock(Customer::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $mockCustomer->id = 1;
        $mockCustomer->shouldReceive('increment')
            ->with('balance', $data['amount'])
            ->once();

        $mockUser = Mockery::mock(User::class);
        $mockUser->shouldReceive('getAttribute')
            ->with('customer')
            ->andReturn($mockCustomer);

        app()->bind('auth', function () use ($mockUser) {
            $mockAuth = Mockery::mock();
            $mockAuth->shouldReceive('user')->andReturn($mockUser);
            return $mockAuth;
        });

        $mockTransaction = Mockery::mock(Transaction::class);
        $mockTransaction->shouldIgnoreMissing();

        $customerRepository = Mockery::mock(CustomerRepositoryInterface::class);
        $transactionRepository = Mockery::mock(TransactionRepositoryInterface::class);

        $transactionRepository
            ->shouldReceive('create')
            ->once()
            ->andReturn($mockTransaction);

        $service = new DepositService($transactionRepository, $customerRepository);

        $result = $service->execute($data);

        $this->assertEquals($mockTransaction, $result);
    }
}
