<?php

require_once __DIR__ . "/classes/Functions.php";
Functions::allowOnlyAdmins();
Functions::sessionInit();

require_once __DIR__ . "/classes/Db.php";
require_once __DIR__ . "/classes/Vehicle.php";
require_once __DIR__ . "/partials/menu.php";

$database = new Db;
$car = new Vehicle($database);
$car->extendUpdate();


