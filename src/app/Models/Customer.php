<?php
namespace Winnipass\Wfx\App\Models;

class Customer extends AbstractModel {

    public string $tableName = 'customers';

    public function getCustomers() 
    {
        return $this->get();
    }

    public function createCustomer() {}
}