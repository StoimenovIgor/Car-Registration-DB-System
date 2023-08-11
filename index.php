<?php
require_once __DIR__ . "/classes/Functions.php";

Functions::allowOnlyGuest();
Functions::sessionInit();

require_once __DIR__ . "/classes/Vehicle.php";
require_once __DIR__ . "/partials/menu.php";



?>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="jumbotron text-center">
                <h1 class="display-3">Vehicle Registration</h1>
                <h4 class="display-5">Enter your Registration Number to check its validity</h4>
                <hr class="my-2 my-4">
                <form method="POST" action="">
                    <div class="form-group row">
                        <label for="regnumber" class="col-sm-2 col-form-label"></label>
                        <div class="col-8">
                            <input type="text" class="form-control" id="search" name="search" placeholder="Registration number">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-8 offset-2">
                            <div class="row">
                                <div class="col-6">
                                <button type="submit" class="btn btn-primary btn-lg w-100 pb-3">Search</button>
                                </div>
                                <div class="col-6">
                                <a href="index.php" class="btn btn-primary btn-lg w-100 pb-3">Clear Search</a>
                                </div>
                            </div>    
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>



<?php

$data = [];

if (isset($_POST['search'])){
    $car = new Vehicle();
    $car->guestSearch();


    ?>

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
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $tableRowNumber = 1;

                        ?>

                        <?php
                        if($row = $car->guestSearch()) {
                            $regEnd = $row['registration_to'];
                            if(strtotime($regEnd) < strtotime('-30 days')) {
                                $dateColor = 'danger';
                            }elseif(strtotime($regEnd) > strtotime('today')){
                                $dateColor = 'dark';
                            }else{
                                $dateColor = 'warning';
                            }
                        ?>
                            <tr class="text-<?= $dateColor ?>">
                                <th scope="row"><?= $tableRowNumber ?></th>
                                <td><?= $row['vehicle_model'] ?></td>
                                <td><?= $row['vehicle_type'] ?></td>
                                <td><?= $row['vehicle_chassis_number'] ?></td>
                                <td><?= $row['production_year'] ?></td>
                                <td><?= $row['registration_number'] ?></td>
                                <td><?= $row['fuel_type'] ?></td>
                                <td><?= $row['registration_to'] ?></td>
                            </tr>
                            <?php $tableRowNumber++ ?>
                        <?php } else{
                                    Functions::setSessionMessage('Vehicle with the requested registration plates number is not found', 'danger');
                                    Functions::redirect("index.php");
                        }?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

<?php
} 
?>

<?php

require_once __DIR__ . "/partials/footer.php";

?>