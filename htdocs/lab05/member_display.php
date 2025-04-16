<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <title>Display VIP Members</title>
</head>
<body>
<?php
	require_once('../../files/sqlinfo.inc.php');

	$conn = @mysqli_connect($sql_host, $sql_user, $sql_pass, $sql_db);

	if (!$conn) {
		echo "<p>Database connection failure</p>";
	} else {
		$query = "SELECT member_id, fname, lname FROM vipmember";
		$result = mysqli_query($conn, $query);

		if (!$result) {
			echo "<p>Something is wrong with ", $query, "</p>";
		} else {
			echo "<h2>All VIP Members</h2>";
			echo "<table border=\"1\">";
			echo "<tr><th>Member ID</th><th>First Name</th><th>Last Name</th></tr>";

			while ($row = mysqli_fetch_assoc($result)) {
				echo "<tr>";
				echo "<td>", $row["member_id"], "</td>";
				echo "<td>", $row["fname"], "</td>";
				echo "<td>", $row["lname"], "</td>";
				echo "</tr>";
			}
			echo "</table>";

			mysqli_free_result($result);
		}

		mysqli_close($conn);
	}
?>
<a href="vip_member.php">Back to Home</a>
</body>
</html>