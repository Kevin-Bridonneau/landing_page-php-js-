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
            return json_encode(['msg'=>'Error : invalid credentials']);
        }
        else{
            $firstname = $body->firstname;
            $lastname = $body->firstname;
            $type = $body->type;
            $email = $body->email;
            $birth = $body->birth;
            $phone = $body->phone;
            $country = $body->country;
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        if(!$this->checkIp($ip)){
            http_response_code(400);
            return json_encode(['msg'=>'Error spam detected: you have already created an acount with this IP : '.$ip]);
        }

        if(!$this->validateEmail($email)){
            http_response_code(400);
            return json_encode(['msg'=>'Error : invalid Email']);
        }

        if(!$this->validateAge($age)){
            http_response_code(400);
            return json_encode(['msg'=>'Error : you cannot register if you are a minor.']);
        }

        if(!$this->validatePhone($phone)){
            http_response_code(400);
            return json_encode(['msg'=>'Error : we need a french phone number.']);
        }

        if(!$this->validateName($name)){
            http_response_code(400);
            return json_encode(['msg'=>'Error : we need a name.']);
        }

        $db = $this->_db->dbConnection();
        $sql = "INSERT INTO users (name, email, phone, age, ip, date)
                VALUE ('$name', '$email', '$phone','$age','$ip',NOW())";
        $db->exec($sql);

        http_response_code(200);
        return json_encode(['msg'=>'User '.$name.' created !']);
    }

    function checkBody($body){
        if(isset($body->name)&&isset($body->email)&&isset($body->phone)&&isset($body->age)){
            return true;
        }
        return false;
    }

    function validateName($name){
        if(preg_match('/^[A-Z][A-Za-z\é\è\ê\-]+$/', $name, $matches, PREG_OFFSET_CAPTURE)){
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

    function validateAge($age){
        if($age < 18){
            return false;
        }
        return true;
    }

    function checkIp($ip){
        $users = json_decode($this->getAll());
        foreach ($users as &$user) {
            if($user->ip == $ip){
                $now = new DateTime();
                $origin = new DateTime($user->date);
                $interval = date_diff($origin, $now);
                if($interval->d == 0){
                    return false;
                }
            }
        }
        return true;
    }
    
}

