<?php
namespace Winnipass\Wfx\App\Controllers;

use Winnipass\Wfx\App\Models\Customer;

final class CustomerController extends AbstractController {
    
    public function __construct(private Customer $customer) {}

    public function index(array|null $request) 
    {
        [$customerId] = $request;
        return $this->customer->getCustomers();
    }

    public function create(array $request) 
    {   
        $response = $this->customer->createCustomer($request);
        
        if ($response) {
            return  [['success' => ' Customer created successfully'],
                200 
            ];
        }
        return  [
            ['error' => 'Error creating customer'],
            400 
        ];
    }

    public function update() {}

    public function delete() {}
}