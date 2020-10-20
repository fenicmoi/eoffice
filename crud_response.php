<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "treejs";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");

$sql = "SELECT *  FROM tb_node";

$result_query = mysqli_query($conn, $sql);

if (mysqli_num_rows($result_query) > 0) {
	
	$operation = isset($_GET['operation']) ? $_GET['operation'] : NULL;
	
	$id = isset($_GET['id']) ? $_GET['id'] : NULL;
	
	$parent = isset($_GET['parent']) ? $_GET['parent'] : NULL;
	
	$text = isset($_GET['text']) ? $_GET['text'] : NULL;
	
	 while($row = mysqli_fetch_assoc($result_query)) {
		
		$data[] = array(
			'id' => $row["id"],
			'parent_id' => $row["parent_id"],
			'text' => $row["name"],
		);
	}
	
        switch($operation) {

            case 'get_node':

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
                $result = $data;
                break;
                
            case 'create_node':
                
                $node = isset($id) && $id !== '#' ? (int) $id : 0;
                
                $nodeText = isset($text) && $text !== '' ? $text : '';
				
				$sql = "INSERT INTO tb_node (id ,parent_id, name)
				VALUES (NULL,'".$parent."', '".$nodeText."')";

				if (mysqli_query($conn, $sql)) {
					
					$last_id = mysqli_insert_id($conn);

					$result = $last_id;
				}

                break;
                
            case 'rename_node':
                
                $node = isset($id) && $id !== '#' ? (int)$id : 0;
                
                $nodeText = isset($text) && $text !== '' ? $text : '';
				
				
				$sql_update_node_id = "UPDATE tb_node SET name = '".$nodeText."' WHERE id = $node";

				if (mysqli_query($conn, $sql_update_node_id)) {

				}
                
            
            break;
            case 'delete_node':
                
               $node = isset($id) && $id !== '#' ? (int)$id : 0;
								
				$sql = "DELETE FROM tb_node WHERE id=$node";

				if ($conn->query($sql) === TRUE) {
					
				}
				
            break;
        
            default:
                
            throw new Exception('Unsupported operation: ' . $operation);
                
            break;
        }

	// Encode:
	echo json_encode($result);

	
}

$conn->close();