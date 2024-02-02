<?php

require_once('Car.php');

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

$car = null;
// Fetch car data from the database
$sql = "SELECT * FROM Cars";
$result = $conn->query($sql);

// Build HTML table with car data
$table = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $car = null; // Initialize $car to null at the beginning of each iteration

        if ($row['type'] === 'electric') {
            $car = new ElectricCar(
                $row['type'],
                $row['name'],
                $row['model'],
                $row['year'],
                $row['battery_capacity']
            );
        } elseif ($row['type'] === 'gas') {
            $car = new GasCar(
                $row['type'],
                $row['name'],
                $row['model'],
                $row['year'],
                $row['fuel_capacity']
            );
        }

        // Check if $car is not null before calling displayCarInfo()
        if ($car) {
            $table .= $car->displayCarInfo();
        }
    }
}

echo $table;

$conn->close();

?>
