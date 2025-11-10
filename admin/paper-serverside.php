<?php
include 'function.php';
include '../library/database.php';
include '../library/config.php';
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


// รับค่าจากฟอร์ม  เพื่อส่งต่อไปในลิงก์รายละเอียด
$u_id = isset($requestData['u_id']) ? $requestData['u_id'] :
$puid = isset($requestData['puid']) ? $requestData['puid'] : 0;

//เงื่อนไขคือต้องเป็นแผนกตนเองเท่านั้น
$level_id = isset($requestData['level_id']) ? $requestData['level_id'] : 0;
$dep_id = isset($requestData['dep_id']) ? $requestData['dep_id'] : 0;

//ฟิลด์ที่จะเอามาแสดงและค้นหา
$columns = array( 
	0 => 'puid',
	1 => 'book_no', 
    2 => 'title',
	3 => 'dep_name',
    4 => 'pid',
	5 => 'postdate',
    6 => 'postdate',
    7 => 'pid'
);

// getting total number records without any search
//$sql="SELECT hire_id FROM hire";
//print $sql;

$sqlBase = "FROM hire h
            INNER JOIN depart d ON d.dep_id=h.dep_id
            INNER JOIN year_money y ON h.yid=y.yid
            WHERE 1=1 "; // ฐานคิวรี่เริ่มต้น

$sql="SELECT p.pid,u.puid, u.pid,p.postdate,p.title,p.file,p.book_no,d.dep_name,s.sec_name,us.firstname FROM paperuser u
      INNER JOIN paper p  ON p.pid=u.pid
      INNER JOIN depart d ON d.dep_id=p.dep_id
	  INNER JOIN section s ON s.sec_id = p.sec_id
	  INNER JOIN user as us ON us.u_id = p.u_id
      WHERE u.u_id=$u_id AND u.confirm=0 ORDER BY u.puid DESC";




if ($level_id >= 3) {
    $sqlBase .= "AND h.dep_id = " . dbEscapeString($dep_id) . " ";
}

$sql = "SELECT p.pid " . $sqlBase;
$query = dbQuery($sql);
$totalData = dbNumRows($query) or die("section 1");

$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

// ส่วนที่ 2: การดึงข้อมูลที่มีการค้นหา (Searching)
$sql = "SELECT p.*, d.dep_name, y.yname " . $sqlBase;

if (!empty($requestData['search']['value'])) { // If there is a search parameter
    $searchValue = dbEscapeString($requestData['search']['value']);
    $searchTerm = "%" . $searchValue . "%";
    
    // ต้องใช้ AND ต่อจากเงื่อนไข level_id (ถ้ามี)
    $sql .= " AND (p.pid LIKE '$searchTerm' ";
    $sql .= " OR  p.title  LIKE '$searchTerm' ";
    $sql .= " OR p.dep_name LIKE '$searchTerm' )";
}

$query = dbQuery($sql) or die("section 2");
$totalFiltered = dbNumRows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

// ส่วนที่ 3: การดึงข้อมูลพร้อมการจัดเรียงและการจำกัดจำนวน (Ordering and Limiting)
$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  
         LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
$query = dbQuery($sql) or die("section 3");

$data = array();
while( $row= dbFetchArray($query) ) {  // preparing an array

    $datein = new DateTime($row["datein"]); // วันที่บันทึก
    $today = new DateTime(); // วันที่ปัจจุบัน
    $interval = $datein->diff($today);
    $days_diff = (int)$interval->days; // ผลต่างเป็นจำนวนวัน

    // $is_disabled = ($days_diff > 3) ? 'disabled' : '';
    // $edit_button = "<a href='#' data-toggle='modal' data-target='.bs-example-modal-table' onclick='loadEditForm(".$row['hire_id'].")' class='btn btn-sm btn-primary ".$is_disabled."'>แก้ไข</a>";
    
    // ตรวจสอบเงื่อนไขเพื่อกำหนดปุ่ม
    if ($days_diff > 3) {
        // รายการเกิน 3 วัน: ใช้ปุ่ม disabled พร้อมไอคอนกุญแจล็อก
        $edit_button = "<a href='#' data-toggle='modal' data-target='.bs-example-modal-table' class='btn btn-sm btn-danger disabled' title='เกิน 3 วัน ไม่สามารถแก้ไขได้' role='button' aria-disabled='true'>
                            <i class='fa fa-lock'></i> 
                        </a>";
    } else {
        // รายการไม่เกิน 3 วัน: ใช้ปุ่มแก้ไขตามปกติ
        $edit_button = "<a href='#' data-toggle='modal' data-target='.bs-example-modal-table' onclick='loadEditForm(".$row['hire_id'].")' class='btn btn-sm btn-primary'>
                            แก้ไข
                        </a>";
    }



	$nestedData=array(); 
    $nestedData[] = $row["puid"];
	$nestedData[] = $row["rec_no"];
    $nestedData[] = thaiDate($row["datein"]);
	$nestedData[] = "<a href='#' data-toggle='modal' data-target='.bs-example-modal-table' onclick='loadData(".$row['hire_id'].",".$u_id.")'>".$row["title"]."</a>";
    $nestedData[] = number_format($row["money"],2);
	$nestedData[] = $row["dep_name"];
    $nestedData[] = "<a href='report/rep-hire-item.php?hire_id=".$row['hire_id']."' class='btn btn-sm btn-warning' target='_blank'>พิมพ์</a>"; 
	$nestedData[] = $edit_button ;
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