<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Winnipass\Wfx\App\Helpers\Helper;
use Winnipass\Wfx\App\Models\Account;
use Winnipass\Wfx\App\Models\Customer;
use Winnipass\Wfx\App\Models\Transaction;

class TransactionTest extends TestCase
{
    use TraitTest;

    protected Customer $customer;

    protected Account $account;

    protected Transaction $transaction;

    public function setUp(): void
    {
        $this->refreshDatabase();
        $this->customer = new Customer();
        $this->account = new Account();
        $this->transaction = new Transaction();
    }

    public function testCanTransferFunds()
    {
        $customerData = [
            [
                "name" => "Neo Matrix" 
            ],
        ];
        $this->customer->createCustomer($customerData);
        $accountData = [
            [
                "amount" => 500.55
            ],
            [
                "amount" => 100.90
            ]
        ];
        $accountValue = 5000.50 * Helper::AMOUNT_CONVERSION_VALUE;
        $this->account->createAccount(1, $accountData);

        $transactionData = [
            "debit_account" => 1,
            "credit_account" => 2,
            "amount" => 50
        ];

        $this->transaction->createTransaction(1, $transactionData);
        $response = $this->transaction->getTransactions();
        
        $this->assertIsArray($response);
        $this->assertCount(2, $response);
    }
}