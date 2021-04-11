<?php

namespace Tests\Unit;

use Illuminate\Http\Response;
use Tests\TestCase;

class OrderRequestTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_order_request_validation_name_empty()
    {
        $response = $this->json('POST', route('order.store'), [
            'name' => ''
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['name']);
    }

    public function test_order_request_validation_email_empty()
    {
        $response = $this->json('POST', route('order.store'), [
            'email' => ''
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_order_request_validation_invalid_email()
    {
        $response = $this->json('POST', route('order.store'), [
            'email' => 'invalid-value'
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_order_request_validation_quantity_nonumber()
    {
        $response = $this->json('POST', route('order.store'), [
            'quantity' => 'two'
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['quantity']);
    }
}
