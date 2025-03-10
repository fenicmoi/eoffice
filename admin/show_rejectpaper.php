
<?php
date_default_timezone_set('Asia/Bangkok');
include 'function.php';
include '../library/database.php';

$pid=$_POST['pid'];   // pk in paper table
$puid=$_POST['puid'];  //pk in paperuser 

?>

<form method="POST" name="frmReject" action="paper.php">
    <div class="form-group">
      <label for=""></label>
      <input type="text" name="msg_reject" id="msg_reject" class="form-control" placeholder="" aria-describedby="helpId">
      <small id="helpId" class="text-muted">กรุณาระบุเหตุผลในการส่งคืนหนังสือ</small>
    </div>
    <center>
       <input type="hidden" name="puid" id = "puid" value="<?php print $pid;?>">
       <input class="btn btn-primary btn-lg" type="submit" id = "btnReject" name="btnReject" value="ตกลง">
        <a class="btn btn-default btn-lg" href="paper.php">ยกเลิก</a>  
    </center>
    
</form>  
<center>
       
                       
</center>   



