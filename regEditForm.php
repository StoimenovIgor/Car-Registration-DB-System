<?php

require_once __DIR__ . "/classes/Functions.php";
Functions::allowOnlyAdmins();
Functions::sessionInit();


require_once __DIR__ . "/classes/Db.php";
require_once __DIR__ . "/classes/User.php";
require_once __DIR__ . "/classes/Login.php";
require_once __DIR__ . "/classes/LoginContr.php";
require_once __DIR__ . "/classes/Vehicle.php";

require_once __DIR__ . "/partials/menu.php";





$database = new Db;
$car = new Vehicle($database);
$rowReg = $car->carEdit();


?>

<div class="container text-center mt-5">
    <div class="row">
        <div class="col">
            <h2>Edit vehicle data</h2>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col">
            <form method="POST" action="updateRegData.php">
                <div class="form-row">
                    <div class="col">
                        <label for="model" class="col-form-label">Vehicle Model</label>
                        <div class="row">
                            <div class="col d-flex">


                                <select id="model" class="form-control col-8" name="model" id="model">
                                    <?php

                                    $query = $database->select('vehicle_models');
                                    $models = $database->executeQuery($query);
                                    foreach ($models as $rowModel) { ?>

                                        <option value="<?= $rowModel['id']; ?>" 
                                        <?php foreach ($rowReg as $row) { ?>
                                            <?= (isset($row) && $row['vehicle_model_id'] == $rowModel['id']) ? 'selected' : '' ?>>
                                            <?= $rowModel['vehicle_model']; ?>
                                            <?php } ?>
                                        </option>

                                    <?php } ?>

                                </select>
                                <a href="manageModels.php" type="button" class="form-control btn btn-outline-primary  col-4">Manage Models</a>
                            </div>
                        </div>
                    </div>

                               

                    <div class="col">
                        <label for="type" class="col-form-label">Vehicle Type</label>
                        <select id="type" class="form-control" name="type" id="type">
                            <?php
                            $query = $database->select('vehicle_type');
                            $vehicleType = $database->executeQuery($query);
                            foreach ($vehicleType as $rowType) { ?>
                                <option value="<?= $rowType['id']; ?>" 
                                <?php foreach ($rowReg as $row) { ?>
                                    <?= (isset($row) && $row['vehicle_type_id'] == $rowType['id']) ? 'selected' : '' ?>>
                                    <?= $rowType['vehicle_type']; ?>
                                    <?php } ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col">
                        <label for="chassis" class="col-form-label">Vehicle Chassis number</label>
                        <input type="text" class="form-control" id="chassis" name="chassis" 
                        value="<?php foreach ($car->selectCar() as $row) {
                            if ($row['id'] == $_POST['id']) {
                                echo $row['vehicle_chassis_number'];
                            }
                        } ?>">
                    </div>
                    <div class="col">
                        <label for="production" class="col-form-label">Vehicle production year</label>
                        <input type="date" class="form-control" id="production" name="production" 
                        value="<?php foreach ($car->carEdit() as $row) {

                                foreach ($rowReg as $row) { 
                                    if ($row['id'] == $_POST['id']){
                                        echo $row['vehicle_production_year']; 
                                    }
                                    } 
                            }?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col">
                        <label for="registration" class="col-form-label">Vehicle Registration number</label>
                        <input type="text" class="form-control" id="registration" name="registration" 
                        value="<?php foreach ($car->selectCar() as $row) {
                                if ($row['id'] == $_POST['id']){
                                    echo $row['registration_number'];
                                }
                            } ?>">
                    </div>
                    <div class="col">
                        <label for="fuel" class="col-form-label">Fuel type</label>
                        <select id="fuel" class="form-control" name="fuel" id="fuel">

                        <?php
                            $query = $database->select('fuel_type');
                            $vehicleType = $database->executeQuery($query);
                            foreach ($vehicleType as $fuelType) { ?>
                                <option value="<?= $fuelType['id']; ?>" 
                                <?php foreach ($rowReg as $row) { ?>
                                    <?= (isset($row) && $row['fuel_type_id'] == $fuelType['id']) ? 'selected' : '' ?>>
                                    <?= $fuelType['fuel_type']; ?>
                                    <?php } ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col">
                        <label for="registration" class="col-form-label py-3"> </label>
                        <input type="hidden" name="id" 
                        value="<?php foreach ($car->carEdit() as $row) {
                            foreach ($rowReg as $row) { 
                                if ($row['id'] == $_POST['id']){
                                    echo $row['id']; 
                                    }
                                } 
                            }?>">
                        <button type="submit" class="form-control btn btn-primary">Update</button>
                    </div>
                    <div class="col">
                        <label for="registration" class="col-form-label py-3"> </label>
                        <a href="vehicle-registration.php" class="form-control btn btn-outline-success">Back to main page</a>
                    </div>
                </div>
            </form>