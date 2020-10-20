<?php
if(!isset($_SESSION['ses_u_id'])){
    header("location:../index.php");
} ?>
<div class="panel-group" id="accordion">

    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
              <i class="fa fa-cog" aria-hidden="true"></i> Administrator
          </a>
        </h4>
      </div>
      
      <div id="collapse1" class="panel-collapse collapse in">
          <div class="panel-body">
              <a href="index_admin.php" class="btn btn-success btn-block" href>
                 <i class="fa fa-home" aria-hidden="true"></i> หน้าหลัก
             </a>
              <a href="object.php" class="btn btn-success btn-block" href>
                 <i class="fa fa-key"></i> วัตถุประสงค์ </a>
              <a href="speed.php" class="btn btn-success btn-block">
                  <i class="fa fa-paper-planex"></i> ชั้นความเร็ว</a>
              <a href="secret.php" class="btn btn-success btn-block">
                  <i class="fa fa-low-vision"></i> ชั้นความลับ</a>
             <a href="?menu=booktype" class="btn btn-success btn-block">
                 <i class="fa fa-file-text"></i> ประเภทหนังสือ</a>
             <a href="officeType.php" class="btn btn-success btn-block">
                 <i class="fa fa-bank"></i> ประเภทหน่วยงาน</a>
             <a href="depart.php" class="btn btn-success btn-block">
                 <i class="fa fa-building-o"></i> หน่วยงานในจังหวัด</a>
              <a href="section.php" class="btn btn-success btn-block">
                 <i class="fa fa-sitemap"></i> กลุ่มงาน/สาขาย่อย</a>
               <a href="user_group.php" class="btn btn-success btn-block">
                 <i class="fa fa-group"></i> กลุ่มผู้ใช้งาน</a>
             <a href="user.php" class="btn btn-success btn-block">
                 <i class="fa fa-user"></i> ผู้ใช้งาน</a>
          </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
              <i class="fa fa-sitemap" aria-hidden="true"></i> ข้อมูลหน่วยงาน
          </a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body">
            <span class="btn btn-primary btn-block">ข้อมูลหน่วยงาน</span>
            <span class="btn btn-primary btn-block">ข้อมูลฝ่าย</span>
            <span class="btn btn-primary btn-block">ข้อมูลผู้ใช้งาน</span>
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
            <span class="glyphicon glyphicon-user"></span><a data-toggle="collapse" data-parent="#accordion" href="#collapse3">ระบบงานสารบรรณ</a>
        </h4>
      </div>
      <div id="collapse3" class="panel-collapse collapse">
        <div class="panel-body">
           <div class="panel-body">
            <span class="btn btn-primary btn-block">หนังสือรับ</span>
            <span class="btn btn-primary btn-block">หนังสือส่ง</span>
            <span class="btn btn-primary btn-block">หนังสือคำสั่ง</span>
            <span class="btn btn-primary btn-block">หนังสือเวียน</span>
            <a class="btn btn-primary btn-block" href="paper.php">ระบบส่งเอกสาร</a>
               
        </div>
        </div>
      </div>
    </div>
      <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
            <span class="glyphicon glyphicon-user"></span>
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">ออกจากระบบ</a>
        </h4>
      </div>
     
    </div>
 </div>
