<?php

namespace app\familyModel;

require_once __DIR__ . '\baseModel.php';
require_once __DIR__ . '\userModel.php';
use app\baseModel\BaseModel;
use app\userModel\UserModel;

class FamilyModel extends BaseModel
{
    private $user_id;
    private $full_name;
    private $members;
    private $phone;
    private $job;
    private $city_id;
    public function add($id,$name,$members,$phone,$job,$city_id)
    {
        $sql="INSERT INTO families (user_id,full_name,members,phone,job,city_id) VALUES (?,?,?,?,?,?)";
        $stm=$this->conn->prepare($sql);
        $stm->execute([$id,$name,$members,$phone,$job,$city_id]);
    }
    public function update($id,$name,$members,$phone,$job,$city_id)
    {
        $sql="UPDATE families SET user_id=?,full_name=?,members=?,phone=?,job=?,city_id=? WHERE user_id=?";
        $stm=$this->conn->prepare($sql);
        $stm->execute([$id,$name,$members,$phone,$job,$city_id,$id]);
    }

}