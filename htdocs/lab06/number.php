<?php 
 session_start(); // start the session 
 if (!isset ($_SESSION["number"])) { // check if session variable exists 
 $_SESSION["number"] = 0; // create the session variable 
 } 
 $num = $_SESSION["number"]; // copy the value to a variable 
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head> 
<title>Managing Session</title> 
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
</head> 
<body> 
<h1>Web Development - Lab06</h1> 
<?php 
 echo "<p>The number is $num</p>"; // displays the number 
?> 
<p><a href="numberup.php">Up</a></p> <!—links to updating page --> 
<p><a href="numberdown.php">Down</a></p> 
<p><a href="numberreset.php">Reset</a></p> 
</body> 
</html>