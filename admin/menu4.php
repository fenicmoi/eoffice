<?php
if(!isset($_SESSION['ses_u_id'])){
	header("location:../index.php");
	//น	ำหนังสือรอลงรับไปแสดง
	$sql="SELECT m.book_id,m.rec_id,d.book_no,d.title,d.sendfrom,d.sendto,d.date_in,d.date_line,d.practice,d.status,s.sec_code
      FROM book_master m
      INNER JOIN book_detail d ON d.book_id = m.book_id
      INNER JOIN section s ON s.sec_id = m.sec_id
      WHERE m.type_id=1 AND d.status ='' AND d.practice=$dep_id";
	$result = dbQuery($sql);
	$num_row = dbNumRows($result);
}
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
              <i class="fa fa-cog" aria-hidden="true"></i> ตั้งค่าระบบ
          </a>
        </h4>
      </div>
      <div id="collapse1" class="panel-collapse collapse">
          <div class="panel-body">
           <?php echo "menu4";?>
              <a href="index_admin.php" class="btn btn-danger btn-block" href>
                  <i class="fa fa-home" aria-hidden="true"></i> หน้าหลัก</a>
              <!-- <a href="section.php" class="btn btn-danger btn-block">
                 <i class="fa fa-sitemap"></i> กลุ่มงาน/สาขาย่อย</a>
              <a href="user.php" class="btn btn-danger btn-block">
                 <i class="fa fa-user"></i> จัดการผู้ใช้</a> -->
           
              <!-- 
              <div class="btn-group">
                <a class="link-disabled btn dropdown-toggle btn-danger btn-block"  data-toggle="dropdown" href="#">
                    <i class="fa fa-cog pull-left"></i> จัดการระบบจองรถยนต์<span class="caret"></span>
                </a>

                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                  <li><a tabindex="-1" href="manage_car.php"><i class="fas fa-car"></i> รถยนต์ราชการ</a></li>
                  <li><a tabindex="-1" href="#"><i class="fas fa-user-tie"></i> พนักงานขับรถ</a></li>
                  <li class="divider"></li>
                  <li><a tabindex="-1" href="#">คู่มือใช้งาน</a></li>
                </ul>
              </div> 
            -->

          </div> <!-- panel-body -->
      </div>  <!-- panel-info -->
</div>
    
    <div class="panel panel-info">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a  data-toggle="collapse" data-parent="#accordion" href="#collapse2">
              <i class="fa fa-credit-card" aria-hidden="true"></i> ทะเบียนสัญญา
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body">
            <a class="btn btn-primary btn-block" href="hire.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i> สัญญาจ้าง</a>
            <a class="btn btn-primary btn-block" href="buy.php" ><i class="far fa-arrow-alt-circle-right  pull-left"></i> สัญญาซื้อ/ขาย</a>
            <!-- <a class="btn btn-primary btn-block" href="announce.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i> เอกสารประกวดราคา</a> -->
        </div>
      </div>
    </div>
    
    <div class="panel panel-info">
      <div class="panel-heading">
        <h4 class="panel-title">
            <span class="fa fa-briefcase"></span><a data-toggle="collapse" data-parent="#accordion" href="#collapse3"> งานสารบรรณ</a>
        </h4>
      </div>
      <div id="collapse3" class="panel-collapse collapse">
        <div class="panel-body">
           <div class="panel-body">
            <kbd>ออกเลขทะเบียนรับ</kbd>
            <!-- <a class="btn btn-primary btn-block" href="flow-resive-province.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i>หนังสือถึงจังหวัด</a> -->
            <!-- <a class="btn btn-primary btn-block" href="FlowResiveDepart.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i> ทะเบียนรับหน่วยงาน</a> -->
            <a class="btn btn-primary btn-block" href="flow-resive-group.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i> ทะเบียนรับกลุ่มงาน</a>
            <kbd>ออกเลขทะเบียนส่ง</kbd>
           
            <a class="btn btn-primary btn-block" href="flow-circle.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i> เลขหนังสือส่ง[เวียน]</a>
            <a class="btn btn-primary btn-block" href="flow-normal.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i> เลขหนังสือส่ง[ปกติ]</a>
            <a class="btn btn-primary btn-block" href="flow-command.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i> เลขคำสั่งจังหวัด</a> 
            <a class="btn btn-primary btn-block" href="underconstruction.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i> เลขหนังสื่อส่ง[หน่วยงาน]</a> 
        </div>
        </div>
      </div>
    </div>
    
     <div class="panel panel-info">
      <div class="panel-heading">
        <h4 class="panel-title">
            <span class="fa fa-paper-plane"></span><a data-toggle="collapse" data-parent="#accordion" href="#collapse4"> รับ-ส่งหนังสือ</a>
        </h4>
      </div>
      <div id="collapse4" class="panel-collapse collapse">
            <div class="panel-body">
            <div class="panel-body">
               <a class="btn btn-primary btn-block" href="paper.php"><i class="fas fa-envelope  pull-left"></i>หนังสือเข้า</a>
               <a class="btn btn-primary btn-block" href="folder.php"><i class="far fa-envelope-open  pull-left"></i>รับแล้ว</a>
               <a class="btn btn-primary btn-block" href="history.php"><i class="fas fa-folder-open  pull-left"></i>ส่งแล้ว</a>
               <a class="btn btn-primary btn-block" href="outside_all.php"><i class="fas fa-paper-plane pull-left"></i>ส่งหนังสือ</a>
            <!-- <a class="btn btn-primary btn-block" href="follow.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i> ระบบติดตามแฟ้ม</a>
            <a class="btn btn-primary btn-block" href="follow-check.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i>ตรวจแฟ้ม[สำหรับเลขาฯ]</a> -->
            </div>
        </div>
      </div>
    </div>

    <div class="panel panel-info">
      <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fab fa-app-store"></i><a data-toggle="collapse" data-parent="#accordion" href="#collapse5"> สำนักงานจังหวัด</a>
        </h4>
      </div>
      <div id="collapse5" class="panel-collapse collapse">
            <div class="panel-body">
            <div class="panel-body">
            <a class="btn btn-primary btn-block" href="flow-depart.php" ><i class="far fa-arrow-alt-circle-right  pull-left"></i> ทะเบียนหนังสือส่ง</a>
            <a class="btn btn-primary btn-block" href="" target="_blank"><i class="far fa-arrow-alt-circle-right  pull-left"></i> ระบบนัดงานผู้บริหาร</a>
            <a class="btn btn-primary btn-block" href="">ระบบลงประกาศ</a>
            <a class="btn btn-primary btn-block" href="http://mbrs.phatthalung.go.th/" target="_blank"><i class="far fa-arrow-alt-circle-right  pull-left"></i> ระบบจองห้องประชุม</a>

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
            <!-- <a class="btn btn-primary btn-block" href=""><i class="far fa-arrow-alt-circle-right  pull-left"></i>E-Office 2.0</a>
            <a class="btn btn-primary btn-block" href="" target="_blank"><i class="far fa-arrow-alt-circle-right  pull-left"></i>ระบบจองห้องประชุม</a>
            <a class="btn btn-primary btn-block" href=""><i class="far fa-arrow-alt-circle-right  pull-left"></i>การลงประกาศ</a> -->
            </div>
        </div>
      </div>
    </div>
    <div class="panel panel-info">
      <div class="panel-heading">
        <h4 class="panel-title">
           <i class="fas fa-book"></i><a data-toggle="collapse" data-parent="#accordion" href="#collapse7"> ประกาศ/ประชาสัมพันธ์</a>
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
              <h5>อยู่ระหว่างการปรับปรุง</h5>
              <!-- <a class="btn btn-primary btn-block" href="meet_room.php"><i class="fas fa-cogs  pull-left"></i>จัดการห้อง</a> -->
              <!-- <a class="btn btn-primary btn-block" href=""><i class="fas fa-cogs  pull-left"></i>จัดการอุปกรณ์</a>
              <a class="btn btn-primary btn-block" href=""><i class="fas fa-cogs  pull-left"></i>จัดการเวลา</a> -->
              <!-- <a class="btn btn-primary btn-block" href="meet_wait.php"><i class="fas fa-rss  pull-left"></i>คำขอใช้ห้องประชุม</a> -->
              <!-- <a class="btn btn-primary btn-block" href="meet_index.php"><i class="fas fa-calendar  pull-left"></i>ปฏิทินห้องประชุม</a>
              <a class="btn btn-primary btn-block" href="meet_index.php"><i class="fas fa-marker  pull-left"></i>จองห้องประชุม</a>
              <a class="btn btn-primary btn-block" href="meet_room_user.php"><i class="fas fa-kaaba  pull-left"></i>ห้องประชุม</a> -->
              <!-- <a class="btn btn-primary btn-block" href="flow-buy.php"><i class="fas fa-cogs  pull-left"></i>รายการรอยืนยัน</a>
              <a class="btn btn-primary btn-block" href="flow-buy.php"><i class="fas fa-cogs  pull-left"></i>รายการอนุมัติแล้ว</a>
              <a class="btn btn-primary btn-block" href="flow-buy.php"><i class="fas fa-cogs  pull-left"></i>รายการไม่อนุมัติ</a> -->
            </div>
      </div>
    </div>
<!-- 
    <div class="panel panel-info">
      <div class="panel-heading">
        <h4 class="panel-title"><i class="fas fa-car"></i><a data-toggle="collapse" data-parent="#accordion" href="#collapse9"> ระบบจองรถราชการ</a></h4>
      </div>
    
      <div id="collapse9" class="panel-collapse collapse">
            <div class="panel-body">
              <a class="btn btn-primary btn-block" href=""><i class="fas fa-cog  pull-left"></i>รถราชการ</a>
              <a class="btn btn-primary btn-block" href=""><i class="fas fa-cog  pull-left"></i>ผู้ขับขี่</a>
              <a class="btn btn-primary btn-block" href=""><i class="fas fa-car  pull-left"></i>ปฏิทินการใช้รถ</a>
            </div>
      </div> 
    </div> -->
     <br>
    
    <div class="panel panel-warning">
      <div class="panel-heading">
        <h4 class="panel-title">
                <img width=100 hight=100 src="../images/line.jpg"/>
        </h4>
      </div>
    </div>
 </div>
