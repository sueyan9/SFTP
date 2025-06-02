<?php
/*
 * Filename:booking.php
 * Student : Xu Yan
 * Student ID: mng2178
 * Description:
  *     This PHP script handles booking submissions via POST requests.
  *     It performs the following operations:
  *       - Validates and sanitizes all input fields
  *       - Ensures pickup time is in the future
  *       - Checks for duplicate bookings by phone, date, and time
  *       - Inserts a new booking into the MySQL database
  *       - Generates a unique booking reference (e.g., BRN00001)
  *       - Returns a JSON response with status and reference ID
 Notes:
  *     - This script requires the sqlinfo.inc.php configuration file.
 */
header("Content-Type: application/json");
date_default_timezone_set('Pacific/Auckland');
// Allow POST only
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["success" => false, "error" => "Invalid request method"]);
    exit;
}
// Include database config
include('../../files/sqlinfo.inc.php');
$mysqli = new mysqli($sql_host, $sql_user, $sql_pass, $sql_db);
// Check DB connection
if ($mysqli->connect_error) {
    echo json_encode(["success" => false, "error" => "Connection failed"]);
    exit;
}
// safety function to sanitize input
function sanitize($input) {
    return htmlspecialchars(trim($input ?? ''));
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
// Basic input length validation
if (strlen($cname) > 100 || strlen($stname) > 100 || strlen($sbname) > 100 || strlen($dsbname) > 100) {
    echo json_encode(["success" => false, "error" => "Input too long"]);
    exit;
}
// Validate date format
$parts = explode('/', $date);
if (count($parts) !== 3) {
    echo json_encode(["success" => false, "error" => "Invalid date format"]);
    exit;
}
list($day, $month, $year) = $parts;
if (!checkdate((int)$month, (int)$day, (int)$year)) {
    echo json_encode(["success" => false, "error" => "Invalid date"]);
    exit;
}
$date_mysql = "$year-$month-$day";

// validate the input of phone number(10-12 digits)
if (!preg_match('/^\d{10,12}$/', $phone)) {
    echo json_encode(["success" => false, "error" => "Invalid phone number"]);
    exit;
}
//check the pickup time is in the future
$pickupTimestamp = strtotime("$date_mysql $time");
if ($pickupTimestamp === false || $pickupTimestamp <= time()) {
    echo json_encode(["success" => false, "error" => "Pickup time must be in the future"]);
    exit;
}

// check if duplicate submit
$check_stmt = $mysqli->prepare("SELECT id FROM booking WHERE phone_number = ? AND pickup_date = ? AND pickup_time = ?");
$check_stmt->bind_param("sss", $phone, $date_mysql, $time);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    echo json_encode(["success" => false, "error" => "A booking with the same phone and time already exists."]);
    $check_stmt->close();
    $mysqli->close();
    exit;
}
$check_stmt->close();

// prepare and bind the SQL statement
$bookingDT = date('Y-m-d H:i:s');
$stmt = $mysqli->prepare("INSERT INTO booking (customer_name, phone_number, unit_number, street_number, street_name, 
suburb, destination_suburb, pickup_date, pickup_time, booking_datetime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssss", $cname, $phone, $unumber, $snumber, $stname, $sbname, $dsbname, $date_mysql,$time, $bookingDT);

if ($stmt->execute()) {
    $ref_id = $mysqli->insert_id;
    $ref = 'BRN' . str_pad($ref_id, 5, '0', STR_PAD_LEFT);
    // Update the booking_ref in the database
    $update_stmt = $mysqli->prepare("UPDATE booking SET booking_ref = ? WHERE id = ?");
    $update_stmt->bind_param("si", $ref, $ref_id);
    $update_stmt->execute();
    $update_stmt->close();
    echo json_encode([
        "success" => true,
        "ref" => $ref,
        "date" => $date,
        "time" => $time
    ]);
} else {
    error_log($stmt->error);
    echo json_encode(["success" => false, "error" => $stmt->error]);
   
}
$stmt->close();
$mysqli->close();
?>
