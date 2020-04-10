<?php
// include("../../config/database_handler.php");
// include("../../objects/users.php");
// include("../../objects/carts.php");

// Instantiate User and Cart object
$userObj= new User($databaseHandler);
$cartObj=new Cart($databaseHandler);

$numOfProducts = 0;

if(!empty($_GET['token'])){

    $token=$_GET['token'];

    if($userObj->validateToken($token)===false){

        $retObject->error="Token is invalid!";
        $retObject->errorCode="1338";
        echo json_encode($retObject);
        die();

    }else{
        
        $return=$cartObj->countCart($token);
        echo $return;
    }
}else{
    echo $numOfProducts;
}
?>