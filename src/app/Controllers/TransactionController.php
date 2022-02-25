<?php
namespace Winnipass\Wfx\App\Controllers;

use Winnipass\Wfx\App\Models\Transaction;

final class TransactionController extends AbstractController 
{
    
    public function __construct(private Transaction $transaction){}

    public function index() 
    {
        return $this->transaction->getTransactions();
    }

    public function create(array $request) 
    {
        [$customer, $data] = $request;
        
        $response = $this->transaction->createTransaction($customer, $data);

        if ($response) {
            return  [
                ['success' => 'Transaction was successful'],
                200 
            ];
        }
        return  [['error' => 'Error creating transaction'],400];
    }

    public function update() {}

    public function delete() {}
}