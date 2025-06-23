<?php
include 'functions.php';
session_start();

$infoMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['unsubscribe_email'])) {
        $_SESSION['unsubscribe_email_pending'] = $_POST['unsubscribe_email'];
        $_SESSION['unsubscribe_code'] = generateVerificationCode();
        sendUnsubscribeVerificationEmail($_SESSION['unsubscribe_email_pending'], $_SESSION['unsubscribe_code']);
        $infoMessage = "Unsubscribe verification code sent to your email.";
    } elseif (isset($_POST['unsubscribe_verification_code']) && isset($_POST['confirm_unsubscribe_email'])) {
        if ($_POST['confirm_unsubscribe_email'] === $_SESSION['unsubscribe_email_pending']) {
            if ($_POST['unsubscribe_verification_code'] === $_SESSION['unsubscribe_code']) {
                unsubscribeEmail($_POST['confirm_unsubscribe_email']);
                $infoMessage = "You have been unsubscribed.";
            } else {
                $infoMessage = "Invalid verification code.";
            }
        } else {
            $infoMessage = "Email mismatch. Please enter the same email used to request the code.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Unsubscribe from GH-Timeline</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>Unsubscribe</h2>

    <?php if (!empty($infoMessage)): ?>
        <div class="message"><?php echo $infoMessage; ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="unsubscribe_email">Email Address:</label>
        <input type="email" name="unsubscribe_email" required>
        <button id="submit-unsubscribe">Unsubscribe</button>
    </form>

    <form method="POST">
        <label for="confirm_unsubscribe_email">Re-enter Email:</label>
        <input type="email" name="confirm_unsubscribe_email" required>
        <label for="unsubscribe_verification_code">Enter Unsubscribe Code:</label>
        <input type="text" name="unsubscribe_verification_code" required>
        <button id="verify-unsubscribe">Verify</button>
    </form>
</body>
</html>
