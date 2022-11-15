<?php
if(!isset($_SESSION['ses_u_id'])){
	header("location:../index.php");
}
?>
<div class="panel panel-primary">
      <div class="panel-heading">
        <h4 class="panel-title">
              <i class="fas fa-list" aria-hidden="true"></i> เมนูหลัก
        </h4>
      </div>
</div>
<div class="panel-group" id="accordion">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
              <i class="fa fa-cog" aria-hidden="true"></i> Administrator
          </a>
        </h4>
      </div>
      <div id="collapse1" class="panel-collapse collapse">
          <div class="panel-body">
              <a href="index_admin.php" class="btn btn-primary btn-block" href><i class="fas fa-home pull-left" aria-hidden="true"></i> หน้าหลัก</a>
              <a href="year.php" class="btn btn-primary btn-block" href><i class="fas fa-calendar-alt  pull-left" aria-hidden="true"></i> จัดการปีปฏิทิน-ทะเบียนเอกสาร</a>
              <a href="year-buy.php" class="btn btn-primary btn-block" href><i class="fas fa-calendar-alt  pull-left" aria-hidden="true"></i> จัดการปีปฏิทิน-ทะเบียนสัญญา</a>
              <a href="object.php" class="btn btn-primary btn-block" href><i class="fas fa-key pull-left"></i> วัตถุประสงค์ </a>
              <a href="speed.php" class="btn btn-primary btn-block"><i class="fas fa-paper-plane pull-left"></i> ชั้นความเร็ว</a>
              <a href="secret.php" class="btn btn-primary btn-block"><i class="fas fa-low-vision pull-left"></i> ชั้นความลับ</a>
              <a href="officeType.php" class="btn btn-primary btn-block"><i class="fas fa-building pull-left"></i> ประเภทหน่วยงาน</a>
              <a href="depart.php" class="btn btn-primary btn-block"><i class="fas fa-building pull-left"></i> หน่วยงานในจังหวัด</a>
              <a href="section.php" class="btn btn-primary btn-block"><i class="fa fa-sitemap pull-left"></i> กลุ่มงาน/สาขาย่อย</a>
              <a href="user_group.php" class="btn btn-primary btn-block"><i class="fas fa-users pull-left"></i> กลุ่มผู้ใช้งาน</a>
              <a href="user.php" class="btn btn-primary btn-block"><i class="fas fa-user pull-left"></i> ผู้ใช้งาน</a>
              <a href="boss.php" class="btn btn-primary btn-block"><i class="fas fa-user-circle pull-left"></i> ผู้บริหาร</a>
              <a href="server-status.php" class="btn btn-primary btn-block"><i class="fas fa-server pull-left"></i> เครื่องแม่ข่าย</a>   
              <a href="static.php" class="btn btn-primary btn-block"><i class="fas fa-chart-pie pull-left"></i> ข้อมูลทั่วไป</a> 
              <a href="backup.php" class="btn btn-primary btn-block"><i class="fas fa-database pull-left"></i> สำรองฐานข้อมูล</a> 
          </div>
      </div>
    </div>
    <div class="panel panel-info">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
              <i class="fa fa-credit-card" aria-hidden="true"></i> ทะเบียนคุมสัญญา
          </a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body">
            <a class="btn btn-primary btn-block" href="hire.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i> สัญญาจ้าง</a>
            <a class="btn btn-primary btn-block" href="buy.php" ><i class="far fa-arrow-alt-circle-right  pull-left"></i> สัญญาซื้อ/ขาย</a>
            <!-- <a class="btn btn-primary btn-block" href="announce.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i> ประกาศสอบราคา</a> -->
        </div>
      </div>
    </div>
    <div class="panel panel-info">
      <div class="panel-heading">
        <h4 class="panel-title">
            <span class="fa fa-briefcase"></span><a data-toggle="collapse" data-parent="#accordion" href="#collapse3"> เลขคำสั่งจังหวัด</a>
        </h4>
      </div>
      <div id="collapse3" class="panel-collapse collapse">
        <div class="panel-body">
           <div class="panel-body">
            <a class="btn btn-primary btn-block" href="flow-resive-province.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i> หนังสือรับจังหวัด</a>
            <a class="btn btn-primary btn-block" href="FlowResiveDepart.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i> หนังสือรับหน่วยงาน</a>
            <a class="btn btn-primary btn-block" href="flow-resive-group.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i> หนังสือรับกลุ่มงาน</a>
            <hr>
            <a class="btn btn-primary btn-block" href="flow-circle.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i> หนังสือส่ง[เวียน]</a>
            <a class="btn btn-primary btn-block" href="flow-normal.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i> หนังสือส่ง[ปกติ]</a>
            <a class="btn btn-primary btn-block" href="underconstruction.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i> ออกเลข[หน่วยงาน]</a> 
            <a class="btn btn-primary btn-block" href="flow-command.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i> ออกเลขคำสั่ง</a>
          </div>
        </div>
      </div>
    </div>
    <div class="panel panel-info">
      <div class="panel-heading">
        <h4 class="panel-title">
            <span class="fa fa-id-card"></span><a data-toggle="collapse" data-parent="#accordion" href="#collapse4"> ส่งเอกสาร/ติดตามแฟ้ม</a>
        </h4>
      </div>
      <div id="collapse4" class="panel-collapse collapse">
            <div class="panel-body">
            <div class="panel-body">
            <a class="btn btn-primary btn-block" href="paper.php"><i class="fas fa-envelope  pull-left"></i>จดหมายเข้า</a>
            <a class="btn btn-primary btn-block" href="folder.php"><i class="far fa-envelope-open  pull-left"></i>รับแล้ว</a>
            <a class="btn btn-primary btn-block" href="history.php"><i class="fas fa-folder-open  pull-left"></i>ส่งแล้ว</a>
            <a class="btn btn-primary btn-block" href="inside_all.php"><i class="fas fa-home  pull-left"></i>ส่งภายใน</a>
            <a class="btn btn-primary btn-block" href="outside_all.php"><i class="fas fa-paper-plane pull-left"></i>ส่งภายนอก</a>
            <a class="btn btn-primary btn-block" href="follow.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i> ระบบติดตามแฟ้ม</a>
            <a class="btn btn-primary btn-block" ><i class="far fa-arrow-alt-circle-right  pull-left"></i>ตรวจแฟ้ม[สำหรับเลขาฯ]</a>
            </div>
        </div>
      </div>
    </div>
    <div class="panel panel-info">
      <div class="panel-heading">
        <h4 class="panel-title">
           <i class="fab fa-app-store"></i><a data-toggle="collapse" data-parent="#accordion" href="#collapse5"> ระบบสนับสนุนอื่นๆ</a>
        </h4>
      </div>
      <div id="collapse5" class="panel-collapse collapse">
            <div class="panel-body">
            <div class="panel-body">
            <a class="btn btn-primary btn-block" href=""><i class="far fa-arrow-alt-circle-right  pull-left"></i>รายนามผู้บริหาร</a>
            <a class="btn btn-primary btn-block" href="http://www.phangnga.go.th/calendar/" target="_blank"><i class="far fa-arrow-alt-circle-right  pull-left"></i>ระบบนัดงานผู้บริหาร</a>
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
     <div class="panel panel-info">
      <div class="panel-heading">
        <h4 class="panel-title">
           <i class="fas fa-bullhorn"></i><a data-toggle="collapse" data-parent="#accordion" href="#collapse7"> ประกาศ</a>
        </h4>
      </div>
      <div id="collapse7" class="panel-collapse collapse">
            <div class="panel-body">
            <div class="panel-body">
            <a class="btn btn-primary btn-block" href="flow-buy.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i>ลงประกาศ</a>
            </div>
            </div>
      </div>
    </div>
     
    <div class="panel panel-info">
      <div class="panel-heading">
        <h4 class="panel-title">
           <i class="fas fa-gopuram"></i><a data-toggle="collapse" data-parent="#accordion" href="#collapse8"> จองห้องประชุม</a>
        </h4>
      </div>
      <div id="collapse8" class="panel-collapse collapse">
            <div class="panel-body">
            <div class="panel-body">
              <a class="btn btn-primary btn-block" href="meet_room.php"><i class="fas fa-cogs  pull-left"></i>จัดการห้อง</a>
              <!-- <a class="btn btn-primary btn-block" href=""><i class="fas fa-cogs  pull-left"></i>จัดการอุปกรณ์</a>
              <a class="btn btn-primary btn-block" href=""><i class="fas fa-cogs  pull-left"></i>จัดการเวลา</a> -->
              <a class="btn btn-primary btn-block" href="meet_wait.php"><i class="fas fa-rss  pull-left"></i>คำขอใช้ห้องประชุม</a>
              <a class="btn btn-primary btn-block" href="meet_index.php"><i class="fas fa-calendar  pull-left"></i>ปฏิทินห้องประชุม</a>
              <a class="btn btn-primary btn-block" href="meet_index.php"><i class="fas fa-marker  pull-left"></i>จองห้องประชุม</a>
              <a class="btn btn-primary btn-block" href="meet_room_user.php"><i class="fas fa-kaaba  pull-left"></i>ห้องประชุม</a>
              <!-- <a class="btn btn-primary btn-block" href="flow-buy.php"><i class="fas fa-cogs  pull-left"></i>รายการรอยืนยัน</a>
              <a class="btn btn-primary btn-block" href="flow-buy.php"><i class="fas fa-cogs  pull-left"></i>รายการอนุมัติแล้ว</a>
              <a class="btn btn-primary btn-block" href="flow-buy.php"><i class="fas fa-cogs  pull-left"></i>รายการไม่อนุมัติ</a> -->
            </div>
            </div>
      </div>
    </div>
    <br>
     <span class="btn btn-danger"><i class="fas fa-user"></i>  <?php include_once "../module/user-online.php"; ?></span>
 </div>



