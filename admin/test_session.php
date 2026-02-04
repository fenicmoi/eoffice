<?php
// Test session redirect
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

echo "Session Status: " . session_status() . "<br>";
echo "Session ID: " . session_id() . "<br>";
echo "ses_u_id isset: " . (isset($_SESSION['ses_u_id']) ? 'YES' : 'NO') . "<br>";
echo "ses_u_id value: " . ($_SESSION['ses_u_id'] ?? 'NOT SET') . "<br>";
echo "<br>All session data:<br>";
var_dump($_SESSION);

if (!isset($_SESSION['ses_u_id']) || empty($_SESSION['ses_u_id'])) {
    echo "<br><br>SHOULD REDIRECT - User not logged in!";
} else {
    echo "<br><br>User is logged in with ID: " . $_SESSION['ses_u_id'];
}
?>