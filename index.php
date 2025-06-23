<?php
include 'functions.php';
session_start();

$infoMessage = "";
$showUnsubscribeLink = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'])) {
        $_SESSION['email_pending_verification'] = $_POST['email'];
        $_SESSION['verification_code'] = generateVerificationCode();
        sendVerificationEmail($_SESSION['email_pending_verification'], $_SESSION['verification_code']);
        $infoMessage = "Verification code sent to your email.";
    } elseif (isset($_POST['verification_code']) && isset($_POST['verify_email'])) {
        if ($_POST['verify_email'] === $_SESSION['email_pending_verification']) {
            if ($_POST['verification_code'] === $_SESSION['verification_code']) {
                registerEmail($_POST['verify_email']);
                $infoMessage = "Email verified and registered.";
                $showUnsubscribeLink = true;
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
    <title>GH-Timeline Subscription</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #e8f5e9;
            border: 1px solid #c8e6c9;
            color: #2e7d32;
        }
        .unsubscribe-btn {
            display: inline-block;
            margin-top: 10px;
            background-color: #d32f2f;
            color: white;
            padding: 10px 16px;
            text-decoration: none;
            border-radius: 4px;
        }
        .unsubscribe-btn:hover {
            background-color: #b71c1c;
        }
    </style>
</head>
<body>
    <h2>Subscribe to GitHub Timeline Updates</h2>

    <?php if (!empty($infoMessage)): ?>
        <div class="message"><?php echo $infoMessage; ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="email">Email Address:</label>
        <input type="email" name="email" required>
        <button id="submit-email">Submit</button>
    </form>

    <form method="POST">
        <label for="verify_email">Re-enter Email:</label>
        <input type="email" name="verify_email" required>
        <label for="verification_code">Enter Verification Code:</label>
        <input type="text" name="verification_code" maxlength="6" required>
        <button id="submit-verification">Verify</button>
    </form>

    <?php if ($showUnsubscribeLink): ?>
        <a class="unsubscribe-btn" href="unsubscribe.php">Click here to unsubscribe</a>
    <?php endif; ?>
</body>
</html>
