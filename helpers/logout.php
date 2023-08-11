<?php

require_once __DIR__ . "/../classes/Functions.php";

Functions::sessionInit();
session_destroy();
Functions::redirect("../login.php");
