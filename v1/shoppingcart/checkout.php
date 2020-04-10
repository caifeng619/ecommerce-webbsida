<?php
include("../../config/database_handler.php");
include("../../objects/users.php");
include("../../objects/carts.php");

// Instantiate User and Cart object
$userObj= new User($databaseHandler);
$cartObj=new Cart($databaseHandler);
$retObject = new stdClass;

// checkout
if(isset($_POST['checkout'])){

    if(!empty($_GET['token'])){

        $token=$_GET['token'];
    
        if($userObj->validateToken($token)===false){
    
            $retObject->error="Token is invalid!";
            $retObject->errorCode="1338";
            echo json_encode($retObject);
            die();
        }
    
        $cartObj->checkoutCart($_GET['token']);
        header("location: ../../index.php?page=checkout");
    
    }else{
        $retObject->error="No token found!";
        $retObject->errorCode="1339";
        echo json_encode($retObject);
    }
}


?>