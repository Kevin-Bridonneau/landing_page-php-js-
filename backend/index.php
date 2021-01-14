 <?php

/**
 * Router for create new user on /api/user and get all on /api/getAll
 * 
 */
require 'config.php';
require 'User.php';
require 'Db.php';

// Switch for rooting
$request = $_SERVER['REQUEST_URI'];
switch ($request) {
    case '/api/getAll' :
        $db = new Db(DB_HOST,DB_PORT,DB_DATABASE,DB_USERNAME,DB_PASSWORD);
        $user = new User($db);
        $msg = $user->getAll();
        echo $msg;
        break;
    case '/api/user' :
        $body = json_decode(file_get_contents('php://input'));
        $db = new Db('localhost','3306','gpbl','gpbl','gpbl');
        $user = new User($db);
        $msg = $user->createUser($body);
        echo $msg;
        break;
    default:
        http_response_code(404);
        echo "It's a backend api go away ! 404 not found";
        break;
}
