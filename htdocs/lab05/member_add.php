<?php
$servername = "webdev.aut.ac.nz";
$username = "mng2178";
$password = "boobtmuwrvedgmtmluwnbchzvixzuq"; // Change this to your actual password
$dbname = "mng2178"; // Change to your database

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table with the updated schema
$createTableSQL = "CREATE TABLE IF NOT EXISTS vipmember (
    member_id INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(40),
    lname VARCHAR(40),
    gender VARCHAR(1),
    email VARCHAR(40),
    phone VARCHAR(20)
)";
$conn->query($createTableSQL);

// Get and sanitize input values
$fname = $conn->real_escape_string($_POST['fname']);
$lname = $conn->real_escape_string($_POST['lname']);
$gender = $conn->real_escape_string($_POST['gender']);
$email = $conn->real_escape_string($_POST['email']);
$phone = $conn->real_escape_string($_POST['phone']);

$insertSQL = "INSERT INTO vipmember (fname, lname, gender, email, phone)
              VALUES ('$fname', '$lname', '$gender', '$email', '$phone')";

if ($conn->query($insertSQL) === TRUE) {
    echo "New member added successfully.<br>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
<a href="vip_member.php">Return to Home</a>