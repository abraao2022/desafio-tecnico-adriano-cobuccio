<?php

namespace Tests\Unit\Services\Transaction;

use App\Models\Transaction;
use App\Models\Customer;
use App\Services\Transaction\RevertTransactionService;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Mockery;
use Tests\TestCase;

class RevertTransactionServiceTest extends TestCase
{
    protected $repository;
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = Mockery::mock(TransactionRepositoryInterface::class);
        $this->service = new RevertTransactionService($this->repository);

        // Mock DB transaction
        DB::shouldReceive('transaction')->andReturnUsing(fn ($callback) => $callback());

        // Fake time for Carbon
        Carbon::setTestNow(now());

        // Spy log
        Log::spy();

        // Mock auth user
        Auth::shouldReceive('user')->andReturn((object)[
            'admin' => (object)[
                'id' => 99,
            ],
        ]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_reverte_transacao_do_tipo_deposito()
    {
        $transaction = new Transaction([
            'id' => 1,
            'type' => 'deposit',
            'status' => 'completed',
            'amount' => 100.00,
        ]);

        $customer = Mockery::mock(Customer::class)->shouldAllowMockingProtectedMethods();
        $customer->shouldReceive('decrement')->once()->with('balance', 100.00);

        $transaction->setRelation('to', $customer);

        $this->repository->shouldReceive('findOrFail')->once()->with(1)->andReturn($transaction);
        $this->repository->shouldReceive('update')->once()->andReturn($transaction);
        $this->repository->shouldReceive('find')->andReturn($transaction);

        $result = $this->service->execute([
            'transaction_id' => 1,
        ]);

        $this->assertInstanceOf(Transaction::class, $result);
    }

    public function test_reverte_transacao_do_tipo_transfer()
    {
        $transaction = new Transaction([
            'id' => 2,
            'type' => 'transfer',
            'status' => 'completed',
            'amount' => 50.00,
        ]);

        $to = Mockery::mock(Customer::class)->shouldAllowMockingProtectedMethods();
        $from = Mockery::mock(Customer::class)->shouldAllowMockingProtectedMethods();

        $to->shouldReceive('decrement')->once()->with('balance', 50.00);
        $from->shouldReceive('increment')->once()->with('balance', 50.00);

        $transaction->setRelation('to', $to);
        $transaction->setRelation('from', $from);

        $this->repository->shouldReceive('findOrFail')->once()->with(2)->andReturn($transaction);
        $this->repository->shouldReceive('update')->once()->andReturn($transaction);
        $this->repository->shouldReceive('find')->andReturn($transaction);

        $result = $this->service->execute([
            'transaction_id' => 2,
        ]);

        $this->assertInstanceOf(Transaction::class, $result);
    }

    public function test_nao_reverte_transacao_com_status_diferente_de_completed()
    {
        $transaction = new Transaction([
            'id' => 3,
            'type' => 'deposit',
            'status' => 'pending',
            'amount' => 100.00,
        ]);

        $fakeCustomer = Mockery::mock(Customer::class);

        $transaction->setRelation('to', $fakeCustomer);

        $this->repository->shouldReceive('findOrFail')->once()->with(3)->andReturn($transaction);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Erro ao reverter transação.');

        $this->service->execute([
            'transaction_id' => 3,
        ]);
    }

}
