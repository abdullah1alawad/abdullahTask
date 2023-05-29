<?php

namespace app\familyController;

require_once __DIR__ . '\baseController.php';
require_once __DIR__ . '\..\models\familyModel.php';
require_once __DIR__ . '\..\..\function.php';
use app\baseController\BaseController;
use app\baseModel\BaseModel;
use app\familyModel\FamilyModel;

class FamilyController extends BaseController
{
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $full_name = validString($_POST['full-name']);
            $members = validNumber($_POST['members']);
            $phone = validString($_POST['phone']);
            $employee = $_POST['emp'];
            $city = $_POST['city'];

            if (empty($full_name) || empty($members) || empty($phone) || empty($employee))
                echo "you must fill all the fields";

            else {
                if ($members == false)
                    echo "you should put a number bigger than 0 and less than 100";
                else {
                    $familyModel = new FamilyModel();
                    $city_id = $familyModel->get_one('cities', 'id', 'name', $city);
                    $family = $familyModel->get_one('families', 'user_id', 'user_id', $_SESSION['user']['id']);
                    if ($family)
                        echo "you already have a family";
                    else {
                        $familyModel->add($_SESSION['user']['id'], $full_name, $members, $phone, $employee, $city_id[0]['id']);
                        $_SESSION['family'] = [
                            "full_name" => $full_name,
                            "members" => $members,
                            "phone" => $phone,
                            "employee" => $employee,
                            "city" => $city,
                            "city_id" => $city_id[0]['id']
                        ];
                        header('location:\abdullahTask\\');
                    }
                }
            }
        }
    }
    public function delete()
    {
        $familyModel=new FamilyModel();
        $familyModel->delete('families','user_id',$_SESSION['user']['id']);
        $_SESSION['family']=null;
        header('location:\abdullahTask\\');
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $full_name = validString($_POST['full-name']);
            $members = validNumber($_POST['members']);
            $phone = validString($_POST['phone']);
            $employee = $_POST['emp'];
            $city = $_POST['city'];

            if(empty($full_name))
                $full_name=$_SESSION['family']['full_name'];
            if(empty($members))
                $members=$_SESSION['family']['members'];
            if(empty($phone))
                $phone=$_SESSION['family']['phone'];
            if(empty($employee))
                $employee=$_SESSION['family']['employee'];

            else
            {
                    if ($members  == false)
                        echo "you should put a number bigger than 0 and less than 100";
                    else
                    {
                        $familyModel = new FamilyModel();
                        $city_id = $familyModel->get_one('cities', 'id', 'name', $city);
                        $familyModel->update($_SESSION['user']['id'], $full_name, $members, $phone, $employee, $city_id[0]['id']);
                        $_SESSION['family'] = [
                            "full_name" => $full_name,
                            "members" => $members,
                            "phone" => $phone,
                            "employee" => $employee,
                            "city" => $city,
                            "city_id" => $city_id[0]['id']
                        ];
                        header('location:\abdullahTask\\');
                    }
            }
        }
    }
    public function getFamiliesCity()
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $city = $_POST['city'];
            $familyModel = new FamilyModel();
            $city=$familyModel->get_one('cities','id','name',$city);
            $data = $familyModel->get_one('families', '*', 'city_id', $city[0]['id']);
            $family = [];
            $ind = 0;
            foreach ($data as $val) {
                $family[$ind][] = $val['full_name'];
                $family[$ind][] = $val['phone'];
                $ind++;
            }
            $this->load_view('show',$family);
        }
    }
    public function getFamiliesPlant()
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $plant = $_POST['type'];
            $familyModel = new FamilyModel();
            $plant_id=$familyModel->get_one('plants','id','type',$plant);
            $data = $familyModel->get_one('lands', 'user_id', 'plant_id', $plant_id[0]['id']);
            $family = [];
            $helpArr=[];
            $ind = 0;
            foreach ($data as $val)
                $helpArr[]=$val['user_id'];
            foreach ($helpArr as $val)
            {
                $x=$familyModel->get_one('families','*','user_id',$val);
                $family[$ind][]=$x[0]['full_name'];
                $family[$ind][]=$x[0]['phone'];
                $ind++;
            }
            $this->load_view('show',$family);
        }
    }

    public function getFamiliesProduct()
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $num = $_POST['num'];
            $familyModel = new FamilyModel();
            $data=$familyModel->greaterThan('lands','user_id','productivity',$num);
            $family =[];
            $helpArr=[];
            $ind = 0;
            foreach ($data as $val)
                $helpArr[]=$val['user_id'];
            foreach ($helpArr as $val)
            {
                $x=$familyModel->get_one('families','*','user_id',$val);
                $family[$ind][]=$x[0]['full_name'];
                $family[$ind][]=$x[0]['phone'];
                $ind++;
            }
            $this->load_view('show',$family);
        }
    }

    public function getFamiliesProfit()
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $num = $_POST['num'];
            $familyModel = new FamilyModel();
            $data=$familyModel->greaterThan('lands','user_id','profit',$num);
            $family =[];
            $helpArr=[];
            $ind = 0;
            foreach ($data as $val)
                $helpArr[]=$val['user_id'];
            foreach ($helpArr as $val)
            {
                $x=$familyModel->get_one('families','*','user_id',$val);
                $family[$ind][]=$x[0]['full_name'];
                $family[$ind][]=$x[0]['phone'];
                $ind++;
            }
            $this->load_view('show',$family);
        }
    }

}