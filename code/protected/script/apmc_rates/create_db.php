 <?php
$servername = "localhost";
$username = "root";
$password = "Aakash24.duaa";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sqlll = "CREATE DATABASE daily_rates";
if ($conn->query($sqlll) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->close();
?> 