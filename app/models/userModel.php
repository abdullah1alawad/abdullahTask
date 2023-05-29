<?php

namespace app\userModel;
require_once __DIR__ . '\baseModel.php';
use app\baseModel\BaseModel;

class UserModel extends BaseModel
{
    protected $id;
    protected $name;
    protected $email;
    protected $password;

    public function add($name,$email,$password)
    {
        $sql='INSERT INTO users (name,email,password) VALUES (?,?,?)';
        $stm=$this->conn->prepare($sql);
        $stm->execute([$name,$email,$password]);
    }
}