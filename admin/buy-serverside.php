<?php
include 'function.php';
include '../library/database.php';
include '../library/config.php';

$requestData= $_REQUEST;

// รับค่าจากฟอร์ม  เพื่อส่งต่อไปในลิงก์รายละเอียด
$u_id = isset($requestData['u_id']) ? $requestData['u_id'] : 0;
$hier_id = isset($requestData['buy_id']) ? $requestData['buy_id'] : 0;

//เงื่อนไขคือต้องเป็นแผนกตนเองเท่านั้น
$level_id = isset($requestData['level_id']) ? $requestData['level_id'] : 0;
$dep_id = isset($requestData['dep_id']) ? $requestData['dep_id'] : 0;

//ฟิลด์ที่จะเอามาแสดงและค้นหา
$columns = array( 
	0 => 'buy_id',
	1 => 'rec_no', 
    2 => 'title',
	3 => 'date_submit', // แก้ไขตำแหน่งเพื่อให้สอดคล้องกับตารางใน buy.php
    4 => 'money', // แก้ไขตำแหน่งเพื่อให้สอดคล้องกับตารางใน buy.php
	5 => 'dep_name',
);

// ส่วนที่ 1: การนับจำนวนเร็คคอร์ดทั้งหมด (Total Records)
$sqlBase=" FROM buy as b
          INNER JOIN depart as d ON d.dep_id = b.dep_id
          INNER JOIN year_money as y ON y.yid = b.yid
          WHERE 1=1 "; // ใช้ WHERE 1=1 เป็นฐานเริ่มต้นเพื่อความง่ายในการต่อ AND

if ($level_id >= 3) {
    // ใช้ AND ต่อจาก WHERE 1=1
    $sqlBase .= "AND b.dep_id = " . dbEscapeString($dep_id) . " ";
}

// *** เพิ่มการนับเรคคอร์ดทั้งหมด (Total Data) ***
$sql = "SELECT b.buy_id " . $sqlBase;
$query = dbQuery($sql);
$totalData = dbNumRows($query) or die("section 1 - Total Data Error"); // กำหนดค่า $totalData ที่นี่

$totalFiltered = $totalData;  // เมื่อไม่มีการค้นหา $totalFiltered จะเท่ากับ $totalData

// ส่วนที่ 2: การดึงข้อมูลที่มีการค้นหา (Searching)
$sql = "SELECT b.*, d.dep_name, y.yname " . $sqlBase;

if (!empty($requestData['search']['value'])) { // If there is a search parameter
    $searchValue = dbEscapeString($requestData['search']['value']);
    $searchTerm = "%" . $searchValue . "%";
    
    // ใช้ AND ต่อท้ายเงื่อนไขที่มีอยู่
    $sql .= " AND (b.rec_no LIKE '$searchTerm' "; // เปลี่ยน buy_id เป็น rec_no ตามฟิลด์ที่ควรจะค้นหา
    $sql .= " OR  b.title  LIKE '$searchTerm' ";
    $sql .= " OR d.dep_name LIKE '$searchTerm' )";
}


$query = dbQuery($sql) or die("section 2 - Search Query Error");
$totalFiltered = dbNumRows($query); // เมื่อมีการค้นหา จะต้องนับ $totalFiltered ใหม่

// ส่วนที่ 3: การดึงข้อมูลพร้อมการจัดเรียงและการจำกัดจำนวน (Ordering and Limiting)
$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  
         LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
$query = dbQuery($sql) or die("section 3 - Limit/Order Query Error");

$data = array();
while( $row= dbFetchArray($query) ) {  // preparing an array

    $datein = new DateTime($row["date_submit"]); // วันที่บันทึก
    $today = new DateTime(); // วันที่ปัจจุบัน
    $interval = $datein->diff($today);
    $days_diff = (int)$interval->days; // ผลต่างเป็นจำนวนวัน

    $is_disabled = ($days_diff > 3) ? 'disabled' : '';
    $edit_button = "<a href='#' data-toggle='modal' data-target='.bs-example-modal-table' onclick='loadEditForm(".$row['buy_id'].")' class='btn btn-sm btn-primary ".$is_disabled."'>แก้ไข</a>";
    

	$nestedData=array(); 
    $nestedData[] = $row["buy_id"]; // 0 (Hidden)
	$nestedData[] = $row["rec_no"].'/'.$row['yname']; // 1. เลขที่สัญญา
    
    // *** แก้ไขลำดับเพื่อให้ตรงกับ buy.php: [2. รายการซื้อขาย], [3. วันที่บันทึก] ***
	$nestedData[] = "<a href='#' data-toggle='modal' data-target='.bs-example-modal-table' onclick='loadData(".$row['buy_id'].",".$u_id.")'>".$row["title"]."</a>"; // 2. รายการซื้อขาย
    $nestedData[] = thaiDate($row["date_submit"]); // 3. วันที่บันทึก

    $nestedData[] = number_format($row["money"],2); // 4. จำนวนเงิน
	$nestedData[] = $row["dep_name"]; // 5. หน่วยงาน
    $nestedData[] = "<a href='report/rep-buy-item.php?buy_id=".$row['buy_id']."' class='btn btn-sm btn-warning' target='_blank'>พิมพ์</a>"; // 6. พิมพ์
	$nestedData[] = $edit_button ; // 7. แก้ไข
    $data[] = $nestedData;
}

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format
?>