<?php
/**
* Filename:admin.php
 * Student : Xu Yan
 * Student ID: mng2178
  * Description:
  *     This PHP script handles both booking assignment and search for the admin interface.
  *     It supports:
  *       - POST: Assigning a booking reference by updating its status
  *       - GET: Searching for a booking by reference, or
  *              listing all unassigned bookings within the next 2 hours
  *     The script returns JSON-encoded responses.
 Notes:
  *     - This script requires the sqlinfo.inc.php configuration file.
  */
header("Content-Type: application/json");
include('../../files/sqlinfo.inc.php');

$mysqli = new mysqli($sql_host, $sql_user, $sql_pass, $sql_db);
if ($mysqli->connect_error) {
    echo json_encode(["success" => false, "error" => "Database connection failed."]);
    exit;
}

// Handle POST (assign booking)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ref = $_POST['ref'] ?? '';

    if (!preg_match('/^BRN\d{5}$/', $ref)) {
        echo json_encode(["success" => false, "error" => "Invalid booking reference"]);
        exit;
    }

    $stmt = $mysqli->prepare("UPDATE booking SET status='assigned' WHERE booking_ref=? AND status='unassigned'");
    $stmt->bind_param("s", $ref);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Booking not found or already assigned"]);
    }

    $stmt->close();
    $mysqli->close();
    exit;
}

// Handle GET (search or list)
$bsearch = $_GET['bsearch'] ?? null;

if  ($bsearch !== null && $bsearch !== '')  {
    // Search by booking reference
    if (!preg_match('/^BRN\d{5}$/', $bsearch)) {
        echo json_encode(["error" => "Invalid booking reference"]);
        $mysqli->close();
        exit;
    }

    $stmt = $mysqli->prepare("SELECT * FROM booking WHERE booking_ref = ?");
    $stmt->bind_param("s", $bsearch);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Get bookings within next 2 hours that are unassigned
    $query = "
        SELECT * FROM booking
        WHERE status = 'unassigned'
            AND CONCAT(pickup_date, ' ', pickup_time)
                       BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 2 HOUR)
        ORDER BY pickup_date, pickup_time
    ";
    $result = $mysqli->query($query);
}

$bookings = [];
while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}

echo json_encode($bookings);
$mysqli->close();
?>