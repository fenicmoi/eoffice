<?php
date_default_timezone_set('Asia/Bangkok');
include 'function.php';
include '../library/database.php';

$pid = $_POST['pid'];   // pk in paper table
$puid = $_POST['puid'];  //pk in paperuser 
$dep_id = $_POST['dep_id'];  //depart id

?>

<form method="POST" name="frmReject" action="paper.php">
  <div class="form-group">
    <label for="msg_reject"></label>กรุณาระบุเหตุผลการส่งคืน</label>
    <select class="form-control" name="msg_reject" id="msg_reject">
      <option value="ไม่มีรายชื่อรับหนังสือ" selected>ไม่มีรายชื่อรับหนังสือ</option>
      <option value="ไม่ใ่ช่หน่วยดำเนินการ">ไม่ใช่หน่วยดำเนินการ</option>
      <option value="อื่นๆ">อื่นๆ</option>
    </select>
  </div>
  <center>
    <input type="hidden" name="puid" id="puid" value="<?php print $puid; ?>">
    <input type="hidden" name="pid" id="pid" value="<?php print $pid; ?>">
    <input type="hidden" name="dep_id" id="dep_id" value="<?php print $dep_id; ?>">
    <input class="btn btn-primary btn-lg" type="submit" id="btnReject" name="btnReject" value="ตกลง">
    <a class="btn btn-default btn-lg" href="paper.php">ยกเลิก</a>
  </center>
</form>
<center>


</center>