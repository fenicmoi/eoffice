<?php
require_once '../library/database.php';

$sql1 = "CREATE TABLE IF NOT EXISTS flownormal_depart (
  cid int NOT NULL AUTO_INCREMENT COMMENT 'รหัสระบบ',
  rec_no int NOT NULL COMMENT 'เลขหนังสือเวียน',
  u_id int NOT NULL COMMENT 'รหัสผู้ใช้',
  obj_id int NOT NULL COMMENT 'วัตถุประสงค์',
  yid int NOT NULL COMMENT 'ปีปฏิทิน',
  typeDoc varchar(50) NOT NULL COMMENT 'ปกติ/เวียน',
  prefex varchar(100) NOT NULL COMMENT 'คำนำหน้าหน่วยงาน',
  title text NOT NULL COMMENT 'เรื่อง',
  speed_id int NOT NULL COMMENT 'ชั้นความเร็ว',
  sec_id int NOT NULL COMMENT 'รหัสแผนก',
  sendfrom varchar(100) NOT NULL COMMENT 'ผู้ส่ง',
  sendto varchar(100) NOT NULL COMMENT 'ผู้รับ',
  refer varchar(100) NOT NULL COMMENT 'อ้างถึง',
  attachment varchar(100) NOT NULL COMMENT 'เอกสารแนบ',
  practice varchar(100) NOT NULL COMMENT 'ผู้เสนอ',
  file_location varchar(100) NOT NULL COMMENT 'ที่เก็บเอกสาร',
  dateline date NOT NULL COMMENT 'วันที่บันทึก',
  dateout date NOT NULL COMMENT 'วันที่หนังสือออก',
  status int NOT NULL DEFAULT '2' COMMENT 'สถานะหนังสือ',
  follow int NOT NULL COMMENT 'ติดตาม',
  open int NOT NULL COMMENT 'เปิดให้คนทั่วไปเห็น',
  file_upload varchar(200) NOT NULL COMMENT 'ไฟล์เอกสาร',
  state_send int NOT NULL COMMENT '0ภายใน1ภายนอก',
  dep_id int NOT NULL COMMENT 'รหัสหน่วยงาน',
  PRIMARY KEY (cid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='ทะเบียนหนังสือส่งปกติสำนักงานจังหวัด'";

$sql2 = "CREATE TABLE IF NOT EXISTS flowcircle_depart (
  cid int NOT NULL AUTO_INCREMENT COMMENT 'รหัสระบบ',
  rec_no int NOT NULL COMMENT 'เลขหนังสือเวียน',
  u_id int NOT NULL COMMENT 'รหัสผู้ใช้',
  obj_id int NOT NULL COMMENT 'วัตถุประสงค์',
  yid int NOT NULL COMMENT 'ปีปฏิทิน',
  typeDoc varchar(50) NOT NULL COMMENT 'ปกติ/เวียน',
  prefex varchar(100) NOT NULL COMMENT 'คำนำหน้าหน่วยงาน',
  title varchar(200) NOT NULL COMMENT 'เรื่อง',
  speed_id int NOT NULL COMMENT 'ชั้นความเร็ว',
  sec_id int NOT NULL COMMENT 'รหัสแผนก',
  sendfrom varchar(100) NOT NULL COMMENT 'ผู้ส่ง',
  sendto varchar(100) NOT NULL COMMENT 'ผู้รับ',
  refer varchar(100) NOT NULL COMMENT 'อ้างถึง',
  attachment varchar(100) NOT NULL COMMENT 'เอกสารแนบ',
  practice varchar(100) NOT NULL COMMENT 'ผู้เสนอ',
  file_location varchar(100) NOT NULL COMMENT 'ที่เก็บเอกสาร',
  dateline date NOT NULL COMMENT 'วันที่บันทึก',
  dateout date NOT NULL COMMENT 'วันที่หนังสือออก',
  status int NOT NULL DEFAULT '2' COMMENT 'สถานะหนังสือ',
  follow int NOT NULL COMMENT 'ติดตาม',
  open int NOT NULL COMMENT 'สถานะการเปิดเผย',
  file_upload varchar(200) NOT NULL COMMENT 'ไฟล์เอกสาร',
  state_send int NOT NULL COMMENT '0ภายใน1ภายนอก',
  dep_id int NOT NULL COMMENT 'รหัสหน่วยงาน',
  hit int NOT NULL DEFAULT 0 COMMENT 'ผู้ดู',
  PRIMARY KEY (cid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='ทะเบียนหนังสือเวียนสำนักงานจังหวัด'";

if (dbQuery($sql1))
    echo "Table flownormal_depart created successfully.\n";
else
    echo "Error creating table flownormal_depart.\n";

if (dbQuery($sql2))
    echo "Table flowcircle_depart created successfully.\n";
else
    echo "Error creating table flowcircle_depart.\n";
