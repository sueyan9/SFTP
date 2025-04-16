<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Search Status Results</title>
  <style>
    .content {
      border: 1px solid #ccc;
      padding: 20px;
      max-width: 600px;
      margin: 20px auto;
      font-family: Arial, sans-serif;
    }
  </style>
</head>
<body>

<h1>Status Search Result</h1>

<div class="content">
<?php
  $searchInput = $_GET['Search'] ?? '';

  if (trim($searchInput) === '') {
    echo "<p><strong>Error:</strong> The search string is <strong>empty</strong> or <strong>blank</strong>. Please enter a keyword to search.</p>";
    echo '<a href="searchstatusform.html">Return to Search Page</a> | <a href="index.html">Home</a>';
    exit;
  }

  // Connect to MySQL
  $host = "localhost";
  $user = "yourusername";  // Change to your actual DB username
  $password = "yourpassword"; // Change to your DB password
  $dbname = "yourdbname"; // Change to your database name

  $conn = mysqli_connect($host, $user, $password, $dbname);

  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Check if the 'status' table exists
  $tableCheck = mysqli_query($conn, "SHOW TABLES LIKE 'status'");
  if (mysqli_num_rows($tableCheck) == 0) {
    echo "<p><strong>No status found in the system.</strong> Please go to the <a href='poststatusform.php'>post status page</a> to post one.</p>";
    exit;
  }

  // Search in the status_text column
  $searchInputEscaped = mysqli_real_escape_string($conn, $searchInput);
  $query = "SELECT * FROM status WHERE status_text LIKE '%$searchInputEscaped%'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    echo "<p>Results containing '<strong>$searchInput</strong>':</p>";
    echo "<ul>";
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<li>";
      echo "<strong>Status Code:</strong> " . htmlspecialchars($row['status_code']) . "<br>";
      echo "<strong>Status:</strong> " . htmlspecialchars($row['status_text']) . "<br>";
      echo "<strong>Share:</strong> " . htmlspecialchars($row['share_option']) . "<br>";
      echo "<strong>Date:</strong> " . htmlspecialchars($row['date_posted']) . "<br>";
      echo "<strong>Permissions:</strong> " . htmlspecialchars($row['permission']) . "<br>";
      echo "</li><br>";
    }
    echo "</ul>";
    echo '<a href="index.html">Return to Home Page</a>';
  } else {
    echo "<p>No matching status found for '<strong>$searchInput</strong>'.</p>";
    echo '<a href="searchstatusform.html">Return to Search Page</a> | <a href="index.html">Home</a>';
  }

  mysqli_close($conn);
?>
</div>

</body>
</html>