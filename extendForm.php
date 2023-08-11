<?php

require_once __DIR__ . "/classes/Functions.php";
Functions::allowOnlyAdmins();
Functions::sessionInit();

require_once __DIR__ . "/classes/Db.php";
require_once __DIR__ . "/classes/Vehicle.php";
require_once __DIR__ . "/partials/menu.php";




$database = new Db;
$car = new Vehicle($database);
$dataReg = $car->extend();

?>

<div class="container text-center mt-5">
    <div class="row">
        <div class="col mb-5">
            <h2>Extend Registration</h2>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col">
            <form method="POST" action="extendRegUpdate.php">

                <div class="form-row">
                    
                    <div class="col">
                        <label for="registration" class="col-form-label">Registration valid until</label>
                        <input type="date" class="form-control" id="registration" name="registration" value="<?= $dataReg['registration_to']; ?>">
                    </div>

                    <div class="col">
                        <label for="" class="col-form-label py-3"> </label>
                        <input type="hidden" name="id" value="<?= isset($dataReg['id']) ? $dataReg['id'] : '' ?>">
                        <button type="submit" class="form-control btn btn-primary">Update</button>
                    </div>

                </div>

            </form>