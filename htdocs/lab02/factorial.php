

<?php
include 'matchfunctions.php';
 $number = isset($_GET['number']) ? intval($_GET['number']) : 0; 
 //$number = $_GET['number'];

 if((is_int($number)) && $number >= 0){
     echo "The factorial of $number is: ".factorial($number).".";
 } else {
     echo "Error, The number $number is not a non-negative integer.";
 }
 ?>
 