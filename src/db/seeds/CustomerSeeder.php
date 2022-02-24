<?php


use Phinx\Seed\AbstractSeed;

class CustomerSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            ["name" => "Arisha Barron"],
            ["name" => "Branden Gibson"],
            ["name" => "Rhonda Church"],
            ["name" => "Georgina Hazel"]
        ];

        $customers = $this->table('customers');
        $customers->insert($data)->saveData();
    }
}
