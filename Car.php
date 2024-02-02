<?php

class Car {
    public $type;
    public $name;
    public $model;
    public $year;

    public function __construct($type, $name, $model, $year) {
        $this->type = $type;
        $this->name = $name;
        $this->model = $model;
        $this->year = $year;
    }

    public function displayCarInfo() {
        echo "<tr>";
        echo "<td>{$this->type}</td>";
        echo "<td>{$this->name}</td>";
        echo "<td>{$this->model}</td>";
        echo "<td>{$this->year}</td>";
    }
}

class ElectricCar extends Car {
    public $batteryCapacity;
    public $fuelEfficiency;
    public function __construct($type, $name, $model, $year, $batteryCapacity) {
        parent::__construct($type, $name, $model, $year);
        $this->batteryCapacity = $batteryCapacity;
        $this->fuelEfficiency = null; 
    }

    public function displayCarInfo() {
        parent::displayCarInfo();
        echo "<td>{$this->batteryCapacity} kWh</td>";
        echo "<td></td>"; // Placeholder for fuel efficiency in ElectricCar
        echo "</tr>";
    }
}

class GasCar extends Car {
    public $fuelEfficiency;
    public $batteryCapacity; 

    public function __construct($type, $name, $model, $year, $fuelEfficiency) {
        parent::__construct($type, $name, $model, $year);
        $this->fuelEfficiency = $fuelEfficiency;
        $this->batteryCapacity = null; 
    }

    public function displayCarInfo() {
        parent::displayCarInfo();
        echo "<td>{$this->batteryCapacity}</td>"; // Display battery capacity
        echo "<td>{$this->fuelEfficiency} MPG</td>";
        echo "</tr>";
    }
}

?>
