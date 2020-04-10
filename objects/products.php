<?php

class Product{

    private $database_handler;
    private $upload_folder;


    public function __construct($database_handler, $upload_folder)
    {
        $this->database_handler=$database_handler;
        $this->upload_folder=$upload_folder;
    }


    public function addProduct($name, $price, $image){

        $returnObj= new stdClass();
        $fileObj= new Files($this->upload_folder);

        $image_name=$fileObj->uploadFile($image);

        if($image_name==false){
            echo $image_name;
            die;
        }else{

            if($this->isProductExist($name, $price)===false){

                $return=$this->insertProductToDatabase($name, $price, $image_name);
    
                if(!empty($return)){
                    $returnObj->state="Success";
                    $returnObj->product=$return;
                }else{
                    $returnObj->state="Error";
                    $returnObj->message="Someting went wrong when trying to insert product.";
                }
    
            }else{
                $returnObj->state="Error";
                $returnObj->message="Product already exists!";
            }
    
            return json_encode($returnObj);

        }

        

    }

    public function isProductExist($name, $price){

        $sql="SELECT count(id) from products where name=:name and price=:price";
        $stmt=$this->database_handler->prepare($sql);

        if($stmt !== false){

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->execute();

            $numOfProduct=$stmt->fetch()[0];
            
            if($numOfProduct>0){
                return true;
            }else{
                return false;
            }

        }else{
            echo "Statementhandler epic fail!";
            die();

        }
    }

    public function insertProductToDatabase($name, $price, $image_name){

        $sql="INSERT INTO products(name, price, image) values(:name, :price, :image)";
        $stmt=$this->database_handler->prepare($sql);

        if($stmt !== false){

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':image', $image_name);
            $stmt->execute();

            $last_insert_id=$this->database_handler->lastInsertId();
            $sql="SELECT name, price, image from products where id=:last_insert_id";
            $stmt=$this->database_handler->prepare($sql);

            $stmt->bindParam(':last_insert_id', $last_insert_id);
            $stmt->execute();
            return $stmt->fetch();

        }else{
            echo "Could not crate statement handler.";
            die();
        }

    }

    public function fetchAllProducts(){

        $sql="SELECT id, name, price, image from products";
        $stmt=$this->database_handler->prepare($sql);
        if($stmt !== false){

            $stmt->execute();
            $result=$stmt->fetchAll();
            if(!empty($result)){
                return $result;
            }else{
                echo "No products.";
                die();
            }
        }else{
            echo "Could not crate statement handler.";
            die();
        }
    }

    public function fetchSingleProduct($product_id){

        $sql="SELECT id, name, price, image from products where id=:product_id";
        $stmt=$this->database_handler->prepare($sql);

        if($stmt !== false){

            $stmt->bindParam(':product_id', $product_id);
            $stmt->execute();
            return $stmt->fetch();
    
        }else{
            echo "Could not crate statement handler.";
            die();
        }
    }

    public function updateProduct($name, $price, $image, $product_id){
        
        if(!empty($name)){
            $sql="UPDATE products set name=:name where id=:product_id";
            $stmt=$this->database_handler->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->execute();
        }
        

        if(!empty($price)){
            $sql="UPDATE products set price=:price where id=:product_id";
            $stmt=$this->database_handler->prepare($sql);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->execute();
        }

        if(!empty($image['name'])){

            $fileObj= new Files($this->upload_folder);
            $image_name=$fileObj->uploadFile($image);
            if($image_name==false){
                echo $image_name;
                die;
            }else{
                $sql="UPDATE products set image=:image_name where id=:product_id";
                $stmt=$this->database_handler->prepare($sql);
                $stmt->bindParam(':image_name', $image_name);
                $stmt->bindParam(':product_id', $product_id);
                $stmt->execute();
            }
        
        }

        $sql="SELECT id, name, price, image from products where id=:product_id";
        $stmt=$this->database_handler->prepare($sql);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        $return=$stmt->fetch();

        echo json_encode($return);

    }

    public function deleteProduct($product_id){

        $sql="DELETE from products where id=:product_id";
        $stmt=$this->database_handler->prepare($sql);

        if($stmt!==false){
            $stmt->bindParam(':product_id', $product_id);
            $return=$stmt->execute();
            if(!$return){
                print_r($this->database_handler->errorInfo());
            }else{
                echo json_encode(array('state'=>'Success'));
            }
        }else{
            echo "Could not create statement handler";
        }
        
    }

    public function searchProducts($search){

        $sql="SELECT id, name, price, image FROM products where name like :search";
        $stmt=$this->database_handler->prepare($sql);

        if($stmt!==false){
            $queryParam='%'.$search.'%';
            $stmt->bindParam(':search', $queryParam);
            $stmt->execute();
            $return=$stmt->fetchAll();

            if(!empty($return)){

                return $return;

            }else{
                echo "No products.";
                die();
            }

        }else{
            echo "Could not create statement handler";
        }
    }

    public function sortProducts($order){
        $sql="SELECT id, name, price, image FROM products order by price $order";
        $stmt=$this->database_handler->prepare($sql);

        if($stmt!==false){
            $stmt->execute();
            $return=$stmt->fetchAll(PDO::FETCH_ASSOC);

            if(!empty($return)){

                return $return;

            }else{

                echo "No products.";
                die();
            }

        }else{
            echo "Could not create statement handler";
        }
    }
    



}


?>