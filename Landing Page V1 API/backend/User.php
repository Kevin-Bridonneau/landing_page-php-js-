<?php

/**
 * User Controller for create new user on /api/user and get all on /api/getAll
 * 
 */

class User{
    
    private $_db = null;

    public function __construct($db)
    {
        $this->_db = $db;
    }

    function getAll(){ 
        $db = $this->_db->dbConnection();
        $sql = 'SELECT * FROM users';
        $stmt = $db->query($sql);
        $rows = $stmt->fetchAll();
        return json_encode($rows);
    }
    
    function createUser($body){

        if(!$this->checkBody($body)){
            http_response_code(400);
            header("Access-Control-Allow-Origin: *");
            header('Content-Type: application/json');
            echo json_encode(['msg'=>'Error : invalid credentials']);
            exit();
        }
        else{
            $firstname = $body->firstname;
            $lastname = $body->firstname;
            $type = $body->type;
            $email = $body->email;
            $birth = $body->birth;
            $phone = $body->phone;
            $country = strtoupper($body->country);
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        if(!$this->checkIp($ip)){
            http_response_code(400);
            header("Access-Control-Allow-Origin: *");
            header('Content-Type: application/json');
            echo json_encode(['msg'=>'Error spam detected: you have already created an acount in last 24h with this IP : '.$ip]);
            exit();
        }

        if(!$this->validateEmail($email)){
            http_response_code(400);
            header("Access-Control-Allow-Origin: *");
            header('Content-Type: application/json');
            echo json_encode(['msg'=>'Error : invalid Email']);
            exit();
        }

        if(!$this->validateAge($birth)){
            http_response_code(400);
            header("Access-Control-Allow-Origin: *");
            header('Content-Type: application/json');
            echo json_encode(['msg'=>'Error : you cannot register if you are a minor.']);
            exit();
        }

        if(!$this->validatePhone($phone)){
            http_response_code(400);
            header("Access-Control-Allow-Origin: *");
            header('Content-Type: application/json');
            echo json_encode(['msg'=>'Error : we need a french phone number.']);
            exit();
        }

        if(!$this->validateName($firstname)){
            http_response_code(400);
            header("Access-Control-Allow-Origin: *");
            header('Content-Type: application/json');
            echo json_encode(['msg'=>'Error : invalid firstname.']);
            exit();
        }

        if(!$this->validateName($lastname)){
            http_response_code(400);
            header("Access-Control-Allow-Origin: *");
            header('Content-Type: application/json');
            echo json_encode(['msg'=>'Error : invalid lastname.']);
            exit();
        }


        $db = $this->_db->dbConnection();
        $u = $this->userExist($email);
        if($u != NULL){
            $u++;
            $sql = "UPDATE users SET updateAt = NOW(),counter = $u WHERE email = '$email'";
            $db->exec($sql);
            http_response_code(200);
            header("Access-Control-Allow-Origin: *");
            header('Content-Type: application/json');
            echo json_encode(['msg'=>'User '.$firstname.' '.$lastname.' Updated !']);
            exit();
        }

        $sql = "INSERT INTO users (firstname, lastname,type, email, birth, phone, country, IP, creatAt, updateAt,counter)
                VALUE ('$firstname','$lastname','$type', '$email','$birth', '$phone','$country','$ip',NOW(),NOW(),0)";
        $db->exec($sql);

        http_response_code(200);
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json');
        echo json_encode(['msg'=>'User '.$firstname.' '.$lastname.' created !']);
        exit();
    }

    function userExist($email){
        $users = json_decode($this->getAll());
        foreach ($users as &$user) {
            if($user->email == $email){
                return $user->counter;
            }
        }
        return NULL;
    }

    function checkBody($body){
        if(isset($body->firstname)&&isset($body->lastname)&&isset($body->type)&&isset($body->email)&&isset($body->birth)&&isset($body->phone)&&isset($body->country)){
            return true;
        }
        return false;
    }

    function validateName($name){
        if(preg_match('/^[a-zA-Z0-9_]{1,16}$/', $name, $matches, PREG_OFFSET_CAPTURE)){
            return true;
        }
        return false;
    }

    function validateEmail($email){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            return true;
        }
        else return false;
        
    }

    function validatePhone($phone){
        if(preg_match('/^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/', $phone, $matches, PREG_OFFSET_CAPTURE)){
            return true;
        }
        return false;
    }

    function validateAge($birth){
        $now = new DateTime();
        $birthDate = new DateTime($birth);
        $interval = date_diff($birthDate, $now);
        $age = $interval->y;
        if($age < 18){
            return false;
        }
        return true;
    }

    function checkIp($ip){
        $users = json_decode($this->getAll());
        foreach ($users as &$user) {
            if($user->IP == $ip){
                $now = new DateTime();
                $updateAt = new DateTime($user->updateAt);
                $interval = date_diff($updateAt, $now);
                if($interval->d == 0){
                    return false;
                }
            }
        }
        return true;
    }
    
}

