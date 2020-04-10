<?php

class Cart{

    private $database_handler;

    public function __construct($database_handler)
    {
        $this->database_handler=$database_handler;
    }

    private function getUserId($token){
        $sql="SELECT userid from tokens where token=:token";
        $stmt=$this->database_handler->prepare($sql);

        if($stmt!==false){
            $stmt->bindParam(':token', $token);
            $stmt->execute();
            $return=$stmt->fetch();

            if(!empty($return)){

                return $return['userid'];
            }else{

                return -1;
            }
            
        }else{
            echo "could not create statement handler";
            die();
        }
     
    }

    // add Item into Cart
    public function addItem($product_id, $token){

            $user_id=$this->getUserId($token);

            if($this->isCartEmpty($user_id)===false){

                $cart_id=$this->getCartId($user_id);

                if($this->isProductInCart($product_id, $user_id)===true){

                    $this->plusQuantity($product_id, $cart_id);

                }else{
                    $this->insertItemtoCartDetails($product_id, $cart_id);                  
                }
            }else{

                $this->insertItemToCart($product_id, $user_id);
            }

            $cart_id=$this->getCartId($user_id);

            $this->updateTotalAmount($cart_id);

            return $this->fetchCart($token);     
    }

    // Insert userid into carts table and product info into cartdetails table
    public function insertItemToCart($product_id, $user_id){
        // insert userid into carts tabel
        $sql="INSERT INTO carts(userid) values(:user_id)";
        $stmt=$this->database_handler->prepare($sql);

        if($stmt!==false){

            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            $last_insert_cartid=$this->database_handler->lastInsertId();
            $this->insertItemtoCartDetails($product_id, $last_insert_cartid);
           
        }else{
            echo "Could not create statement handler";
            die();
        }
    }

    // Insert product info into cartdetails table
    public function insertItemtoCartDetails($product_id, $cart_id){

        $sql="INSERT INTO cartdetails(productid, quantity, cartid) values(:productid, :quantity, :cart_id)";
        $stmt=$this->database_handler->prepare($sql);
        if($stmt!==false){
            $quantity=1;
            $stmt->bindParam(':productid', $product_id);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':cart_id', $cart_id);
            $stmt->execute();
        }else{
            echo "Could not create statement handler";
            die();
        }
    }

    public function fetchCart($token){
        $user_id=$this->getUserId($token);
        // fetch all the data from the cart
        $sql="SELECT p.id, p.name, p.price, p.image, cd.quantity, c.total from products p 
        inner join cartdetails cd on cd.productid=p.id
        inner join carts c on c.id=cd.cartid
        where c.userid=:user_id and c.checkout=0";
        $stmt=$this->database_handler->prepare($sql);

        if($stmt!==false){
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            $return=$stmt->fetchAll();

            return $return;
        }else{
            echo "could not create statement handler";
            die();
        }
    }

    public function countCart($token){
        $user_id=$this->getUserId($token);
        $sql="SELECT SUM(cd.quantity) from cartdetails cd inner join carts c on cd.cartid=c.id
        where c.userid=:user_id and c.checkout=0";
        $stmt=$this->database_handler->prepare($sql);

        if($stmt!==false){
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            $return=$stmt->fetch()[0];

            return $return;
        }else{
            echo "could not create statement handler";
            die();
        }
    }

    public function isCartEmpty($user_id){
        $sql="SELECT count(cd.productid) as numofproducts from cartdetails cd
              inner join carts c on cd.cartid=c.id
              where c.userid=:user_id and c.checkout=0";

        $stmt=$this->database_handler->prepare($sql);

        if($stmt!==false){
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            $return=$stmt->fetch();
        
            if($return['numofproducts']>0){

               return false;
            }
            else{
                return true;
            }

        }else{
            echo "could not create statement handler";
        }
    }

    public function isProductInCart($product_id, $user_id){

        $sql="SELECT productid from cartdetails
        inner join carts on cartdetails.cartid=carts.id 
        where userid=:user_id and checkout=0";
        $stmt=$this->database_handler->prepare($sql);

        if($stmt!==false){
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            $return=$stmt->fetchAll();
        
            $productid_array=array_column($return, "productid");
            
            if(in_array($product_id, $productid_array)){

                return true;
            }else{
                return false;
            }

        }else{
                echo "could not create statement handler";
                die();
        }

    }

    public function plusQuantity($product_id, $cart_id){
        $sql="UPDATE cartdetails set quantity=quantity+1 where productid=:product_id and
         cartid=:cart_id";
        $stmt=$this->database_handler->prepare($sql);

        if($stmt!==false){
            $stmt->bindParam(':product_id', $product_id);
            $stmt->bindParam(':cart_id', $cart_id);
            $stmt->execute();

        }else{
            echo "could not create statement handler";
            die();
        }
    }

    private function getCartId($user_id){
        // get cartid, that is which cart the user is adding products into
        $sql="SELECT id from carts where userid=:user_id and checkout=0";
        $stmt=$this->database_handler->prepare($sql);
        if($stmt!==false){
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            $return=$stmt->fetch();
            return $return['id'];
        }else{
            echo "could not create statement handler";
            die();
        }
     
    }
   
    public function updateTotalAmount($cart_id){
        // calculate total amount
        $sql="SELECT sum(p.price*c.quantity) as total from cartdetails c 
        inner join products p on c.productid=p.id
        where c.cartid=:cart_id";
        $stmt=$this->database_handler->prepare($sql);
        if($stmt!==false){
            $stmt->bindParam(':cart_id', $cart_id);
            $stmt->execute();
            $return=$stmt->fetch();

            // update total amount in carts table
            $total=$return['total'];
            $sql="UPDATE carts set total=:total where id=:id";
            $stmt=$this->database_handler->prepare($sql);
            $stmt->bindParam(':total', $total);
            $stmt->bindParam(':id', $cart_id);
            $stmt->execute();
        }else{
            echo "could not create statement handler";
            die();
        }
        
    }

    public function removeItem($product_id, $token){
       
        $user_id=$this->getUserId($token);
        $cart_id=$this->getCartId($user_id);
        $quantity=$this->getQantity($product_id, $cart_id);
        // if the quantity of the product in the cart is larger than 1, decrease the quantity
        if($quantity > 1 ){

            $this->minusQuantity($product_id, $cart_id);
            $this->updateTotalAmount($cart_id);

        }else{
            // otherwise delete product info from cartdetails table
            $this->deleteItemFromCartDetails($product_id, $cart_id);
        }

        if($this->isCartEmpty($user_id)===true){
            // if there is no item in the cart, delete cart info from carts table
            $this->deleteCart($cart_id);
        }

        // return $this->fetchCart($token);
    }


    private function getQantity($product_id, $cart_id){
        // count quantity of the product
        $sql="SELECT quantity from cartdetails
        where productid=:product_id and cartid=:cart_id";
        $stmt=$this->database_handler->prepare($sql);
        if($stmt!==false){
            $stmt->bindParam(':cart_id', $cart_id);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->execute();
            $return=$stmt->fetch();

            if (!empty($return)) {
                return $return[0];
            } else {
                return -1;
            }

        }else{
            echo "Could not create statement handler";
            die();
        }

    }

    public function deleteCart($cart_id){

        $sql="DELETE FROM carts where id=:cart_id";
        $stmt=$this->database_handler->prepare($sql);

        if($stmt!==false){
           
            $stmt->bindParam(':cart_id', $cart_id);
            $stmt->execute();
           
        }else{
            echo "Could not create statement handler";
            die();
        }
    }

    public function minusQuantity($product_id, $cart_id){
        $sql="UPDATE cartdetails set quantity=quantity-1 where productid=:product_id and
         cartid=:cart_id";
        $stmt=$this->database_handler->prepare($sql);

        if($stmt!==false){
            $stmt->bindParam(':product_id', $product_id);
            $stmt->bindParam(':cart_id', $cart_id);
            $stmt->execute();

        }else{
            echo "could not create statement handler";
            die();
        }
    }

    public function deleteItemFromCartDetails($product_id, $cart_id){

        $sql="DELETE FROM cartdetails where productid=:product_id and cartid=:cart_id";
        $stmt=$this->database_handler->prepare($sql);

        if($stmt!==false){
            
            $stmt->bindParam(':product_id', $product_id);
            $stmt->bindParam(':cart_id', $cart_id);
            $stmt->execute();

            $this->updateTotalAmount($cart_id);
        }else{
            echo "Could not create statement handler";
            die();
        }
        
    }

    public function checkoutCart($token){
        $retObject = new stdClass;
        $user_id=$this->getUserId($token);
        // update checkout status
        echo "checkout";
        $sql="UPDATE carts set checkout=1 where userid=:user_id and checkout=0";
        $stmt=$this->database_handler->prepare($sql);

        if($stmt!==false){
            $stmt->bindParam(':user_id', $user_id);
            $result=$stmt->execute();

            if($result==true){

                $retObject->status="Success";
                
            }else{
                $retObject->error="Error";
            }
            echo json_encode($retObject);
        }else{
            echo "Could not create statement handler";
            die();
        }
    }


}
