
<?php
function componentWithToken($productid, $productname, $productprice, $productimg, $token){
    $element = "
                <form action=\"http://localhost:1234/sunglasses/v1/shoppingcart/addItemToCart.php?token=$token\" method=\"post\">
                    <div class=\"card shadow h-100\">
                        <div>
                            <img src=\"uploads/$productimg\" alt=\"Image1\" class=\"img-fluid card-img-top\">
                        </div>
                        <div class=\"card-body\">
                            <h5 class=\"card-title\">$productname</h5>
                            <h5>
                                <span class=\"price\">$productprice kr</span>
                            </h5>

                            <button type=\"submit\" class=\"btn btn-secondary my-3\" name=\"add\">Add to Cart <i class=\"fas fa-shopping-cart\"></i></button>
                             <input type='hidden' name='product_id' value='$productid'>
                             <input type='hidden' name='token' value='$token'>
                        </div>
                    </div>
                </form>
    ";
    echo $element;
}

function component($productid, $productname, $productprice, $productimg){
    $element = "
                <form action=\"http://localhost:1234/sunglasses/v1/shoppingcart/addItemToCart.php\" method=\"post\">
                    <div class=\"card shadow h-100\">
                        <div>
                            <img src=\"uploads/$productimg\" alt=\"Image1\" class=\"img-fluid card-img-top\">
                        </div>
                        <div class=\"card-body\">
                            <h5 class=\"card-title\">$productname</h5>
                            <h5>
                                <span class=\"price\">$productprice kr</span>
                            </h5>

                            <button type=\"submit\" class=\"btn btn-secondary my-3\" name=\"add\">Add to Cart <i class=\"fas fa-shopping-cart\"></i></button>
                             <input type='hidden' name='product_id' value='$productid'>
                        </div>
                    </div>
                </form>
    ";
    echo $element;
}

function cartElement($productid, $productname, $productprice, $quantity, $token)
{
    $element = "
            <form action=\"http://localhost:1234/sunglasses/v1/shoppingcart/changeQuantityOfItem.php?token=".$token."\" method=\"post\">
                <div class=\"cart-item\">
                        <span class=\"cart-item-title\">$productname</span>
                        <span class=\"cart-price\">$productprice kr</span>
                        <input type='submit' name='minus' value='-'>
                        <span class=\"cart-price\"> $quantity </span>
                        <input type='submit' name='plus' value='+'>
                        <input type='hidden' name='id' value='$productid'>
                        <input type='hidden' name='token' value='$token'>
                    </div>
            </form>
";
    echo $element;
}

function tableContent($id, $name, $price, $token){
    $element=" <tr>
                  <th scope=\"row\">$id</th>
                  <td>$name</td>
                  <td>$price</td>
                  <td><a href=\"index.php?token=$token&action=update&id=$id&name=$name&price=$price\">update</a></td>
                  <td><a href=\"products/deleteProduct.php?token=$token&action=delete&id=$id\">delete</a></td>
              </tr>";
  echo $element;
  }
?>