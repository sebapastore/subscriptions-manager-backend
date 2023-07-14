<?php

namespace Tests\Feature\Customer;

use Domain\Customer\Models\Customer;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    /** @test */
    public function can_create_customer()
    {
        $this->login();

        $data = [
            'business_name' => 'Zentcode',
            'document_number' => '123',
            'contact_name' => 'Jon Doe',
            'email' => 'test@email.com',
            'phone_number' => '123456',
            'address' => 'Zentcode Avenue',
            'comments' => 'This is a comment',
        ];

        $response = $this->postJson(route('customers.store'), $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertTrue(Customer::query()
            ->where('business_name', 'Zentcode')
            ->where('document_number', '123')
            ->where('contact_name', 'Jon Doe')
            ->where('email', 'test@email.com')
            ->where('phone_number', '123456')
            ->where('address', 'Zentcode Avenue')
            ->where('comments', 'This is a comment')
            ->exists());
    }

    /** @test */
    public function fields_are_validated_when_try_to_create_a_customer()
    {
        //$this->withoutExceptionHandling();

        $this->login();
        $data = [
            'email' => 'asd',
        ];

        $response = $this->postJson(route('customers.store'), $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['business_name', 'email'])
            ->assertJsonMissingValidationErrors(['document_number', 'contact_name', 'phone_number', 'address', 'comments']);
    }
}
