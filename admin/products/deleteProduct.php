<?php
include("../../config/database_handler.php");
include("../../objects/users.php");
include("../../objects/products.php");
include("../../config/file_conf.php");
include("../../objects/files.php");
include("validation.php");

$productObj = new Product($databaseHandler, $upload_folder);
// delete product
if(!empty($_GET['id'])){

    $productObj->deleteProduct($_GET['id']);
    
    header("location:../index.php?token=$token");
    
}else{
    $retObject->error="Invalid product id!";
    $retObject->errorCode="1336";
    echo json_encode($retObject);
}


?>