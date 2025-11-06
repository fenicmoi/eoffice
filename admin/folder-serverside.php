<?php
// ตั้งค่าโซนเวลา
date_default_timezone_set('Asia/Bangkok');
// นำเข้าไฟล์ที่จำเป็น
include 'function.php'; 
include '../library/database.php'; 

// รับค่าจาก Datatables (POST/REQUEST)
$requestData= $_REQUEST;

// รับค่าตัวแปรจาก Client-Side (ที่ส่งผ่าน 'data' ใน Datatables ajax)
$u_id = isset($requestData['u_id']) ? $requestData['u_id'] : 0;
$dep_id = isset($requestData['dep_id']) ? $requestData['dep_id'] : 0;

// ฐานข้อมูล (ปรับให้ตรงกับโครงสร้างฐานข้อมูลของคุณ)
$mainTable = "paper AS p";
$joinTable = "paperuser AS pu";
$secTable = "section AS s"; // ตารางหน่วยงานเจ้าของเอกสาร

// ฟิลด์ที่จะเอามาแสดง (ต้องตรงกับลำดับใน Datatables [targets] และหัวตาราง HTML)
$columns = array( 
	0 => 'p.pid', // (Hidden) Primary Key
	1 => 'p.paper_name', // ชื่อเอกสาร
    2 => 'p.date_submit', // วันที่ส่ง
    3 => 's.sec_name', // หน่วยงานผู้ส่ง (หรือหน่วยงานเจ้าของ)
	4 => 'pu.confirm', // สถานะการรับ (1=ลงรับ, 2=ไม่เกี่ยวข้อง, 0=รอ)
    5 => 'pu.confirmdate', // วันที่ลงรับ
    6 => 'p.pid' // สำหรับคอลัมน์ Action (การดำเนินการ)
);

// ส่วนที่ 1: การนับจำนวนเร็คคอร์ดทั้งหมด (Total Records)
// เอกสารที่ถูกส่งมาให้หน่วยงานนี้ลงรับ
$sqlBase=" FROM $mainTable
          INNER JOIN $joinTable ON pu.pid = p.pid
          INNER JOIN $secTable ON s.sec_id = p.sec_id
          WHERE pu.dep_id = $dep_id "; // เงื่อนไขหลัก: กรองตามหน่วยงานที่ต้องลงรับ

$sql="SELECT COUNT(p.pid) AS total_count ".$sqlBase;
$query = dbQuery($sql);
$row = dbFetchAssoc($query);
$totalData = $row['total_count'];
$totalFiltered = $totalData; // โดยปกติจะถือว่ามีค่าเท่ากันก่อนการค้นหา

// ส่วนที่ 2: การจัดการการค้นหา (Searching)
$sql = "SELECT p.pid, p.paper_name, p.date_submit, s.sec_name, pu.confirm, pu.confirmdate, pu.msg_reject ".$sqlBase;

if( !empty($requestData['search']['value']) ) {
    $search_value = $requestData['search']['value'];
    
	$sql.=" AND ( p.paper_name LIKE '%".$search_value."%' "; // ค้นหาในชื่อเอกสาร
    $sql.=" OR s.sec_name LIKE '%".$search_value."%' ";      // ค้นหาในชื่อหน่วยงานผู้ส่ง
	$sql.=" OR pu.confirmdate LIKE '%".$search_value."%' )"; // ค้นหาในวันที่ลงรับ
}

// นับจำนวนแถวหลังการค้นหา (Total Filtered Records)
$query = dbQuery($sql);
$totalFiltered = dbNumRows($query);

// ส่วนที่ 3: การจัดการ Paging และ Ordering
// Ordering
if(isset($requestData['order'])) {
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  ";
} else {
	// จัดเรียงเริ่มต้นด้วย PID ล่าสุด
	$sql.=" ORDER BY p.pid DESC ";
}

// Paging
$sql.=" LIMIT ".$requestData['start']." ,".$requestData['length']." ";

// ส่วนที่ 4: ประมวลผลและส่งผลลัพธ์
$query = dbQuery($sql);

$data = array();
while( $row=dbFetchAssoc($query) ) {
    // กำหนดสถานะการรับให้เป็นข้อความและสี
    $status_text = '';
    $status_class = '';
    switch ($row['confirm']) {
        case 1:
            $status_text = 'ลงรับแล้ว';
            $status_class = 'success';
            break;
        case 2:
            $status_text = 'ไม่เกี่ยวข้อง';
            $status_class = 'danger';
            break;
        default:
            $status_text = 'รอลงรับ';
            $status_class = 'warning';
            break;
    }

    // สร้างปุ่ม Actions สำหรับคอลัมน์สุดท้าย
    $action_button = '';
    if ($row['confirm'] == 0) { // แสดงปุ่มเมื่อยังไม่ลงรับเท่านั้น (สถานะ 0)
        // ใช้ลิงก์เพื่อส่งค่ากลับไปที่ folder.php เพื่อจัดการการอัปเดตสถานะ
        $action_button .= "<a href='folder.php?confirm=1&pid={$row['pid']}' class='btn btn-sm btn-success' onclick='return confirm(\"ยืนยันการลงรับเอกสารหรือไม่?\")'><i class='fa fa-check'></i> ลงรับ</a> ";
        $action_button .= "<a href='folder.php?confirm=2&pid={$row['pid']}' class='btn btn-sm btn-danger' onclick='return confirm(\"ยืนยันว่าเอกสารไม่เกี่ยวข้องหรือไม่?\")'><i class='fa fa-times'></i> ไม่เกี่ยวข้อง</a>";
    } else {
        $action_button .= "<span class='text-{$status_class}'><i class='fa fa-info-circle'></i> {$status_text}</span>";
    }
    
	$nestedData=array(); 
    // ลำดับต้องตรงกับ $columns และหัวตาราง HTML
	$nestedData[] = $row["pid"]; // 0. (Hidden)
	$nestedData[] = $row["paper_name"]; // 1. ชื่อเอกสาร
    $nestedData[] = thaiDate($row["date_submit"]); // 2. วันที่ส่ง
    $nestedData[] = $row["sec_name"]; // 3. หน่วยงานผู้ส่ง
    $nestedData[] = "<span class='text-{$status_class}'>{$status_text}</span>"; // 4. สถานะการรับ
    $nestedData[] = $row["confirmdate"] != '0000-00-00 00:00:00' ? thaiDate($row["confirmdate"]) : '-'; // 5. วันที่ลงรับ
	$nestedData[] = $action_button; // 6. การดำเนินการ

    $data[] = $nestedData;
}

$json_data = array(
	"draw"            => intval( $requestData['draw'] ),   // ส่งค่า draw กลับไป
	"recordsTotal"    => intval( $totalData ),  // จำนวนเร็คคอร์ดทั้งหมดในตาราง
	"recordsFiltered" => intval( $totalFiltered ), // จำนวนเร็คคอร์ดหลังจาก Filter
	"data"            => $data   // ข้อมูลที่แสดงในหน้าปัจจุบัน
);

echo json_encode($json_data);
?>