<?php
//สารบรรณประจำหน่วยงาน
if(!isset($_SESSION['ses_u_id'])){
	header("location:../index.php");
}
//นำหนังสือรอลงรับไปแสดง
$sql="SELECT m.book_id,m.rec_id,d.book_no,d.title,d.sendfrom,d.sendto,d.date_in,d.date_line,d.practice,d.status,s.sec_code
      FROM book_master m
      INNER JOIN book_detail d ON d.book_id = m.book_id
      INNER JOIN section s ON s.sec_id = m.sec_id
      WHERE m.type_id=1 AND d.status ='' AND d.practice=$dep_id";
$result = dbQuery($sql);
$num_row = dbNumRows($result);
?>
<div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
              <a href="index_admin.php"><i class="fas fa-list" aria-hidden="true"></i> เมนูหลัก</a>
        </h4>
      </div>
</div>
<div class="panel-group" id="accordion">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
              <i class="fa fa-cog" aria-hidden="true"></i> Setup
          </a>
        </h4>
      </div>
      <div id="collapse1" class="panel-collapse collapse">
          <div class="panel-body">
              <a href="index_admin.php" class="btn btn-danger btn-block" href>
                  <i class="fa fa-home" aria-hidden="true"></i> หน้าหลัก</a>
              <a href="section.php" class="btn btn-danger btn-block">
                 <i class="fa fa-sitemap"></i> กลุ่มงาน/สาขาย่อย</a>
              <a href="user.php" class="btn btn-danger btn-block">
                 <i class="fa fa-user"></i> ผู้ใช้งาน</a>
          </div>
      </div>
    </div>
    <div class="panel panel-info">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
              <i class="fa fa-credit-card" aria-hidden="true"></i> ทะเบียนคุมเอกสารการจัดซื้อจัดจ้าง
          </a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body">
            <a class="btn btn-primary btn-block" href="hire.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i> สัญญาจ้าง</a>
            <a class="btn btn-primary btn-block" href="buy.php" ><i class="far fa-arrow-alt-circle-right  pull-left"></i> สัญญาซื้อ/ขาย</a>
            <a class="btn btn-primary btn-block" href="announce.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i>เอกสารประกวดราคา</a>
        </div>
      </div>
    </div>
    <div class="panel panel-info">
      <div class="panel-heading">
        <h4 class="panel-title">
            <span class="fa fa-id-card"></span><a data-toggle="collapse" data-parent="#accordion" href="#collapse4"> ส่งเอกสาร</a>
        </h4>
      </div>
      <div id="collapse4" class="panel-collapse collapse">
            <div class="panel-body">
            <div class="panel-body">
            <a class="btn btn-primary btn-block" href="paper.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i>ส่งเอกสาร</a>
            </div>
        </div>
      </div>
    </div>
       <div class="panel panel-info">
      <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fab fa-app-store"></i></span><a data-toggle="collapse" data-parent="#accordion" href="#collapse5"> ระบบสนับสนุนอื่นๆ</a>
        </h4>
      </div>
      <div id="collapse5" class="panel-collapse collapse">
          <div class="panel-body">
            <div class="panel-body">
              <a class="btn btn-primary btn-block" href="http://www.phangnga.go.th/meeting/index.php" target="_blank">ระบบจองห้องประชุม</a>
              <a class="btn btn-primary btn-block" href="http://www.phangnga.go.th/calendar/" target="_blank">ระบบนัดงานผู้บริหาร</a>
              <a class="btn btn-primary btn-block" href="">ระบบลงประกาศ</a>
          </div>
      </div>
      </div>
    </div>
     <div class="panel panel-info">
        <div class="panel-heading">
          <h4 class="panel-title">
            <i class="fas fa-book"></i><a data-toggle="collapse" data-parent="#accordion" href="#collapse6"> คู่มือการใช้งาน</a>
          </h4>
        </div>
      <div id="collapse6" class="panel-collapse collapse">
            <div class="panel-body">
              <div class="panel-body">
              <a class="btn btn-primary btn-block" href=""><i class="far fa-arrow-alt-circle-right  pull-left"></i>E-Office 2.0</a>
              <a class="btn btn-primary btn-block" href="" target="_blank"><i class="far fa-arrow-alt-circle-right  pull-left"></i>ระบบจองห้องประชุม</a>
              <a class="btn btn-primary btn-block" href=""><i class="far fa-arrow-alt-circle-right  pull-left"></i>การลงประกาศ</a>
              </div>
            </div>
      </div>
    </div>
 </div>

 <div class="panel panel-warning">
      <div class="panel-heading">
        <h4 class="panel-title">
              <a href="FlowResiveProvince.php"><i class="fas fa-envelope-square"></i> หนังสือเข้าใหม่<span class="badge"><?=$num_row?></span>ฉบับ</a>
        </h4>
      </div>

       <?php
 $sql="SELECT u.puid, u.pid,p.postdate,p.title,p.file,d.dep_name FROM paperuser u
      INNER JOIN paper p  ON p.pid=u.pid
      INNER JOIN depart d ON d.dep_id=p.dep_id
      WHERE u.u_id=$u_id AND u.confirm=0 ORDER BY u.puid" ;
 $result = dbQuery($sql);
$num = dbNumRows($result);
 ?>
 
      <div class="panel-heading">
        <h4 class="panel-title">
              <a href="paper.php"><i class="fas fa-paper-plane"></i> เอกสารเข้าใหม่<span class="badge"><?=$num?></span>ฉบับ</a>
        </h4>
      </div>
      <div class="panel-heading">
        <h4 class="panel-title">
                <img width=100 hight=100 src="../images/line.jpg"/>
        </h4>
      </div>
</div>