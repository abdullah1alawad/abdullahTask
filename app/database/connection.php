<?php

namespace app\database;

class Connection
{
    public $dbData;

    public function __construct()
    {
        $this->dbData=require(__DIR__ . '/config.php');
    }
    public function connect()
    {
        $dsn='mysql:host=' . $this->dbData['servername'] .';' .'dbname=' . $this->dbData['dbname'];
        try {
            $conn = new \PDO($dsn, $this->dbData['username'], $this->dbData['password']);
            $conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        }catch (\Exception $e){
            echo $e->getMessage();
            exit();
        }
        return $conn;
    }

}
