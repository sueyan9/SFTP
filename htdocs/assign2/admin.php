<?php
header("Content-Type: application/json");
include('../../files/sqlinfo.inc.php');
$mysqli = new mysqli($sql_host, $sql_user, $sql_pass, $sql_db);
if ($mysqli->connect_error) { echo json_encode([]); exit; }
$sql = "SELECT * FROM booking ORDER BY pickup_date, pickup_time";
$result = $mysqli->query($sql);
$bookings = [];
while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}
echo json_encode($bookings);
$mysqli->close();
?>