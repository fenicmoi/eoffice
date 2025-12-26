include '../chksession.php';
include '../library/database.php';

$id = $_POST['id'] ?? '';
$sql = "SELECT * FROM depart WHERE dep_id = ?";
$result = dbQuery($sql, "i", [(int)$id]);
if($result && dbNumRows($result) > 0){
$row = dbFetchAssoc($result);
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