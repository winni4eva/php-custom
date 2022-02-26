<?php
namespace Winnipass\Wfx\App\Controllers;

use Winnipass\Wfx\App\Models\Customer;

final class CustomerController extends AbstractController {
    
    /**
     * Initializes class properties
     *
     * @param Customer $customer
     *
     * @return void
     */
    public function __construct(private Customer $customer) {}

    /**
     * Gets customers for a given account or returns all customers 
     *
     * @param array $request
     *
     * @return array
     */
    public function index(array|null $request): array 
    {
        [$customerId] = $request;
        
        $response = $this->customer->getCustomers($customerId);

        if ($response) {
            return  [
                ['data' => $response],
                200 
            ];
        }
        return  [['error' => 'Error fetching customer data'], 400];
    }

    public function create(array $request) 
    {   
        $response = $this->customer->createCustomer($request);
        
        if ($response) {
            return  [['success' => ' Customer created successfully'],
                201
            ];
        }
        return  [
            ['error' => 'Error creating customer'],
            400 
        ];
    }
}