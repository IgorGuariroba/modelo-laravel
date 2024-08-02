<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

test('example', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
