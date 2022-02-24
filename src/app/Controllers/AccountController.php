<?php
namespace Winnipass\Wfx\App\Controllers;

use Winnipass\Wfx\App\Models\Account;

final class AccountController extends AbstractController {
    
    public function __construct(private Account $account) {}

    public function index() {
        return $this->account->getAccounts();
    }

    public function create() {}

    public function update() {}

    public function delete() {}
}