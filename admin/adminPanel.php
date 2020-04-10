<h1 class="banner">Admin panel</h1>
<div class="nav">
    <ul class="nav-links">
        <?php
            echo '<li><a href="index.php?token='.$token.'&page=getProducts">Products lists</a></li>';
            echo '<li><a href="index.php?token='.$token.'&page=add">Add new product</a></li>';
        ?>
    </ul>
</div>
<div>
    <?php
    if(isset($_GET['action']) && $_GET['action']=="update"){
        include("frontend/updateProductForm.php");
    }else{
        $page = (isset($_GET['page']) ? $_GET['page'] : '');

        if($page=="add"){
            include("frontend/addProductForm.php"); 
        }elseif($page="getProducts"){
            include("products/getAllProducts.php"); 
        }else{
            include("products/getAllProducts.php");
        }
    }
    ?>
</div>