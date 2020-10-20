<?php
header("Content-type:application/json; charset=UTF-8");    
header("Cache-Control: no-store, no-cache, must-revalidate");         
header("Cache-Control: post-check=0, pre-check=0", false); 
require_once("dbconnect.php");
$sql = "
 SELECT * FROM depart WHERE dep_id='".$_POST['id']."'
";
$result = $mysqli->query($sql);
if($result && $result->num_rows > 0){
    $row = $result->fetch_assoc();
        $json_data[] = array(
            "id" => $row['dep_id'],
            "name_th" => $row['dep_name']
        );
}
// แปลง array เป็นรูปแบบ json string  
if(isset($json_data)){  
    $json= json_encode($json_data);    
    if(isset($_GET['callback']) && $_GET['callback']!=""){    
    echo $_GET['callback']."(".$json.");";        
    }else{    
    echo $json;    
    }    
}