<?php

class Db{

    private $_host = null;
    private $_port = null;
    private $_dbName   = null;
    private $_user = null;
    private $_pass = null;
    
    public function __construct($host, $port, $dbNameame, $user, $pass)
    {
        $this->_host = $host;
        $this->_port = $port;
        $this->_dbName   = $dbNameame;
        $this->_user = $user;
        $this->_pass = $pass;
    }
    
    function dbConnection(){
        try {
            $db = new PDO('mysql:host='.$this->_host.';port='.$this->_port.';dbname='.$this->_dbName, $this->_user, $this->_pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
    
        } catch (PDOException $e){
            print "Error ! : " . $e->getMessage() . "<br/>";
            die;
        }
    }
}