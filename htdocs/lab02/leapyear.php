

<?php

  function is_leapyear($year){
    if (($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0)) {
        return true;
    }
    return false;
}
if (isset($_GET['year']) && is_numeric($_GET['year'])) {
    $year = $_GET['year'];
    if(is_leapyear($year)){
        echo "The year $year is a leap year.";
    } else {
        echo "The year $year is not a leap year.";
    } 
} else {
    echo "Please enter a valid year.";
}  
?>
<!-- if($year % 4 == 0){
    if($year % 100 == 0){
        if($year % 400 == 0){
            echo "The year $year is a leap year.";
        } else {
            echo "The year $year is not a leap year.";
        }
    } else {
        echo "The year $year is a leap year.";
    }
} else {
    echo "The year $year is not a leap year.";
} -->




