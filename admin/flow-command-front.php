
<?php
include "header.php"; 
include "admin/function.php"; 

//ตรวจสอบปีเอกสาร
list($yid,$yname,$ystatus)=chkYear();  
$yid=$yid;
$yname=$yname;
$ystatus=$ystatus;
?>
<br><br><br>
        <div  class="col-md-12">
            <div class="panel panel-primary" style="margin: 20">
                <div class="panel-heading">
                        <i class="fas fa-clipboard-list  fa-2x" aria-hidden="true"></i>  <strong>ทะเบียนคำสั่งจังหวัด</strong>
                </div> <!-- panel -heading-->
                     <table class="table table-bordered table-hover" id="tbCommand">
                        <thead class="bg-info">
                             <tr >
                                <td colspan="6">
                                    <form class="form-inline" method="post">
                                        <div class="form-group">
                                            <input type="radio" name="number" id="number" value="1">ค้นหาด้วยเลข
                                            <input type="radio" name="number" id="number" value="2" checked>ค้นหาด้วยชื่อเรื่อง
                                            <div class="input-group">
                                            <span class="input-group-addon">แถวการแสดงผล:</span>
                                                <select class="form-control" name="Per_page">
                                                    <option value="20">20</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                            <input class="form-control" id="search" name="search" type="text" size=80 placeholder="พิมพ์ข้อความค้นหา">
                                            <button class="btn btn-success" type="submit" name="save">
                                                <i class="fas fa-search "></i> ตกลง
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <th>เลขที่คำสั่ง</th>
                                <th>เรื่อง</th>
                                <th>ไฟล์แนบ</th>
                                <th>ลงวันที่</th>
                                <th>เจ้าของเรื่อง</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php
                                $sql = "SELECT cid FROM flowcommand  ";
                                $result=dbQuery($sql);
                                $Num_Rows = dbNumRows($result);

                                @$txt_search=$_POST['search'];    //รับค่าจากกล่องข้อความ
                                @$type_search=$_POST['number'];   // รับค่าจากการเลือกวิธีสืบค้น
                                //$Per_Page=10;

                                if(isset($_POST['Per_page'])){    //ตรวจสอบตัวแปร perpage เพื่อหาจำนวนรายการที่จะนำไปแสดงผล
                                    $Per_Page = $_POST['Per_page'];  //รับค่า
                                }else{
                                    $Per_Page = 10;                //ถ้าไม่มีให้ใช้ 10
                                }

                                 
                                if (isset($_GET['Page'])) {    //ถ้ามีการรับค่า Page มา
                                    $Page = $_GET['Page'];     //กำหนดตัวแปร page
                                }else{
                                    $Page = 1;                 //ถ้าไม่มีการกำหนด  ตัวแปรเท่ากับ 1
                                }

                                $Prev_Page = $Page-1;          //ก่อนหน้า
                                $Next_Page = $Page+1;          //5yfwx

                                $Page_Start = (($Per_Page*$Page)-$Per_Page);    //หน้าเริ่มต้น เท่ากับจำนวนหน้าแสดงผล * หน้า

                                if($Num_Rows<=$Per_Page){
                                    $Num_Pages =1;
                                }else if(($Num_Rows % $Per_Page)==0)
                                {
                                    $Num_Pages =($Num_Rows/$Per_Page) ;
                                }else{
                                    $Num_Pages =($Num_Rows/$Per_Page)+1;
                                    $Num_Pages = (int)$Num_Pages;
                                }

                                $sql .=" ORDER  by cid ASC LIMIT $Page_Start , $Per_Page";
                                $objQuery  = dbQuery($sql);

                                if(isset($_POST['save'])){    //กรณีที่มีการกดปุ่มค้นหา
                                      if($type_search==1){    //ถ้าค้นหาด้วยเลขคำสั่ง
                                         $sql="SELECT c.*,y.yname,d.dep_name
                                                FROM  flowcommand as c
                                                INNER JOIN sys_year as y ON y.yid=c.yid
                                                INNER JOIN depart as d ON d.dep_id =c.dep_id
                                                WHERE rec_id LIKE '%$txt_search%' 
                                                ORDER BY cid DESC
                                                limit $Page_Start , $Per_Page  ";
                                      }else if($type_search==2){    //ถ้าค้นหาด้วยชื่อคำสั่ง
                                           $sql="SELECT c.*,y.yname,d.dep_name
                                                FROM  flowcommand as c
                                                INNER JOIN sys_year as y ON y.yid=c.yid
                                                INNER JOIN depart as d ON d.dep_id =c.dep_id
                                                WHERE title LIKE '%$txt_search%'   ORDER BY cid DESC
                                                limit $Page_Start , $Per_Page  ";  
                                      }

                                      //print $sql;
                                     
                                }else{
                                     $sql="SELECT c.*,y.yname,d.dep_name
                                      FROM  flowcommand as c
                                      INNER JOIN sys_year as y ON y.yid=c.yid
                                      INNER JOIN depart as d ON d.dep_id =c.dep_id
                                      ORDER BY c.cid DESC LIMIT $Page_Start,$Per_Page";
                                }
                               
                                //print $sql;
                               // $edit=1;
                                $result = dbQuery($sql);
                                while($row=dbFetchArray($result)){?>
                                    <?php 
                                        $cid=$row['cid'];
                                        $file_upload=$row['file_upload'];
                                     ?>
                                    <tr>
                                        <td> <?php echo $row['rec_id']; ?>/<?php echo $row['yname']; ?></td> 
                                      
                                        <td> <a class="text-success" href="#" onclick="load_leave_data('<?php print $cid; ?>');" data-toggle="modal" data-target=".bs-example-modal-table"> 
                                            <?php echo iconv_substr($row['title'],0,100,"UTF-8")."...";?> </a> <i class="fas fa-eye"> <?=$row['hit'];?></i></td>
                                        <td>
                                            <?php
                                                if($file_upload==''){
                                                    echo "No file";
                                                }else{
                                                     echo "<a class=\"btn btn-info\" href='admin/$file_upload' target='_blank'><i class='fas fa-file-alt'></i> ไฟล์แนบ</a>";
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo thaiDate($row['dateout']); ?></td>
                                        <td><?=$row['dep_name']?> </td>
                                    </tr>
                                    <?php }?>
                                  <tr>

                                    <?php
                                        if($Num_Rows<=$Per_Page){
                                            $Num_Pages =1;
                                        }else if(($Num_Rows % $Per_Page)==0){
                                            $Num_Pages =($Num_Rows/$Per_Page) ;
                                        }else{
                                            $Num_Pages =($Num_Rows/$Per_Page)+1;
                                            $Num_Pages = (int)$Num_Pages;
                                        }
                                    ?>
                                        <td colspan=5>
                                            <center>
                                             <nav>
                                                <ul class="pagination">
                                                    <?php 
                                                        if($Prev_Page){
                                                            echo " 
                                                                <li>
                                                                    <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page'>ก่อนหน้า</a> 
                                                                    <span aria-hidden=\"true\"><i class=\"fas fa-arrow-alt-circle-left\"></i>
                                                                </li>";
                                                        }

                                                        for($i=1; $i<=$Num_Pages; $i++){
                                                                $Page1 = $Page-2;
                                                                $Page2 = $Page+2;
                                                                if($i != $Page && $i >= $Page1 && $i <= $Page2){
                                                                    echo "<li><a href='$_SERVER[SCRIPT_NAME]?Page=$i'>$i</a></li>";
                                                                }
                                                        }
                                                        
                                                        if($Page!=$Num_Pages){
                                                            echo " 
                                                                <li>
                                                                    <span aria-hidden=\"true\"><i class=\"fas fa-arrow-alt-circle-right\"></i>
                                                                    <a href='$_SERVER[SCRIPT_NAME]?Page=$Next_Page'>ถัดไป</a> 
                                                                </li>";
                                                        }
                                                        ?>
                                                </ul>
                                            </nav>
                                            </center>
                                        </td>
                                    </tr>
                        </tbody>
                    </table>
            </div>
        </div>  <!-- col-md-10 -->
    </div>  <!-- container -->


 <!-- Modal แสดงรายละเอียด -->
  <div  class="modal fade bs-example-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-info"></i> รายละเอียดคำสั่ง</h4>
        </div>
        <div class="modal-body no-padding">
            <div id="divDataview"></div>     <!-- สวนสำหรับแสดงผลรายละเอียด   อ้างอิงกับไฟล์  show_command_detail.php -->
        </div> <!-- modal-body -->
        <div class="modal-footer bg-primary">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!--end Modal  -->

<!-- Modal -->
<div id="modalAdd" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title"> <i class="fas fa-plus"></i> ออกเลขคำสั่ง</h4>
      </div>
      <div class="modal-body">
         <form name="form" method="post" enctype="multipart/form-data">
         <div class="form-group">
          <div class="input-group">
              <span class="input-group-addon">ปีคำสั่ง:</span>
              <input type="text" class="form-control" name="yearDoc" value="<?php print $yname ; ?>">
            </div>  
          </div>       
           <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">เลขที่คำสั่ง:</span>
                <kbd>ออกโดยระบบ</kbd>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">ผู้ลงนาม:</span>
                <input type="text" class="form-control" name="boss" value="ผู้ว่าราชการจังหวัดพังงา">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">เรื่อง:</span>
                <input class="form-control" type="text" class="form-control" name="title" required>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">วันที่ลงนาม:</span>
                <input class="form-control" type="date" name="datepicker"  id="datepicker" required >
            </div>
         </div>
         <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">วันที่บันทึก:</span>
                <input type="text" name="currentDate"  id="currentDate" value="<?php  echo DateThai(); ?>" >
            </div>
         </div>
         <div class="form-group">
            <div class="input-group">
                <input class="form-control" type="file" name="fileupload" id="fileupload" disabled><label><i class="fas fa-exclamation-circle"></i>ออกเลขให้เสร็จก่อนดำเนินการแนบไฟล์</label>
            </div>
         </div>
             <center> <button class="btn btn-primary" type="submit" name="save" id="save"><i class="fas fa-save fa-2x"></i> บันทึก</button></center>
         </form>
      </div>
      <div class="modal-footer bg-primary">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<script type="text/javascript">
function load_leave_data(cid) {
                    var sdata = {
                      cid: cid,
                    };
                    $('#divDataview').load('show_command_detail-front.php', sdata);
                  }
</script>
