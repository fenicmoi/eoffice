<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "treejs";

$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");


$sql = "SELECT *  FROM tb_node";


$result_query = mysqli_query($conn, $sql);

if (mysqli_num_rows($result_query) > 0) {
	
	 while($row = mysqli_fetch_assoc($result_query)) {
		
		$data[] = array(
			'id' => $row["id"],
			'parent_id' => $row["parent_id"],
			'text' => $row["name"],
		);
	}
	
	$itemsByReference = array();

	// Build array of item references:
	foreach($data as $key => &$item) {
	   $itemsByReference[$item['id']] = &$item;
	   // Children array:
	   $itemsByReference[$item['id']]['children'] = array();
	   // Empty data class (so that json_encode adds "data: {}" ) 
	   $itemsByReference[$item['id']]['data'] = new StdClass();
	}

	// Set items as children of the relevant parent item.
	foreach($data as $key => &$item)
	   if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
		  $itemsByReference [$item['parent_id']]['children'][] = &$item;

	// Remove items that were added to parents elsewhere:
	foreach($data as $key => &$item) {
	   if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
		  unset($data[$key]);
	}

	// Encode:
	echo json_encode($data);
}

$conn->close();
?>