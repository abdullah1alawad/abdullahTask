<?php

namespace app\userController;

require_once __DIR__ . '\..\..\function.php';
require_once __DIR__ . '\baseController.php';
require_once __DIR__ . '\..\models\userModel.php';
require_once __DIR__ . '\..\models\adminModel.php';

use app\baseModel\BaseModel;
use app\userModel\UserModel;
use app\baseController\BaseController;
use app\adminModel\AdminModel;

class UserController extends BaseController
{
    public function login()
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $email=validEmail($_POST['email']);
            $password=validString($_POST['password']);

            $userModel=new UserModel();
            $user=$userModel->get_one('users','*','email',$email);

            if(empty($email) || empty($password))
                echo "you must fill all the fields <br>";

            else if(!$user)
                echo "you must signup <br>";

            else
            {
                if(!password_verify($password,$user[0]['password']))
                    echo "wrong password <br>";
                else
                {
                    $q=0;
                    $adminModel=new AdminModel();
                    $data = $adminModel->checkAdmin($user[0]['id']);
                    if($data)
                        $q=1;
                    session_start();
                    $_SESSION['user'] = [
                        'id'=>$user[0]['id'],
                        'name' => $user[0]['name'],
                        'email' => $email,
                        'admin' => $q
                    ];
                    header('location:\abdullahTask\\');
                }
            }
        }
    }
    //---------------------------------------------------------
    public function signup()
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $name=validString($_POST['name']);
            $email=validEmail($_POST['email']);
            $checkPassword=validPassword($_POST['password']);

            if(empty($name) || empty($email) || empty($checkPassword))
                echo "you must fill all the fields <br>";
            else
            {
                $userModel = new UserModel();
                $user = $userModel->get_one('users', '*', 'email', $email);
                if($user)
                    echo "this user already exist <br>";
                else
                {
                    if ($checkPassword[0]==0)
                        echo $checkPassword[1] . '<br>';
                    else
                    {
                        $password = $checkPassword[1];
                        $userModel=new UserModel();
                        $userModel->add($name,$email,$password);

                        $_POST['password']=$_POST['email']=$_POST['password']=null;
                        header('location:\abdullahTask\\');
                    }
                }
            }
        }
    }
}