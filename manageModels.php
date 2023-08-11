<?php
require_once __DIR__ . "/classes/Functions.php";
Functions::allowOnlyAdmins();
require_once __DIR__ . "/classes/Db.php";
require_once __DIR__ . "/classes/User.php";
require_once __DIR__ . "/classes/Login.php";
require_once __DIR__ . "/classes/LoginContr.php";
require_once __DIR__ . "/classes/Vehicle.php";

require_once __DIR__ . "/partials/menu.php";

$database = new Db;
$car = new Vehicle();
$query = $database->select('vehicle_models');
$models = $database->executeQuery($query);



?>

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col text-center mb-5">
            <h1>Manage Vehicle Models</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <table class="table table-bordered ">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Vehicle Model</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $row = 1;
                    foreach ($models as $vehicleModel) { ?>
                        <tr>
                            <th scope="row"><?= $row ?></th>
                            <td><?= $vehicleModel['vehicle_model']  ?></td>
                            <td class="d-flex">
                                <form action="deleteVehicle.php" method="POST">
                                    <input type="hidden" name="delreg" 
                                        value="<?= isset($vehicleModel['id']) ? $vehicleModel['id'] : '' ?>">
                                    <button type="submit" class="btn btn-danger mr-5">Delete</button>
                                </form>
                                <form action="editModelForm.php" method="POST">
                                    <input type="hidden" name="id" 
                                    value="<?= isset($vehicleModel['id']) ? $vehicleModel['id'] : '' ?>">
                                    <button type="submit" class="btn btn-warning">Edit</button>
                                </form>

                            </td>
                            <?php $row++ ?>
                        <?php } ?>
                        </tr>
                </tbody>
            </table>
        </div>

        <!-- ADD NEW MODELS -->

        <div class="col-6">
            <form class="p-5 border" method="POST" action="addVehicleModel.php">
                <div class="form-group">
                    <h3>Add new Vehicle Model</h3>
                    <hr>
                </div>
                <div class="form-group">
                    <label for="model">Vehicle Model</label>
                    <input type="text" class="form-control" id="model" name="model">
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Add</button>
            </form>
            <div class="row mt-5">
                <div class="col">
                    <a href="vehicle-registration.php" class="btn btn-outline-success btn-block btn-lg">Back to Registration Page</a>
                </div>
            </div>
        </div>
    </div>
</div>