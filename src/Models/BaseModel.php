<?php

namespace App\Models;

use PDO;

class BaseModel
{
    protected $table = 'products';
    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=localhost;dbname=bobby;charset=utf8", 'root', '');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw $e->getMessage();
        }
    }

    public static function all()
    {
        $static = new static;
        $sqlBuilder = "Select * From $static->table";
        $stmt = $static->conn->prepare($sqlBuilder);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public static function find($id)
    {
        $model = new static;
        $sqlBuilder = "Select * From $model->table WHERE id=$id";
        $stmt = $model->conn->prepare($sqlBuilder);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_CLASS, get_class($model));
        return $result[0];
    }

    public function insert($arr)
    {
        $this->queryBuilder = "INSERT INTO " . $this->table;

        $cols = "(";
        $values = "(";

        foreach ($arr as $key => $value) {
            $cols .= "{$key}, ";
            $values .= ":{$key}, ";
        }

        $cols = rtrim($cols, ', ') . ") ";
        $values = rtrim($values, ', ') . ")";

        $this->queryBuilder .= $cols . " Values" . $values;
        $stmt = $this->conn->prepare($this->queryBuilder);
        // $this->currentId = $this->conn->currentId;
        return $stmt->execute($arr);
    }

    public function update($arr)
    {
        $this->queryBuilder = "Update " . $this->table . " SET ";

        foreach ($arr as $key => $value) {
            $this->queryBuilder .= "{$key}=:{$key}, ";
        }

        $this->queryBuilder = rtrim($this->queryBuilder, ', ') . " WHERE id=:id";

        $arr['id'] = $this->id;

        // var_dump($this->queryBuilder, "; id: " . $this->id);
        // var_dump($arr);
        $stmt = $this->conn->prepare($this->queryBuilder);
        $stmt->execute($arr);
    }

    public static function where($column, $operator, $value)
    {
        $model = new static;
        $model->queryBuilder = "SELECT * FROM " . $model->table . " WHERE $column $operator '$value'";

        return $model;
    }
    public function andWhere($column, $operator, $value)
    {
        $this->queryBuilder .= " AND $column $operator '$value'";
        return $this;
    }
    public function orWhere($column, $operator, $value)
    {
        $this->queryBuilder .= " OR $column $operator '$value'";
        return $this;
    }
    public function get()
    {
        $stmt = $this->conn->prepare($this->queryBuilder);
        // var_dump($this->queryBuilder);
        // die;
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, get_class($this));
    }
    public function first()
    {
        $stmt = $this->conn->prepare($this->queryBuilder);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_CLASS, get_class($this));
        return $result[0];
    }
}
