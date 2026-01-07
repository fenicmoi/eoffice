<?php
header('Content-Type: application/json');
session_start();
echo json_encode(['valid' => isset($_SESSION['ses_u_id'])]);
?>