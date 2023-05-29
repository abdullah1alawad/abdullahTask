<?php
session_start();
const BASE_PATH = '/abdullahTask/';
$req=$_SERVER['REQUEST_URI'];

use app\userController\userController;
use app\cityController\CityController;
use app\familyController\FamilyController;
use app\landController\LandController;
use app\planController\PlantController;

switch ($req)
{
    case BASE_PATH :
        require_once __DIR__ . '\app\controllers\userController.php';
        $userController=new UserController();
        if(isset($_SESSION['user']['email']))
        {
            require_once __DIR__ . '\app\controllers\cityController.php';
            require_once __DIR__ . '\app\controllers\plantController.php';

            $cityController=new CityController();
            $inf1=$cityController->get_all();

            $plantController=new PlantController();
            $inf2=$plantController->get_type();

            $cityController->load_view('home',["city"=>$inf1,"type"=>$inf2]);
        }
        else
        {
            $userController->load_view('login',[]);
            $userController->login();
        }
        break;
    case BASE_PATH . 'register' :
        require_once __DIR__ . '\app\controllers\userController.php';
        $userController=new UserController();
        $userController->load_view('signup',[]);
        $userController->signup();
        break;
    case BASE_PATH . 'family-form':
        require_once __DIR__ . '\app\controllers\cityController.php';
        require_once __DIR__ . '\app\controllers\familyController.php';
        $cityController=new CityController();
        $inf=$cityController->get_all();
        $cityController->load_view('family-form',$inf);
        $familyController=new FamilyController();
        $familyController->add();
        break;
    case BASE_PATH . 'delete-family':
        require_once __DIR__ . '\app\controllers\familyController.php';
        $familyController=new FamilyController();
        $familyController->delete();
        break;
    case BASE_PATH . 'update-family':
        require_once __DIR__ . '\app\controllers\cityController.php';
        require_once __DIR__ . '\app\controllers\familyController.php';
        $cityController=new CityController();
        $inf=$cityController->get_all();
        $cityController->load_view('update',$inf);

        $familyController=new FamilyController();
        $familyController->update();
        break;
    case BASE_PATH . 'family-city':
        require_once __DIR__ . '\app\controllers\cityController.php';
        require_once __DIR__ . '\app\controllers\familyController.php';

        $cityController=new CityController();
        $city=$cityController->get_all();
        $cityController->load_view('chooseCity',$city);

        $familyController=new FamilyController();
        $familyController->getFamiliesCity();
        break;
    case BASE_PATH . 'add-land':
        require_once __DIR__ . '\app\controllers\plantController.php';
        $plantController=new PlantController();
        $inf=$plantController->get_type();
        $plantController->load_view('land-form',$inf);
        $plantController->add();
        break;
    case BASE_PATH . 'show-land':
        require_once __DIR__ . '\app\controllers\plantController.php';
        $plantController=new PlantController();
        $inf=$plantController->get_all();
        $plantController->load_view('show-land',$inf);
        break;
    case BASE_PATH . 'family-plant-type':
        require_once __DIR__ . '\app\controllers\plantController.php';
        require_once __DIR__ . '\app\controllers\familyController.php';
        $plantController=new PlantController();
        $inf=$plantController->get_type();
        $plantController->load_view('family-plant-type',$inf);
        $familyController=new FamilyController();
        $familyController->getFamiliesPlant();
        break;
    case BASE_PATH . 'family-productivity':
        require_once __DIR__ . '\app\controllers\familyController.php';
        $familyController=new FamilyController();
        $familyController->load_view('family-productivity',[]);
        $familyController->getFamiliesProduct();
        break;
    case BASE_PATH . 'family-profit':
        require_once __DIR__ . '\app\controllers\familyController.php';
        $familyController=new FamilyController();
        $familyController->load_view('familyProfit',[]);
        $familyController->getFamiliesProfit();
        break;
    case BASE_PATH . 'logout' :
        require_once 'function.php';
        require_once __DIR__ . '\app\controllers\userController.php';
        destroySession();
        $userController=new UserController();
        header('location:\abdullahTask\\');
        break;

}