<html> 
<head> 
<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
<title>Using file functions</title> 
</head> 
<body> 
<h1>Web Development - Lab05</h1> 
<?php 
 set_time_limit(60);
 require_once ("../../files/settings.php"); 
 // complete your answer here 
 $conn = new mysqli($host, $user, $pswd, $dbnm);
 if ($conn->connect_error) {
    die("Database connect failed ：" . $conn->connect_error);
}
$query = "SELECT car_id, make, model, price FROM car";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>
            <th>Car ID</th>
            <th>Make</th>
            <th>Model</th>
            <th>Price ($)</th>
          </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["car_id"] . "</td>
                <td>" . $row["make"] . "</td>
                <td>" . $row["model"] . "</td>
                <td>" . $row["price"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No records found";
}
$conn->close();     

?> 
</body> 
</html>