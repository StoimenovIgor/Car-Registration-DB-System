<?php

require_once __DIR__ . "/../classes/Functions.php";
Functions::sessionInit();

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <nav class="navbar navbar-light bg-light">
        <a href="index.php" class="navbar-brand">Vehicle Registration</a>
        <?php
            if(!Functions::auth()){ 

            ?>
        <a href="login.php" class="navbar-brand text-primary">Login</a>
        <?php }else{ ?>
            <a href="./helpers/logout.php" class="navbar-brand text-primary">Logout</a>
        <?php  } ?>  
    </nav>

    <?php

    if (isset($_SESSION['status'])) {
        Functions::showMsg($_SESSION['msg'], $_SESSION['status']);
    }


    ?>