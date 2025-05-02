<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Post a New Status</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <h1>Status Posting System</h1>
  <form action="poststatusprocess.php" method="post">

    <label for="stcode">Status Code:</label>
    <input type="text" id="stcode" name="stcode" pattern="S[0-9]{4}" maxlength="5" required>
    <small>Format: S followed by 4 digits (e.g. S0001)</small>

    <label for="st">Status:</label>
    <input type="text" id="st" name="st" pattern="[A-Za-z0-9\s.,!?]+" required>
    <small>Only letters, numbers, comma, period, !, ?</small>

    <label>Share:</label>
    <div class="radio-group">
      <label><input type="radio" name="share" value="University" required> University</label>
      <label><input type="radio" name="share" value="Class"> Class</label>
      <label><input type="radio" name="share" value="Private"> Private</label>
    </div>

    <label for="date">Date:</label>
    <?php
    // Set the default timezone to UTC
      $today = date("d/m/Y"); 
    ?>
    <input type="text" id="date" name="date" value="<?php echo $today; ?>" required>

    <label>Permission:</label>
    <div class="checkbox-group">
      <label><input type="checkbox" name="permission[]" value="Allow Like"> Allow Like</label>
      <label><input type="checkbox" name="permission[]" value="Allow Comments"> Allow Comments</label>
      <label><input type="checkbox" name="permission[]" value="Allow Share"> Allow Share</label>
    </div>

    <div class="form-buttons">
      <input type="submit" value="Submit Status">
    </div>
  </form>

  <p><a href="index.html">Return to Home Page</a></p>

</body>
</html>