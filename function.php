<?php
function validString($variable)
{
    return trim(filter_var($variable,FILTER_SANITIZE_STRING));
}
function validEmail($variable)
{
    return trim(filter_var($variable,FILTER_SANITIZE_EMAIL));
}

function validNumber($variable)
{
    if($variable>0&&$variable<100)
        return $variable;
    return 0;
}

function validPassword($variable)
{
    $variable=validString($variable);
    if(strlen($variable)<8)
        return [0,"password must be more than 7 chars"];
    $containLetter=preg_match("/[a-zA-z]/",$variable);
    $containNum=preg_match('/[0-9]/',$variable);
    if(!$containLetter || !$containNum)
        return [0,"password must contain at least one letter and one number"];

    return [1,password_hash($variable,PASSWORD_DEFAULT)];

}

function validImg($a)
{
    $res=[];
    $error="";
    $tar="../images/";
    $path=uniqid($tar) . basename($a['name']);
    $q=1;
    $ext = strtolower(pathinfo($path,PATHINFO_EXTENSION));

    $check = getimagesize($a['tmp_name']);
    if($check===false)
    {
        $error="this is not an img";
        $q=0;
    }
    if(file_exists($path))
    {
        $error="this file already exist";
        $q=0;
    }
    if($a['size']>10000000)
    {
        $error="this img is too larg";
        $q=0;
    }
    if($ext!="jpg" && $ext!="png" && $ext!="jpeg")
    {
        $error="we dont support this ext" . " $ext";
        $q=0;
    }
    if(!$q)
        $res=[$q,$error];
    else
    {
        if(!move_uploaded_file($a['tmp_name'],$path))
        {
            $error="some thing went wrong";
            $q=0;
            $res=[$q,$error,$path];
        }
        else
            $res=[$q,$path];
    }
    return $res;     
}

spl_autoload_register('autoLoader');

function autoLoader($className)
{
    //$path="mvcDesignSignup&Login/";
    $path="";
    $ext=".class.php";
    $classNameLower=$className;
    $fullPath=$path.$classNameLower.$ext;
    if(file_exists($fullPath))
        include_once $fullPath;
}

function destroySession()
{
    $_SESSION=array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time()-2592000, '/');

    session_destroy();
}