<?php

require_once __DIR__ . "/classes/Functions.php";
Functions::allowOnlyAdmins();

require_once __DIR__ . "/classes/Db.php";
require_once __DIR__ . "/classes/Vehicle.php";
require_once __DIR__ . "/partials/menu.php";

$car = new Vehicle();
$car->addModel();


$database = new Db;
$car = new Vehicle($database);
?>

