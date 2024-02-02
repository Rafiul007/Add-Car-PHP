<?php
require_once('Car.php');
$carData = json_decode(file_get_contents('php://input'), true);
// Data validation
if (!isset($carData['carType']) || !isset($carData['carName']) || !isset($carData['carModel']) || !isset($carData['carYear'])) {
    echo "Testing PHP:Invalid data. Please provide all required fields.";
    exit;
}

// Creating object of Car class.
if ($carData['carType'] === 'electric') {
    $car = new ElectricCar(
        $carData['carType'],
        $carData['carName'],
        $carData['carModel'],
        $carData['carYear'],
        $carData['batteryCapacity']
    );
} elseif ($carData['carType'] === 'gas') {
    $car = new GasCar(
        $carData['carType'],
        $carData['carName'],
        $carData['carModel'],
        $carData['carYear'],
        $carData['fuelEfficiency']
    );
} else {
    echo "Invalid car type. Please enter either Electric or Gas.";
    exit;
}

// Connect to your MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car";
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Creating the Cars table if it doesn't exist
$sqlCreateTable = "CREATE TABLE IF NOT EXISTS Cars (
    car_id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(50) NOT NULL,
    name VARCHAR(100) NOT NULL,
    model VARCHAR(50) NOT NULL,
    year INT NOT NULL,
    battery_capacity INT DEFAULT NULL,
    fuel_capacity INT DEFAULT NULL
)";

if ($conn->query($sqlCreateTable) === FALSE) {
    echo "Error creating table: " . $conn->error;
    exit;
}
// Insert car data into the database
$sql = "INSERT INTO Cars VALUES (null,'$car->type', '$car->name', ' $car->model','$car->year' , ' $car->batteryCapacity ', ' $car->fuelEfficiency ')";

if ($conn->query($sql) === TRUE) {
    echo "Car added successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>