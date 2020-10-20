<?php
	require("mysql2json.class.php");
	$hostname_connection = "XXXXXX";
	$database_connection = "XXXXXX";
	$username_connection = "XXXXXX";
	$password_connection = "XXXXXX";
	$connection = mysql_connect($hostname_connection, $username_connection, $password_connection) or trigger_error(mysql_error(),E_USER_ERROR); 
	mysql_query("SET character_set_results=utf8");
	mysql_query("SET character_set_client=utf8");
	mysql_query("SET character_set_connection=utf8");
	mysql_select_db($database_connection, $connection);
	
	$ID=$_GET[ID];
	$type=$_GET[TYPE];
	
	if($type=='Proviance'){
		$query="SELECT PROVINCE_ID, PROVINCE_NAME FROM province ORDER BY PROVINCE_NAME ASC ";
	}else if($type=='District') {
		$query="SELECT AMPHUR_ID, AMPHUR_NAME FROM amphur WHERE PROVINCE_ID='".$ID."'";
	} else if($type=='Subdistrict'){
		$query="SELECT DISTRICT_ID, DISTRICT_NAME FROM district WHERE AMPHUR_ID='".$ID."'";
	} else if($type=='Postcode'){
		$query="SELECT POST_CODE FROM amphur_postcode WHERE AMPHUR_ID='".$ID."'";
	}
	$result=mysql_query($query,$connection);
	$num=mysql_affected_rows();
	
	$json=new mysql2json;
	$data=$json->getJSON($result,$num);
	echo $data;
?>
