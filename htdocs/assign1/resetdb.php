<?php
require_once('../../files/sqlinfo.inc.php');
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conn = mysqli_connect($sql_host, $sql_user, $sql_pass, $sql_db);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $tableName = 'status'; 
    // SQL statement to drop the table if it exists 
    $sql = "DROP TABLE IF EXISTS `$tableName`";

    if (mysqli_query($conn, $sql)) {
        echo "Database table '$tableName' has been successfully reset!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
     // Show an error if the request was not a POST request
    echo "Invalid request.";
}
?>
