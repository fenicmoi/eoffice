ขั้นตอนการติดตั้งโปรแกรมจองห้องประชุมออนไลน์

1.แตกไฟล์ meeting.rar แล้ว upload file ทั้งหมด ไปยัง web directory ยกเว้น meeting.sql
2.ตั้งค่าต่างๆในไฟล์ inc/connect_db.php
$hostname = ""; //ชื่อโฮสต์
$user = ""; //ชื่อผู้ใช้
$password = ""; //รหัสผ่าน
$dbname = ""; //ชื่อฐานข้อมูล
3.ไฟล์ calendar.php  บรรทัดที่  76 $dbname="ชื่อฐานข้อมูล";
4.chkadmin.php บรรทัดที่ 17 และ 37 $dbname="ชื่อฐานข้อมูล";
5.chkuser.php บรรทัดที่ 17 และ 37 $dbname="ชื่อฐานข้อมูล";
6.ติดตั้งฐานข้อมูล meeting.sql โดยการรันด้วยโปรแกรมต่างๆเช่น phpmyadmin หรือ เปิดข้อมูลในไฟล์ meeting.sql แล้ว ไปใส่ในช่อง sql เพื่อรัน
4.พิมพ์ชื่อเว็บไซต์ที่อยู่ของไฟล์โปรแกรม เช่น http://www.yourdomain.com หรือ ถ้ารันบนเครื่องตนเอง http://localhost/meeting เป็นต้น
5.username and passwords for admin=admin and admin
6.username and passwords for user=user and user


ขอให้โชคดีครับ
http://www.php-mysql-program.com ติดต่อ pimarn_com@hotmail.com