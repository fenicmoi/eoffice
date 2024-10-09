<?php  
// Start the session  
session_start();  

// Check if the user is logged in  
if (isset($_SESSION['user_id'])) {  
    // User is logged in, check if they are online  
    if (time() - $_SESSION['last_activity'] < 300) { // 5 minutes  
        echo "User is online";  
    } else {  
        echo "User is offline";  
    }  
} else {  
    echo "User is not logged in";  
}  

// Update the last activity time  
$_SESSION['last_activity'] = time();  
?>