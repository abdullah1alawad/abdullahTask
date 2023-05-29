<?php

namespace app\cityController;

require_once __DIR__ . '\baseController.php';
require_once __DIR__ . '\..\models\baseModel.php';
use app\baseController\BaseController;
use app\baseModel\BaseModel;

class CityController extends BaseController
{
    public function get_all()
    {
        $baseModel=new BaseModel();
        $data=$baseModel->get_all('cities','name');
        $cities=[];
        foreach ($data as $val)
            $cities[]=$val['name'];
        return $cities;
    }
}