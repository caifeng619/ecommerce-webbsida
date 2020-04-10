<?php
include("../../config/database_handler.php");
include("../../objects/users.php");
include("../../objects/carts.php");

// Instantiate User and Cart object
$userObj= new User($databaseHandler);
$cartObj=new Cart($databaseHandler);
$retObject = new stdClass;
  
if(!empty($_POST['token'])){

    $token=$_POST['token'];

    if($userObj->validateToken($token)===false){

        $retObject->error="Token is invalid!";
        $retObject->errorCode="1338";
        echo json_encode($retObject);
        die();

    }else{
        if(isset($_POST['plus'])){
    
            // increase quantity of the item
            if(!empty($_POST['id'])){
        
                $cartObj->addItem($_POST['id'], $_POST['token']);
                header("location: ../../index.php?token=$token");
        
            }else{
                $retObject->error="Invalid product id!";
                $retObject->errorCode="1336";
                echo json_encode($retObject);
            }  
        }

        if(isset($_POST['minus'])){

            // decrease quantity of the item
            if(!empty($_POST['id'])){

                $cartObj->removeItem($_POST['id'], $_POST['token']);
                header("location: ../../index.php?token=$token");

            }else{
            $retObject->error="Invalid product id!";
            $retObject->errorCode="1336";
            echo json_encode($retObject);
            }
        }
    }

}else{
    $retObject->error="No token found!";
    $retObject->errorCode="1339";
    echo json_encode($retObject);
}
?>