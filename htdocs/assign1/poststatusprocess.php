<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Post Status Result</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Status Posting Result</h1>

<div class="content">
<?php
  require_once('../../files/sqlinfo.inc.php');

  $conn = mysqli_connect($sql_host, $sql_user, $sql_pass, $sql_db);
  // Check if the connectionis failed
  if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
  }
  // Sanitize and retrieve form data
  $statusCode = mysqli_real_escape_string($conn, trim($_POST['stcode'] ?? ''));
  $statusText = mysqli_real_escape_string($conn, trim($_POST['st'] ?? ''));
  $share = mysqli_real_escape_string($conn, trim($_POST['share'] ?? ''));
  $date = mysqli_real_escape_string($conn, trim($_POST['date'] ?? ''));
  $permissions = $_POST['permission'] ?? [];
  $permissionStr = mysqli_real_escape_string($conn, implode(", ", $permissions));
// Check if the table exists, if not, create one
  $createTableQuery = "CREATE TABLE IF NOT EXISTS status (
    status_code VARCHAR(5) PRIMARY KEY,
    status_text VARCHAR(255) NOT NULL,
    share_option VARCHAR(20),
    date_posted VARCHAR(20),
    permission VARCHAR(100)
  )";

  mysqli_query($conn, $createTableQuery);
 // Validate status code format: must start with 'S' followed by four digits
  if (!preg_match('/^S\d{4}$/', $statusCode)) {
    echo "<p><strong>Wrong format!</strong> The status code must start with an 'S' followed by four digits, like <strong>S0001</strong>.</p>";
    echo '<a href="poststatusform.php">Return to Post Status Page</a> | <a href="index.html">Home</a>';
    exit;
  }
// Validate status text: must contain only alphanumerics and basic punctuation
  if ($statusText === '' || !preg_match('/^[A-Za-z0-9\s.,!?]+$/', $statusText)) {
    echo "<p><strong>Format error:</strong> Your status is in a wrong format! It can only contain alphanumericals, spaces, commas, periods, ! and ? — and cannot be empty!</p>";
    echo '<a href="poststatusform.php">Return to Post Status Page</a> | <a href="index.html">Home</a>';
    exit;
  }
// Check for duplicate status code
  $checkQuery = "SELECT * FROM status WHERE status_code = '$statusCode'";
  $result = mysqli_query($conn, $checkQuery);
  if (mysqli_num_rows($result) > 0) {
    echo "<p><strong>Duplicate error:</strong> The status code already exists. Please try another one! (Hint: must be <strong>unique</strong>).</p>";
    echo '<a href="poststatusform.php">Return to Post Status Page</a> | <a href="index.html">Home</a>';
    exit;
  }
// Validate date format as dd/mm/yyyy
  $dateParts = explode("/", $date);
  if (count($dateParts) === 3) {
    $isValidDate = checkdate($dateParts[1], $dateParts[0], $dateParts[2]);
  } else {
    $isValidDate = false;
  }

  if (!$isValidDate) {
    echo "<p><strong>Invalid date:</strong> Please enter a valid date in dd/mm/yyyy format.</p>";
    echo '<a href="poststatusform.php">Return to Post Status Page</a> | <a href="index.html">Home</a>';
    exit;
  }
 // Insert validated and sanitized data into the database
  $insertQuery = "INSERT INTO status (status_code, status_text, share_option, date_posted, permission)
                  VALUES ('$statusCode', '$statusText', '$share', '$date', '$permissionStr')";

  if (mysqli_query($conn, $insertQuery)) {
    echo "<p><strong>Success!</strong> The status has been <strong>posted</strong> and <strong>saved</strong> to the system!</p>";
    echo "<ul>
            <li>Status Code: $statusCode</li>
            <li>Status: $statusText</li>
            <li>Share: $share</li>
            <li>Date Posted: $date</li>
            <li>Permissions: $permissionStr</li>
          </ul>";
    echo '<a href="index.html">Return to Home Page</a>';
  } else {
    // Display error if insert fails
    echo "<p>Database error: " . mysqli_error($conn) . "</p>";
    echo '<a href="poststatusform.php">Return to Post Status Page</a>';
  }

  mysqli_close($conn);
?>
</div>

</body>
</html>