
<!-- หนังสือรับถึงจังหวัด -->
<?php   
include "header.php"; 
$u_id=$_SESSION['ses_u_id'];
?>

<script type="text/javascript" src="datePicket.js"></script>

<?php    
//ตรวจสอบปีเอกสาร
    list($yid,$yname,$ystatus)=chkYear();  
    $yid=$yid;
    $yname=$yname;
    $ystatus=$ystatus;
?>
<!-- ส่วนการทำ auto complate -->

        <div class="col-md-2" >
           <?php
                $menu=  checkMenu($level_id);
                include $menu;
           ?>
        </div>
        <div  class="col-md-10">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    <i class="fa fa-university fa-2x" aria-hidden="true"></i>  <strong>ทะเบียนหนังสือรับ[จากจังหวัด]</strong>
                    <a href="" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myReport"><i class="fa fa-print " aria-hidden="true"></i> รายงานประจำวัน</a>
                </div>
                    <table class="table table-bordered table-hover" id="tbRecive">
                        <thead class="bg-info">
                            <tr>
                                <th>ท/บ กลาง</th>
                                <th>ท/บ รับ</th>
                                <th>เลขที่เอกสาร</th>
                                <th>เรื่อง</th>
                                <th>จาก</th>
                                <th>ลงวันที</th>
                                <th>ไฟล์</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $count=1;
                                $sql="SELECT fr.*,d.book_id,d.book_no,d.title,d.sendfrom,d.date_book,d.date_line,d.status,d.file_location
                                      FROM flowrecive as fr
                                      INNER JOIN book_detail as d ON fr.book_detail_id = d.book_detail_id
                                      WHERE dep_id = $dep_id ORDER BY fr.cid";
                                      
                               // print $sql;
                                $result=dbQuery($sql);
                                while($row=dbFetchArray($result)){?>
                                    <?php $rec_id=$row['rec_no']; ?>    <!-- กำหนดตัวแปรเพื่อส่งไปกับลิงค์ -->
                                    <?php $book_id=$row['book_detail_id']; ?>  <!-- กำหนดตัวแปรเพื่อส่งไปกับลิงค์ -->
                                    <tr>
                                        <td> <?php echo $row['cid']; ?></td>  
                                        <td><?php echo $row['rec_no']; ?></td>
                                        <td><?php echo $row['book_no']; ?></td>
                                        <td>
                                            <a href="#" 
                                                    onclick="load_leave_data('<? print $u_id;?>','<? print $rec_id; ?>','<? print $book_id; ?>');" data-toggle="modal" data-target=".bs-example-modal-table">
                                                    <?php echo $row['title'];?> 
                                            </a>
                                        </td>
                                        <td><?php echo $row['sendfrom']; ?></td>
                                        <td><?php echo $row['date_book']; ?></td>
                                        <td>
                                        <?php
                                            if($row['file_location']==''){?>
                                                ไม่มีไฟล์
                                            <? }else{ ?>
                                                <a class="btn btn-success btn-xs btn-block" href="<?php echo $row['file_location'];?>" target="_bank"><i class="fas fa-download"></i></a>
                                            <? } ?>
                                        </td>
                                    </tr>
                            <?php $count++; }?>  <!--end while
                                    
                        </tbody>
                    </table>
                   
                        <div class="col">
                       <kbd>หมายเหตุ >>></kbd>  <i class='alert-success fa fa-envelope'></i >รอรับ  
                       <i class='alert-info fa fa-envelope-open'></i>รับแล้ว  
                       <i class='alert-danger fa fa-reply'></i>ส่งคืน
                    
                    <hr/>
            </div> <!-- class panel -->
        </div>  <!-- col-md-10 -->

    <!-- Modal report -->
            <div id="myReport" class="modal fade" role="dialog">
              <div class="modal-dialog">
            
                <!-- Modal content-->
                <div class="modal-content ">
                  <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-print"></i> รายงานทะเบียนหนังสือรับ</h4>
                  </div>
                  <div class="modal-body">
                    	 <form class="form-inline" role="form" id="form_other" name="form_other" method="POST"  action="report/rep-resive-depart.php"> 
                                <span>เลือกวันที่</span>
                                <input class="form-control" id="dateprint" name="dateprint" type="date" value="<?=$pDate;?> ">
                                <button type="submit" class="btn btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-floppy-saved"></span>&nbspตกลง
                                </button>
                                <input type="hidden" name="yid" value="<?=$yid?>">
                                <input type="hidden" name="uid" value="<?=$uid?>"></td>
                                <input type="hidden" name="username" value="<?=$username?>"></td>
                         </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
            
              </div>
            </div>
    <!-- end myReport -->
    
    <!--  modal แสงรายละเอียดข้อมูล -->
        <div  class="modal fade bs-example-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-info"></i> รายละเอียด</h4>
                    </div>
                    <div class="modal-body no-padding">
                        <div id="divDataview">
                            <!-- สวนสำหรับแสดงผลรายละเอียด   อ้างอิงกับไฟล์  show_command_detail.php -->                             
                        </div>     
                    </div> <!-- modal-body -->
                    <div class="modal-footer bg-info">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- ส่วนนำข้อมูลไปแสดงผลบน Modal -->
<script type="text/javascript">
function load_leave_data(u_id,rec_id,book_id) {
                    var sdata = 
                    {u_id : u_id , 
                    rec_id : rec_id,
                    book_id : book_id
                    };
                    $('#divDataview').load('show_resive_depart_detail.php',sdata);
}
</script>

<!-- ตารางแสดงข้อมูลหลัก -->
<script type='text/javascript'>
       $('#tbRecive').DataTable( {
        "order": [[ 0, "desc" ]]
    } )
</script>
<!-- ตารางแสดงหน่วยงาน -->
<script type='text/javascript'>
       $('#tbNew').DataTable( {
        "order": [[ 0, "desc" ]]
    } )
</script>

<script>
function setEnabledTo2(obj) {
	 if(obj.value=="3") {             //กรณีเลือกเอง
        obj.form.toSomeOneUser.disabled=false;
	} 
}
</script>
 <script type="text/javascript">     
    function listSome(a,b,c) {     //ฟังค์ชั่นกรณีเลือกส่วนราชการเอง
        m=document.form.toSomeOneUser.value;
        
        if (a.checked) {
            if (m.indexOf(b)<0) m+='|'+b;
        
        } else {
        m=document.form.toSomeOneUser.value.replace('|'+b,'');
        }
        z="|";
        if (m.substring(2) == c) m=m.substring(2);
        document.form.toSomeOneUser.value=m;
    }
</script>
