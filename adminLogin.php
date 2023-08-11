<?php

require_once __DIR__ . "/classes/Functions.php";
Functions::sessionInit();
Functions::onlyPostAllowed("login.php");



if(isset($_POST['submit'])){

    $password = $_POST['password'];
    $username = $_POST['username'];

    require_once __DIR__ . "/classes/Db.php";
    require_once __DIR__ . "/classes/Login.php";
    require_once __DIR__ . "/classes/LoginContr.php";

    $login = new LoginContr($username, $password);
    $login->LoginUser($username, $password);

}

