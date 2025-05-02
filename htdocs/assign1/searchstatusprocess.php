<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Search Status Results</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="content">
<?php
  $searchInput = $_GET['Search'] ?? '';
// Check if input is empty or whitespace only
  if (trim($searchInput) === '') {
    echo "<p><strong>Error:</strong> The search string is <strong>empty</strong> or <strong>blank</strong>. Please enter a keyword to search.</p>";
    echo '<div class="links">
            <a href="searchstatusform.html">Return to Search Page</a>
            <a href="index.html">Return to Home Page</a>
          </div>';
    exit;
  }

  require_once('../../files/sqlinfo.inc.php');

  $conn = mysqli_connect($sql_host, $sql_user, $sql_pass, $sql_db);

  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
// Check if table status exists
  $tableCheck = mysqli_query($conn, "SHOW TABLES LIKE 'status'");
  if (mysqli_num_rows($tableCheck) == 0) {
    echo "<p><strong>No status found in the system.</strong> Please go to the <a href='poststatusform.php'>post status page</a> to post one.</p>";
    exit;
  }
// Escape search input to prevent SQL injection
  $searchInputEscaped = mysqli_real_escape_string($conn, $searchInput);
  // Query to search for statuses that contain the search term
  $query = "SELECT * FROM status WHERE status_text LIKE '%$searchInputEscaped%'";
  $result = mysqli_query($conn, $query);
// Check if any results were found
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<h2>Status Information</h2>";
      echo "<p>Status: " . htmlspecialchars($row['status_text']) . "</p>";
      echo "<p>Status Code: " . htmlspecialchars($row['status_code']) . "</p>";
      echo "<br>";
      echo "<p>Share: " . htmlspecialchars($row['share_option']) . "</p>";
      // Format the date according the imgage
      $dateObj = DateTime::createFromFormat('d/m/Y', $row['date_posted']);
      if ($dateObj) {
          $dateFormatted = $dateObj->format('F j, Y');
          echo "<p>Date Posted: " . $dateFormatted . "</p>";
      } else {
          echo "<p>Date Posted: Invalid date format</p>";
      }
      echo "<p>Permission: " . htmlspecialchars($row['permission']) . "</p>";
    }
    echo '<div class="links">
            <a href="searchstatusform.html">Search for another status</a>
            <a href="index.html">Return to Home Page</a>
          </div>';
  } else {
    // If no match was found
    echo "<p>No matching status found for '<strong>$searchInput</strong>'.</p>";
    echo '<div class="links">
            <a href="searchstatusform.html">Return to Search Page</a>
            <a href="index.html">Return to Home Page</a>
          </div>';
  }

  mysqli_close($conn);
?>
</div>

</body>
</html>
