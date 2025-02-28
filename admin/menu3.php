<?php
//สารบรรณประจำหน่วยงาน
if (!isset($_SESSION['ses_u_id'])) {
    header('location:../index.php');
}
//นำหนังสือรอลงรับไปแสดง
$sql = "SELECT m.book_id,m.rec_id,d.book_no,d.title,d.sendfrom,d.sendto,d.date_in,d.date_line,d.practice,d.status,s.sec_code
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
              <a href="index_admin.php" class="btn btn-danger btn-block">
                  <i class="fa fa-home" aria-hidden="true"></i> หน้าหลัก</a>
              <a href="depart_edit.php?dep_id=<?php echo $dep_id; ?>" class="btn btn-danger btn-block">
                  <i class="fa fa-info" aria-hidden="true"></i> ข้อมูลหน่วยงาน</a>
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
              <i class="fa fa-credit-card" aria-hidden="true"></i> ทะเบียนคุมสัญญา
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
            <span class="fa fa-briefcase"></span><a data-toggle="collapse" data-parent="#accordion" href="#collapse3"> ระบบงานสารบรรณ</a>
        </h4>
      </div>
      <div id="collapse3" class="panel-collapse collapse">
          <div class="panel-body">
            <div class="panel-body">
              <a class="btn btn-primary btn-block" href="flow-resive-province.php">หนังสือรับจังหวัด</a>
              <a class="btn btn-primary btn-block" href="FlowResiveDepart.php">หนังสือรับหน่วยงาน</a>
              <a class="btn btn-primary btn-block" href="flow-resive-group.php">หนังสือรับกลุ่มงาน</a>
              <hr>
              <a class="btn btn-warning btn-block" href="FlowResiveProvince.php">หนังสือเข้าใหม่<span class="badge"><?=$num_row; ?></span></a>
              <a class="btn btn-warning btn-block" href="flow-resive-depart.php">ทะเบียนหนังสือรับจังหวัด</a>
              <hr>
              <a class="btn btn-info btn-block" href="flow-circle.php">ทะเบียนหนังสือส่ง[เวียน]</a>
              <a class="btn btn-info btn-block" href="flow-normal.php">ทะเบียนหนังสือส่ง[ปกติ]</a>
              <a class="btn btn-primary btn-block" href="flow-command.php">ทะเบียนคำสั่งจังหวัด</a>
          </div>
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
              <a class="btn btn-primary btn-block" href="paper.php"><i class="fas fa-envelope  pull-left"></i>หนังสือเข้า</a>
              <a class="btn btn-primary btn-block" href="folder.php"><i class="far fa-envelope-open  pull-left"></i>รับแล้ว</a>
              <a class="btn btn-primary btn-block" href="history.php"><i class="fas fa-folder-open  pull-left"></i>ส่งแล้ว</a>
              <a class="btn btn-primary btn-block" href="outside_all.php"><i class="fas fa-paper-plane pull-left"></i>ส่งหนังสือ</a>
              <!-- <a class="btn btn-primary btn-block" href="inside_all.php"><i class="fas fa-home  pull-left"></i>ส่งภายใน</a> -->
             
              <!-- <a class="btn btn-primary btn-block" href="follow.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i> ระบบติดตามแฟ้ม</a>
              <a class="btn btn-primary btn-block" href="follow-check.php"><i class="far fa-arrow-alt-circle-right  pull-left"></i>ตรวจแฟ้ม[สำหรับเลขาฯ]</a> -->
            </div>
        </div>
      </div>
    </div>
    <?php
      if($dep_id == 1){   //ถ้าเป็นสำนักงานจังหวัด ให้แสดงเมนู
        echo"
            <div class='panel panel-info'>
              <div class='panel-heading'>
                <h4 class='panel-title'>
                  <i class = 'fab fa-app-store'></i><a data-toggle='collapse' data-parent='#accordion' href='#collapse5'>สำนักงานจังหวัด</a>
                </h4>
              <div id='collapse5' class='panel-collapse collapse'>
                <div class='panel-body'>
                   <a class='btn btn-warning btn-block' href='circleoffice.php'>ทะเบียนหนังสือส่ง[เวียน]</a>
                   <a class='btn btn-warning btn-block' href='flow-normal.php'>ทะเบียนหนังสือส่ง[ปกติ]</a>
                   <a class='btn btn-warning btn-block' href='flow-command.php'>ทะเบียนคำสั่งจังหวัด</a>
                </div>
              </div>
              </div>
            </div>
        ";
      }   
    ?>
     <div class="panel panel-info">
        <div class="panel-heading">
          <h4 class="panel-title">
            <i class="fas fa-book"></i><a data-toggle="collapse" data-parent="#accordion" href="#collapse6"> คู่มือการใช้งาน</a>
          </h4>
        </div>
      <div id="collapse6" class="panel-collapse collapse">
            <div class="panel-body">
              <div class="panel-body">
              <a class="btn btn-primary btn-block" href="https://shorturl.at/WEZe3" target='_blank'><i class="far fa-arrow-alt-circle-right  pull-left"></i>E-Office</a>
              <!-- <a class="btn btn-primary btn-block" href="" target="_blank"><i class="far fa-arrow-alt-circle-right  pull-left"></i>ระบบจองห้องประชุม</a>
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
     <br>
 </div>

