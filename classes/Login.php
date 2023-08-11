<?php
require_once __DIR__ . "/Functions.php";


class Login extends Db
{

    protected function getUser($username)
    {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->openConnection()->prepare($sql);
        $stmt->execute(['username' => $username]);

        

        if($stmt->rowCount() == 1){
            $admin = $stmt->fetch();
            if (password_verify($_POST['password'], $admin['password'])){
                $_SESSION['username'] = $admin['username'];
                Functions::redirect("vehicle-registration.php");
                Functions::redirect("test.php");
            }else{
                Functions::setSessionMessage('Incorrect Password', 'danger');
                Functions::redirect("login.php");
            }
        } else{
            Functions::setSessionMessage('Wrong Credentials', 'danger');
            Functions::redirect("login.php");
        }
    }

}
