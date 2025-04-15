<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

test('should create a customer successfully', function () {
    $payload = [
        'user' => [
            'name' => 'Lucas',
            'email' => 'lucas@example.com',
            'cpf' => '12345678900',
            'password' => '123456',
        ],
        'phone_number' => '11999999999',
        'address' => 'Rua Teste',
        'city' => 'São Paulo',
        'state' => 'SP',
        'postal_code' => '01234567',
        'birthdate' => '2000-01-01',
    ];

    $response = $this->postJson('/api/customers', $payload);

    $response->assertCreated();

    $response->assertJsonStructure([
        'data' => [
            'id',
            'user' => [
                'id',
                'name',
                'email',
                'cpf',
            ],
            'phone_number',
            'address',
            'city',
            'state',
            'postal_code',
            'birthdate',
        ]
    ]);
});
