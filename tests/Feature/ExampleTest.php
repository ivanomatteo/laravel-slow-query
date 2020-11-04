<?php

namespace IvanoMatteo\LaravelSlowQuery\Tests\Feature;

use IvanoMatteo\LaravelSlowQuery\Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
