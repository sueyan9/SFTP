<?php
if (isset($_GET['number'])) {
    $number = $_GET['number'];

    
    if (is_numeric($number)) {

        if (strpos($number, '.') !== false) {
            $message = "The value $number is not a valid integer.";
        } else {
            $number = (int)$number;
            if ($number % 2 == 0) {
                $message = "The number $number is an integer and even.";
            } else {
                $message = "The number $number is an integer but odd.";
            }
        }
    } else {
        $message = "The value $number is not a valid integer.";
    }
} else {
    $message = "Please provide a number.";
}
?>

<html>
    <body>
        <?php if (!empty($message)): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form action="iseven.php" method="GET">
            Number: <input type="text" name="number">
            <input type="submit" value="Check">
        </form>
    </body>
</html>