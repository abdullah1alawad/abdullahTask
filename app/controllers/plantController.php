<?php

namespace app\planController;

require_once __DIR__ . '\baseController.php';
require_once __DIR__ . '\..\models\landModel.php';

use app\baseController\BaseController;
use app\landModel\LandModel;

class PlantController extends BaseController
{
    public function get_all()
    {
        $landModel=new LandModel();
        $data=$landModel->get_all('plants','*');
        $land=[];
        foreach ($data as $val)
            $land[]=$val;
        return $land;
    }
    public function get_type()
    {
        $landModel=new LandModel();
        $data=$landModel->get_all('plants','type');
        $plant=[];
        foreach ($data as $val)
            $plant[]=$val['type'];
        return $plant;
    }

}