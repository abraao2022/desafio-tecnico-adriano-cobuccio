<?php

use App\Models\User;
use App\Models\Customer;
use App\Services\Customer\StoreCustomerService;
use App\Services\User\StoreUserService;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Mockery;

it('should create a customer and related user successfully', function () {
    $userData = [
        'name' => 'Lucas',
        'email' => 'lucas@example.com',
        'cpf' => '12345678900',
        'password' => '123456'
    ];

    $customerData = [
        'balance' => 100.0,
        'phone_number' => '12345678900'
    ];

    $payload = [
        'user' => $userData,
        'customer' => $customerData,
    ];

    // Mock do usuário retornado
    $mockedUser = new User();
    $mockedUser->id = 1;

    // Mock do serviço de usuário
    $storeUserService = Mockery::mock(StoreUserService::class);
    $storeUserService
        ->shouldReceive('execute')
        ->once()
        ->with($userData)
        ->andReturn($mockedUser);

    // Mock do customer com load(user)
    $mockedCustomer = Mockery::mock(Customer::class)->makePartial();
    $mockedCustomer->user_id = 1;
    $mockedCustomer->balance = 100.0;
    $mockedCustomer->phone_number = '12345678900';

    $mockedCustomer->shouldReceive('load')
        ->once()
        ->with('user')
        ->andReturnSelf();

    // Mock do repositório de customer
    $customerRepository = Mockery::mock(CustomerRepositoryInterface::class);
    $customerRepository
        ->shouldReceive('create')
        ->once()
        ->with([
            'user_id' => 1,
            'balance' => 100.0,
            'phone_number' => '12345678900'
        ])
        ->andReturn($mockedCustomer);

    // Mock do repositório de usuário (não está sendo usado nesse teste, mas precisa ser passado)
    $userRepository = Mockery::mock(UserRepositoryInterface::class);

    // Mock da transação do DB
    DB::shouldReceive('transaction')
        ->once()
        ->andReturnUsing(fn ($callback) => $callback());

    // Instanciar o service
    $service = new StoreCustomerService(
        $customerRepository,
        $userRepository,
        $storeUserService
    );

    // Executar e testar
    $result = $service->execute($payload);

    expect($result)->toBeInstanceOf(Customer::class)
        ->and($result->user_id)->toBe(1)
        ->and($result->balance)->toBe(100.0)
        ->and($result->phone_number)->toBe('12345678900');
});
