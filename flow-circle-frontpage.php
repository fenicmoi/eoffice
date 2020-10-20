

<?php    
   //ตรวจสอบปีเอกสารว่าเป็นปีปัจจุบันหรือไม่
    list($yid,$yname,$ystatus)=chkYear();  
    $yid=$yid;
    $yname=$yname;
    $ystatus=$ystatus;
?>
            <div class="panel panel-primary" >
                <div class="panel-heading">
                    <i class="fa fa-envelope fa-2x" aria-hidden="true"></i>  <strong>หนังสือเวียนจังหวัด (5 อันดับล่าสุด)</strong>
                </div>
                <div class="panel-body">
                 <table class="table table-bordered table-hover" id="tableCircle">
                        <thead class="bg-info">
                            <tr>
                                <th>ความเร็ว</th>
                                <th>เรื่อง</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql = "SELECT cid FROM flowcircle  ";
                                $result=dbQuery($sql);
                                $Num_Rows = dbNumRows($result);
                               
                                @$txt_search=$_POST['search'];
                                @$type_search=$_POST['number'];

                                //ตรวจสอบและกำหนดจำนวนรายการ
                                if(isset($_POST['Per_page'])){    //ตรวจสอบตัวแปร perpage เพื่อหาจำนวนรายการที่จะนำไปแสดงผล
                                    $Per_Page = $_POST['Per_page'];  //รับค่า
                                }else{
                                    $Per_Page = 10;                //ถ้าไม่มีให้ใช้ 10
                                }

                                //ตรวจสอบการรับค่าหน้า
                                 if (isset($_GET['Page'])) {    //ถ้ามีการรับค่า Page มา
                                    $Page = $_GET['Page'];     //กำหนดตัวแปร page
                                }else{
                                    $Page = 1;                 //ถ้าไม่มีการกำหนด  ตัวแปรเท่ากับ 1
                                }
                                $Prev_Page = $Page-1;          //ก่อนหน้า
                                $Next_Page = $Page+1;          //ถัดไป

                                $Page_Start = (($Per_Page*$Page)-$Per_Page);    //หน้าเริ่มต้น เท่ากับจำนวนหน้าแสดงผล * หน้า

                                if($Num_Rows<=$Per_Page){
                                    $Num_Pages =1;
                                }else if(($Num_Rows % $Per_Page)==0){
                                    $Num_Pages =($Num_Rows/$Per_Page) ;
                                }else{
                                    $Num_Pages =($Num_Rows/$Per_Page)+1;
                                    $Num_Pages = (int)$Num_Pages;
                                }
                                
                                $sql.=" ORDER BY cid ASC LIMIT $Page_Start , $Per_Page";
                               // print $sql;
                                
                                $sql="SELECT fl.*,s.speed_name 
                                      FROM  flowcircle as fl
                                      INNER JOIN speed as s ON s.speed_id = fl.speed_id";

                                if(isset($_POST['save'])){    // check button search
                                      if($type_search==1){    //search by id
                                         $sql.=" WHERE rec_no LIKE '%$txt_search%' AND fl.open=1 ORDER BY cid DESC LIMIT $Page_Start , $Per_Page";
                                      }else if($type_search==2){        //search by name
                                         $sql.=" WHERE title LIKE '%$txt_search%' AND fl.open=1  ORDER BY cid DESC LIMIT $Page_Start , $Per_Page  ";  
                                      }
                                }else{ //ถ้าไม่มีการกดเลือกใด ๆ  ใช้แสดงผลหน้าแรก
                                     $sql.=" WHERE fl.open=1  ORDER BY cid DESC limit $Page_Start , $Per_Page  ";
                                }

                                $result = dbQuery($sql);
                                while($row = dbFetchArray($result)){?>
                                    <tr>
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
                                            <a class="text-success" href="#?u_id=<?php print $u_id;?>" 
                                                onClick="loadData('<?php print $cid;?>');" 
                                                data-toggle="modal" data-target=".bs-example-modal-table">
                                                <?php echo iconv_substr( $row['title'],0,150,"UTF-8")."...";?> 
                                        </a>
                                        <i class="fas fa-eye"> <?=$row['hit'];?></i>
                                        </td>
                                    </tr>
                                    <?php  } ?>
                        </tbody>
                    </table>
                </div> <!-- panel-body -->
                <div class="panel-footer">
                    <center><i class="fas fa-home fa-2x"></i></center>
                </div> <!-- panel-footer -->
            </div> <!-- panel -->
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
