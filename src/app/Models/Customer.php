<?php
namespace Winnipass\Wfx\App\Models;

class Customer extends AbstractModel {

    public string $tableName = 'customers';

    public function getCustomers() 
    {
        return $this->get();
    }

    public function createCustomer(array $data) 
    {
        $fields = ['name'];
    
        return $this->create($fields, $data);
    }
}