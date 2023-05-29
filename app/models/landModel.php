<?php

namespace app\landModel;
require_once __DIR__ . '\baseModel.php';

use app\baseModel\BaseModel;

class LandModel extends BaseModel
{
    private $id;
    private $user_id;
    private $productivity;
    private $profit;
    private $plant_id;

    public function add($user_id,$productivity,$profit,$plant_id)
    {
        $sql='INSERT INTO lands (user_id,productivity,profit,plant_id) VALUES (?,?,?,?)';
        $stm=$this->conn->prepare($sql);
        $stm->execute([$user_id,$productivity,$profit,$plant_id]);
    }
}