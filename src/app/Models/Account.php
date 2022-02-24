<?php
namespace Winnipass\Wfx\App\Models;

use PDO;

class Account extends AbstractModel {

    private string $tableName = 'accounts';

    public function getAccounts() 
    {
        $connection = $this->connect();
        return $connection->query("SELECT * FROM {$this->tableName}")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createAccount() {}
}