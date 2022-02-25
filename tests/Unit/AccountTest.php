<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Winnipass\Wfx\App\Helpers\Helper;
use Winnipass\Wfx\App\Models\Account;
use Winnipass\Wfx\App\Models\Customer;

class AccountTest extends TestCase
{
    use TraitTest;

    protected Customer $customer;
    protected Account $account;

    public function setUp(): void
    {
        $this->refreshDatabase();
        $this->customer = new Customer();
        $this->account = new Account();
    }

    public function testCanCreateAccounts()
    {
        $customerData = [
            [
                "name" => "Marco Polo" 
            ],
        ];
        $this->customer->createCustomer($customerData);
        $accountData = [
            [
                "amount" => 5000.50
            ],
            [
                "amount" => 1800.99
            ]
        ];
        $accountValue = 5000.50 * Helper::AMOUNT_CONVERSION_VALUE;

        $createResponse = $this->account->createAccount(1, $accountData);
        $response = $this->account->getAccounts();

        $this->assertTrue($createResponse);
        $this->assertIsArray($response);
        $this->assertCount(2, $response);
        $this->assertArrayHasKey('amount', $response[0]);
        $this->assertEquals($accountValue, $response[0]['amount']);
    }
}