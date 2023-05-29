<?php

namespace app\landController;
require_once __DIR__ . '\baseController.php';
require_once __DIR__ . '\..\models\landModel.php';

use app\baseController\BaseController;
use app\landModel\LandModel;

class LandController extends BaseController
{
    public function add()
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $type=$_POST['land-type'];
            $prod=$_POST['prod'];
            $profit=$_POST['profit'];
            if($prod <0 || $profit <0)
                echo "please enter a valid number";
            else
            {
                if(empty($type) || empty($prod) || empty($profit))
                    echo "you must fill all the fields";
                else
                {
                    $landModel=new LandModel();
                    $plant_id=$landModel->get_one('plants','id','type',$type);
                    $landModel->add($_SESSION['user']['id'],$prod,$profit,$plant_id[0]['id']);
                }
            }
        }
    }



}