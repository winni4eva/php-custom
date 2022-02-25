<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Winnipass\Wfx\App\Models\Customer;

class CustomerTest extends TestCase
{
    use TraitTest;

    protected Customer $customer;

    public function setUp(): void
    {
        $this->refreshDatabase();
        $this->customer = new Customer();
    }

    public function testCanCreateCustomers()
    {
        $data = [
            [
                "name" => "Marco Polo" 
            ],
        ];
        $this->customer->createCustomer($data);

        $response = $this->customer->getCustomers();
        
        $this->assertIsArray($response);
        $this->assertCount(1, $response);
    }

    protected function tearDown(): void
    {
    }
}