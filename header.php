<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        if (empty($title)) {
            echo "Sunglasses webshop";
        } else echo $title;
        ?>
    </title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style.css?<?php echo time(); ?>">
    <script src="app.js" defer></script>
</head>

<body>
    <!-- start of nav bar -->
    <nav>
        <div class="logo">
            <h1>Sunglasses</h1>
        </div>
        <ul class="nav-links">
            <?php
                if(isset($_GET['token'])){
                    echo '<li><a href="index.php?token='.$_GET['token'].'">Home</a></li>';
                }else{
                    echo '<li><a href="index.php">Home</a></li>';
                }
            ?>
            
        </ul>
        <ul class="customer-links">        
            <li>
                <?php
                if(isset($_GET['token'])){
                    echo '<a href="index.php?page=login&token='.$_GET['token'].'"><i class=\"fas fa-user\"></i>Login/Sign up</a>'; 
                }else{
                    echo '<a href="index.php?page=login"><i class=\"fas fa-user\"></i>Login/Sign up</a>'; 
                }
                ?>
            </li>
            <div class="popup">
                <li onclick="showPopup()"><i class="fas fa-cart-plus"></i>Cart</li>
                <div class="popup-cart" id="myPopup">
                    <?php include("v1/shoppingcart/getCart.php");?>
                </div>
                <span class="num">
                    <?php include("v1/shoppingcart/countItemsInCart.php") ;?> 
                </span>
            </div>
            <script>
                // When the user clicks on cart, open the popup
                function showPopup() {
                    var myPopup = document.getElementById("myPopup");
                    myPopup.classList.toggle("show");
                }
            </script>
        </ul>
    </nav>