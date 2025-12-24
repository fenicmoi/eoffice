<?php
include 'function.php';
include '../library/database.php';
include '../library/config.php';

$requestData = $_REQUEST;

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
$sqlBase = " FROM buy as b
          INNER JOIN depart as d ON d.dep_id = b.dep_id
          INNER JOIN year_money as y ON y.yid = b.yid
          WHERE 1=1 ";

$params = [];
$types = "";

if ($level_id >= 3) {
    $sqlBase .= " AND b.dep_id = ? ";
    $params[] = (int) $dep_id;
    $types .= "i";
}

// *** เพิ่มการนับเรคคอร์ดทั้งหมด (Total Data) ***
$sql = "SELECT b.buy_id " . $sqlBase;
$query = dbQuery($sql, $types, $params);
$totalData = dbNumRows($query);

$totalFiltered = $totalData;

// ส่วนที่ 2: การดึงข้อมูลที่มีการค้นหา (Searching)
$sqlSearch = $sqlBase;
$searchParams = $params;
$searchTypes = $types;

if (!empty($requestData['search']['value'])) {
    $searchValue = $requestData['search']['value'];
    $searchTerm = "%" . $searchValue . "%";

    $sqlSearch .= " AND (b.rec_no LIKE ? ";
    $sqlSearch .= " OR  b.title  LIKE ? ";
    $sqlSearch .= " OR d.dep_name LIKE ? )";

    $searchParams[] = $searchTerm;
    $searchParams[] = $searchTerm;
    $searchParams[] = $searchTerm;
    $searchTypes .= "sss";
}

$sql = "SELECT b.*, d.dep_name, y.yname " . $sqlSearch;
$query = dbQuery($sql, $searchTypes, $searchParams);
$totalFiltered = dbNumRows($query);

// ส่วนที่ 3: การดึงข้อมูลพร้อมการจัดเรียงและการจำกัดจำนวน (Ordering and Limiting)
$orderColumnIndex = (int) $requestData['order'][0]['column'];
$orderDir = ($requestData['order'][0]['dir'] === 'asc') ? 'ASC' : 'DESC';
$orderColumn = $columns[$orderColumnIndex];

$start = (int) $requestData['start'];
$length = (int) $requestData['length'];

$sql .= " ORDER BY $orderColumn $orderDir LIMIT ?, ? ";
$searchParams[] = $start;
$searchParams[] = $length;
$searchTypes .= "ii";

$query = dbQuery($sql, $searchTypes, $searchParams);

$data = array();
while ($row = dbFetchArray($query)) {

    $datein = new DateTime($row["date_submit"]);
    $today = new DateTime();
    $interval = $datein->diff($today);
    $days_diff = (int) $interval->days;

    if ($days_diff > 3) {
        $edit_button = "<a href='#' data-toggle='modal' data-target='.bs-example-modal-table' class='btn btn-sm btn-danger disabled' title='เกิน 3 วัน ไม่สามารถแก้ไขได้' role='button' aria-disabled='true'>
                            <i class='fa fa-lock'></i> 
                        </a>";
    } else {
        $edit_button = "<a href='#' data-toggle='modal' data-target='.bs-example-modal-table' onclick='loadEditForm(" . (int) $row['buy_id'] . ")' class='btn btn-sm btn-primary'>
                            แก้ไข
                        </a>";
    }

    $nestedData = array();
    $nestedData[] = (int) $row["buy_id"];
    $nestedData[] = htmlspecialchars($row["rec_no"] . '/' . $row['yname']);

    $nestedData[] = "<a href='#' data-toggle='modal' data-target='.bs-example-modal-table' onclick='loadData(" . (int) $row['buy_id'] . "," . (int) $u_id . ")'>" . htmlspecialchars($row["title"]) . "</a>";
    $nestedData[] = thaiDate($row["date_submit"]);

    $nestedData[] = number_format($row["money"], 2);
    $nestedData[] = htmlspecialchars($row["dep_name"]);
    $nestedData[] = "<a href='report/rep-buy-item.php?buy_id=" . (int) $row['buy_id'] . "' class='btn btn-sm btn-warning' target='_blank'>พิมพ์</a>";
    $nestedData[] = $edit_button;
    $data[] = $nestedData;
}

$json_data = array(
    "draw" => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
    "recordsTotal" => intval($totalData),  // total number of records
    "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
    "data" => $data   // total data array
);

echo json_encode($json_data);  // send data as json format
?>