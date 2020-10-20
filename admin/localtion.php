<?php
    header("content-type: text/html; charset=utf-8");
    header ("Expires: Wed, 21 Aug 2013 13:13:13 GMT");
    header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header ("Cache-Control: no-cache, must-revalidate");
    header ("Pragma: no-cache");

    include "function.php";
    include '../library/database.php';

    $data = $_GET['data'];
    $val = $_GET['val'];


         if ($data=='province') { 
              echo "<select class=\"form-control\" name='province' onChange=\"dochange('amphur', this.value)\" required>";
              echo "<option value=''>- เลือก -</option>\n";
              $sql="select * from office_type order by type_id";
              $result = mysqli_query($dbConn,$sql);
              while($row= mysqli_fetch_array($result)){
                   echo "<option value='$row[type_id]' >$row[type_name]</option>" ;
              }
         } else if ($data=='amphur') {
              echo "<select class=\"form-control\" name='amphur' onChange=\"dochange('district', this.value)\" required>";
              echo "<option value=''>- เลือก -</option>\n";  
              $sql="SELECT * FROM depart WHERE type_id= '$val' ORDER BY dep_id DESC";
              $result = mysqli_query($dbConn, $sql);
              while($row= mysqli_fetch_array($result)){
                   echo "<option value=\"$row[dep_id]\" >$row[dep_name]</option> " ;
              }
         } else if ($data=='district') {
              echo "<select class =\"form-control\" name='district' required>\n";
              echo "<option value=''>- เลือก1 -</option>\n";
              $sql="SELECT * FROM section WHERE dep_id= '$val' ORDER BY sec_id DESC";
              $result=  mysqli_query($dbConn, $sql);
              while($row= mysqli_fetch_array($result)){
                   echo "<option value=\"$row[sec_id]\" >$row[sec_name]</option> \n" ;
              }
         }
         echo "</select>\n";
         
       // echo mysql_error();
        //closedb();
?>