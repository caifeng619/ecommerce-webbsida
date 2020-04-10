<?php
// include("../../config/database_handler.php");
// include("../../objects/users.php");
// include("../../objects/carts.php");

// Instantiate User and Cart object
$userObj = new User($databaseHandler);
$cartObj = new Cart($databaseHandler);
$retObject = new stdClass;
?>

<h2>Shopping cart</h2>
<hr>
<?php
$total=0;
if (!empty($_GET['token'])) {

    $token = $_GET['token'];

    if ($userObj->validateToken($token) === false) {

        $retObject->error = "Token is invalid!";
        $retObject->errorCode = "1338";
        echo json_encode($retObject);
        die();
    }

    $cart=$cartObj->fetchCart($_GET['token']);
    if(!empty($cart)){
        foreach($cart as $row){
            cartElement($row['id'], $row['name'], $row['price'], $row['quantity'], $token);
            $total=$row['total'];
        }
    }else{
        echo "<h5>Your cart is Empty</h5>";
    }
} else {
    echo "<h5>Your cart is Empty</h5>";
}
?>
<hr>
<div class="cart-bottom">
    <p>Total: <?php echo $total ?> kr</p>
    <form action="http://localhost:1234/sunglasses/v1/shoppingcart/checkout.php?token=<?php echo $token ?>" method="POST">
        <button class="btn-checkout" name="checkout">Checkout</button>
    </form>
</div>

