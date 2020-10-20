
<?php   
include "header.php";
$u_id=$_SESSION['ses_u_id'];
?>
<?php    
//ตรวจสอบปีเอกสาร
list($yid,$yname,$ystatus)=chkYear();
$yid=$yid;
$yname=$yname;
$ystatus=$ystatus;

$sql="SELECT 
        COUNT(IF(level_id=1,1,null)) AS c1,
        COUNT(IF(level_id=2,1,null)) AS c2,
        COUNT(IF(level_id=3,1,null)) AS c3,
        COUNT(IF(level_id=4,1,null)) AS c4,
        COUNT(IF(level_id=5,1,null)) AS c5
     FROM user";
$result=dbQuery($sql);
$row=dbFetchArray($result);
$c1=$row['c1'];
$c2=$row['c2'];
$c3=$row['c3'];
$c4=$row['c4'];
$c5=$row['c5'];

$sum=$c1+$c2+$c3+$c4+$c5;
?>
<div class="col-md-2" >
<?php
$menu=  checkMenu($level_id);
include $menu;
?>
 </div>
        <div  class="col-md-10">
            <div class="panel panel-danger" >
                <div class="panel-heading">
                    <i class="fas fa-chart-pie  fa-2x" aria-hidden="true"></i>  <strong>Admin Panal</strong>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                           <table class="table table-bordered">
                                <thead>
                                <tr class="bg-primary text-white">
                                    <th align="center">ประเภท User</th>
                                    <th>จำนวน User</th>
                                </tr>
                                </thead>
                                <tbody>  
                                <tr class="success">
                                    <td>ผู้ดูแลระบบ</td>
                                    <td><?=$row['c1'];?></td>
                                </tr>
                                <tr class="danger">
                                    <td>สารบรรณจังหวัด</td>
                                    <td><?=$row['c2'];?></td>
                                </tr>
                                <tr class="info">
                                    <td>สารบรรณหน่วยงาน</td>
                                    <td><?=$row['c3'];?></td>
                                </tr>
                                <tr class="warning">
                                    <td>สารบรรณกลุ่มฝ่าย</td>
                                    <td><?=$row['c4'];?></td>
                                </tr>
                                <tr class="active">
                                    <td>ผู้ใช้ทั่วไป</td>
                                    <td><?=$row['c5'];?></td>
                                </tr>
                                <tr>
                                    <td>รวม</td>
                                    <td><?=$sum;?></td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <div id="piechart"></div>
                            <script type="text/javascript" src="../js/chart/loader.js"></script>
                            <script type="text/javascript">
                            // Load google charts
                            google.charts.load('current', {'packages':['corechart']});
                            google.charts.setOnLoadCallback(drawChart);

                            // Draw the chart and set the chart values
                            function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                            ['Task', 'Hours per Day'],
                            ['ผู้ดูแลระบบ', <?=$c1?>],
                            ['สารบรรณจังหวัด', <?=$c2?>],
                            ['สารบรรณหน่วยงาน', <?=$c3?>],
                            ['สารบรรณกลุ่ม', <?=$c4?>],
                            ['ผู้ใช้ทั่วไป',<?=$c5?>]
                            ]);

                            // Optional; add a title and set the width and height of the chart
                            var options = {'title':'สัดส่วนผู้ใช้งาน', 'width':550, 'height':400};

                            // Display the chart inside the <div> element with id="piechart"
                            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                            chart.draw(data, options);
                            }
                            </script>
                        </div>
                    </div> 
                </div>
                <div class="panel-footer">
                </div>
            </div> <!-- class panel -->
        </div>  <!-- col-md-10 -->


   

  