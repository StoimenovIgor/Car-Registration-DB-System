<?php

require_once __DIR__ . "/Db.php";
require_once __DIR__ . "/Functions.php";

class Vehicle 
{


    public $database;
    private $model;
    private $type;
    private $chassisNum;
    private $prodYear;
    private $regNum;
    private $fuelType;
    private $regTo;
    private $conn;

    public function __construct($database = new Db())
    {
        $this->database = $database;
    }

    

    public function addCar($model, $type, $chassisNum, $prodYear, $regNum, $fuelType, $regTo)
    {

        $table = 'registration';

        $row = 'vehicle_model_id, 
        vehicle_type_id,
        vehicle_chassis_number,
        vehicle_production_year,
        registration_number,
        fuel_type_id,
        registration_to';

        $values = ':vehicle_model_id,
        :vehicle_type_id,
        :vehicle_chassis_number,
        :vehicle_production_year,
        :registration_number,
        :fuel_type_id,
        :registration_to';

        $data = [
            'vehicle_model_id' =>  $_POST['model'],
            'vehicle_type_id' => $_POST['type'],
            'vehicle_chassis_number' => $_POST['chassis'],
            'vehicle_production_year' => $_POST['production'],
            'registration_number' => $_POST['registration'],
            'fuel_type_id' => $_POST['fuel'],
            'registration_to' => $_POST['registrationto'],
        ];

            $query = $this->database->insert($table, $row, $values);

    
        if ($this->database->executeQuery($query, $data, $fetchMode = 3)) {
            Functions::setSessionMessage('Registered vehicle added successfully', 'success');
            Functions::redirect("vehicle-registration.php");
        } else {
            Functions::setSessionMessage('Registered vehicle cannot be added ', 'danger');
            Functions::redirect("vehicle-registration.php");
        };
    }


    public function addModel()
    {
        $table = 'vehicle_models';
        $row = 'vehicle_model';
        $values = ':vehicle_model';
        $data = ['vehicle_model' => $_POST['model']];

        $query = $this->database->insert($table, $row, $values);


        if ($this->database->executeQuery($query, $data, $fetchMode = 3)) {
            Functions::setSessionMessage('New Model Sucessfully Added', 'success');
            Functions::redirect("vehicle-registration.php");
        } else {
            Functions::setSessionMessage('An error ocured while adding the new model', 'success');
            Functions::redirect("addVehicleModel.php");
        };
    }





    public function selectCar()
    {
        $table = 'registration';
        $row = 'registration.id,
        registration.vehicle_model_id, 
        vehicle_models.vehicle_model,
        registration.vehicle_type_id,
        vehicle_type.vehicle_type,
        vehicle_chassis_number,

        YEAR(vehicle_production_year) AS production_year,
        registration_number,
        registration.fuel_type_id,
        fuel_type.fuel_type,
        registration_to';

        $join = ' vehicle_models ON registration.vehicle_model_id = vehicle_models.id
        JOIN vehicle_type ON registration.vehicle_type_id = vehicle_type.id
        JOIN fuel_type ON registration.fuel_type_id = fuel_type.id';

        $data = [];

        if(isset($_GET['search'])){
            $join .= " WHERE vehicle_models.vehicle_model LIKE :search OR vehicle_chassis_number LIKE :search OR registration_number LIKE :search";
            $data = [
                'search' => "%{$_GET['search']}%"
            ];
        }
        
        $query = $this->database->select($table,$row, $join);
        $result = $this->database->executeQuery($query,$data, $fetchMode = 1);

        return $result;
        
    }



    public function carEdit(){
        $table = 'registration';
        $row = 'registration.id,
        registration.vehicle_model_id, 
        vehicle_models.vehicle_model,
        registration.vehicle_type_id,
        vehicle_type.vehicle_type,
        vehicle_chassis_number,
        vehicle_production_year,
        registration_number,
        registration.fuel_type_id,
        fuel_type.fuel_type,
        registration_to';

        $join = ' vehicle_models ON registration.vehicle_model_id = vehicle_models.id
        JOIN vehicle_type ON registration.vehicle_type_id = vehicle_type.id
        JOIN fuel_type ON registration.fuel_type_id = fuel_type.id';

        $where = $_POST['id'];

        $query = $this->database->select($table,$row, $join, $where);
        $result = $this->database->executeQuery($query);

        return $result;
    }






    public function deleteRegisteredVehicle($table)
    {
        $query = $this->database->delete($table);
        $data = ['id' => $_POST['delreg']];

        try{
            if ($this->database->executeQuery($query, $data, $fetchMode = 3)) {
                Functions::setSessionMessage('Vehicle deleted', 'success');
                Functions::redirect("vehicle-registration.php");
            } else {
                Functions::setSessionMessage('The vehicle cannot be deleted', 'danger');
                Functions::redirect("vehicle-registration.php");
            }
        }catch (PDOException $e){
            Functions::setSessionMessage('Cannot delete a model that is in use', 'danger');
                Functions::redirect("vehicle-registration.php");
        }
    }


    public function updateRegistration()
    {

        $table = 'registration';
        $row = 'vehicle_model_id = :vehicle_model_id, 
        vehicle_type_id = :vehicle_type_id,
        vehicle_chassis_number = :vehicle_chassis_number,
        vehicle_production_year = :vehicle_production_year,
        registration_number = :registration_number,
        fuel_type_id = :fuel_type_id';


        $data = [
            'vehicle_model_id' => $_POST['model'],
            'vehicle_type_id' => $_POST['type'],
            'vehicle_chassis_number' => $_POST['chassis'],
            'vehicle_production_year' => $_POST['production'],
            'registration_number' => $_POST['registration'],
            'fuel_type_id' => $_POST['fuel'],
            'id' => $_POST['id']
        ];

        $result = $this->database->update($table,$row);

        try {
            if ($this->database->executeQuery($result, $data, $fetchMode = 3)) {
                Functions::setSessionMessage('Vehicle data updated', 'success');
                Functions::redirect("vehicle-registration.php");
            } else {
                Functions::setSessionMessage('Vehicle data cannot be updated', 'danger');
                Functions::redirect("vehicle-registration.php");
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function updateModel()
    {
        $table = 'vehicle_models';
        $row = 'vehicle_model = :vehicle_model';

        $data = [
            'vehicle_model' => $_POST['model'],
            'id' => $_POST['id']
        ];

        $result = $this->database->update($table,$row);

        if ($this->database->executeQuery($result, $data, $fetchMode = 3)) {
            Functions::setSessionMessage('Vehicle model updated', 'success');
            Functions::redirect("manageModels.php");
        } else {
            Functions::setSessionMessage('The vehicle model cannot be updated', 'danger');
            Functions::redirect("updateVehicle.php");
        }
    }




    public function extend()
    {
        $table = 'registration';
        $row = 'registration.id, registration_to';
        $where = ':id';
        $data = [
            'id' => $_POST['id']
        ];

        $query = $this->database->select($table,$row,$join = null, $where);
        $result = $this->database->executeQuery($query,$data, $fetchMode = 0);
        return $result;
    }


    public function extendUpdate()
    {
        $table = 'registration';
        $row = ' registration_to = :registration_to';

        $data = [
            'registration_to' => $_POST['registration'],
            'id' => $_POST['id']
        ];

        $query = $this->database->update($table, $row);

        if ($this->database->executeQuery($query,$data, $fetchMode = 3)) {
            Functions::setSessionMessage('Registration extended successfully', 'success');
            Functions::redirect("vehicle-registration.php");
        } else {
            Functions::setSessionMessage('An error occured. Registration cannot be extended', 'danger');
            Functions::redirect("vehicle-registration.php");
        }
    }


    public function guestSearch()

    {
        $table = 'registration';
        $row = 'registration.id,
        registration.vehicle_model_id, 
        vehicle_models.vehicle_model,
        registration.vehicle_type_id,
        vehicle_type.vehicle_type,
        vehicle_chassis_number,

        YEAR(vehicle_production_year) AS production_year,
        registration_number,
        registration.fuel_type_id,
        fuel_type.fuel_type,
        registration_to';

        $join = ' vehicle_models ON registration.vehicle_model_id = vehicle_models.id
        JOIN vehicle_type ON registration.vehicle_type_id = vehicle_type.id
        JOIN fuel_type ON registration.fuel_type_id = fuel_type.id WHERE registration_number LIKE :search';


        $data = [
            'search' => "{$_POST['search']}"
        ];

        $query = $this->database->select($table,$row, $join);
        $search = $this->database->executeQuery($query,$data, $fetchMode = 0);

        return $search;
    }


    public function checkChassisNumber()
    {
        $table = 'registration';
        $row = 'vehicle_chassis_number';

        $sqlCheck = $this->database->select($table,$row);

        $stmtCheck = $this->database->openConnection()->prepare($sqlCheck);
        $stmtCheck->execute();
        while ($chassisNumCheck = $stmtCheck->fetch()) {
            if ($chassisNumCheck['vehicle_chassis_number'] == $_POST['chassis']) {
                Functions::setSessionMessage('Vehicle with entered chassis number already exists', 'danger');
                Functions::redirect("vehicle-registration.php");
            }
        }
    }




    public function getDatabase()
    {
        return $this->database;
    }
}
