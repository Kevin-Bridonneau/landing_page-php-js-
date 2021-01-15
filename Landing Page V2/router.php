 <?php
/**
 * Router for create new user
 * 
 */
require 'config.php';
require 'User.php';
require 'Db.php';



/**
 * 
 * check if all credentials exist
 */
function checkCredentials(){
    if(
        isset($_POST['firstname']) &&
        isset($_POST['lastname']) &&
        isset($_POST['gender']) &&
        isset($_POST['email']) &&
        isset($_POST['birth']) &&
        isset($_POST['phone']) &&
        isset($_POST['country']) &&
        isset($_POST['question'])){
        return true;
    }
    return false;
}

/**
 * 
 *      Routing to Users Controller to try to create new User or update
 */
if(checkCredentials()){
    /**
     * create database connector objet
     */
    $db = new Db(DB_HOST,DB_PORT,DB_DATABASE,DB_USERNAME,DB_PASSWORD);
    /**
     * 
     * create User controller object with database connector
     */
    $user = new User($db);
    /**
     * 
     * try to create new user or update
     */
    $user->createUser($_POST['firstname'], $_POST['lastname'] , $_POST['gender'], $_POST['email'], $_POST['birth'], $_POST['phone'], $_POST['country'], $_POST['question']);
}
else{

    /**
     * If invalid credential return to index with msg
     */
    $_SESSION['msg'] =  "Error : Invalid Credential";
    header('Status: 400 Invalid Credential', false, 400);      
    header('Location: index.php');
    exit();
}