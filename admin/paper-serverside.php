<?php
include 'function.php';
include '../library/database.php';
include '../library/config.php';

$requestData = $_REQUEST;

$u_id = isset($requestData['u_id']) ? $requestData['u_id'] : 0;
$dep_id = isset($requestData['dep_id']) ? $requestData['dep_id'] : 0;
$sec_id = isset($requestData['sec_id']) ? $requestData['sec_id'] : 0;
$level_id = isset($requestData['level_id']) ? $requestData['level_id'] : 0;

$columns = array(
    0 => 'u.puid',
    1 => 'p.book_no',
    2 => 'p.title',
    3 => 'd.dep_name',
    4 => 'p.pid',
    5 => 'p.postdate',
    6 => 'p.postdate',
    7 => 'p.pid',
    8 => 'p.pid'
);

$sqlBase = " FROM paperuser u
      INNER JOIN paper p  ON p.pid=u.pid
      INNER JOIN depart d ON d.dep_id=p.dep_id
      INNER JOIN section s ON s.sec_id = p.sec_id
      INNER JOIN user as us ON us.u_id = p.u_id
      WHERE u.u_id=" . (int) $u_id . " AND u.confirm=0 ";

$params = [];
$types = "";

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

$sql = "SELECT p.pid, u.puid, u.pid as upid, p.postdate, p.title, p.file, p.book_no, d.dep_name, s.sec_name, us.firstname " . $sqlSearch;
$query = dbQuery($sql, $searchTypes, $searchParams);
$totalFiltered = dbNumRows($query);

// Ordering
$orderColumnIndex = isset($requestData['order'][0]['column']) ? (int) $requestData['order'][0]['column'] : 0;
$orderDir = isset($requestData['order'][0]['dir']) && $requestData['order'][0]['dir'] === 'asc' ? 'ASC' : 'DESC';

// Default ordering
if ($orderColumnIndex == 0 && empty($requestData['order'])) {
    $orderColumn = 'u.puid';
    $orderDir = 'DESC';
} else {
    $sortColumns = array(
        0 => 'u.puid',
        1 => 'p.book_no',
        2 => 'p.title',
        3 => 'd.dep_name',
        5 => 'p.postdate',
        6 => 'p.postdate',
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

while ($rowNew = dbFetchArray($query)) {
    $nestedData = array();

    // 0: Icon
    $nestedData[] = '<i class="fas fa-envelope-square"></i>';

    // 1: Book No
    $bookNoHtml = $rowNew['book_no'] == null ? "..." : htmlspecialchars($rowNew['book_no']);
    $nestedData[] = '<span class="highlight-target">' . $bookNoHtml . '</span>';

    // 2: Title and Attachments
    $titleHtml = '<div class="highlight-target" style="font-weight: 700; margin-bottom: 5px;">' . htmlspecialchars($rowNew['title']) . '</div>';

    $titleHtml .= '<div class="attachment-list">';
    $sqlFiles = "SELECT * FROM paper_file WHERE pid = ?";
    $resFiles = dbQuery($sqlFiles, "i", [$rowNew['pid']]);
    while ($fRow = dbFetchArray($resFiles)) {
        $titleHtml .= '<a href="download.php?file=' . urlencode($fRow['file_path']) . '" target="_blank" class="btn btn-xs btn-default" style="margin-right: 2px; margin-bottom: 2px;" title="' . htmlspecialchars($fRow['file_name']) . '"><i class="fas fa-paperclip text-primary"></i> <small>' . htmlspecialchars($fRow['file_name']) . '</small></a>';
    }

    if (dbNumRows($resFiles) == 0 && !empty($rowNew['file'])) {
        $titleHtml .= '<a href="download.php?file=' . urlencode($rowNew['file']) . '" target="_blank" class="btn btn-xs btn-default" title="ดาวน์โหลด"><i class="fas fa-file-pdf text-danger"></i> ไฟล์หลัก</a>';
    }
    $titleHtml .= '</div>';
    $nestedData[] = $titleHtml;

    // 3: Department Name (Sender)
    $nestedData[] = htmlspecialchars($rowNew['dep_name']);

    // 4: Track
    $nestedData[] = '<a href="checklist.php?pid=' . $rowNew['pid'] . '" class="badge" target="_blank">หน่วยรับร่วม</a>';

    // 5: Post Date
    $nestedData[] = thaiDate(substr($rowNew['postdate'], 0, 10));

    // 6: Post Time
    $nestedData[] = substr($rowNew['postdate'], 10);

    // 7: Receive
    if ($level_id > 5) {
        $nestedData[] = '<kbd>จำกัดสิทธิ์</kbd>';
    } else {
        $nestedData[] = '<a class="btn btn-warning" href="recive.php?pid=' . $rowNew['pid'] . '&sec_id=' . $sec_id . '&dep_id=' . $dep_id . '&confirm=1"><i class="fas fa-check"></i> ลงรับ</a>';
    }

    // 8: Return
    if ($level_id > 5) {
        $nestedData[] = '<kbd>จำกัดสิทธิ์</kbd>';
    } else {
        $nestedData[] = '<a class="btn btn-danger" href="recive.php?pid=' . $rowNew['pid'] . '&sec_id=' . $sec_id . '&dep_id=' . $dep_id . '&confirm=2"><i class="fa fa-close"></i> ส่งคืน</a>';
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