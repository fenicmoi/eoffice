<?php
class Database {
	
	public $_connect;
	public $_host = "localhost";
	public $_username = "root";
	public $_password = "";
	public $_database = "test";
	
	public function __construct(){
		
		$this->_connect = new mysqli($this->_host,$this->_username,$this->_password,$this->_database);
			
			// error connect to database
			if(mysqli_connect_error()){
				trigger_error("Failed to conencto to MySQL: " . mysql_connect_error(),
				 E_USER_ERROR);
			}
	}

	//insert image name to database
	public function addImage($img_name){
		
		$db = $this->_connect;
		$img = $db->prepare("INSERT INTO img(id,img_name) VALUES( NULL,? )");
		$img->bind_param("s",$img_name);
		if(!$img->execute()){
			echo $db->error;
		}
	
	}
	
	//delete image name form database
	public function delImage($img_name){
		
		$db = $this->_connect;
		$img = $db->prepare("DELETE FROM img WHERE img_name = ?");
		$img->bind_param("s",$img_name);
		if(!$img->execute()){
			echo $db->error;
		}
		
	}
	
}