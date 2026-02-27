<?php
include 'function.php';
include '../library/database.php';
include '../library/config.php';

$requestData = $_REQUEST;

$dep_id = isset($requestData['dep_id']) ? $requestData['dep_id'] : 0;
$sec_id = isset($requestData['sec_id']) ? $requestData['sec_id'] : 0;

$columns = array(
    0 => 'pid',
    1 => 'book_no',
    2 => 'title',
    3 => 'dep_name',
    4 => 'postdate',
    5 => 'postdate', // สำหรับเวลา
    6 => 'pid',      // ตรวจสอบ
    7 => 'pid',      // แก้ไข
    8 => 'pid'       // ยกเลิก
);

$sqlBase = " FROM paper p 
             INNER JOIN section s ON p.sec_id = s.sec_id 
             INNER JOIN depart d ON s.dep_id = d.dep_id 
             WHERE s.dep_id = ? ";

$params = [(int) $dep_id];
$types = "i";

// Total Records
$sql = "SELECT p.pid " . $sqlBase;
$query = dbQuery($sql, $types, $params);
$totalData = dbNumRows($query);
$totalFiltered = $totalData;

// Searching
$sqlSearch = $sqlBase;
$searchParams = $params;
$searchTypes = $types;

if (!empty($requestData['search']['value'])) {
    $searchValue = $requestData['search']['value'];
    $searchTerm = "%" . $searchValue . "%";

    $sqlSearch .= " AND (p.book_no LIKE ? OR p.title LIKE ?)";

    $searchParams[] = $searchTerm;
    $searchParams[] = $searchTerm;
    $searchTypes .= "ss";
}

$sql = "SELECT p.*, d.dep_name " . $sqlSearch;
$query = dbQuery($sql, $searchTypes, $searchParams);
$totalFiltered = dbNumRows($query);

// Ordering and Limiting
$orderColumnIndex = isset($requestData['order'][0]['column']) ? (int) $requestData['order'][0]['column'] : 0;
$orderDir = isset($requestData['order'][0]['dir']) && $requestData['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';

// Default order by pid DESC if no explicit order is set, or if ordering by a non-sortable column
if ($orderColumnIndex == 0 && empty($requestData['order'])) {
    $orderColumn = 'p.pid';
    $orderDir = 'DESC';
} else {
    // Column index to name mapping for sorting
    $sortColumns = array(
        0 => 'p.pid',
        1 => 'p.book_no',
        2 => 'p.title',
        3 => 'd.dep_name',
        4 => 'p.postdate',
        5 => 'p.postdate'
    );

    $orderColumn = isset($sortColumns[$orderColumnIndex]) ? $sortColumns[$orderColumnIndex] : 'p.pid';
}

$start = isset($requestData['start']) ? (int) $requestData['start'] : 0;
$length = isset($requestData['length']) ? (int) $requestData['length'] : 10;

$sql .= " ORDER BY $orderColumn $orderDir LIMIT ?, ? ";
$searchParams[] = $start;
$searchParams[] = $length;
$searchTypes .= "ii";

$query = dbQuery($sql, $searchTypes, $searchParams);

$data = array();
$searchKeyword = isset($requestData['search']['value']) ? $requestData['search']['value'] : '';

// Helper function to highlight text (same as JS but in PHP for the initial load if you want, but actually JS handles it via drawCallback usually, or we can just send text)
// However, the JS highlight logic works on `.highlight-target`. We will output raw text, and let JS highlight it if needed.

while ($rowList = dbFetchArray($query)) {
    $nestedData = array();

    // 0: ที่ (bullseye)
    $nestedData[] = '<i class="fas fa-bullseye"></i>';

    // 1: เลขหนังสือ
    $bookNoHtml = $rowList['book_no'] == null ? "..." : htmlspecialchars($rowList['book_no']);
    $nestedData[] = '<span class="highlight-target">' . $bookNoHtml . '</span>';

    // 2: เรื่องและไฟล์แนบ
    $titleHtml = '<div class="highlight-target" style="font-weight: 700; margin-bottom: 5px;">' . htmlspecialchars($rowList['title']) . '</div>';

    $titleHtml .= '<div class="attachment-list">';
    // Get attachments
    $sqlFiles = "SELECT * FROM paper_file WHERE pid = ?";
    $resFiles = dbQuery($sqlFiles, "i", [$rowList['pid']]);
    while ($fRow = dbFetchArray($resFiles)) {
        $titleHtml .= '<a href="download.php?file=' . urlencode($fRow['file_path']) . '" target="_blank" class="btn btn-xs btn-default" style="margin-right: 2px; margin-bottom: 2px;" title="' . htmlspecialchars($fRow['file_name']) . '"><i class="fas fa-paperclip text-primary"></i> <small>' . htmlspecialchars($fRow['file_name']) . '</small></a>';
    }

    if (dbNumRows($resFiles) == 0 && !empty($rowList['file'])) {
        $titleHtml .= '<a href="download.php?file=' . urlencode($rowList['file']) . '" target="_blank" class="btn btn-xs btn-default" title="ดาวน์โหลด"><i class="fas fa-file-pdf text-danger"></i> ไฟล์หลัก</a>';
    }
    $titleHtml .= '</div>';
    $nestedData[] = $titleHtml;

    // 3: หน่วยส่ง
    $nestedData[] = htmlspecialchars($rowList['dep_name']);

    // 4: วันที่ส่ง
    $nestedData[] = thaiDate($rowList['postdate']);

    // 5: เวลา
    $nestedData[] = substr($rowList['postdate'], 10);

    // 6: ตรวจสอบ
    $nestedData[] = '<a href="checklist.php?pid=' . $rowList['pid'] . '" class="btn btn-warning" target="_blank"><i class="fab fa-wpexplorer"></i> ติดตาม</a>';

    // 7 & 8: แก้ไข / ยกเลิก logic
    $d1 = $rowList['postdate'];
    $d2 = date('Y-m-d');
    $numday = getNumDay($d1, $d2);
    $isOwnSection = ($rowList['sec_id'] == $sec_id);

    // 7: แก้ไข
    if ($numday > 7) {
        $nestedData[] = '<center><i class="fab fa-expeditedssl fa-2x"></i></center>';
    } else {
        if (!$isOwnSection) {
            $nestedData[] = '<button class="btn btn-secondary" disabled style="cursor: not-allowed; opacity: 0.5;"><i class="fas fa-edit"></i> แก้ไข</button>';
        } else {
            if ($rowList['insite'] == 1) {
                $nestedData[] = '<a class="btn btn-info" href="inside_all_edit.php?pid=' . $rowList['pid'] . '"><i class="fas fa-edit"></i>แก้ไข</a>';
            } else if ($rowList['outsite'] == 1) {
                $nestedData[] = '<a class="btn btn-info" href="outside_all_edit.php?pid=' . $rowList['pid'] . '"><i class="fas fa-edit"></i>แก้ไข</a>';
            } else {
                $nestedData[] = '';
            }
        }
    }

    // 8: ยกเลิก
    if ($numday > 7) {
        $nestedData[] = '<center><i class="fab fa-expeditedssl fa-2x"></i></center>';
    } else if (!$isOwnSection) {
        $nestedData[] = '<button class="btn btn-secondary" disabled style="cursor: not-allowed; opacity: 0.5;"><i class="fas fa-trash-alt"></i> ยกเลิก</button>';
    } else {
        $nestedData[] = '<a class="btn btn-default" href="in_out_del.php?pid=' . $rowList['pid'] . '" onclick="return confirm(\'คุณกำลังจะลบข้อมูล !\'); "> <i class="fas fa-trash-alt"></i> ยกเลิก</a>';
    }

    $data[] = $nestedData;
}

$json_data = array(
    "draw" => isset($requestData['draw']) ? intval($requestData['draw']) : 1,
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data
);

echo json_encode($json_data);
?>