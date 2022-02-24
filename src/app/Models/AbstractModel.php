<?php
namespace Winnipass\Wfx\App\Models;

use Illuminate\Support\Collection;
use PDO;
use Winnipass\Wfx\App\Database;

abstract class AbstractModel extends Database 
{
    public string $tableName;

    protected function get(array $fields = []) 
    {
        $connection = $this->connect();
        $statement = $connection->query("SELECT * FROM {$this->tableName}");
        
        return $statement->fetchAll($connection::FETCH_ASSOC);
    }

    protected function all()
    {
        return $this->get();
    }

    protected function create(array $fields, array $data)
    {
        try {
            $fieldList = implode(',', $fields);
            $connection = $this->connect();
            $connection->beginTransaction();

            foreach ($data as $key => $value) {
                $collection = (new Collection())->make($value);
                $values = $collection->keys()->map(function($field) {
                    return ':'.$field;
                })->values()->all();
                $values = implode(',', $values);
                
                $query = "INSERT INTO {$this->tableName} ({$fieldList}) VALUES ({$values})";
                var_dump($query);
                $bindings = $collection->map(function($val, $field) {
                   return [':'.$field => (int)$val];
                })->values()->all();

                $bindings = (array)array_merge(...$bindings);
                $statement = $connection->prepare($query);
                $statement->execute($bindings);
            }

            $connection->commit();

        } catch (\Throwable $th) {
            $connection->rollBack();
            throw $th;
        }
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
        return $statement->fetch($connection::FETCH_ASSOC);
    }
}