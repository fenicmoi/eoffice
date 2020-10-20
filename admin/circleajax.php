
<?php
date_default_timezone_set('Asia/Bangkok');
include 'function.php';
include '../library/database.php';

$requestData= $_REQUEST;
$columns = array( 
    0 => 'cid', 
    1 => 'rec_no',
    2 => 'title',
    3 => 'date',
    );

$sql="SELECT * FROM  flowcircle ";
$result = dbQuery($sql);
$totalData = dbNumRows($result);
$totalFiltered = $totalData;

$sql = "SELECT * FROM flowcircle WHERE 1=1";
//echo $sql;
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql.=" AND ( cid LIKE '".$requestData['search']['value']."%' ";    
    $sql.=" OR rec_no LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR titleLIKE '".$requestData['search']['value']."%' )";
    $sql.=" OR date '".$requestData['search']['value']."%' )";
}
$query=dbQuery($sql);
$totalFiltered = dbNumRows($query);
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
$query=dbQuery($sql);

$data = array();
while( $row=dbFetchArray($query) ) {  // preparing an array
    $nestedData=array(); 
    $nestedData[] = $row["cid"];
    $nestedData[] = $row["rec_no"];
    $nestedData[] = $row["title"];
    $nestedData[] = $row["date"];
    $data[] = $nestedData;
}

$json_data = array(
   "draw" => intval( $requestData['draw'] ),
   "recordsTotal" => intval( $totalData ),  // total number of records
   "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
   "data"            => $data   // total data array
   );

echo json_encode($json_data);  // send data as json format
?>