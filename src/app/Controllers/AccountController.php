<?php
namespace Winnipass\Wfx\App\Controllers;

use Winnipass\Wfx\App\Models\Account;

final class AccountController extends AbstractController {
    
    public function __construct(private Account $account) {}

    public function index() {
        return $this->account->getAccounts();
    }

    public function create(array $request) 
    {
        [$customer, $data] = $request;
 
        return $this->account->createAccount($customer, $data);
    }

    public function update() {}

    public function delete() {}
}