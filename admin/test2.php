<?php 
	$hidden = $_POST['hidden'];
	for($i=1;$i<=$hidden;$i++){
		$tel[$i] = $_POST['tel'.$i];
		echo "phone$i = "; echo $tel[$i]; echo "<br>";
	}
	
?>