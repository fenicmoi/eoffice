
<!-- หนังสือถึงส่วนราชการ-->
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
                    <i class="fa fa-university fa-2x" aria-hidden="true"></i>  <strong>หนังสือเข้า [จากจังหวัด]</strong>
                </div>
                    <table class="table table-bordered table-hover" id="tbRecive">
                        <thead class="bg-info">
                            <tr>
                                <th>เลขรับ</th>
                                <th>เลขที่เอกสาร</th>
                                <th>เรื่อง</th>
                                <th>จาก</th>
                                <th>วันที่</th>
                                <th>ไฟล์</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql="SELECT m.book_id,m.rec_id,d.book_no,d.title,d.sendfrom,d.sendto,d.recive_no,d.date_in,d.date_line,d.practice,d.file_location,d.status,s.sec_code
                                      FROM book_master m
                                      INNER JOIN book_detail d ON d.book_id = m.book_id
                                      INNER JOIN section s ON s.sec_id = m.sec_id
                                      WHERE m.type_id=1 AND d.practice = $dep_id AND d.status = 0
                                      ORDER BY m.book_id DESC";
                               // echo $sql;
                                $result=dbQuery($sql);
                               // $numrow=dbNumRows($result);
                                while($row=  dbFetchArray($result)){?>
                                    <?php $rec_id=$row['rec_id']; ?>    <!-- กำหนดตัวแปรเพื่อส่งไปกับลิงค์ -->
                                    <?php $book_id=$row['book_id']; ?>  <!-- กำหนดตัวแปรเพื่อส่งไปกับลิงค์ -->
                                    <?php $recive_no=$row['recive_no']; ?>  <!-- ตรวจสอบว่าได้เลขลงรับแล้วหรือไม่ -->
                                    <tr>
                                        <?php
                                        if($recive_no == null){?>
                                            <td><?php echo 'รอยืนยัน';?></td>
                                        <?}else{?>
                                            <td><?php echo $recive_no ;?></td>
                                        <?}?>
                                        
                                        <td><?php echo $row['book_no'];?></td>
                                        <td>
                                            <a href="#" 
                                                    onclick="load_leave_data('<? print $u_id;?>','<? print $rec_id; ?>','<? print $book_id; ?>');" data-toggle="modal" data-target=".bs-example-modal-table">
                                                    <?php echo $row['title'];?> 
                                            </a>
                                        </td>
                                        <td><?php echo $row['sendfrom']; ?></td>
                                        <?php if($row['date_line']==null){
                                            $date_line= "รอยืนยัน";
                                        }else{
                                            $date_line= thaiDate($row['date_line']);
                                        }
                                        ?>
                                        <td><?php echo $date_line; ?></td>
                                        <td>
                                        <?php
                                            if($row['file_location']==''){?>
                                            ไม่มีไฟล์
                                           <?php }else{ ?>
                                            <a class="btn btn-info btn-xs btn-block" href="<?php echo $row['file_location'];?>" target="_bank"><i class="fas fa-download"></i></a>
                                         <?   } ?>
                                         </td>
                                    </tr>

                                    <?php } ?> <!-- end while -->
                                    
                        </tbody>
                    </table>
            </div> <!-- class panel -->        
        </div>  <!-- col-md-10 -->
    
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



<?php 
 #######  กรณีลงรับหนังสือ  ##########
 if(isset($_POST['resive'])){
    $book_detail_id = $_POST['book_detail_id'];
    $date=date('Y-m-d');

    dbQuery('BEGIN');
    
     $sql2 = "SELECT MAX(rec_no) AS num FROM flowrecive WHERE (dep_id = $dep_id) && (yid = $yid)";
    $result2 = dbQuery($sql2);
    $row = dbFetchAssoc($result2);
    $num=$row['num'];
    if($num != 0){
        $num++;
    }else{
        $num = 1;
    }

    $sql1="UPDATE book_detail SET recive_no=$num, date_line='$date',status=1 WHERE book_detail_id=$book_detail_id";  //update สถานะหนังสือว่าลงรับแล้ว
    $result1=dbQuery($sql1);

   
    $sql3 = "INSERT INTO flowrecive (book_detail_id,rec_no,dep_id,yid) VALUES ($book_detail_id, $num, $dep_id, $yid ) ";
    $result3 = dbQuery($sql3);

         if($result1 && $result3){
            dbQuery('COMMIT');
            echo "<script>
            swal({
                title:'ลงทะเบียนรับเรียบร้อยแล้ว',
                type:'success',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='flow-resive-depart.php';
                    }
                }); 
            </script>";
        }else{
            dbQuery("ROLLBACK");
            echo "<script>
            swal({
                title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
                type:'error',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='FlowResiveProvince.php';
                    }
                }); 
            </script>";
        } 
 }


//กรณีส่งคืนหนังสือ
 if(isset($_POST['reply'])){
    $book_detail_id = $_POST['book_detail_id'];
    $date=date('Y-m-d');
    $sql="UPDATE book_detail SET date_line='$date', status=2 WHERE book_detail_id=$book_detail_id";  //1 ยอมรับหนังสือ
    //echo $sql;
        $result=dbQuery($sql);
         if($result){
            echo "<script>
            swal({
                title:'ส่งคืนหนังสือแล้ว',
                type:'success',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='FlowResiveProvince.php';
                    }
                }); 
            </script>";
        }else{
            echo "<script>
            swal({
                title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
                type:'error',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='FlowResiveProvince.php';
                    }
                }); 
            </script>";
        } 
 }


?>


<!-- ส่วนนำข้อมูลไปแสดงผลบน Modal -->
<script type="text/javascript">
function load_leave_data(u_id,rec_id,book_id) {
                    var sdata = 
                    {u_id : u_id , 
                    rec_id : rec_id,
                    book_id : book_id
                    };
                    $('#divDataview').load('ShowResiveProvinceDetail.php',sdata);
}
</script>


<script type='text/javascript'>
       $('#tbRecive').DataTable( {
        "order": [[ 0, "desc" ]]
    } )
</script>

<script type='text/javascript'>
       $('#tbNew').DataTable( {
        "order": [[ 0, "desc" ]]
    } )
</script>


