<?php
namespace Winnipass\Wfx\App\Controllers;

use Winnipass\Wfx\App\Models\Account;

final class AccountController extends AbstractController {
    
    public function __construct(private Account $account) {}

    public function index(array $request) 
    {
        [$accountId] = $request;
        
        $response = $this->account->getAccounts($accountId);

        if ($response) {
            return  [
                ['data' => $response],
                200 
            ];
        }
        return  [['error' => 'Error fetching account data'], 400];
    }

    public function create(array $request) 
    {
        [$customer, $data] = $request;
 
        $response = $this->account->createAccount($customer, $data);
        if ($response) {
            return  [
                ['success' => 'Account created successfully'],
                200 
            ];
        }
        return  [['error' => 'Error creating account'],400];
    }

    public function update() {}

    public function delete() {}
}