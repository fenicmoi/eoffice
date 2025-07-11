<link rel="stylesheet" href="../css/note.css">
<?php
// Sanitize variables for SQL safety
$dep_id = isset($dep_id) ? (int)$dep_id : 0;
$sec_id = isset($sec_id) ? (int)$sec_id : 0;
$level_id = isset($level_id) ? (int)$level_id : 0;
?>
<div class="row">
    <div class="col-md-2">
        <?php  // ตรวจสอบสิทธิ์การใช้งานเมนู
        $menu = checkMenu($level_id);
        include $menu;
        ?>
    </div>
    <div class="col-md-10">
        <div class="container-fluid">
            <?php
            $sql = "SELECT COUNT(puid) AS pcount FROM paperuser WHERE confirm = 0 AND dep_id = $dep_id AND sec_id = $sec_id";
            $result = dbQuery($sql);
            $row = $result ? dbFetchArray($result) : ['pcount' => 0];
            ?>
            <?php if ($level_id < 4) { ?>
            <div class="row">
                <div class="col-md-3">
                    <div class="bg-danger">
                        <center>
                            <a href="paper.php" data-toggle="tooltip1" title="เอกสารจากส่วนราชการต่าง ๆ!">
                                <i class="fas fa-envelope fa-4x" aria-label="เอกสารเข้าใหม่"></i>
                                <h5>เอกสารเข้าใหม่ <span class="badge"><?php echo $row['pcount']; ?></span></h5>
                            </a>
                        </center>
                    </div>
                </div>
                <?php
                $sql = "SELECT m.book_id,m.rec_id,d.book_no,d.title,d.sendfrom,d.sendto,d.date_in,d.date_line,d.practice,d.status,s.sec_code
                        FROM book_master m
                        INNER JOIN book_detail d ON d.book_id = m.book_id
                        INNER JOIN section s ON s.sec_id = m.sec_id
                        WHERE m.type_id=1 AND d.status ='' AND d.practice=$dep_id";
                $result = dbQuery($sql);
                $num = $result ? dbNumRows($result) : 0;
                ?>
                <div class="col-md-3">
                    <div class="bg-danger">
                        <center>
                            <a href="FlowResiveProvince.php">
                                <i class="fas fa-book fa-4x" aria-label="หนังสือเข้าใหม่"></i>
                                <h5>หนังสือเข้าใหม่ <span class="badge"><?php echo $num; ?></span></h5>
                            </a>
                        </center>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-danger">
                        <center>
                            <a href="#" tabindex="-1" aria-disabled="true">
                                <i class="fas fa-eye fa-4x" aria-label="หนังสือเวียน"></i>
                                <h5>หนังสือเวียน</h5>
                            </a>
                        </center>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-danger">
                        <center>
                            <a href="paper.php">
                                <i class="fas fa-bell fa-4x" aria-label="ประชาสัมพันธ์"></i>
                                <h5>ประชาสัมพันธ์ <span class="badge">0</span></h5>
                            </a>
                        </center>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-danger">
                        <div class="panel-heading">Shot Menu</div>
                        <div class="panel-body">
                            <div class="col-md-3">
                                <div class="bg-success">
                                    <div class="panel-group">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" href="#menu1"><center><i class="fa fa-briefcase fa-2x text-center"></i><br> ทะเบียนหนังสือจังหวัด</center></a>
                                                </h4>
                                            </div>
                                            <div id="menu1" class="panel-collapse collapse">
                                                <ul class="list-group">
                                                    <li class="list-group-item"><a href="flow-circle.php" class="btn btn-primary">หนังสือส่ง[เวียน]</a> <i class="fas fa-thumbtack"></i><small>หนังสือแจ้งเวียน</small> </li>
                                                    <li class="list-group-item"><a href="flow-normal.php" class="btn btn-primary">หนังสือส่ง[ปกติ]</a> <i class="fas fa-thumbtack"></i><small>หนังสือส่งปกติ</small> </li>
                                                    <li class="list-group-item"><a href="flow-command.php" class="btn btn-primary">ออกเลขคำสั่งจังหวัด</a> <i class="fas fa-thumbtack"></i><small>คำสั่งจังหวัด</small> </li>
                                                </ul>
                                                <div class="panel-footer"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-success">
                                    <div class="panel-group">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" href="#menu2"><center><i class="fas fa-credit-card fa-2x"></i><br> ทะเบียนสัญญา</center></a>
                                                </h4>
                                            </div>
                                            <div id="menu2" class="panel-collapse collapse">
                                                <ul class="list-group">
                                                    <li class="list-group-item"><a href="hire.php" class="btn btn-primary">สัญญาจ้าง</a> <i class="fas fa-thumbtack"></i><small> ทะเบียนคุมสัญญาจ้าง</small></li>
                                                    <li class="list-group-item"><a href="buy.php" class="btn btn-primary">สัญญาซื้อขาย</a> <i class="fas fa-thumbtack"></i><small>ทะเบียนคุมสัญญาซื้อขาย</small> </li>
                                                </ul>
                                                <div class="panel-footer"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-success">
                                    <div class="panel-group">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" href="#menu4"><center><i class="fas fa-gopuram fa-2x"></i><br> จองห้องประชุม</center></a>
                                                </h4>
                                            </div>
                                            <div id="menu4" class="panel-collapse collapse">
                                                <ul class="list-group">
                                                </ul>
                                                <div class="panel-footer"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-success">
                                    <div class="panel-group">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" href="#menu5"><center><i class="fas fa-address-book fa-2x"></i><br> สมุดโทรศัพท์จังหวัด</center></a>
                                                </h4>
                                            </div>
                                            <div id="menu5" class="panel-collapse collapse">
                                                <ul class="list-group">
                                                    <li class="list-group-item"><a class="btn btn-primary" href="http://www.phone.phatthalung.go.th/" target="_news"><i class="fas fa-home  pull-left"></i>  สมุดโทรศัพท์จังหวัด</a>
                                                </ul>
                                                <div class="panel-footer"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- row -->
            <div class="row">
                <div class="row">
                    <div class="col-md-6">
                        <div class="quote-container">
                            <i class="pin"></i>
                            <blockquote class="note yellow">
                                <kbd><img src='../images/new.gif' alt="new">Tip</kbd>
                                <br>
                                <caption>จังหวัดพัทลุงเพิ่ม ระบบใหม่ ดังนี้</caption>
                                <ol>
                                    <li>ระบบงานสารบรรณเต็มรูปแบบ</li>
                                    <li>ระบบรับ-ส่งหนังสือ</li>
                                    <li>และระบบอื่นๆ</li>
                                </ol>
                                <cite class="author">Developer</cite>
                            </blockquote>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="quote-container">
                            <i class="pin"></i>
                            <blockquote class="note yellow">
                                <i class="fas fa-chat"></i> warning <br>
                                <ol>
                                    <li>ระบบ รับ - ส่ง หนังสือสำนักงานจังหวัดระบบเดิม กำหนดปิดใช้ในในเร็วๆ นี้</li>
                                </ol>
                                <cite class="author">สำนักงานจังหวัดพัทลุง</cite>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            if ($level_id == 1) {
                // ตรวจสอบปีเอกสาร
                list($yid, $yname, $ystatus) = chkYear();
                $yid = $yid;
                $yname = $yname;
                $ystatus = $ystatus;

                $sql = 'SELECT 
                    COUNT(IF(level_id=1,1,null)) AS c1,
                    COUNT(IF(level_id=2,1,null)) AS c2,
                    COUNT(IF(level_id=3,1,null)) AS c3,
                    COUNT(IF(level_id=4,1,null)) AS c4,
                    COUNT(IF(level_id=5,1,null)) AS c5
                FROM user';
                $result = dbQuery($sql);
                $row = dbFetchArray($result);
                $c1 = $row['c1'];
                $c2 = $row['c2'];
                $c3 = $row['c3'];
                $c4 = $row['c4'];
                $c5 = $row['c5'];

                $sum = $c1 + $c2 + $c3 + $c4 + $c5; ?>

            <div class="row">  <!-- สถิติข้อมูล -->
                <div  class="col-md-12">
                    <div class="panel panel-danger" >
                        <div class="panel-heading">
                            <i class="fas fa-chart-pie  fa-2x" aria-hidden="true"></i>  <strong>Admin Panal</strong>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
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
                                            <td><?=$row['c1']; ?></td>
                                        </tr>
                                        <tr class="danger">
                                            <td>สารบรรณจังหวัด</td>
                                            <td><?=$row['c2']; ?></td>
                                        </tr>
                                        <tr class="info">
                                            <td>สารบรรณหน่วยงาน</td>
                                            <td><?=$row['c3']; ?></td>
                                        </tr>
                                        <tr class="warning">
                                            <td>สารบรรณกลุ่มฝ่าย</td>
                                            <td><?=$row['c4']; ?></td>
                                        </tr>
                                        <tr class="active">
                                            <td>ผู้ใช้ทั่วไป</td>
                                            <td><?=$row['c5']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>รวม</td>
                                            <td><?=$sum; ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div> <!-- col-md-6 -->
                                <div class="col-md-6">
                                    <div id="piechart"></div>
                                    <script type="text/javascript" src="../js/chart/loader.js"></script>
                                    <script type="text/javascript">
                                    // Load google charts (โหลดครั้งเดียว)
                                    google.charts.load('current', {'packages':['corechart']});
                                    google.charts.setOnLoadCallback(drawUserChart);
                                    function drawUserChart() {
                                        var data = google.visualization.arrayToDataTable([
                                            ['Task', 'Hours per Day'],
                                            ['ผู้ดูแลระบบ', <?=$c1; ?>],
                                            ['สารบรรณจังหวัด', <?=$c2; ?>],
                                            ['สารบรรณหน่วยงาน', <?=$c3; ?>],
                                            ['สารบรรณกลุ่ม', <?=$c4; ?>],
                                            ['ผู้ใช้ทั่วไป', <?=$c5; ?>]
                                        ]);
                                        var options = {'title':'สัดส่วนผู้ใช้งาน', 'width':550, 'height':400};
                                        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                                        chart.draw(data, options);
                                    }
                                    </script>
                                </div> <!-- col-md-6 -->
                            </div>  <!-- row -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div id="depart" style="width: 700px; height: 350px;"></div>
                                    <script type="text/javascript">
                                    // ไม่ต้องโหลดซ้ำ google.charts.load
                                    google.charts.setOnLoadCallback(drawDepartChart);
                                    function drawDepartChart() {
                                        var data = google.visualization.arrayToDataTable([
                                            ['Task', 'Hours per Day'],
                                            ['ส่วนกลาง', <?=$c1; ?>],
                                            ['ส่วนภูมิภาค', <?=$c2; ?>],
                                            ['ส่วนท้องถิ่น', <?=$c3; ?>],
                                            ['รัฐวิสาหกิจ', <?=$c4; ?>],
                                            ['อื่น', <?=$c5; ?>]
                                        ]);
                                        var options = {
                                            title: 'ส่วนราชการ',
                                            pieHole: 0.4,
                                            width: 550,
                                            height: 400
                                        };
                                        var chart = new google.visualization.PieChart(document.getElementById('depart'));
                                        chart.draw(data, options);
                                    }
                                    </script>
                                </div>
                                <?php 
                                $sql = 'SELECT 
                                        COUNT(IF(level_id=1,1,null)) AS c1,
                                        COUNT(IF(level_id=2,1,null)) AS c2,
                                        COUNT(IF(level_id=3,1,null)) AS c3,
                                        COUNT(IF(level_id=4,1,null)) AS c4,
                                        COUNT(IF(level_id=5,1,null)) AS c5
                                    FROM user';

                $result = dbQuery($sql);
                $row = dbFetchArray($result);
                $c1 = $row['c1'];
                $c2 = $row['c2'];
                $c3 = $row['c3'];
                $c4 = $row['c4'];
                $c5 = $row['c5'];
                $sum = $c1 + $c2 + $c3 + $c4 + $c5; ?>
                                <div class="row">
                                <div class="col-md-6">
                                    <div id="piechart"></div>
                                
                                    <script type="text/javascript">
                                    // Load google charts
                                    google.charts.load('current', {'packages':['corechart']});
                                    google.charts.setOnLoadCallback(drawChart);

                                    // Draw the chart and set the chart values
                                    function drawChart() {
                                    var data = google.visualization.arrayToDataTable([
                                    ['Task', 'Hours per Day'],
                                    ['ผู้ดูแลระบบ', <?=$c1; ?>],
                                    ['สารบรรณจังหวัด', <?=$c2; ?>],
                                    ['สารบรรณหน่วยงาน', <?=$c3; ?>],
                                    ['สารบรรณกลุ่ม', <?=$c4; ?>],
                                    ['ผู้ใช้ทั่วไป',<?=$c5; ?>]
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
                        </div> <!-- panel-body -->
                        <div class="panel-footer"></div>
                    </div> <!-- class panel -->
                </div>  <!-- col-md-12 -->
            </div> <!-- row -->
            <?php } ?> <!-- end if -->
        </div> <!-- container  -->
    </div>
</div>

