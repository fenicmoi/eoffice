<?php
include 'admin/function.php';
include 'library/database.php';
include 'library/config.php';
// storing  request (ie, get/post) global array to a variable  
$requestData = $_REQUEST;

$primarykey = 'id';

//ฟิลด์ที่จะเอามาแสดงและค้นหา
$columns = array(
	array('db' => 'cid', 'dt' => 0),
	array('db' => 'rec_id', 'dt' => 1),
	array('db' => 'title', 'dt' => 2),
	array('db' => 'dateline', 'dt' => 3),
);

// getting total number records without any search
$sql = "SELECT cid FROM flowcommand";
//print $sql;
$query = dbQuery($sql);

$totalData = dbNumRows($query) or die("serverside1.php: get user totalData");
//print $totalData;

$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.



$sql = "SELECT c.*,y.yname,d.dep_name,u.firstname
		FROM  flowcommand as c
		INNER JOIN sys_year as y ON y.yid=c.yid
		INNER JOIN user as u ON  u.u_id = c.u_id
		INNER JOIN depart as d ON d.dep_id =c.dep_id
		";

if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql .= " AND ( rec_id LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR title  LIKE '" . $requestData['search']['value'] . "%' ";
	$sql .= " OR dep_name LIKE '" . $requestData['search']['value'] . "%' )";
}


$query = dbQuery($sql) or die("query-commandfront.php: get view commandfront query2");
$totalFiltered = dbNumRows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  
		LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";

$query = dbQuery($sql) or die("query-commandfront.php: get use queryr3");

$data = array();
while ($row = dbFetchArray($query)) {  // preparing an array
	$nestedData = array();
	$nestedData[] = $row["rec_id"] . '/' . $row['yname'];
	if ($row['file_upload'] != '') {
		$nestedData[] = "<a href='download.php?cid=$row[cid]' target='_blank'>" . $row["title"] . "</a>";
	} else {
		$nestedData[] = $row["title"];
	}
	$nestedData[] = $row["dateline"];
	if ($row['file_upload'] == '' || is_null($row['file_upload'])) {
		$nestedData[] = "<span class='text-danger'>No File</span>";
	} else {
		$nestedData[] = "<a href='download.php?cid=$row[cid]' target='_blank' class='btn btn-xs btn-primary'><i class='fas fa-download'></i> Download</a>";
	}
	$nestedData[] = $row["dep_name"];
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