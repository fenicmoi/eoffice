<?php
session_start();
session_unset();
session_destroy();
echo "Session cleared! You are now logged out.<br><br>";
echo "<a href='deskboard.php'>Try accessing deskboard.php now (should redirect to login)</a><br>";
echo "<a href='../index.php'>Go to login page</a>";
?>