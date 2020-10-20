<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>รายละเอียดสัญญา</title>
<style>
td{border:1px dashed #CCC;  }
img {
    display: block;
    margin-left: auto;
    margin-right: auto;
}
</style>
</head>

<body>

<?php
// Require composer autoload
require_once __DIR__ . '/vendor/autoload.php';
// Create an instance of the class:
$mpdf = new \Mpdf\Mpdf();

ob_start(); // ทำการเก็บค่า html นะครับ
session_start();
$dep_id=$_SESSION['ses_dep_id'];
$sec_id=$_SESSION['ses_sec_id'];

$buy_id=$_GET['buy_id'];
$dateprint=$_POST['dateprint'];
$uid=$_POST['uid'];
$yid=$_POST['yid'];
$username=$_POST['username'];



// Write some HTML code:
$mpdf->WriteHTML($buy_id);

// Output a PDF file directly to the browser
$mpdf->Output();
?>
</body>
</html>