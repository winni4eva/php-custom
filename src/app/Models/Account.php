<?php
namespace Winnipass\Wfx\App\Models;

use PDO;

class Account extends AbstractModel {

    public string $tableName = 'accounts';

    public function getAccounts() 
    {
        return $this->get();
    }

    public function createAccount() 
    {
        //
    }
}