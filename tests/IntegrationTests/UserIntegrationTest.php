<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('health check', function () {
    $response = $this->get('/up');

    $response->assertStatus(200);
});
