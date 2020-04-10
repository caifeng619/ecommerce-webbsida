<?php
header("Content-Type: application/json; charset=UTF-8");
include("../../config/database_handler.php");
include("../../objects/users.php");

// Instantiate user object
$userObj = new User($databaseHandler);
$returnObj = new stdClass;

$result=json_decode($userObj->userLogin($_POST['username'], $_POST['password']), true);

$token=$result['token'];

if($userObj->isUserAdmin($token)==false){
    echo "You are note admin!";
    include("../frontend/login.html");
    
}else{
    header("location:../index.php?token=$token");
}
?>