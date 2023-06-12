<?php

namespace Tests\Unit;

use Tests\TestCase;

class CityTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_city()
    {
        $response = $this->get('/cities');
        $response->assertStatus(200);
    }
}
