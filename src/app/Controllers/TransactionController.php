<?php
namespace Winnipass\Wfx\App\Controllers;

use Winnipass\Wfx\App\Models\Transaction;

final class TransactionController extends AbstractController 
{
    /**
     * Initializes class properties
     *
     * @param Transaction $transaction
     *
     * @return void
     */
    public function __construct(private Transaction $transaction){}

    /**
     * Gets transaction for a given account or returns all transactions 
     *
     * @param array $request
     *
     * @return array
     */
    public function index(array $request): array 
    {
        [$accountId] = $request;
        
        $response = $this->transaction->getTransactions($accountId);

        if ($response) {
            return  [
                ['data' => $response],
                200 
            ];
        }
        return  [['error' => 'Error fetching transaction data'], 400];
    }

    /**
     * Adds a transaction record for a given customers account
     *
     * @param array $request
     *
     * @return array
     */
    public function create(array $request): array 
    {
        [$customer, $data] = $request;
        
        $response = $this->transaction->createTransaction($customer, $data);

        if ($response) {
            return  [
                ['success' => 'Transaction was successful'],
                201
            ];
        }
        return  [['error' => 'Error creating transaction'],400];
    }
}