
<?php
$host = 'localhost'; // Database host
$dbname = 's'; // Database name
$username = 'root'; // Database username (change if needed)
$password = ''; // Database password (change if needed)

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>