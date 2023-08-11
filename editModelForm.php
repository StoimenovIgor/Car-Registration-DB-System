<?php

require_once __DIR__ . "/classes/Functions.php";
Functions::allowOnlyAdmins();
Functions::sessionInit();

require_once __DIR__ . "/classes/Db.php";
require_once __DIR__ . "/classes/Vehicle.php";
require_once __DIR__ . "/partials/menu.php";




$database = new Db;
$car = new Vehicle($database);
$query = $database->select('vehicle_models');
$models = $database->executeQuery($query);

// echo "POST = ". $_POST['id'];
// echo "<hr>";
// echo "<pre>";
// var_dump($models);
// die();

?>

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-12">
            <form class="p-5 border" method="POST" action="updateVehicle.php">
                <div class="form-group">
                    <h3>Edit Vehicle Model</h3>
                    <hr>
                </div>
                <div class="form-group">
                    <label for="model">Vehicle Model</label>
                    <input type="hidden" name="id" 
                    value="
                        <?php
                            foreach ($models as $model){
                                if($model['id'] == $_POST['id']){
                                    echo $model['id'];
                                }
                            }
                        ?>
                    ">
                    <input type="text" class="form-control" id="model" name="model" 
                    value="<?php
                            foreach ($models as $model){
                                if($model['id'] == $_POST['id']){
                                    echo $model['vehicle_model'];
                                }
                            }
                        ?>">
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Update</button>
            </form>
        </div>
    </div>
</div>