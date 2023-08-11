<?php


class Functions
{

    public static function redirect($url)
    {
        header("Location: $url");
        die();
    }

    public static function onlyPostAllowed($url)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            self::redirect($url);
        }
    }

    public static function setSessionMessage($msg, $status)
    {
        $_SESSION['status'] = $status;
        $_SESSION['msg'] = $msg;
        $_SESSION['old'] = $_POST;
    }

    public static function showMsg($msg, $status)
    {
        echo "<div class='alert alert-{$status} alert-dismissible fade show' role='alert'>
    {$msg} <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
    </button>
    </div>";

        unset($_SESSION['status']);
        unset($_SESSION['msg']);
    }

    public static function sessionInit()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function allowOnlyAdmins()
    {
        self::sessionInit();
        if (!isset($_SESSION['username'])) {
            self::setSessionMessage("Only Admins can access this page.", "danger");
            self::redirect("login.php");
        }
    }

    public static function auth()
    {
        self::sessionInit();
        return isset($_SESSION['username']);
    }

    
    public static function allowOnlyGuest()
    {
        self::sessionInit();
        if (isset($_SESSION['username'])) {
            self::redirect("vehicle-registration.php");
        }
    }

}
