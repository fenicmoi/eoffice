

<?php
date_default_timezone_set('Asia/Bangkok');
include "header.php"; 
include_once 'admin/function.php';
include 'library/pagination.php';
?>
<style>

    .highlight {
        background-color: #FFFF88;
    }

</style>
<?php    
   //ตรวจสอบปีเอกสารว่าเป็นปีปัจจุบันหรือไม่
    list($yid,$yname,$ystatus)=chkYear();  
    $yid=$yid;
    $yname=$yname;
    $ystatus=$ystatus;
?>
<br><br><br>
        <div  class="col-md-12">
            <div class="panel panel-primary" >
                <div class="panel-heading">
                    <i class="fa fa-envelope fa-2x" aria-hidden="true"></i>  <strong>หนังสือเวียนจังหวัด</strong>
                </div>
                <div class="panel-body">
                 <table class="table table-bordered table-hover" id="tableCircle">
                        <thead class="bg-info">
                            <tr >
                                <td colspan="6">
                                <form class="form-inline" method="post">
                                    <div class="form-group">
                                        <input type="radio" name="number" id="number" value="1">ค้นหาด้วยเลข
                                        <input type="radio" name="number" id="number" value="2" checked>ค้นหาด้วยชื่อเรื่อง
                                        <input type="radio" name="number" id="number" value="3">ค้นหาด้วยชื่อหน่วยงาน
                                        <input class="form-control" id="search" name="search" type="text" size=80 placeholder="Keyword สั้น ๆ ">
                                        <button class="btn btn-success" type="submit" name="save">
                                            <i class="fas fa-search "></i> ตกลง
                                        </button>
                                    </div>
                                    
                                </form>
                                </td>
                            </tr>
                            <tr>
                                <th>ทะเบียนหนังสือ</th>
                                <th>ชั้นความเร็ว</th>
                                <th>เรื่อง</th>
                                <th>ไฟล์แนบ</th>
                                <th>เจ้าของเรื่อง</th>
                                <th>ลงวันที่</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                @$type_search = $_POST['number'];
                                $txt_search = isset($_POST['search']) ? $_POST['search'] : '';
                                $sql = "SELECT fl.*,s.speed_name ,d.dep_name
                                      FROM  flowcircle as fl
                                      INNER JOIN speed as s ON s.speed_id = fl.speed_id
                                      INNER JOIN depart as d ON d.dep_id =fl.dep_id";
                                if(isset($_POST['save'])){    // check button search
                                    if($txt_search != null){
                                        if($type_search==1){    //search by id
                                         $sql.=" WHERE fl.rec_no LIKE '%$txt_search%' AND fl.open=1 ORDER BY cid DESC ";
                                        }else if($type_search==2){        //search by name
                                            $sql.=" WHERE fl.title LIKE '%$txt_search%' AND fl.open=1  ORDER BY cid DESC ";  
                                        }else if($type_search==3){
                                            $sql.=" WHERE d.dep_name LIKE '%$txt_search%' AND fl.open=1 ORDER BY cid DESC ";
                                        }//check type
                                        $num_row=100;  //แสดงผลจากการค้นหา
                                    }else{
                                        $sql.=" WHERE fl.open=1  ORDER BY cid DESC";
                                    }  //check null
                                }else{ //ถ้าไม่มีการกดเลือกใด ๆ  ใช้แสดงผลหน้าแรก
                                     $sql.=" WHERE fl.open=1  ORDER BY cid DESC";
                                     $num_row=10;
                                }//check button
                                //print $sql;
                                $result = page_query( $dbConn, $sql,@$num_row );

                                while($row = dbFetchArray($result)){?>
                                    <tr>
                                        <td><?php echo $row['prefex']; echo $row['rec_no']; ?></td>
                                    <?php
                                        $speedname=$row['speed_name'];
                                        if($speedname=='ปกติ'){
                                           echo  "<td class='bg-success'>".$row['speed_name']."</td>";
                                        }elseif ($speedname=='ด่วน') {
                                            echo  "<td class='bg-info'>".$row['speed_name']."</td>";
                                        }elseif ($speedname=='ด่วนมาก') {
                                            echo  "<td class='bg-warning'>".$row['speed_name']."</td>";
                                        }elseif ($speedname=='ด่วนที่สุด') {
                                             echo  "<td class='bg-danger'>".$row['speed_name']."</td>";
                                        }
                                    ?>
                                    
                                        <td>
                                            <?php 
                                            $cid=$row['cid']; 
                                            $doctype='flow-circle';  //ใช้แยกประเภทตารางเพื่อส่งไปให้ file paper
                                            ?>
                                            <a class="text-success" href="#" 
                                                onClick="loadData('<?php print $cid;?>');" 
                                                data-toggle="modal" data-target=".bs-example-modal-table">
                                                <?php echo iconv_substr( $row['title'],0,150,"UTF-8")."...";?> 
                                           </a>
                                        <i class="fas fa-eye"> <?=$row['hit'];?></i>
                                        </td>
                                        <td>
                                            <?php 
                                            $file_upload=$row['file_upload'];
                                            if($file_upload==''){
                                                echo "no file";
                                            }else{
                                                echo "<a class=\"btn btn-info\" href='admin/$file_upload' target='_blank'><i class='fas fa-file-alt'></i> ไฟล์แนบ</a>";
                                            } 
                                            ?>
                                        </td>
                                        <td>
                                                <?php echo iconv_substr( $row['dep_name'],0,50,"UTF-8")."...";?> 
                                        
                                        </td>
                                        <td><?php echo thaiDate($row['dateline']); ?></td>
                                    </tr>
                                    <?php  } ?>
                        </tbody>
                    </table>
                </div> <!-- panel-body -->
                <div class="panel-footer">
                    <center>
                        <a href="flow-circle-front.php" class="btn btn-primary"><i class="fas fa-home"></i> หน้าหลัก</a>
                        <?php 
                            page_link_border("solid","1px","gray");
                            page_link_bg_color("lightblue","pink");
                            page_link_font("14px");
                            page_link_color("blue","red");
                            page_echo_pagenums(10,true); 
                        ?>
                    </center>
                </div> <!-- panel-footer -->
            </div> <!-- panel -->

        </div>  <!-- col-md-10 -->


    </div>  <!-- container -->
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
<script type="text/javascript">
function loadData(cid) {
    var sdata = {
        cid : cid,
    };
$('#divDataview').load('show-flow-circle.php',sdata);
}
</script>
<script>    
$("td").highlight("<?php echo $txt_search;?>");
</script>