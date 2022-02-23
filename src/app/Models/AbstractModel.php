<?php
namespace Winnipass\Wfx\App\Models;

use Winnipass\Wfx\Database;

abstract class AbstractModel {

    protected $connection;

    public function __construct(private Database $database){
        $this->connection = $database->connect();
    }
}