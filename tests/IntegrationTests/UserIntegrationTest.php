<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use \Tests\TestCase;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('health check', function () {
    $response = $this->get('/up');

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'OK',
            'database' => [
                'connected' => true,
                'version' => '8.0.32',
            ],
            'cache' => [
                'connected' => true,
            ],
            'app' => [
                'version' => '11.19.0',
                'environment' => 'testing',
            ],
        ]);
});
