<?php

use App\Models\User;
use App\Services\User\StoreUserService;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Facades\DB;
use Mockery;

uses(\Illuminate\Foundation\Testing\TestCase::class)->in('Unit');

it('should create a user successfully', function () {
    $userData = [
        'name' => 'Lucas',
        'email' => 'lucas@example.com',
        'cpf' => '12345678900',
        'password' => '123456',
    ];

    $expectedHashedPassword = 'hashed_password';

    // Mock do Hasher
    $hasher = Mockery::mock(Hasher::class);
    $hasher->shouldReceive('make')
        ->once()
        ->with('123456')
        ->andReturn($expectedHashedPassword);

    // Mock do UserRepository
    $userRepository = Mockery::mock(UserRepositoryInterface::class);

    $userRepository
        ->shouldReceive('create')
        ->once()
        ->with(Mockery::on(function ($data) use ($expectedHashedPassword) {
            return $data['name'] === 'Lucas'
                && $data['email'] === 'lucas@example.com'
                && $data['cpf'] === '12345678900'
                && $data['password'] === $expectedHashedPassword;
        }))
        ->andReturnUsing(function ($data) {
            $user = new User();
            $user->id = 1;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->cpf = $data['cpf'];
            $user->password = $data['password'];
            return $user;
        });

    // Mock da transação
    DB::shouldReceive('transaction')
        ->once()
        ->andReturnUsing(fn ($callback) => $callback());

    // Instancia o service
    $service = new StoreUserService($userRepository, $hasher);
    $result = $service->execute($userData);

    expect($result)->toBeInstanceOf(User::class)
        ->and($result->id)->toBe(1)
        ->and($result->name)->toBe('Lucas')
        ->and($result->email)->toBe('lucas@example.com')
        ->and($result->password)->toBe($expectedHashedPassword);
});
