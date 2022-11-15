
<div class="rows">
        <div class="col-md-12">
        <!-- ถ้าไม่มีการกดเลือกวันที่ -->
        <?php if(!$startdate){ ?>  
                    <br>
                    <table width="100%" class="table table-hover" border='1'>
                        <thead>
                            <tr class="bg-primary">
                                <th colspan='6'>
                                    <h5><i class="fas fa-clipboard-list fa-2x "></i> <b>ตารางการประชุมวันที่</b> <span class="badge"><?php echo $today;?></span></h5>
                                  
                                </th>
                            </tr>
                            <tr>
                                <th width="6%">สถานะ</th>
                                <th width="65%"><b>เรื่อง</b></th>
                                <th width="10%"><b>ชื่อห้องประชุม</b></th>
                                <th class="text-center" width="10%"><b>จำนวนคน</b></th>
                                <th class="text-center" width="10%"><b>เวลาประชุม</b></th>
                                <th><b>คำขออนุมัติ</b></th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php
                                    $sql="SELECT bk.book_id, bk.subject, rm.roomname, 
                                                bk.startdate, bk.enddate, bk.dep_id ,
                                                bk.starttime, bk.endtime, bk.numpeople,
                                                bk.conf_status, bk.catgory, bk.fileupload
                                        FROM meeting_booking as bk, meeting_room as rm 
                                        WHERE  bk.room_id=rm.room_id   
                                        AND    bk.conf_status <> 0
                                        AND    bk.startdate='$year-$curMonth-$curDay' 
                                        ORDER BY bk.room_id ASC";
                                    $dbquery = dbQuery($sql);
                                    $numrows = dbNumRows($dbquery);
                                    if($numrows == 0){?>
                                        <tr>
                                            <td colspan="6" class="text-center"><h4><i class="fas fa-info "></i> ไม่มีข้อมูลการประชุมสำหรับวันนี้</h4></td>
                                        </tr>
                                    <?php } else {
                                         while($result=dbFetchArray($dbquery)){
                                                $book_id=$result[0];
                                                $subject=$result[1];
                                                $room_name=$result[2];
                                                $startdate=$result[3];
                                                $enddate=$result[4];
                                                $bookname=$result[5];
                                                $starttime=$result[6];
                                                $endtime=$result[7];
                                                $num=$result[8];
                                                $conf_status=$result[9];
                                                $catgory=$result[10];
                                                $fileupload=$result[11];
                                                ?>      
                                        <tr>
                                            <td>
                                                <?php
                                                    switch($conf_status){
                                                        case 0:
                                                            echo "<b><font color='red'>ยกเลิก</font></b>";
                                                            break;
                                                        case 1:
                                                            echo "<b><font color='red'>รออนุมัติ</font></b>";
                                                            break;
                                                        case 2:
                                                            echo "<b><font color='green'>อนุมัติ</font></b>";
                                                            break;
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                 <a  href="#" 
                                                    onClick="loadListFrontDetail('<?php echo $book_id; ?>');" 
                                                    data-toggle="modal" data-target=".modal-reserv">
                                                    <?php echo $subject;?>
                                                 </a>
                                            </td>
                                            <td><?php echo $room_name;?></td>
                                            <td class="text-center"><?php echo $num;?>&nbspคน</td>
                                            <td class="text-center"><?php echo $starttime;?> - <?php echo $endtime;?></td>
                                            <td><?php echo $fileupload;?></td>
                                        </tr>
                                   <?php }?>
                             <?php } ?>
                                     <tr>
                                        <td class="text-center" colspan="6"><a class="btn btn-default"><i class="fas fa-print"></i> สั่งพิมพ์</a></td></td>
                                    </tr>      
                        </tbody>
                    </table>    
     <!-- ถ้ามีการกดเลือกวันที่ -->           
    <? }else if($startdate){?>
                <table width="100%" class="table table-hover" border='1'>
                        <thead>
                            <tr class="bg-primary">
                                <th colspan='6'>
                                    <h5><i class="fas fa-clipboard-list fa-2x "></i> <b>ตารางการประชุมวันที่</b> <span class="badge"><?php echo thaiDate($startdate); ?></span></h5>
                                </th>
                            </tr>
                            <tr>
                                <th width="6%">สถานะ</th>
                                <th width="65%"><b>เรื่อง</b></th>
                                <th width="10%"><b>ชื่อห้องประชุม</b></th>
                                <th class="text-center" width="10%"><b>จำนวนคน</b></th>
                                <th class="text-center" width="10%"><b>เวลาประชุม</b></th>
                                <th><b>คำขออนุมัติ</b></th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php
                                 $sql="SELECT bk.book_id, bk.subject, rm.roomname, 
                                                bk.startdate, bk.enddate, bk.dep_id ,
                                                bk.starttime, bk.endtime, bk.numpeople,
                                                bk.conf_status, bk.remark, bk.catgory, bk.fileupload
                                        FROM meeting_booking as bk, meeting_room as rm 
                                        WHERE  bk.room_id=rm.room_id   
                                        AND    bk.conf_status <> 0
                                        AND    bk.startdate='$startdate' 
                                        ORDER BY bk.starttime ASC";
                                //print $sql;
                                $dbquery = dbQuery($sql);

                                while ($result = dbFetchArray($dbquery)) {
                                     $book_id=$result[0];
                                     $subject=$result[1];
                                    $room_name=$result[2];
                                    $startdate=$result[3];
                                    $enddate=$result[4];
                                    $bookname=$result[5];
                                    $starttime=$result[6];
                                    $endtime=$result[7];
                                    $num=$result[8];
                                    $conf_status=$result[9];
                                    $remark=$result[10];
                                    $catgory=$result[11];
                                    $fileupload=$result[12];
                                    ?>       
                                    
                                        <tr>
                                            <td>
                                                 <?php
                                                    switch($conf_status){
                                                        case 0:
                                                            echo "<b><font color='red'>ยกเลิก</font></b>";
                                                            break;
                                                        case 1:
                                                            echo "<b><font color='red'>รออนุมัติ</font></b>";
                                                            break;
                                                        case 2:
                                                            echo "<b><font color='green'>อนุมัติ</font></b>";
                                                            break;
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                 <a  href="#" 
                                                    onClick="loadListFrontDetail('<?php echo $book_id; ?>');" 
                                                    data-toggle="modal" data-target=".modal-reserv">
                                                    <?php echo $subject; ?>
                                                 </a>
                                                 [<?php echo $remark;?>]
                                            </td>
                                            <td><?php echo $room_name; ?></td>
                                            <td class="text-center"><?php echo $num; ?>&nbspคน</td>
                                            <td class="text-center"><?php echo $starttime; ?> - <?php echo $endtime; ?></td>
                                            <td><a href="form-meeting/<?php echo $fileupload;?>" target="_blank"><i class="fas fa-download fa-2x"></i></a></td>
                                        </tr>
                                   <?php 
                                } ?>   
                        </tbody>
                    </table>    
			<? }?>	
            </div>  <!-- col-md10 -->
        </div>  <!-- col-md-rows -->
    </div> <!-- class rows -->


<script>
function loadListFrontDetail(book_id) {
    var sdata = {book_id : book_id};
$('#divReserv').load('meet_listFront_detail.php',sdata);
}

</script>