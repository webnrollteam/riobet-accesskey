<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

class AccessKeyTest extends TestCase
{
    use RefreshDatabase;
    
    const HEADERS = [
        'Accept' => 'application/json'
    ];

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_create(): void
    {
        $response = $this->post('/api/accesskey/create', [
            "masterkey" => env('MASTERKEY'),
            "params" => [
                "service" => "user",
            ]
        ],  self::HEADERS);

        $response->assertStatus(200);
    }
}
