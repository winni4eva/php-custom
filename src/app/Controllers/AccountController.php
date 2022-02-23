<?php
namespace Winnipass\Wfx\App\Controllers;

use Winnipass\Wfx\App\Models\Account;

class AccountController extends AbstractController {
    
    public function __construct(private Account $account) {}

    public function index() {
        return [
            'data' => [
                '1' => 'Adam'
            ]
        ];
    }

    public function create() {}

    public function update() {}

    public function delete() {}
}