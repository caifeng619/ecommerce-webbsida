<?php
include("config/database_handler.php");
include("config/file_conf.php");
include("objects/files.php");
include("objects/products.php");
include("objects/users.php");
include("objects/carts.php");
include("frontend/component.php");


include("header.php");


$page = (isset($_GET['page']) ? $_GET['page'] : '');

if($page=="login"){
    include("frontend/login.html");
}elseif($page=="signup"){
    include("frontend/register.html");
}elseif($page=="checkout"){
    include("frontend/checkout.html");
}else{
    include("frontend/searchform.php");
    include("frontend/sort.php");
    include("v1/products/getAllProducts.php");
}
?>



<?php
include("footer.php")
?>

</body>
</html>