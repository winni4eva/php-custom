<?php
namespace Winnipass\Wfx\App\Models;

use Illuminate\Support\Collection;
use PDO;

class Account extends AbstractModel {

    public string $tableName = 'accounts';

    public function getAccounts() 
    {
        return $this->get();
    }

    public function createAccount(int $customerId, array $data) 
    {
        $collection = (new Collection())->make($data);
        $accountData = $collection->map(function($account) use($customerId) {
            $account['customer_id'] = $customerId;
            return $account;
        })->values()->all();

        $fields = ['amount', 'customer_id'];

        return $this->create($fields, $accountData);
    }
}