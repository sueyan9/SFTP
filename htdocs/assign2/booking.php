<?php
header("Content-Type: application/json");
date_default_timezone_set('Pacific/Auckland');
//debugging
file_put_contents("debug.log", print_r($_POST, true));

// path to DB connect file
include('../../files/sqlinfo.inc.php');
// connect to the database
$mysqli = new mysqli($sql_host, $sql_user, $sql_pass, $sql_db);
if ($mysqli->connect_error) {
    echo json_encode(["success" => false, "error" => "Connection failed"]);
    exit;
}
// safety function to sanitize input
function sanitize($input) {
    return htmlspecialchars(trim($input));
}
// get the POST data
$cname = sanitize($_POST['cname']);
$phone = sanitize($_POST['phone']);
$unumber = sanitize($_POST['unumber']);
$snumber = sanitize($_POST['snumber']);
$stname = sanitize($_POST['stname']);
$sbname = sanitize($_POST['sbname']);
$dsbname = sanitize($_POST['dsbname']);
$date = sanitize($_POST['date']);
$time = sanitize($_POST['time']);
$bookingDT = date('Y-m-d H:i:s');
// validate the inpu of phone number(10-12 digits)
if (!preg_match('/^\d{10,12}$/', $phone)) {
    echo json_encode(["success" => false, "error" => "Invalid phone number"]);
    exit;
}
//check the pickup time is in the future
$pickupTime = strtotime("$date $time");
$currentTime = time();
if ($pickupTime <= $currentTime) {
    echo json_encode(["success" => false, "error" => "Pickup time must be in the future"]);
    exit;
}
//create the booking timestamp
$bookingDT = date('Y-m-d H:i:s');


// prepare and bind the SQL statement
$stmt = $mysqli->prepare("INSERT INTO booking (customer_name, phone_number, unit_number, street_number, street_name, 
suburb, destination_suburb, pickup_date, pickup_time, booking_datetime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssss", $cname, $phone, $unumber, $snumber, $stname, $sbname, $dsbname, $date, $time, $bookingDT);

if ($stmt->execute()) {
    $ref = $mysqli->insert_id;
    echo json_encode([
        "success" => true,
        "ref" => $ref,
        "date" => $date,
        "time" => $time
    ]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
   
}
$stmt->close();
$mysqli->close();
?>
