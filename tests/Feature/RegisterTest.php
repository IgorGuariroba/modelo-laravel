<?php

use function Pest\Laravel\post;
use Illuminate\Foundation\Testing\RefreshDatabase;

beforeEach(function () {
    $this->artisan('migrate:fresh');
});

test('testar validação do registro', function () {

    $payload = [];

    $response = post('/api/register', $payload);

    $response->assertStatus(400);
    $response->assertJson([
        'name' => ['O campo nome é obrigatório.'],
        'email' => ['O campo email é obrigatório.'],
        'password' => ['O campo senha é obrigatório.'],
    ]);

});

test('testar validação de senha fraca', function () {

    $payload = [
        'name' => 'igor',
        'email' => 'igor@gmail.com',
        'password' => 'igor'
    ];

    $response = post('/api/register', $payload);

    $response->assertStatus(400);
    $response->assertJson([
        'password' => [
            'O campo senha deve ter pelo menos 8 caracteres.',
            'O campo senha deve conter pelo menos uma letra maiúscula e uma letra minúscula.',
            'O campo senha deve conter pelo menos um símbolo.',
            'O campo senha deve conter pelo menos um número.'
        ],
    ]);

});


test('testar a criação do usuario', function () {

    $payload = [
        'name' => 'igor',
        'email' => 'igor@gmail.com',
        'password' => '@D2igo45vbf'
    ];

    $response = post('/api/register', $payload);

    $response->assertStatus(201);
    $response->assertJsonStructure([
        'user' => [
            'name',
            'email',
            'updated_at',
            'created_at',
            'id',
        ],
        'token',
    ]);

});
