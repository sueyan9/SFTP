<?php
// This page both shows the form and processes the search
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>Search VIP Members</title>
</head>
<body>
    <h1>Search VIP Members by Last Name</h1>

    <!-- Search Form -->
    <form method="post" action="">
        <label for="lname">Last Name:</label>
        <input type="text" name="lname" id="lname" required />
        <input type="submit" value="Search" />
    </form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('../../files/sqlinfo.inc.php');

    // Establish database connection
    $conn = @mysqli_connect($sql_host, $sql_user, $sql_pass, $sql_db);

    if (!$conn) {
        echo "<p>Database connection failure</p>";
    } else {
        $lname = trim($_POST["lname"]);

        // Use LIKE for partial match and escape input
        $lname_escaped = mysqli_real_escape_string($conn, $lname);
        $query = "SELECT member_id, fname, lname, gender, email FROM vipmember WHERE lname LIKE '%$lname_escaped%'";

        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo "<p>Something is wrong with the query: $query</p>";
        } else {
            echo "<h2>Search Results</h2>";
            echo "<table border='1'>";
            echo "<tr>
                    <th scope='col'>Member ID</th>
                    <th scope='col'>First Name</th>
                    <th scope='col'>Last Name</th>
                    <th scope='col'>Gender</th>
                    <th scope='col'>Email</th>
                  </tr>";

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['member_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['fname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['lname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No matching members found.</td></tr>";
            }

            echo "</table>";
            mysqli_free_result($result);
        }

        mysqli_close($conn);
    }
}
?>
<p><a href="vip_member.php">Return to Home</a></p>
</body>
</html>