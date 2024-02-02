document.getElementById("carTypeInput").addEventListener("input", function () {
    handleVisibility();
});

function handleVisibility() {
    var carType = document.getElementById("carTypeInput").value.toLowerCase();
    var batteryCapacityGroup = document.getElementById("batteryCapacityGroup");
    var fuelEfficiencyGroup = document.getElementById("fuelEfficiencyGroup");

    if (carType === "electric") {
        batteryCapacityGroup.style.display = "block";
        fuelEfficiencyGroup.style.display = "none";
    } else if (carType === "gas") {
        batteryCapacityGroup.style.display = "none";
        fuelEfficiencyGroup.style.display = "block";
    } else {
        batteryCapacityGroup.style.display = "none";
        fuelEfficiencyGroup.style.display = "none";
    }
}

function addCar() {
    var carType = document.getElementById("carTypeInput").value.toLowerCase();
    var carName = document.getElementById("carName").value;
    var carModel = document.getElementById("carModel").value;
    var carYear = document.getElementById("carYear").value;
    var batteryCapacity = document.getElementById("batteryCapacity").value;
    var fuelEfficiency = document.getElementById("fuelEfficiency").value;

    // // Validation
    if (carType !== "electric" && carType !== "gas") {
        console.log(carType);
        alert("JS:: Invalid car type. Please enter either Electric or Gas.");
        return;
    }

    // Create an object with the entered data
    var carData = {
        carType: carType,
        carName: carName,
        carModel: carModel,
        carYear: carYear,
        batteryCapacity: (carType === "electric") ? batteryCapacity : null,
        fuelEfficiency: (carType === "gas") ? fuelEfficiency : null,
    };
    
    console.log(JSON.stringify(carData));
    // Call PHP script to store data in the database
    fetch('SaveCar.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(carData), // body
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById("carForm").reset();
        loadCarList();
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}

function loadCarList() {
    // Call PHP script to fetch car data from the database
    fetch('GetCar.php')
    .then(response => response.text())
    .then(data => {
        // Populate the car list table dynamically
        document.getElementById("carTable").getElementsByTagName("tbody")[0].innerHTML = data;
        // Initialize DataTable
        $('#carTable').DataTable();
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}

// Load car list on page load
loadCarList();
