<?php

require_once __DIR__ . "/classes/Functions.php";
Functions::allowOnlyAdmins();
require_once __DIR__ . "/partials/menu.php";

require_once __DIR__ . "/classes/Db.php";
require_once __DIR__ . "/classes/User.php";
require_once __DIR__ . "/classes/Login.php";
require_once __DIR__ . "/classes/LoginContr.php";
require_once __DIR__ . "/classes/Vehicle.php";



$database = new Db;
$car = new Vehicle($database);

?>

<div class="container text-center mt-5">
    <div class="row">
        <div class="col">
            <h2>Vehicle registration</h2>
        </div>
    </div>
</div>

<div class="container">

    <div class="row">
        <div class="col">
            <form method="POST" action="addRegVehicle.php">
                <div class="form-row">
                    <div class="col">
                        <label for="model" class="col-form-label">Vehicle Model</label>
                        <div class="row">
                            <div class="col d-flex">
                                <select id="model" class="form-control" name="model" id="model">

                                    <?php
                                    $query = $database->select('vehicle_models');
                                    $models = $database->executeQuery($query);

                                    foreach ($models as $row) { ?>
                                        <option value="<?= $row['id']; ?>"><?= $row['vehicle_model']; ?></option>
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
                            foreach ($vehicleType as $row) { ?>
                                <option value="<?= $row['id']; ?>"><?= $row['vehicle_type']; ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col">
                        <label for="chassis" class="col-form-label">Vehicle Chassis number</label>
                        <input type="text" class="form-control" id="chassis" name="chassis">
                    </div>
                    <div class="col">
                        <label for="production" class="col-form-label">Vehicle production year</label>
                        <input type="date" class="form-control" id="production" name="production">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col">
                        <label for="registration" class="col-form-label">Vehicle Registration number</label>
                        <input type="text" class="form-control" id="registration" name="registration">
                    </div>
                    <div class="col">
                        <label for="fuel" class="col-form-label">Fuel type</label>
                        <select id="fuel" class="form-control" name="fuel" id="fuel">

                            <?php
                            $query = $database->select('fuel_type');
                            $fuelType = $database->executeQuery($query);
                            foreach ($fuelType as $row) { ?>
                                <option value="<?= $row['id']; ?>">
                                    <?= $row['fuel_type']; ?>
                                </option>
                            <?php } ?>

                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col">
                        <label for="registrationto" class="col-form-label">Registration to</label>
                        <input type="date" class="form-control" id="registrationto" name="registrationto">
                    </div>
                    <div class="col">
                        <label for="registration" class="col-form-label py-3"> </label>
                        <button name="submit" type="submit" class="form-control btn btn-primary">Add new car</button>
                    </div>
                </div>
            </form>



        </div>
    </div>
</div>
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="search">
                    <form method="GET" action="" class="form-inline my-2 my-lg-0 ml-auto">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search" value="<?= ($_GET['search'] ?? '') ?>">
                        <button class="btn btn-primary my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </nav>
        </div>
    </div>
</div>

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Vehicle Model</th>
                        <th scope="col">Vehicle Type</th>
                        <th scope="col">Vehicle chassis number</th>
                        <th scope="col">Vehicle production year</th>
                        <th scope="col">Registration number</th>
                        <th scope="col">Fuel type</th>
                        <th scope="col">Registration to</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $row = 1;
                    foreach ($car->selectCar() as $registration) {


                        $regEnd = $registration['registration_to'];
                        if (strtotime($regEnd) < strtotime('-30 days')) {
                            $dateColor = 'danger';
                            $extend = 1;
                        } elseif (strtotime($regEnd) > strtotime('today')) {
                            $dateColor = 'dark';
                            $extend = 0;
                        } else {
                            $dateColor = 'warning';
                            $extend = 1;
                        }

                    ?>


                        <tr class="text-<?= $dateColor ?>">

                            <th scope="row"><?= $row ?></th>
                            <td><?= $registration['vehicle_model'] ?></td>
                            <td><?= $registration['vehicle_type'] ?></td>
                            <td><?= $registration['vehicle_chassis_number'] ?></td>
                            <td><?= $registration['production_year'] ?></td>
                            <td><?= $registration['registration_number'] ?></td>
                            <td><?= $registration['fuel_type'] ?></td>
                            <td><?= $registration['registration_to'] ?></td>
                            <td class="m-0 p-0 d-flex">
                                <form method="POST" action="deleteReg.php">
                                    <input type="hidden" name="delreg" value="<?= isset($registration['id']) ? $registration['id'] : '' ?>">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                                <form method="POST" action="regEditForm.php">
                                    <input type="hidden" name="id" value="<?= isset($registration['id']) ? $registration['id'] : '' ?>">
                                    <button type="submit" class="btn btn-warning mx-2">Edit</button>
                                </form>

                                <?php if ($extend == 1) { ?>
                                    <form method="POST" action="extendForm.php">
                                        <input type="hidden" name="id" value="<?= isset($registration['id']) ? $registration['id'] : '' ?>">
                                        <button type="submit" class="btn btn-success">Extend</button>
                                    </form>
                                <?php  } ?>
                            </td>
                            <?php $row++ ?>
                        <?php } ?>
                        </tr>
                        <tr>
                </tbody>
            </table>

        </div>
    </div>
</div>
<?php

require_once __DIR__ . "/partials/footer.php";

?>