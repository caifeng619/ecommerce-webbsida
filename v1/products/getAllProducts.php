<?php
// include("../../config/database_handler.php");
// include("../../objects/products.php");
// include("../../config/file_conf.php");
// include("../../objects/files.php");

// Instantiate product object
$productObj = new Product($databaseHandler, $upload_folder);

if(isset($_GET['submit'])){

    if(!empty($_GET['search'])){

        $result=$productObj->searchProducts($_GET['search']);
    
    }else{
        $retObject->error="Error! Invalid search word!";
        $retObject->errorCode="1333";
        echo json_encode($retObject);
    }
}else{
    $result=$productObj->fetchAllProducts();
}

$order=isset($_GET['order'])? $_GET['order'] : '';

if(!empty($order)){

    $result=$productObj->sortProducts($_GET['order']);

}
?>


<div class="products-section">
    <div class="products">
    <?php
        if(isset($_GET['token']) && !empty($_GET['token'])){

            $token=$_GET['token'];

            foreach($result as $row){
                componentWithToken($row['id'], $row['name'], $row['price'], $row['image'], $token);
            }
        }else{

            foreach($result as $row){
                component($row['id'], $row['name'], $row['price'], $row['image']);
            }
        }
            
    ?>   
    </div>
</div>

    