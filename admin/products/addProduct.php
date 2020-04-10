<?php
include("../../config/database_handler.php");
include("../../objects/users.php");
include("../../objects/products.php");
include("../../config/file_conf.php");
include("../../objects/files.php");
include("validation.php");

$productObj = new Product($databaseHandler, $upload_folder);

if(isset($_POST['submit'])){
    //  add product in database
    if(!empty($_POST['name'])){

        if(!empty($_POST['price'])){

            if(!empty($_FILES['file_to_upload'])){

                $result=json_decode($productObj->addProduct($_POST['name'], $_POST['price'], $_FILES['file_to_upload']), true);
                
                echo $result['state']."<br>";
                
                echo '<a href="../index.php?token='.$token.'&page=getProducts">Go back>></a>';

            }else{
                $retObject->error="Error! Image is missing!";
                $retObject->errorCode="1334";
                echo json_encode($retObject);
            }

        }else{

            $retObject->error="Invalid product price!";
            $retObject->errorCode="1336";
            echo json_encode($retObject);
        }
                
    }else{
        $retObject->error="Invalid product name!";
        $retObject->errorCode="1337";
        echo json_encode($retObject);
    }
}


?>
