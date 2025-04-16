<?php
if (isset($_POST['inputString'])) {
    $inputString = $_POST['inputString'];

    $inputString = strtolower($inputString);

    $inputString = preg_replace("/[^a-zA-Z0-9]/", "", $inputString);

    $reversedString = strrev($inputString);

    if (strcmp($inputString, $reversedString) === 0) {
        echo "<p>The string is a standard palindrome!</p>";
    } else {
        echo "<p>The string is not a standard palindrome.</p>";
    }
} else {
    echo "<p>Please enter a string in the form.</p>";
}
?>