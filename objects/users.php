<?php

class User{

    private $database_handler;
    private $token_validity_time=60;//min

    public function __construct($database_handler)
    {
        $this->database_handler=$database_handler;
    }

    public function addUser($username, $password1, $password2, $email){

        $returnObj= new stdClass();

        if($this->isUsernameTaken($username) === false){

            if($this->isEmailValid($email) === true){

                if($this->isEmailTaken($email)===false){

                    if($this->isPasswordMatched($password1, $password2)===true){

                        $return=$this->insertUserToDatabase($username, $password1, $email);

                        if($return!==false){
                            $returnObj->state="SUCCESS";
                            $returnObj->user=$return;
                        }else{
                            $returnObj->state="Error";
                            $returnObj->message='Someting went wrong when trying to insert user.';
                        }

                    }else{
                        $returnObj->state="Error";
                        $returnObj->message="Password are not matched";
                    }

                }else{
                    $returnObj->state="Error";
                    $returnObj->message="Email is taken.";
                }
            }else{
                $returnObj->state="Error";
                $returnObj->message="Invalid email format.";
            }

        }else{
            $returnObj->state="Error";
            $returnObj->message="Username is taken.";
        }

        return json_encode($returnObj);

    }

    public function insertUserToDatabase($username, $password, $email){

        $sql="INSERT INTO users(username, password, email) values(:username, :password, :email)";
        $stmt=$this->database_handler->prepare($sql);

        $password=md5($password);
        if($stmt!==false){

            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':email', $email);

            $stmt->execute();

            $last_insert_id=$this->database_handler->lastInsertId();

            $sql="SELECT id, username, email from users where id=:last_insert_id";
            $stmt=$this->database_handler->prepare($sql);
            if($stmt !==false ){
                $stmt->bindParam(':last_insert_id', $last_insert_id);
                $stmt->execute();

                return $stmt->fetch();

            }else{
                echo json_encode(
                    array('message'=>'Could not create statement handler.'));
            }


        }else{
           return false;
        }

        
    }

    public function isUsernameTaken($username){
        $sql="SELECT id from users where username=:username";
        $stmt=$this->database_handler->prepare($sql);

        if($stmt !== false){

            $stmt->bindParam(':username',$username);
            $stmt->execute();

            if(empty($stmt->fetch())){

                return false;
            }else{

                return true;
            }


        }else{
            echo "Could not create statement handler";
        }
    }

    public function isEmailTaken($email){

        $sql="SELECT id from users where email=:email";
        $stmt=$this->database_handler->prepare($sql);

        if($stmt !== false){

            $stmt->bindParam(':email',$email);
            $stmt->execute();

            if(empty($stmt->fetch())){

                return false;
            }else{

                return true;
            }


        }else{
            echo "Could not create statement handler";
        }
    }

    public function isEmailValid($email){

        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            
            return true;

        }else return false;

    }

    public function isPasswordMatched($password1, $password2){

        if($password1 === $password2){
            return true;
        }else return false;
    }

    public function userLogin($username, $password){
        $returnObj= new stdClass();
        $sql="SELECT id, username from users where username=:username and password=:password";
        $stmt=$this->database_handler->prepare($sql);

        if($stmt!==false){

            $password=md5($password);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            $return=$stmt->fetch();
            
            if(!empty($return)){

                $token=$this->checkToken($return['id']);
                $returnObj->token=$token;
            }else{
                $returnObj->message="fel login";
            }

        }else{
            $returnObj->message="Could not create statement handler";
        }

        return json_encode($returnObj);
    }

    public function createToken($id){
        $uniqtoken=md5(uniqid().time());
        $sql="INSERT INTO tokens(token, userId) values(:uniqtoken, :id)";
        $stmt=$this->database_handler->prepare($sql);

        if($stmt!==false){

            $stmt->bindParam(':uniqtoken', $uniqtoken);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return $uniqtoken;

        }else{
            echo "Could not create statement handler";
        }
    }

    public function checkToken($id){

        $sql="SELECT token, updated_date from tokens where userId=:id";
        $stmt=$this->database_handler->prepare($sql);
        if($stmt!==false){

            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $return=$stmt->fetch();

            if(!empty($return)){

                $token_timestamp=strtotime($return['updated_date']);
                $diff=time()-$token_timestamp;

                if(($diff / 60) < $this->token_validity_time){
    
                    $token=$return['token'];
    
                }else{

                    $sql="DELETE FROM tokens where userid=:id";
                    $stmt=$this->database_handler->prepare($sql);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();

                    $token=$this->createToken($id);
                }            
            }else{
                $token=$this->createToken($id);
            }
            return $token;

        }else{
            echo "Could not create statement handler";
        }

    }

    public function validateToken($token){

        $sql="SELECT userId, token, updated_date from tokens where token=:token";
        $stmt=$this->database_handler->prepare($sql);

        if($stmt!==false){

            $stmt->bindParam(':token', $token);
            $stmt->execute();
            $result=$stmt->fetch();

            if(!empty($result)){
                
                $diff=time()-strtotime($result['updated_date']);
    
                if($diff/60 < $this->token_validity_time){
                    $updated_date=date("Y-m-d H:I:s");
                    $sql="UPDATE tokens set updated_date=:updated_date where token=:token";
                    $stmt=$this->database_handler->prepare($sql);
                    $stmt->bindParam(':token', $token);
                    $stmt->bindParam(':updated_date', $updated_date);
                    $stmt->execute();
                    return true;
                    
                }else{
                    return false;
                }
    
            }else{
                echo "Could not find token, please login first<br>";
                return false;
            }
            
        }else{
            echo "Could not create statement handler";
            return false;
        }
       

    }

    private function getUserData($token){
        $sql="SELECT u.id, u.username, u.email, u.admin from users u 
        inner join tokens t on u.id=t.userid where t.token=:token";
        $stmt=$this->database_handler->prepare($sql);

        if($stmt!==false){
            $stmt->bindParam(':token', $token);
            $stmt->execute();
            $result=$stmt->fetch();

            if(!empty($result)){

                return $result;
            }else{
                return false;
            }

        }else{
            echo "Could not create statement handler";
            return false;
        }
    }


    public function isUserAdmin($token){

            $user_data=$this->getUserData($token);
            // admin=1 means it's a admin account. admin = 0 means it's an normal user account
            if($user_data['admin']==1){
                return true;
            }else{
                return false;
            }
    }

}

?>