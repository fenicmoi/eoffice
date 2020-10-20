<?php
/*if(!isset($_SESSION['ses_u_id'])){
    header("location:../index.php");
}*/
date_default_timezone_set('Asia/Bangkok');
include "header.php"; 
$u_id=$_SESSION['ses_u_id'];
//require_once 'crud_object.php';

###วัตถุประสงค์###
$sqlobj="SELECT * FROM object ORDER BY obj_id";
$resObj=$conn->query($sqlobj);
###เลขประจำเจ้าของเรื่อง###
$sqlPrefex="SELECT d.dep_id,d.prefex 
            FROM depart d
            INNER JOIN ";

?>
    <div class="row">
        <div class="col-md-2" >
            <?php include 'menu1.php';?>
        </div>
        <div class="col-md-10">
           
            <form  action="#" method="post">
                <div class="container"
                <div class="row">
                    <div class="col-md-2" style="background-color: yellow">
                        ch1
                    </div>
                    <div class="col-md-8">
                        <div class="col-sm-offset-2 col-sm-10">
        <div class="checkbox">
          <label><input type="checkbox" name="remember"> Remember me</label>
        </div>
      </div>
                        <div class="form-group form-inline">
                            <label for="obj_id">วัตถุประสงค์ :</label>
                            <select class="form-control" id="obj_id" name="obj_name">
                                <?php 
                                while ($row=$resObj->fetch_array()){
                                echo "<option  value=".$row['obj_id'].">".$row['obj_name']."</option>";
                                }?>
                            </select>
                        </div>
                        <div class="form-group form-inline">
                            <label for="typeDoc">ประเภทหนังสือ :</label>
                            <input name="typeDoc" type="radio" value="1" checked=""> ปกติ
                            <input name="typeDoc" type="radio" value="0" disabled=""> เวียน
                            <div class="form-group">
                            <label for="prefex">เลขประจำเจ้าของเรื่อง</label>
                            <input class="form-control" type="text" name="prefex" id="prefex" value="hellojava">
                        </div>
                        </div>
                    </div>    
                    <div class="col-md-2" style="background-color: yellow;">
                        ch3
                    </div>     
                       
                  
                 </div> 
        
             </form>   
        </div>   
    </div>  
<?php include "footer.php"; ?>


