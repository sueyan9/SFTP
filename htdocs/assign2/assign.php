<?php
header("Content-Type: application/json");
include('../../files/sqlinfo.inc.php');
$mysqli = new mysqli($sql_host, $sql_user, $sql_pass, $sql_db);
if ($mysqli->connect_error) { echo json_encode(["success"=>false]); exit; }
$ref = intval($_POST['ref']);
$stmt = $mysqli->prepare("UPDATE booking SET status='assigned' WHERE booking_ref=?");
$stmt->bind_param("i", $ref);
$stmt->execute();
echo json_encode(["success"=>true]);
$stmt->close();
$mysqli->close();
?>