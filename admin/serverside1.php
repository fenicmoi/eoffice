<?php
include 'function.php';
include '../library/database.php';
include '../library/config.php';
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

//ฟิลด์ที่จะเอามาแสดงและค้นหา
$columns = array( 
// datatable column index  => database column name
	0 => 'firstname', 
	1 => 'lastname',
	2 => 'position',
);

// getting total number records without any search
$sql = "SELECT firstname, lastname, position";
$sql.=" FROM user";

$query = dbQuery($sql);


//$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
//$totalData = mysqli_num_rows($query);
$totalData = dbNumRows($query) or die("serverside1.php: get user totalData");

$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT firstname, lastname, position ";
$sql.=" FROM user WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( firstname LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR lastname  LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR position LIKE '".$requestData['search']['value']."%' )";
}

//$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
$query = dbQuery($sql) or die("serverside1.php: get user query2");
$totalFiltered = dbNumRows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" 
        ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  
		LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc*/	
//$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
//echo $requestData['length'];
//echo $sql;
$query = dbQuery($sql) or die("serverside1.php: get use query3r");

$data = array();
while( $row= dbFetchArray($query) ) {  // preparing an array
	$nestedData=array(); 
	$nestedData[] = $row["firstname"];
	$nestedData[] = $row["lastname"];
	$nestedData[] = $row["position"];
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