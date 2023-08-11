<?php

require_once __DIR__ . "/classes/Functions.php";
Functions::allowOnlyAdmins();
Functions::sessionInit();

require_once __DIR__ . "/partials/menu.php";

require_once __DIR__ . "/classes/Db.php";
require_once __DIR__ . "/classes/Vehicle.php";


$database = new Db;
$car = new Vehicle($database);

if (isset($_POST['submit'])) {

    $car->checkChassisNumber();
    $car->addCar($model, $type, $chassisNum, $prodYear, $regNum, $fuelType, $regTo);


}


