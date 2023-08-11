<?php

require_once __DIR__ . "/../consts.php";
require_once __DIR__ . "/../functions/functions.php";

try{
    $pdo = new Pdo("mysql:host=localhost;dbname=" . DBNAME, DBUSER, DBPASS);
    // echo " Connection sucessfull";
}catch(PDOException $e){
    redirect("login.php");
}