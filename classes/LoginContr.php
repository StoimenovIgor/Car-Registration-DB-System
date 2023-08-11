<?php

require_once __DIR__ . "/Functions.php";

class LoginContr extends Login {
    private $username;
    private $password;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function EmptyInput(){
        $result = true;
        if(empty($this->username) || empty($this->password)){
            $result = false;
        }else{
            $result = true;
        }
        return $result;
    }

    public function LoginUser(){
        if($this->EmptyInput() == false){
            Functions::setSessionMessage('All fields are required', 'danger');
            Functions::redirect("login.php");
        }
        $this->getUser($this->username, $this->password);
    }
}