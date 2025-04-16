<?php
session_start(); // start the session
// Generate a random number if not already set
if (!isset($_SESSION['randomNumber'])) {
    $_SESSION['randomNumber'] = rand(1, 100); // Random number between 1 and 100
    $_SESSION['guessCount'] = 0; // Initialize guess count
}

// Initialize variables
$message = "";
$guess = null;
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['guess'])) {
        $guess = $_POST['guess'];

        // Check if input is numeric and in range
        if (is_numeric($guess) && $guess >= 1 && $guess <= 100) {
            $_SESSION['guessCount']++; // Increment guess count

            // Compare guess with the random number
            if ($guess < $_SESSION['randomNumber']) {
                $message = "Your guess is too low!";
            } elseif ($guess > $_SESSION['randomNumber']) {
                $message = "Your guess is too high!";
            } else {
                $message = "Congratulations! You guessed the number in " . $_SESSION['guessCount'] . " attempts.";
                unset($_SESSION['randomNumber']); // Reset the game
                unset($_SESSION['guessCount']);
            }
        } else {
            $message = "Please enter a valid number between 1 and 100.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guessing Game</title>
</head>
<body>
    <h1>Guessing Game</h1>
    <p>Guess a number between 1 and 100.</p>
    <form method="POST" action="">
        <label for="guess">Your Guess:</label>
        <input type="number" id="guess" name="guess" min="1" max="100" required>
        <button type="submit">Submit</button>
    </form>
    <p><?php echo $message; ?></p>
    <p>Number of guesses: <?php echo isset($_SESSION['guessCount']) ? $_SESSION['guessCount'] : 0; ?></p>
    <a href="giveup.php">Give Up</a> | <a href="startover.php">Start Over</a>
</body>
</html>