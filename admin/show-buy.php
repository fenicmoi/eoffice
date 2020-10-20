<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
include 'function.php';
include '../library/database.php';
session_start();
$level_id=$_SESSION['ses_level_id'];
$u_id=$_POST['u_id'];
$cid=$_POST['cid'];
$edit=$_POST['edit'];

$sql="SELECT c.*,y.yname,u.firstname,d.dep_name 
      FROM flowbuy as c 
      INNER JOIN sys_year as y ON y.yid=c.yid 
      INNER JOIN user as u ON u.u_id=c.u_id 
      INNER JOIN depart as d ON d.dep_id=c.dep_id
      WHERE c.cid=$cid
      ORDER BY c.cid DESC";

$result=dbQuery($sql);
$row=dbFetchArray($result);
?>
     <form method="POST" name="upload" action="flow-buy.php" enctype="multipart/form-data" >
         <div class="form-group">
          <div class="input-group">
              <span class="input-group-addon"><i class="fas fa-list-ul"></i> ปีที่ออกประกาศ:</span>
              <input type="text" class="form-control" name="yearDoc" value="<?php print $row['yname'] ;?>" disabled>
            </div>  
          </div>       
           <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fas fa-list-ul"></i> เลขที่อ้างอิง:</span>
                <?php echo $row['rec_id'];?>/<?php echo $row['yname'];?>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fas fa-list-ul"></i> ผู้ลงนาม:</span>
                <input type="text" class="form-control" name="boss" value="<?php print $row['boss'];?>">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fas fa-list-ul"></i> เรื่อง:</span>
                <input class="form-control" type="text" class="form-control" name="title" value="<?php print $row['title'];?>">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fas fa-list-ul"></i> วันที่ลงนาม:</span>
                <input class="form-control" type="date" name="datepicker"  id="datepicker" onKeyDown="return false" value="<?php print $row['dateline'];?>">
            </div>
         </div>
         <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fas fa-list-ul"></i> วันที่บันทึก:</span>
                <input type="text" name="currentDate"  id="currentDate" value="<?php print thaiDate($row['dateout']);?>" disabled >
            </div>
         </div>
         <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fas fa-list-ul"></i> ไฟล์เอกสารปัจจุบัน</span>
                <a href="<?php print $row['file_upload'];?>" target="_blank"><?php print trim($row['file_upload'],'buy/');?></a>
            </div>
         </div>
         <div class="form-group">
            <div class="input-group">
                <input class="form-control" type="file" name="fileupload" id="fileupload">
            </div>
         </div>
         <input type="hidden" name="cid" value="<?=$row['cid'];?>">
             <center> <button class="btn btn-success" type="submit" name="update" id="update"><i class="fas fa-save fa-2x"></i> บันทึกการเปลี่ยนแปลง</button></center>
         </form>
         
    
