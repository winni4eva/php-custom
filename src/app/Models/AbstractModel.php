<?php
namespace Winnipass\Wfx\App\Models;

use PDO;
use Winnipass\Wfx\App\Database;

abstract class AbstractModel extends Database 
{
    public string $tableName;

    protected function get(array $fields = []) 
    {
        return $this->connect()->query("SELECT * FROM {$this->tableName}")
            ->fetchAll(static::FETCH_ASSOC);
    }
}