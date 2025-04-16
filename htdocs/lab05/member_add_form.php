<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New VIP Member</title>
</head>
<body>
    <h2>Add New VIP Member</h2>

    <form method="post" action="member_add.php">
        <p>
            <label for="fname">First Name:</label>
            <input type="text" name="fname" id="fname" required>
        </p>
        <p>
            <label for="lname">Last Name:</label>
            <input type="text" name="lname" id="lname" required>
        </p>
        <p>
            <label for="gender">Gender (M/F):</label>
            <input type="text" name="gender" id="gender" maxlength="1" required>
        </p>
        <p>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </p>
        <p>
            <label for="phone">Phone:</label>
            <input type="text" name="phone" id="phone" required>
        </p>
        <input type="submit" value="Add Member">
    </form>

    <p><a href="vip_member.php">Back to Home</a></p>
</body>
</html>