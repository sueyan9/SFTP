<?php

$servername = "webdev.aut.ac.nz"; // Change this to your server name
$username = "mng2178";
$password = "boobtmuwrvedgmtmluwnbchzvixzuq"; // Change this to your actual password
$dbname = "mng2178"; // Change to your database

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'] ?? '';
$password = $_POST['pwd'] ?? '';

if (empty($name) || empty($password)) {
    echo "Name and password are required.";
    exit;
}

$sql = "SELECT * FROM users WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Name not found in the database.";
} else {

    $user = $result->fetch_assoc();

    if ($user['password'] === $password) {
        echo "Email address: " . $user['email'];
    } else {
        echo "Incorrect password.";
    }
}

$stmt->close();
$conn->close();
?>