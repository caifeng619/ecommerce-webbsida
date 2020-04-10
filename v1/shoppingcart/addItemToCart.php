<?php
include("../../config/database_handler.php");
include("../../objects/users.php");
include("../../objects/carts.php");

// Instantiate User and Cart object
$userObj= new User($databaseHandler);
$cartObj=new Cart($databaseHandler);
$retObject = new stdClass;

if(!empty($_GET['token'])){

    $token=$_GET['token'];

    if($userObj->validateToken($token)===false){

        echo '<script>alert("Token is invalid!")</script>';

    }else{

        if(isset($_POST['add'])){
            // add Item to cart
            if(!empty($_POST['product_id'])){
        
                $cartObj->addItem($_POST['product_id'], $token);
                header("location: ../../index.php?token=$token");
        
            }else{
                $retObject->error="Invalid product id!";
                $retObject->errorCode="1336";
                echo json_encode($retObject);
            }  
        }
    }
}else{
   echo '<script>alert("You are not logged in!")</script>';
}
?>
