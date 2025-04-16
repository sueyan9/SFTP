<!DOCTYPE html> 
<html> 
<head> 
<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
<title>Using string functions</title> 
</head> 
<body> 
<h1>Web Development – Lab 3</h1> 
<?php 
  if (isset($_POST['inputString'])) { 
    $str = $_POST['inputString']; 
    $pattern = "/^[A-Za-z ]+$/"; //only letters and space
    if (preg_match($pattern, $str)) {
      $ans= "";
      $len = strlen($str);
      for($i = 0; $i < $len; $i++) {
        $letter = substr ($str, $i, 1);
        // check using strops, is numeric is used as strop retuen a  number
        //(position) if found, and false otherwise
        if(! is_numeric (strpos("aeiouAEIOU", $letter))) {
          $ans = $ans . $letter;//concatenate letter to answer

        }
      }
      //generate answer after all letters are checked
        echo "<p>The word with no vowels is: " , $ans, ". </P>";
    } else {
        echo "<p>Please enter a string containing only letters or space.</p>";
        }
    } else {
        echo "<p>Please enter string from the input form.</p>";
    }
?> 
</body> 
</html>