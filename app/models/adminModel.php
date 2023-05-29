<?php

namespace app\adminModel;
require_once __DIR__ . '\userModel.php';
use app\userModel\UserModel;

class AdminModel extends UserModel
{
    public function checkAdmin($id)
    {
        $sql="SELECT user_id FROM admins WHERE user_id=?";
        $stm=$this->conn->prepare($sql);
        $stm->execute([$id]);
        return $stm->fetchAll();
    }
}