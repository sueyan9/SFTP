<?php
session_start(); 
if (isset($_SESSION['randomNumber'])) {
    $randomNumber = $_SESSION['randomNumber'];
} else {
    $randomNumber = "No game in progress. Please start a new game.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Give Up</title>
</head>
<body>
    <h1>Give Up</h1>
    <p>
        <?php 
        if (is_numeric($randomNumber)) {
            echo "The random number was: " . $randomNumber;
        } else {
            echo $randomNumber;
        }
        ?>
    </p>
    <a href="startover.php">Start Over</a>
</body>
</html>