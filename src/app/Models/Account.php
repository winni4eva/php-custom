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
        var_dump('Customer');
        var_dump($customerId);
        var_dump('Datas');
        var_dump($data);
        $collection = (new Collection())->make($data);
        $accountData = $collection->map(function($account) use($customerId) {
            $account['customer_id'] = $customerId;
            $account['amount'] = $account['amount'] * 100;
            return $account;
        })->values()->all();

        $fields = ['amount', 'customer_id'];

        return $this->create($fields, $accountData);
    }
}