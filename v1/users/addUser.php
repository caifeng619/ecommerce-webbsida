<?php
include("../../config/database_handler.php");
include("../../objects/users.php");

// Instantiate user object
$userObj = new User($databaseHandler);


if(!empty($_POST)){

    print_r($userObj->addUser($_POST['username'], $_POST['password1'], $_POST['password2'], $_POST['email']));

}else{

    echo json_encode(
        array('message'=>'form is empty.')
    );
}
?>