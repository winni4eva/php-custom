<?php
namespace Winnipass\Wfx\App\Controllers;

use Winnipass\Wfx\App\Models\Account;

final class AccountController extends AbstractController {
    
    /**
     * Initializes class properties
     *
     * @param Account $account
     *
     * @return void
     */
    public function __construct(private Account $account) {}

    /**
     * Gets a single account or all accounts 
     *
     * @param array $request
     *
     * @return array
     */
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

    /**
     * Adds an account for a given customer
     *
     * @param array $request
     *
     * @return array
     */
    public function create(array $request) 
    {
        [$customer, $data] = $request;
 
        $response = $this->account->createAccount($customer, $data);
        if ($response) {
            return  [
                ['success' => 'Account created successfully'],
                201 
            ];
        }
        return  [['error' => 'Error creating account'],400];
    }
}