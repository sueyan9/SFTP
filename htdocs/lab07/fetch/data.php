<!--file data.php -->
<?php
header("Access-Control-Allow-Origin: *");
	// get name and password passed from client
	$name = $_POST['name'];
	$pwd = $_POST['pwd'];
	// sleep for 10 seconds to slow server response down
	// sleep(10);
	// write back the password concatenated to end of the name
	ECHO ($name." : ".$pwd)
?>
