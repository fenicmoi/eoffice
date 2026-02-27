<?php
include 'function.php';
include '../library/database.php';
include '../library/config.php';

$requestData = $_REQUEST;

$dep_id = isset($requestData['dep_id']) ? $requestData['dep_id'] : 0;
$sec_id = isset($requestData['sec_id']) ? $requestData['sec_id'] : 0;
$level_id = isset($requestData['level_id']) ? $requestData['level_id'] : 0;

$columns = array(
    0 => 'u.puid',
    1 => 'p.book_no',
    2 => 'p.title',
    3 => 'p.postdate',
    4 => 'p.postdate',
    5 => 'us.firstname',
    6 => 'd.dep_name',
    7 => 'u.confirmdate',
    8 => 'u.confirmdate',
    9 => 'ur.firstname',
    10 => 'u.confirm',
    11 => 'u.confirm',
    12 => 'u.puid'
);

$sqlBase = " FROM paperuser u
             INNER JOIN paper p ON p.pid = u.pid
             INNER JOIN depart d ON d.dep_id = p.dep_id
             INNER JOIN section s ON s.sec_id = p.sec_id
             INNER JOIN user us ON us.u_id = p.u_id
             LEFT JOIN user ur ON ur.u_id = u.u_id
             WHERE u.dep_id = ? AND u.confirm > 0 ";

$params = [(int) $dep_id];
$types = "i";

// Total Records
$sql = "SELECT u.puid " . $sqlBase;
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

$sql = "SELECT p.pid, p.postdate, u.puid, u.pid as upid, u.confirm, u.confirmdate, u.u_id as receiver_id, p.title, p.file, p.book_no, d.dep_name, s.sec_name, us.firstname as sender_name, ur.firstname as receiver_name " . $sqlSearch;
$query = dbQuery($sql, $searchTypes, $searchParams);
$totalFiltered = dbNumRows($query);

// Ordering
$orderColumnIndex = isset($requestData['order'][0]['column']) ? (int) $requestData['order'][0]['column'] : 0;
$orderDir = isset($requestData['order'][0]['dir']) && $requestData['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';

// Default ordering if index 0 or not set
if ($orderColumnIndex == 0 && empty($requestData['order'])) {
    $orderColumn = 'u.puid';
    $orderDir = 'DESC';
} else {
    $sortColumns = array(
        0 => 'u.puid',
        1 => 'p.book_no',
        2 => 'p.title',
        3 => 'p.postdate',
        4 => 'p.postdate',
        5 => 'us.firstname',
        6 => 'd.dep_name',
        7 => 'u.confirmdate',
        8 => 'u.confirmdate',
        9 => 'ur.firstname',
    );
    $orderColumn = isset($sortColumns[$orderColumnIndex]) ? $sortColumns[$orderColumnIndex] : 'u.puid';
}

$start = isset($requestData['start']) ? (int) $requestData['start'] : 0;
$length = isset($requestData['length']) ? (int) $requestData['length'] : 10;

$sql .= " ORDER BY $orderColumn $orderDir LIMIT ?, ? ";
$searchParams[] = $start;
$searchParams[] = $length;
$searchTypes .= "ii";

$query = dbQuery($sql, $searchTypes, $searchParams);

$data = array();

while ($rowf = dbFetchArray($query)) {
    $nestedData = array();

    // 0: Icon
    $nestedData[] = '<i class="far fa-envelope-open"></i>';

    // 1: Book No
    $bookNoHtml = $rowf['book_no'] == null ? "..." : htmlspecialchars($rowf['book_no']);
    $nestedData[] = '<span class="highlight-target">' . $bookNoHtml . '</span>';

    // 2: Title and Attachments
    $titleHtml = '<div class="highlight-target" style="font-weight: 700; margin-bottom: 5px;">' . htmlspecialchars($rowf['title']) . '</div>';

    $titleHtml .= '<div class="attachment-list">';
    $sqlFiles = "SELECT * FROM paper_file WHERE pid = ?";
    $resFiles = dbQuery($sqlFiles, "i", [$rowf['pid']]);
    while ($fRow = dbFetchArray($resFiles)) {
        $titleHtml .= '<a href="download.php?file=' . urlencode($fRow['file_path']) . '" target="_blank" class="btn btn-xs btn-default" style="margin-right: 2px; margin-bottom: 2px;" title="' . htmlspecialchars($fRow['file_name']) . '"><i class="fas fa-paperclip text-primary"></i> <small>' . htmlspecialchars($fRow['file_name']) . '</small></a>';
    }

    if (dbNumRows($resFiles) == 0 && !empty($rowf['file'])) {
        $titleHtml .= '<a href="download.php?file=' . urlencode($rowf['file']) . '" target="_blank" class="btn btn-xs btn-default" title="ดาวน์โหลด"><i class="fas fa-file-pdf text-danger"></i> ไฟล์หลัก</a>';
    }
    $titleHtml .= '</div>';
    $nestedData[] = $titleHtml;

    // 3: Post Date
    $nestedData[] = thaiDate($rowf['postdate']);

    // 4: Post Time
    $nestedData[] = substr($rowf['postdate'], 10);

    // 5: Sender Name
    $nestedData[] = htmlspecialchars($rowf['sender_name']);

    // 6: Department Name
    $nestedData[] = htmlspecialchars($rowf['dep_name']);

    // 7: Confirm Date
    $nestedData[] = thaiDate($rowf['confirmdate']);

    // 8: Confirm Time
    $nestedData[] = substr($rowf['confirmdate'], 10);

    // 9: Receiver Name
    if (!empty($rowf['receiver_name'])) {
        $nestedData[] = htmlspecialchars($rowf['receiver_name']);
    } else {
        $nestedData[] = "<span style='color: #999;'>-</span>";
    }

    // 10: Action (Edit) logic
    $actionHtml = '';
    if ($level_id == 3) {
        if ($rowf['confirm'] == 1) {
            $actionHtml = "<a class='btn btn-danger btn-sm' href='?pid=" . $rowf['pid'] . "&sec_id=" . $sec_id . "&dep_id=" . $dep_id . "&confirm=2' onclick='return confirm(\"ต้องการเปลี่ยนเป็นส่งคืนหรือไม่?\");'><i class='fas fa-undo'></i> ส่งคืน</a>";
        } else if ($rowf['confirm'] == 2) {
            $actionHtml = "<a class='btn btn-success btn-sm' href='?pid=" . $rowf['pid'] . "&sec_id=" . $sec_id . "&dep_id=" . $dep_id . "&confirm=1' onclick='return confirm(\"ต้องการเปลี่ยนเป็นลงรับหรือไม่?\");'><i class='fas fa-check'></i> ลงรับ</a>";
        }
    } else {
        if ($rowf['confirm'] == 1) {
            $actionHtml = "<span class='badge badge-success' style='background-color: #28a745; color: white; padding: 5px 10px;'>ลงรับแล้ว</span>";
        } elseif ($rowf['confirm'] == 2) {
            $actionHtml = "<span class='badge badge-danger' style='background-color: #dc3545; color: white; padding: 5px 10px;'>ส่งคืนแล้ว</span>";
        }
    }
    $nestedData[] = $actionHtml;

    // 11: Status Text
    if ($rowf['confirm'] == 1) {
        $nestedData[] = "<font color='green'><b>ลงรับ</b></font>";
    } elseif ($rowf['confirm'] == 2) {
        $nestedData[] = "<font color='red'><b>ส่งคืน</b></font>";
    } else {
        $nestedData[] = "";
    }

    // 12: Track Button
    $nestedData[] = '<a href="checklist.php?pid=' . $rowf['pid'] . '" class="btn btn-warning btn-sm" target="_blank" style="color: #000; font-weight: bold;"><i class="fab fa-wpexplorer"></i> ติดตาม</a>';

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