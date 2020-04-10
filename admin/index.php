<?php
include("../config/database_handler.php");
include("../objects/products.php");
include("../objects/users.php");
include("../config/file_conf.php");
include("../objects/files.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css?<?php echo time(); ?>">
</head>

<body>

    <?php
    $userObj= new User($databaseHandler);
    if(!empty($_GET['token'])){

        $token=$_GET['token'];
    
        if($userObj->validateToken($token)===true){
           
            if($userObj->isUserAdmin($token)===true){

                include("adminPanel.php");

            }else{

                echo "<p class=\"error\">You are not admin!</p>";
                include("frontend/login.html");
            }
            
        }else{
            echo "<p class=\"error\">Token is invalid, please login in again!</p>";
            include("frontend/login.html");
        }

    }else{
        echo "<p class=\"error\">No token found, Login first!</p>";
        include("frontend/login.html");
    }
    ?>


</body>

</html>