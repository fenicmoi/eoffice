<?php
    include "config.php";
    conndb();

    $type_id_id = $_POST['province'];
    $dep_id = $_POST['amphur'];
    $sec_id = $_POST['district'];

    $sql_1 = "SELECT * FROM office_type WHERE type_id = '$province_id' ";
    $result_1 = mysql_query($sql_1);
    $row_1 = mysql_fetch_array($result_1);
    $province_name = $row_1['PROVINCE_NAME'];

    $sql_2 = "SELECT * FROM depart WHERE dep_id = '$dep_id' ";
    $result_2 = mysql_query($sql_2);
    $row_2 = mysql_fetch_array($result_2);
    $amphur_name = $row_2['AMPHUR_NAME'];

    $sql_3 = "SELECT * FROM district WHERE DISTRICT_ID = '$district_id' ";
    $result_3 = mysql_query($sql_3);
    $row_3 = mysql_fetch_array($result_3);
    $district_name = $row_3['DISTRICT_NAME'];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Drop Down menu เลือกจังหวัด, อำเภอ, ตำบล ของประเทศไทย โดย www.itangmo.com</title>
        <meta name="description" content="ไอ้แตงโมดอทคอม แจกแอพฟรีประจำวัน สอนทำเว็บไซต์ ด้วย php,ajax,jquery,css,css3,HTML5 แบบง่ายสุดๆ"/>
        <meta name="keywords" content="app ฟรีประจำวัน,สอนทำเว็บไซต์ฟรี,สอนทำเว็บ,สอนทำเว็บไซต์,php,html5,css,css3,jquery,ajax,สอนทำเว็บไซต์ด้วย php,Drop Down menu เลือกจังหวัด"/>
    </head>
    <body>
        <h3>Drop Down menu เลือกจังหวัด, อำเภอ, ตำบล ของประเทศไทย</h3>
        <p>โดย <a href="http://www.itangmo.com" title="Drop Down menu เลือกจังหวัด, อำเภอ, ตำบล ของประเทศไทย">www.itangmo.com</a></p>
        <p>จังหวัด : <?php echo $province_name." (".$province_id.")"; ?></p>
        <p>อำเภอ : <?php echo $amphur_name." (".$amphur_id.")"; ?></p>
        <p>ตำบล : <?php echo $district_name." (".$district_id.")"; ?></p>
    </body>
</html>
