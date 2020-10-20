<?php  
header('Content-Type: application/json');
include "../library/database.php";
include "function.php";
$yid=chkYearMonth();  //ตรวจสอบปีปัจจุบัน

//ต	ัวเลขรันอัตโนมัติ
$sql="SELECT buy_id, rec_no FROM buy  WHERE yid=$yid[0] ORDER BY buy_id DESC LIMIT 1";

	$result=dbQuery($sql);
	$row=dbFetchAssoc($result);
	$rec_no=$row['rec_no'];
	if($rec_no==0){
		$rec_no=1;
	}else{
		$rec_no++;
    }
    

//รับค่า
$title = $_POST["title"];
$money_project = $_POST["money_project"];
$dep_id = $_POST["dep_id"];
$governer = $_POST["governer"];
$company = $_POST["company"];
$manager = $_POST["manager"];
$add1 = $_POST["add1"];
$signer = $_POST["signer"];
$add2 = $_POST["add2"];
$telphone = $_POST["telphone"];
$product = $_POST["product"];
$location = $_POST["location"];
$date_stop = $_POST["date_stop"];
$confirm_id = $_POST["selConFirm"];
$money = $_POST["txtMoney"];
$bank = $_POST["bank"];
$brance = $_POST["brance"];
$doc_num = $_POST["doc_num"];
$date_num = $_POST["date_num"];
$date_submit = date("Y-m-d");
$sec_id = $_POST["sec_id"];
$u_id = $_POST["u_id"];


$sql = "INSERT INTO buy(rec_no, dep_id, governer,title, money_project, company, manager, add1, signer, add2, telphone, product, location, 
date_stop, confirm_id, money, bank, brance, doc_num, date_num, date_submit, sec_id, u_id, yid)
VALUE($rec_no, $dep_id, '$governer', '$title',$money_project, '$company', '$manager', '$add1', '$signer', '$add2', '$telphone', '$product', '$location', '$date_stop', $confirm_id, 
$money, '$bank', '$brance', '$doc_num', '$date_num', '$date_submit', $sec_id, $u_id, $yid[0])";

$result = dbQuery($sql);
if($result){
    echo json_encode(array('status' => '1','message'=> 'Record add successfully'));
}  else {
    echo json_encode(array('status' => '0','message'=> 'Error insert data!'));
} 
?>