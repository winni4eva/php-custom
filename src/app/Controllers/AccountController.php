<?php
namespace Winnipass\Wfx\App\Controllers;

class AccountController extends AbstractController {
    
    public function __construct()
    {
        //
    }

    public function index() {
        return [
            'data' => [
                '1' => 'Adam'
            ]
        ];
    }

    public function create() {}

    public function update() {}

    public function delete() {}
}