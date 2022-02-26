<?php
namespace Winnipass\Wfx\App\Models;

use Illuminate\Support\Collection;
use PDO;
use Winnipass\Wfx\App\Helpers\Helper;

class Account extends AbstractModel {

    public string $tableName = 'accounts';

    public function getAccounts(int|null $accountId = null) 
    {
        if ($accountId) {
            return $this->convertAccountAmounts($this->find($accountId));
        }

        return $this->convertAccountAmounts($this->get(), true);
    }

    public function createAccount(int $customerId, array $data) 
    {
        $collection = (new Collection())->make($data);
        $accountData = $collection->map(function($account) use($customerId) {
            $account['customer_id'] = $customerId;
            $account['amount'] = $account['amount'] * Helper::AMOUNT_CONVERSION_VALUE;
            return $account;
        })->values()->all();

        $fields = ['amount', 'customer_id'];

        return $this->create($fields, $accountData);
    }

    private function convertAccountAmounts(array $data, bool $isAssoc = false): array
    {
        if (! $isAssoc) {
            $data['amount'] = $data['amount'] / Helper::AMOUNT_CONVERSION_VALUE;
            return $data;
        }

        $collection = (new Collection())->make($data);
        $convertedAccounts = $collection->map(function($account){
            $account['amount'] = $account['amount']/Helper::AMOUNT_CONVERSION_VALUE;
            return $account;
        })->values()->all();

        return $convertedAccounts;
    }
}