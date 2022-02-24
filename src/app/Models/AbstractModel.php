<?php
namespace Winnipass\Wfx\App\Models;

use PDO;
use Winnipass\Wfx\App\Database;

abstract class AbstractModel extends Database 
{
    public string $tableName;

    protected function get(array $fields = []) 
    {
        $connection = $this->connect();
        $statement = $connection->query("SELECT * FROM {$this->tableName}");
        
        return $statement->fetchAll(static::FETCH_ASSOC);
    }

    protected function all()
    {
        return $this->get();
    }

    protected function where(array $filters)
    {
        $connection = $this->connect();
        $query = "SELECT * FROM {$this->tableName}";
        $bindings = [];
        foreach ($filters as $key => $value) {
            [$field, $operation, $comparison] = $value;
            $parameter = ':'.$$comparison;
            array_push($bindings, [$parameter => $comparison]);

            if ($key === 0) {
                $query .= " WHERE {$field} {$operation} {$parameter}";
            } else {
                $query .= " OR WHERE {$field} {$operation} {$parameter}";
            }
        }
        $statement = $connection->prepare($query);
        $statement->execute($bindings);
        return $statement->fetch(static::FETCH_ASSOC);
    }
}