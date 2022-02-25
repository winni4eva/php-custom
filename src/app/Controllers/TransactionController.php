<?php
namespace Winnipass\Wfx\App\Controllers;

use Winnipass\Wfx\App\Models\Transaction;

final class TransactionController extends AbstractController {
    
    public function __construct(private Transaction $transaction){}

    public function index() {}

    public function create(array $request) 
    {
        [$customer, $data] = $request;
        
        return $this->transaction->createTransaction($customer, $data);
    }

    public function update() {}

    public function delete() {}
}