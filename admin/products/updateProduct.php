<?php
include("../../config/database_handler.php");
include("../../objects/products.php");
include("../../config/file_conf.php");
include("../../objects/files.php");
include("../../objects/users.php");

// Instantiate product object
$productObj = new Product($databaseHandler, $upload_folder);
$userObj= new User($databaseHandler);
$retObject = new stdClass;

if(isset($_POST['submit'])){
    // if the token is empty or if the token is invalid, then the user cannot add product
    if(!empty($_GET['token'])){

        $token=$_GET['token'];

        if($userObj->validateToken($token)===false){
        
            $retObject->error="Token is invalid!";
            $retObject->errorCode="1338";
            echo json_encode($retObject);
            die();
        }
    }else{
        $retObject->error="No token found!";
        $retObject->errorCode="1339";

        echo json_encode($retObject);
    }


    // if the user is not admin, then the user cannot update product
    if($userObj->isUserAdmin($token)===false){
        $retObject->error="You are not admin!";
        $retObject->errorCode="1400";
        echo json_encode($retObject);
        die;
        
    }

    //  update product
    $name = ( isset($_POST['name']) ? $_POST['name'] : '' );
    $price = ( isset($_POST['price']) ? $_POST['price'] : '' );
    $image = ( isset($_FILES['file_to_upload']) ? $_FILES['file_to_upload'] : '' );
    $id = ( isset($_POST['id']) ? $_POST['id'] : '' );

    if(!empty($id)){

        $productObj->updateProduct($name, $price, $image, $id);
        header("location:../index.php?token=$token");
        
    }else{

        $retObject->error="Invalid product id!";
        $retObject->errorCode="1336";
        echo json_encode($retObject);
    }
}
?>