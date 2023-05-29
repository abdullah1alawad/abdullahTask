<?php

namespace app\baseModel;
require_once __DIR__ . '\..\database\connection.php';
use app\database\Connection;

class BaseModel
{
    protected $conn;
    public function __construct()
    {
        $obj = new Connection();
        $this->conn = $obj->connect();
    }
    public function get_one($table_name,$col1,$col2,$val)
    {
        $sql='SELECT '.$col1.' FROM '.$table_name.' WHERE '.$col2."=?";
        $stm=$this->conn->prepare($sql);
        $stm->execute([$val]);
        return $stm->fetchAll();
    }
    public function get_all($table_name,$col)
    {
        $sql='SELECT '.$col.' FROM '.$table_name;
        $stm=$this->conn->prepare($sql);
        $stm->execute();
        return $stm->fetchAll();
    }
    public function delete($table_name,$col,$val)
    {
        $sql='DELETE FROM '.$table_name.' WHERE '.$col.'=?';
        $stm=$this->conn->prepare($sql);
        $stm->execute([$val]);
    }
    public function greaterThan($table_name,$col1,$col2,$val)
    {
        $sql='SELECT '.$col1.' FROM '.$table_name.' WHERE '.$col2.">?";
        $stm=$this->conn->prepare($sql);
        $stm->execute([$val]);
        return $stm->fetchAll();
    }
}