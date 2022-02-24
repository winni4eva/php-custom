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

    public function create(array|null $request) 
    {
        var_dump($request);
        return ["Huraaaaaaaaaay"];
    }

    public function update() {}

    public function delete() {}
}