<?php
// **✅ ปรับปรุง: การจัดการ Error**
// ปิดการแสดงผล Error ใน Production (ควรเปิดใน Staging/Dev เท่านั้น)
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
// หากต้องการ Debug ให้ใช้ error_log() แทน die()

require_once 'function.php';
require_once '../library/database.php';
// require_once '../library/config.php'; // สมมติว่าไฟล์นี้มีอยู่

// **✅ Failsafe: ตรวจสอบฟังก์ชัน DB และรวม dbError (หากมี)**
// ตรวจสอบว่ามี function dbEscapeString และ dbQuery อยู่จริงหรือไม่
if (!function_exists('dbQuery') || !function_exists('dbEscapeString') || !function_exists('dbError')) {
    // ส่ง Error JSON กลับไปที่ DataTables แทน
    $json_data = array(
        "draw"            => isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : 0,
        "recordsTotal"    => 0,
        "recordsFiltered" => 0,
        "data"            => array(),
        "error"           => "Database functions (dbQuery, dbEscapeString, dbError) are missing or inaccessible. Check your includes."
    );
    echo json_encode($json_data);
    exit();
}

$requestData = $_REQUEST;

// **✅ ปรับปรุงความปลอดภัย: ใช้ dbEscapeString กับทุกตัวแปรที่รับมาจากภายนอก**
$u_id = isset($requestData['u_id']) ? (int)dbEscapeString($requestData['u_id']) : 0; 
$dep_id = isset($requestData['dep_id']) ? (int)dbEscapeString($requestData['dep_id']) : 0; 

// ฟิลด์ที่จะเอามาแสดงและค้นหา (ต้องตรงกับ <thead> ใน paper.php)
$columns = array( 
    // 0: ลำดับ (ซ่อน) -> ใช้ p.pid สำหรับ Sorting/Reference
	0 => 'p.pid', 
    1 => 'p.book_no', 
    2 => 'p.title',
	3 => 'd.dep_name',
    4 => 'checkbutton', // ปุ่มตรวจสอบ (ไม่ใช่ Field)
	5 => 'p.postdate', // วันที่ส่ง
    6 => 'posttime',   // เวลา (ไม่ใช่ Field จริงๆ แต่ใช้ p.postdate ในการจัดเรียงได้)
    7 => 'confirmbutton', // ปุ่มรับ
    8 => 'rejectbutton'   // ปุ่มคืน
);


// --- Base Query FROM (ใช้ในการนับและดึงข้อมูล) ---
$sqlFrom = " FROM paperuser u
             INNER JOIN paper p  ON p.pid=u.pid
             INNER JOIN depart d ON d.dep_id=p.dep_id
	         INNER JOIN section s ON s.sec_id = p.sec_id
	         INNER JOIN user as us ON us.u_id = p.u_id";


// --- ส่วนที่ 1: การสร้างเงื่อนไข WHERE และการนับจำนวนเร็คคอร์ด ---

$whereBase = "u.u_id='$u_id' AND u.confirm=0"; // เงื่อนไขพื้นฐาน
$whereSearch = ""; // เงื่อนไขสำหรับค้นหา (ถ้ามี)
$searchValue = "";

if (!empty($requestData['search']['value'])) {
    $searchValue = dbEscapeString($requestData['search']['value']);
    // สร้างเงื่อนไขค้นหาสำหรับหลายคอลัมน์
    $whereSearch = " AND ( p.title LIKE '%".$searchValue."%' 
                       OR p.book_no LIKE '%".$searchValue."%' 
                       OR d.dep_name LIKE '%".$searchValue."%'
                       OR s.sec_name LIKE '%".$searchValue."%' )";
}

// Full WHERE condition
$whereFull = " WHERE " . $whereBase . $whereSearch;


// 2. ดึงจำนวนเร็คคอร์ดทั้งหมด (Total Records - ไม่มีการค้นหา)
$sqlTotal = "SELECT COUNT(p.pid) AS total_count " . $sqlFrom . " WHERE " . $whereBase;
$query_count_total = dbQuery($sqlTotal);

if (!$query_count_total) {
     // Failsafe: หากนับจำนวนทั้งหมดล้มเหลว
     $json_data = array(
        "draw"            => intval( $requestData['draw'] ),
        "recordsTotal"    => 0,
        "recordsFiltered" => 0,
        "data"            => array(),
        "error"           => "SQL Total Count Error: " . dbError() . " (Query: " . $sqlTotal . ")"
    );
    echo json_encode($json_data);
    exit();
}

$row_count_total = dbFetchArray($query_count_total);
$totalData = $row_count_total ? (int)$row_count_total['total_count'] : 0;
$totalFiltered = $totalData; 


// 3. ดึงจำนวนเร็คคอร์ดที่ถูกค้นหา (Total Filtered - มีการค้นหา)
if (!empty($searchValue)) {
    $sqlFiltered = "SELECT COUNT(p.pid) AS filtered_count " . $sqlFrom . $whereFull;
    $query_count_filtered = dbQuery($sqlFiltered);
    
    if (!$query_count_filtered) {
         // Failsafe: หากนับจำนวน Filtered ล้มเหลว
         $json_data = array(
            "draw"            => intval( $requestData['draw'] ),
            "recordsTotal"    => intval( $totalData ),
            "recordsFiltered" => 0,
            "data"            => array(),
            "error"           => "SQL Filtered Count Error: " . dbError() . " (Query: " . $sqlFiltered . ")"
        );
        echo json_encode($json_data);
        exit();
    }
    
    $row_count_filtered = dbFetchArray($query_count_filtered);
    $totalFiltered = $row_count_filtered ? (int)$row_count_filtered['filtered_count'] : 0;
}


// --- ส่วนที่ 2: การดึงข้อมูลพร้อมการจัดเรียงและการจำกัดจำนวน (Ordering and Limiting) ---

// 4. Base Query สำหรับดึงข้อมูล (SELECT)
$sql = "SELECT p.pid, u.puid, p.postdate, p.title, p.file, p.book_no, d.dep_name, d.dep_id AS dep_id_current, s.sec_name, us.firstname " . $sqlFrom . $whereFull;


$orderClause = "";
if (isset($requestData['order'])) {
    // ป้องกันการ Error หาก column index เกิน bounds
    $colIndex = (int)$requestData['order'][0]['column'];
    $colName = isset($columns[$colIndex]) ? $columns[$colIndex] : $columns[0];
    $orderDir = dbEscapeString($requestData['order'][0]['dir']); // asc/desc
    
    // **✅ FIX: ตรวจสอบไม่ให้จัดเรียงด้วยคอลัมน์ที่เป็นปุ่ม (Targets 4, 7, 8)**
    if (in_array($colIndex, [4, 7, 8])) {
        // หากเป็นคอลัมน์ปุ่ม ให้จัดเรียงด้วย postdate แทน
        $orderClause = " ORDER BY p.postdate DESC "; 
    } else {
        // **✅ FIX: ใช้ชื่อคอลัมน์จริงในการจัดเรียง**
        $colForOrder = $colName;
        // หากเป็นคอลัมน์ที่ 6 (เวลา) หรือ 5 (วันที่) ให้ใช้ p.postdate
        if ($colIndex == 6 || $colIndex == 5) {
             $colForOrder = 'p.postdate';
        }
        
        $orderClause = " ORDER BY " . $colForOrder . " " . $orderDir;
    }
} else {
    // Default Order
    $orderClause = " ORDER BY p.postdate DESC";
}

$limitClause = " LIMIT " . (int)$requestData['start'] . " , " . (int)$requestData['length'];

$sql .= $orderClause . $limitClause;

$query = dbQuery($sql);
if (!$query) {
    // Error Handling: ส่ง JSON Error กลับไปที่ DataTables
    $json_data = array(
        "draw"            => intval( $requestData['draw'] ),
        "recordsTotal"    => intval( $totalData ),
        "recordsFiltered" => intval( $totalFiltered ),
        "data"            => array(),
        "error"           => "SQL Data Fetch Error: " . (function_exists('dbError') ? dbError() : 'Database error') . " (Query: " . $sql . ")"
    );
    echo json_encode($json_data);
    exit();
}


$data = array();
while( $row = dbFetchArray($query) ) { 
    $pid = (int)$row["pid"];
    $puid = (int)$row["puid"];
    $dep_id_current = (int)$row['dep_id_current']; 

    // จัดรูปแบบวันที่และเวลา
    // **ปรับปรุง: ใช้ date() และ strtotime() ในการจัดรูปแบบวันที่และเวลาให้แน่นอน**
    $postDate = isset($row['postdate']) ? date('d-m-Y', strtotime($row['postdate'])) : ''; 
    $postTime = isset($row['postdate']) ? date('H:i', strtotime($row['postdate'])) : ''; 

    // สร้างปุ่ม
    $check_button = "<a href='display_paper.php?pid=$pid' target='_blank' class='btn btn-sm btn-info fas fa-search' title='ตรวจสอบเอกสาร'></a>";
    $confirm_button = "<a href='process_confirm.php?pid=$pid&puid=$puid&dep_id=$dep_id_current' class='btn btn-sm btn-success fas fa-check btn-confirm-action' title='ยืนยันการรับ'></a>";
    $reject_button = "<a href='#' data-toggle='modal' data-target='.bs-example-modal-table' onclick='loadData($pid, $puid, $dep_id_current)' class='btn btn-sm btn-danger fas fa-reply' title='ส่งคืน'></a>";
    
	$nestedData=array(); 	
	$nestedData[] = $row["pid"]; // 0: สำหรับคอลัมน์ที่ซ่อน/อ้างอิง
    $nestedData[] = $row["book_no"]; // 1
    $nestedData[] = $row["title"]; // 2
	$nestedData[] = $row['dep_name']; // 3
    $nestedData[] = $check_button; // 4
	$nestedData[] = $postDate; // 5
    $nestedData[] = $postTime; // 6
    $nestedData[] = $confirm_button; // 7
    $nestedData[] = $reject_button; // 8
	$data[] = $nestedData;
}


$json_data = array(
    "draw"            => intval( $requestData['draw'] ),   
    "recordsTotal"    => intval( $totalData ),  
    "recordsFiltered" => intval( $totalFiltered ), 
    "data"            => $data   
);

// **✅ จุดสำคัญ: echo เฉพาะ JSON เท่านั้น**
echo json_encode($json_data);
// **✅ FIX: ห้ามมีโค้ด, ช่องว่าง, หรือแท็กปิด ?>**