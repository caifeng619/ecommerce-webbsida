<?php
// Instantiate product object
$userObj= new User($databaseHandler);
$retObject = new stdClass;

// if the token is empty or if the token is invalid, then the user cannot add product
if(!empty($_GET['token'])){

    $token=$_GET['token'];

    if($userObj->validateToken($token)===false){
    
        $retObject->error="Token is invalid!";
        $retObject->errorCode="1338";
        echo json_encode($retObject);
        die();
    }
}else{
    $retObject->error="No token found!";
    $retObject->errorCode="1339";

    echo json_encode($retObject);
}


// check if the user is admin
if($userObj->isUserAdmin($token)===false){
    $retObject->error="You are not admin!";
    $retObject->errorCode="1400";
    echo json_encode($retObject);
    die;     
}else{
    return true;
}
    
?>