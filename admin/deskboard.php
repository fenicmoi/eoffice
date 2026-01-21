<link rel="stylesheet" href="../css/note.css">
<?php
include '../chksession.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<div class="row">
    <div class="col-md-2">
        <?php  //ตรวจสอบสิทธิ์การใช้งานเมนู
        $menu = checkMenu($level_id);
        include $menu;
        ?>
    </div>
    <div class="col-md-10">
        <div class="container-fluid">
            <?php
            $sql = "SELECT COUNT(puid) AS pcount FROM paperuser WHERE confirm = 0 AND dep_id = ? AND sec_id = ?";
            $result = dbQuery($sql, "ii", [(int) $dep_id, (int) $sec_id]);
            $row = dbFetchArray($result);
            ?>
            <?php
            // ========== NEW STATISTICS SECTION ==========
            // Query for Active Users
            $sqlActiveUsers = "SELECT COUNT(*) as active_users FROM user_online";
            $resultActiveUsers = dbQuery($sqlActiveUsers);
            $rowActiveUsers = dbFetchArray($resultActiveUsers);
            $activeUsers = $rowActiveUsers['active_users'] ?? 0;

            // Query for Today's Documents
            $sqlTodayDocs = "SELECT COUNT(*) as today_docs FROM book_detail WHERE date_in = CURDATE()";
            $resultTodayDocs = dbQuery($sqlTodayDocs);
            $rowTodayDocs = dbFetchArray($resultTodayDocs);
            $todayDocs = $rowTodayDocs['today_docs'] ?? 0;

            // Query for Incoming Documents (Total)
            $sqlIncomingTotal = "SELECT COUNT(*) as incoming_total FROM book_master WHERE type_id = 1";
            $resultIncomingTotal = dbQuery($sqlIncomingTotal);
            $rowIncomingTotal = dbFetchArray($resultIncomingTotal);
            $incomingTotal = $rowIncomingTotal['incoming_total'] ?? 0;

            // Query for Incoming Documents (Pending)
            $sqlIncomingPending = "SELECT COUNT(*) as incoming_pending 
                                   FROM book_master m 
                                   INNER JOIN book_detail d ON d.book_id = m.book_id 
                                   WHERE m.type_id = 1 AND d.status = ''";
            $resultIncomingPending = dbQuery($sqlIncomingPending);
            $rowIncomingPending = dbFetchArray($resultIncomingPending);
            $incomingPending = $rowIncomingPending['incoming_pending'] ?? 0;

            // Query for Outgoing Documents (Normal)
            $sqlOutgoingNormal = "SELECT COUNT(*) as outgoing_normal FROM book_master WHERE type_id = 2";
            $resultOutgoingNormal = dbQuery($sqlOutgoingNormal);
            $rowOutgoingNormal = dbFetchArray($resultOutgoingNormal);
            $outgoingNormal = $rowOutgoingNormal['outgoing_normal'] ?? 0;

            // Query for Circular Documents
            $sqlCircular = "SELECT COUNT(*) as circular_docs FROM book_master WHERE type_id = 3";
            $resultCircular = dbQuery($sqlCircular);
            $rowCircular = dbFetchArray($resultCircular);
            $circularDocs = $rowCircular['circular_docs'] ?? 0;

            // Query for Provincial Commands
            $sqlCommands = "SELECT COUNT(*) as commands FROM book_master WHERE type_id = 4";
            $resultCommands = dbQuery($sqlCommands);
            $rowCommands = dbFetchArray($resultCommands);
            $commands = $rowCommands['commands'] ?? 0;

            // Query for Pending Documents
            $sqlPending = "SELECT COUNT(*) as pending_docs FROM book_detail WHERE status = ''";
            $resultPending = dbQuery($sqlPending);
            $rowPending = dbFetchArray($resultPending);
            $pendingDocs = $rowPending['pending_docs'] ?? 0;

            // Query for Completed Documents
            $sqlCompleted = "SELECT COUNT(*) as completed_docs FROM book_detail WHERE status != ''";
            $resultCompleted = dbQuery($sqlCompleted);
            $rowCompleted = dbFetchArray($resultCompleted);
            $completedDocs = $rowCompleted['completed_docs'] ?? 0;
            ?>

            <!-- Statistics Overview Section -->
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-md-12">
                    <h3 style="margin-bottom: 20px; color: #4e73df; font-weight: 600;">
                        <i class="fas fa-chart-line"></i> สถิติระบบ
                        <small style="font-size: 14px; color: #858796; margin-left: 10px;">
                            อัพเดท: <span id="stats-timestamp"><?php echo date('d/m/Y H:i:s'); ?></span>
                        </small>
                        <button id="refresh-stats-btn" class="btn btn-sm btn-primary"
                            style="margin-left: 15px; border-radius: 20px;" title="รีเฟรชข้อมูล">
                            <i class="fas fa-sync-alt"></i> รีเฟรช
                        </button>
                    </h3>
                </div>
            </div>

            <!-- Row 1: Main Statistics -->
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-md-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="background: linear-gradient(135deg, #4e73df, #224abe);">
                            <i class="fas fa-users fa-3x pull-left" style="opacity: 0.8;"></i>
                            <div class="text-right">
                                <div class="huge" style="font-size: 30px; font-weight: bold;">
                                    <span id="stat-active-users"><?php echo $activeUsers; ?></span>
                                </div>
                                <div>ผู้ใช้งานออนไลน์</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-success">
                        <div class="panel-heading" style="background: linear-gradient(135deg, #1cc88a, #047857);">
                            <i class="fas fa-file-alt fa-3x pull-left" style="opacity: 0.8;"></i>
                            <div class="text-right">
                                <div class="huge" style="font-size: 30px; font-weight: bold;"><span id="stat-today-docs"><?php echo $todayDocs; ?></span>
                                </div>
                                <div>เอกสารวันนี้</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-info">
                        <div class="panel-heading" style="background: linear-gradient(135deg, #36b9cc, #1a8a9a);">
                            <i class="fas fa-inbox fa-3x pull-left" style="opacity: 0.8;"></i>
                            <div class="text-right">
                                <div class="huge" style="font-size: 30px; font-weight: bold;">
                                    <span id="stat-incoming-total"><?php echo $incomingTotal; ?></span>
                                </div>
                                <div>หนังสือรับทั้งหมด</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-warning">
                        <div class="panel-heading" style="background: linear-gradient(135deg, #f6c23e, #d4a017);">
                            <i class="fas fa-paper-plane fa-3x pull-left" style="opacity: 0.8;"></i>
                            <div class="text-right">
                                <div class="huge" style="font-size: 30px; font-weight: bold;">
                                    <span id="stat-outgoing-normal"><?php echo $outgoingNormal; ?></span>
                                </div>
                                <div>หนังสือส่ง</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row 2: Document Types -->
            <div class="row" style="margin-bottom: 20px;">
                <div class="col-md-3">
                    <div class="panel panel-danger">
                        <div class="panel-heading" style="background: linear-gradient(135deg, #e74a3b, #b91d1d);">
                            <i class="fas fa-gavel fa-3x pull-left" style="opacity: 0.8;"></i>
                            <div class="text-right">
                                <div class="huge" style="font-size: 30px; font-weight: bold;"><span id="stat-commands"><?php echo $commands; ?></span>
                                </div>
                                <div>คำสั่งจังหวัด</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="background: linear-gradient(135deg, #5a67d8, #3c4ab3);">
                            <i class="fas fa-sync-alt fa-3x pull-left" style="opacity: 0.8;"></i>
                            <div class="text-right">
                                <div class="huge" style="font-size: 30px; font-weight: bold;">
                                    <span id="stat-circular-docs"><?php echo $circularDocs; ?></span>
                                </div>
                                <div>หนังสือเวียน</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-warning">
                        <div class="panel-heading" style="background: linear-gradient(135deg, #f39c12, #d68910);">
                            <i class="fas fa-clock fa-3x pull-left" style="opacity: 0.8;"></i>
                            <div class="text-right">
                                <div class="huge" style="font-size: 30px; font-weight: bold;">
                                    <span id="stat-pending-docs"><?php echo $pendingDocs; ?></span>
                                </div>
                                <div>รอดำเนินการ</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-success">
                        <div class="panel-heading" style="background: linear-gradient(135deg, #28a745, #1e7e34);">
                            <i class="fas fa-check-circle fa-3x pull-left" style="opacity: 0.8;"></i>
                            <div class="text-right">
                                <div class="huge" style="font-size: 30px; font-weight: bold;">
                                    <span id="stat-completed-docs"><?php echo $completedDocs; ?></span>
                                </div>
                                <div>ดำเนินการแล้ว</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            // ========== ORIGINAL USER-LEVEL SPECIFIC SECTION ==========
            if ($level_id < 4) {
                ?>
                <div class="row">
                    <div class="col-md-3">
                        <div class="bg-danger text-center">
                            <a href="paper.php" data-toggle="tooltip1" title="เอกสารจากส่วนราชการต่าง ๆ!">
                                <i class="fas fa-envelope fa-4x"></i>
                                <h5>เอกสารเข้าใหม่ <span class="badge"><?php echo $row['pcount'] ?? 0; ?></span></h5>
                            </a>
                        </div>
                    </div>
                    <?php
                    $sql = "SELECT m.book_id,m.rec_id,d.book_no,d.title,d.sendfrom,d.sendto,d.date_in,d.date_line,d.practice,d.status,s.sec_code
                            FROM book_master m
                            INNER JOIN book_detail d ON d.book_id = m.book_id
                            INNER JOIN section s ON s.sec_id = m.sec_id
                            WHERE m.type_id=1 AND d.status ='' AND d.practice = ?";
                    $result = dbQuery($sql, "i", [(int) $dep_id]);
                    $num = dbNumRows($result); ?>
                    <div class="col-md-3">
                        <div class="bg-danger text-center">
                            <a href="FlowResiveProvince.php">
                                <i class="fas fa-book fa-4x"></i>
                                <h5>หนังสือเข้าใหม่ <span class="badge"><?php echo $num; ?></span></h5>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="bg-danger text-center">
                            <a href="flow-circle.php">
                                <i class="fas fa-eye fa-4x"></i>
                                <h5>หนังสือเวียน <span class="badge"><?php echo $circularDocs; ?></span></h5>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="bg-danger text-center">
                            <a href="paper.php">
                                <i class="fas fa-bell fa-4x"></i>
                                <h5>ประชาสัมพันธ์ <span class="badge">0</span></h5>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
            } ?>
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
                                                <h4 class="panel-title text-center">
                                                    <a data-toggle="collapse" href="#menu1"><i
                                                            class="fa fa-briefcase fa-2x"></i><br>
                                                        ทะเบียนหนังสือจังหวัด</a>
                                                </h4>
                                            </div>
                                            <div id="menu1" class="panel-collapse collapse">

                                                <ul class="list-group">
                                                    <!-- <li class="list-group-item"><a href="flow-resive-province.php" class="btn btn-primary">หนังสือรับจังหวัด</a> <i class="fas fa-thumbtack"></i><small> หนังสือถึงผู้ว่าราชการจังหวัด</small></li> -->
                                                    <!-- <li class="list-group-item"><a href="FlowResiveDepart.php" class="btn btn-primary">หนังสือรับหน่วยงาน</a> <i class="fas fa-thumbtack"></i><small>หนังสือเข้าส่วนราชการ/หน่วยงาน</small> </li> -->
                                                    <!-- <li class="list-group-item"><a href="flow-resive-group.php" class="btn btn-primary">หนังสือรับกลุ่มงาน/ฝ่าย</a> <i class="fas fa-thumbtack"></i><small>หนังสือเข้าระดับกลุ่ม/ฝ่าย</small> </li> -->
                                                    <!-- <li class="list-group-item"><a href="flow-resive-depart.php" class="btn btn-primary">หนังสือรับจากจังหวัด</a> <i class="fas fa-thumbtack"></i><small>หนังสือรับจากจังหวัด</small> </li> -->
                                                    <!-- <hr> -->
                                                    <li class="list-group-item"><a href="flow-circle.php"
                                                            class="btn btn-primary">หนังสือส่ง[เวียน]</a> <i
                                                            class="fas fa-thumbtack"></i><small>หนังสือแจ้งเวียน</small>
                                                    </li>
                                                    <li class="list-group-item"><a href="flow-normal.php"
                                                            class="btn btn-primary">หนังสือส่ง[ปกติ]</a> <i
                                                            class="fas fa-thumbtack"></i><small>หนังสือส่งปกติ</small>
                                                    </li>
                                                    <!-- <li class="list-group-item"><a href="#" class="btn btn-primary">หนังสือส่ง[หน่วยงาน]</a> <i class="fas fa-thumbtack"></i><small>หนังสือส่งของหน่วยงาน</small> </li> -->
                                                    <li class="list-group-item"><a href="flow-command.php"
                                                            class="btn btn-primary">ออกเลขคำสั่งจังหวัด</a> <i
                                                            class="fas fa-thumbtack"></i><small>คำสั่งจังหวัด</small>
                                                    </li>
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
                                                <h4 class="panel-title text-center">
                                                    <a data-toggle="collapse" href="#menu2"><i
                                                            class="fas fa-credit-card fa-2x"></i><br> ทะเบียนสัญญา</a>
                                                </h4>
                                            </div>
                                            <div id="menu2" class="panel-collapse collapse">
                                                <ul class="list-group">
                                                    <li class="list-group-item"><a href="hire.php"
                                                            class="btn btn-primary">สัญญาจ้าง</a> <i
                                                            class="fas fa-thumbtack"></i><small>
                                                            ทะเบียนคุมสัญญาจ้าง</small></li>
                                                    <li class="list-group-item"><a href="buy.php"
                                                            class="btn btn-primary">สัญญาซื้อขาย</a> <i
                                                            class="fas fa-thumbtack"></i><small>ทะเบียนคุมสัญญาซื้อขาย</small>
                                                    </li>
                                                    <!-- <li class="list-group-item"><a href="announce.php" class="btn btn-primary">เอกสารประกวดราคา</a> <i class="fas fa-thumbtack"></i><small>ทะเบียนคุมเอกสารประกวดราคา</small> </li> -->
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
                                                <h4 class="panel-title text-center">
                                                    <a data-toggle="collapse" href="#menu4"><i
                                                            class="fas fa-gopuram fa-2x"></i><br> จองห้องประชุม</a>
                                                </h4>
                                            </div>
                                            <div id="menu4" class="panel-collapse collapse">

                                                <ul class="list-group">
                                                    <!-- <li class="list-group-item"><a class="btn btn-primary" href="meet_index.php"><i class="fas fa-envelope  pull-left"></i>  ปฏิทินการใช้ห้อง</a>
                                                        <li class="list-group-item"><a class="btn btn-primary" href="meet_index.php"><i class="far fa-envelope-open  pull-left"></i>  จองห้องประชุม</a> 
                                                        <li class="list-group-item"><a class="btn btn-primary" href="meet_room_user.php"><i class="fas fa-folder-open  pull-left"></i>  รายละเอียดห้องประชุม</a>  -->
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
                                                <h4 class="panel-title text-center">
                                                    <a data-toggle="collapse" href="#menu5"><i
                                                            class="fas fa-address-book fa-2x"></i><br>
                                                        สมุดโทรศัพท์จังหวัด</a>
                                                </h4>
                                            </div>
                                            <div id="menu5" class="panel-collapse collapse">

                                                <ul class="list-group">
                                                    <li class="list-group-item"><a class="btn btn-primary"
                                                            href="http://www.phone.phatthalung.go.th/" target="_news"><i
                                                                class="fas fa-home  pull-left"></i>
                                                            สมุดโทรศัพท์จังหวัด</a>
                                                        <!-- <li class="list-group-item"><a class="btn btn-primary" href="phone_depart.php"><i class="fas fa-school  pull-left"></i>  ข้อมูลหน่วยงาน</a> -->
                                                        <!-- <li class="list-group-item"><a class="btn btn-primary" href="headoffice.php"><i class="far fa-user-circle  pull-left"></i>  ข้อมูลผู้บริหาร/เจ้าหน้าที่</a>  -->
                                                        <!-- <li class="list-group-item"><a class="btn btn-primary" href="excel.php"><i class="fas fa-file-export  pull-left"></i>  ส่งออกเป็น Excel</a>  -->
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
        </div>


        <?php
        if ($level_id == 1) {
            //ตรวจสอบปีเอกสาร
            list($yid, $yname, $ystatus) = chkYear();


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

            $sum = $c1 + $c2 + $c3 + $c4 + $c5;

            // New Summary Query
            $sqlBook = "SELECT COUNT(*) as all_books FROM book_master";
            $resBook = dbQuery($sqlBook);
            $rowBook = dbFetchArray($resBook);

            $sqlToday = "SELECT COUNT(*) as today_books FROM book_detail WHERE date_in = CURDATE()";
            $resToday = dbQuery($sqlToday);
            $rowToday = dbFetchArray($resToday);

            // Count Departs
            $sqlDep = "SELECT COUNT(*) as all_dep FROM depart";
            $resDep = dbQuery($sqlDep);
            $rowDep = dbFetchArray($resDep);
            ?>

            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-book fa-3x pull-left"></i>
                            <div class="text-right">
                                <div class="huge"><?php echo $rowBook['all_books']; ?></div>
                                <div>หนังสือทั้งหมด</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <i class="fa fa-calendar-check-o fa-3x pull-left"></i>
                            <div class="text-right">
                                <div class="huge"><?php echo $rowToday['today_books']; ?></div>
                                <div>หนังสือเข้าวันนี้</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <i class="fa fa-university fa-3x pull-left"></i>
                            <div class="text-right">
                                <div class="huge"><?php echo $rowDep['all_dep']; ?></div>
                                <div>หน่วยงานทั้งหมด</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <style>
                .huge {
                    font-size: 30px;
                    font-weight: bold;
                }
            </style>

            <div class="row"> <!-- สถิติข้อมูล -->
                <div class="col-md-12">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <i class="fas fa-chart-pie  fa-2x" aria-hidden="true"></i> <strong>Admin Panal</strong>
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
                                                <td><?= $row['c1']; ?></td>
                                            </tr>
                                            <tr class="danger">
                                                <td>สารบรรณจังหวัด</td>
                                                <td><?= $row['c2']; ?></td>
                                            </tr>
                                            <tr class="info">
                                                <td>สารบรรณหน่วยงาน</td>
                                                <td><?= $row['c3']; ?></td>
                                            </tr>
                                            <tr class="warning">
                                                <td>สารบรรณกลุ่มฝ่าย</td>
                                                <td><?= $row['c4']; ?></td>
                                            </tr>
                                            <tr class="active">
                                                <td>ผู้ใช้ทั่วไป</td>
                                                <td><?= $row['c5']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>รวม</td>
                                                <td><?= $sum; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div> <!-- col-md-6 -->
                                <div class="col-md-6">
                                    <div id="piechart"></div>
                                    <script type="text/javascript" src="../js/chart/loader.js"></script>
                                    <script type="text/javascript">
                                        // Load google charts
                                        google.charts.load('current', { 'packages': ['corechart'] });
                                        google.charts.setOnLoadCallback(drawChart);

                                        // Draw the chart and set the chart values
                                        function drawChart() {
                                            var data = google.visualization.arrayToDataTable([
                                                ['Task', 'Hours per Day'],
                                                ['ผู้ดูแลระบบ', <?= $c1; ?>],
                                                ['สารบรรณจังหวัด', <?= $c2; ?>],
                                                ['สารบรรณหน่วยงาน', <?= $c3; ?>],
                                                ['สารบรรณกลุ่ม', <?= $c4; ?>],
                                                ['ผู้ใช้ทั่วไป', <?= $c5; ?>]
                                            ]);

                                            // Optional; add a title and set the width and height of the chart
                                            var options = { 'title': 'สัดส่วนผู้ใช้งาน', 'width': 550, 'height': 400 };

                                            // Display the chart inside the <div> element with id="piechart"
                                            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                                            chart.draw(data, options);
                                        }
                                    </script>
                                </div> <!-- col-md-6 -->
                            </div> <!-- row -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div id="depart" style="width: 100%; height: 350px;"></div>
                                    <script type="text/javascript">
                                        google.charts.setOnLoadCallback(drawChartDepart);
                                        function drawChartDepart() {
                                            var data = google.visualization.arrayToDataTable([
                                                ['Type', 'Count'],
                                                <?php
                                                $sqlType = "SELECT t.type_name, COUNT(d.dep_id) as count 
                                                            FROM office_type t 
                                                            LEFT JOIN depart d ON t.type_id = d.type_id 
                                                            GROUP BY t.type_id";
                                                $resultType = dbQuery($sqlType);
                                                while ($rowType = dbFetchArray($resultType)) {
                                                    echo "['" . $rowType['type_name'] . "', " . $rowType['count'] . "],";
                                                }
                                                ?>
                                            ]);

                                            var options = {
                                                title: 'จำนวนส่วนราชการ (แยกตามประเภท)',
                                                pieHole: 0.4,
                                                width: '100%',
                                                height: 350
                                            };

                                            var chart = new google.visualization.PieChart(document.getElementById('depart'));
                                            chart.draw(data, options);
                                        }
                                    </script>
                                </div>
                                <?php
                                // Removed duplicate chart code
                                ?>
                            </div> <!-- panel-body -->
                            <div class="panel-footer"></div>
                        </div> <!-- class panel -->
                    </div> <!-- col-md-12 -->
                </div> <!-- row -->
                <?php
        } ?> <!-- end if -->
        </div> <!-- container  -->
    </div>
<script src="js/dashboard_refresh.js"></script>
