<?php
namespace Winnipass\Wfx\App\Controllers;

use Winnipass\Wfx\App\Models\Account;

final class AccountController extends AbstractController {
    
    public function __construct(private Account $account) {}

    public function index() {
        return $this->account->getAccounts();
    }

    public function create(array|null $request) 
    {
        var_dump('Create account data');
        var_dump($request[1]);
        var_dump('Create account Customer');
        var_dump($request[0]);
    }

    public function update() {}

    public function delete() {}
}