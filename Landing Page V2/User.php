<?php
/**
 * User Controller for create new user
 * 
 */

class User{
    
    private $_db = null;

    public function __construct($db)
    {
        $this->_db = $db;
    }

    /**
     * 
     *  Return all users in database
     */
    function getAll(){ 
        $db = $this->_db->dbConnection();
        $sql = 'SELECT * FROM users';
        $stmt = $db->query($sql);
        $rows = $stmt->fetchAll();
        return json_encode($rows);
    }
    
    /**
     * 
     *  create or update one user if credential are comform and there was not any registering for the last 24hours
     */
    function createUser($firstname, $lastname, $type, $email, $birth, $phone, $country, $question){
        /**
         * Get CLIENT IP
         */
        $ip = $_SERVER['REMOTE_ADDR'];
        if(!$this->checkIp($ip)){
            session_destroy();
            session_start();
            $_SESSION['msg'] =  "Error : Spam detection you already subscrib in last 24h";
            header('Status: 400 SpamBot', false, 400);      
            header('Location: index.php');
            exit();
        }

        /**
         * 
         *  Launch all credentials validator
         */
        if(!$this->validateEmail($email)){
            session_destroy();
            session_start();
            $_SESSION['msg'] =  "Error : invalid Email";
            header('Status: 400 invalid Email', false, 400);      
            header('Location: index.php');
            exit();
        }

        if(!$this->validateAge($birth)){
            session_destroy();
            session_start();
            $_SESSION['msg'] =  "Error : you cannot register if you are a minor.";
            header('Status: 400 You\'r not an adult ', false, 400);      
            header('Location: index.php');
            exit();
        }

        if(!$this->validatePhone($phone)){
            session_destroy();
            session_start();
            $_SESSION['msg'] =  "Error : we need a french phone number.";
            header('Status: 400 invalid phone ', false, 400);      
            header('Location: index.php');
            exit();
        }

        if(!$this->validateName($firstname)){
            session_destroy();
            session_start();
            $_SESSION['msg'] =  "Error : invalid firstname.";
            header('Status: 400 invalid firstname ', false, 400);      
            header('Location: index.php');
            exit();
        }

        if(!$this->validateName($lastname)){
            session_destroy();
            session_start();
            $_SESSION['msg'] =  "Error : invalid lastname.";
            header('Status: 400 invalid lastname ', false, 400);      
            header('Location: index.php');
            exit();
        }

        if(!$this->validateQuestion($question)){
            session_destroy();
            session_start();
            $_SESSION['msg'] =  "Error : invalid question.";
            header('Status: 400 invalid question ', false, 400);      
            header('Location: index.php');
            exit();
        }


        /**
         * 
         * Get all users in the database and check if user already exist
         */
        $db = $this->_db->dbConnection();
        $u = $this->userExist($email);
        if($u != NULL){
            $u++;
            $sql = "UPDATE users SET updateAt = NOW(),counter = :counter WHERE email = '?";
            /**
             * 
             * Secure the bdd and start update
             */
            $prep = $db->prepare($sql);
            $prep->execute(array($email));
            session_destroy();
            session_start();
            $_SESSION['msg'] =  'User '.$firstname.' '.$lastname.' Updated !';
            http_response_code(200);      
            header('Location: index.php');
            exit();
        }

        /**
         * 
         * Secure the bdd and start create user
         */
        $sql = "INSERT INTO users (firstname, lastname,type, email, birth, phone, country, IP, creatAt, updateAt,counter,question)
                VALUE (?,?,?, ?,'$birth', ?,?,'$ip',NOW(),NOW(),0,?)";
        $prep = $db->prepare($sql);
        $prep->execute(array(
        $firstname,
        $lastname,
        $type,
        $email,
        $phone,
        $country,
        $question,
        ));

        session_destroy();
        session_start();
        $_SESSION['msg'] =  'User '.$firstname.' '.$lastname.' created !';
        http_response_code(200);      
        header('Location: index.php');
        exit();
    }

    /**
     * 
     *  check in the database if user exist
     */
    function userExist($email){
        $users = json_decode($this->getAll());
        foreach ($users as &$user) {
            if($user->email == $email){
                return $user->counter;
            }
        }
        return NULL;
    }

    /**
     * 
     *  Spambot security
     * 
     */
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

    /**
     * 
     * 
     *          Credentials Controls
     * 
     * 
     * 
     */
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

    function validateQuestion($question){
        if(strlen($question) >= 15 && strlen($question) <= 250 ){
            return true;
        }
        return false;
    }
  
}

