
<?php
/*if(!isset($_SESSION['ses_u_id'])){
    header("location:../index.php");
}*/
//date_default_timezoe_set('Asia/Bangkok');
include "header.php"; 
include "admin/function.php"
//$u_id=$_SESSION['ses_u_id'];
//include '../library/database.php';
//include "crud_flowcommand.php";
?>
<?php    
  //ตรวจสอบปีเอกสาร
  list($yid,$yname,$ystatus)=chkYear();  
  $yid=$yid;
  $yname=$yname;
  $ystatus=$ystatus;

?>
<br>
<br><br>
        <div  class="col-md-12">
            <div class="panel panel-primary" style="margin: 20">
                <div class="panel-heading">
                        <i class="fas fa-clipboard-list  fa-2x" aria-hidden="true"></i>  <strong>ทะเบียนคำสั่งจังหวัด</strong>
                </div> <!-- panel -heading-->
           
                     <table class="table table-bordered table-hover" id="tbCommand">
                        <thead class="bg-info">
                             <tr >
                                <td colspan="5">
                                <form class="form-inline" method="post">
                                    <div class="form-group">
                                        <input type="radio" name="number" id="number" value="1">ค้นหาด้วยเลข
                                        <input type="radio" name="number" id="number" value="2" checked>ค้นหาด้วยชื่อเรื่อง
                                        <div class="input-group">
                                        <span class="input-group-addon">แถวการแสดงผล:</span>
                                            <select class="form-control" id="perpage">
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
                                <th>Ref_sys</th>
                                <th>เลขที่คำสั่ง</th>
                                <th>เรื่อง</th>
                                <th>ลงวันที่</th>
                                <th>เจ้าของเรื่อง</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php
                                @$txt_search=$_POST['search'];    //รับค่าจากกล่องข้อความ
                                @$type_search=$_POST['number'];   // รับค่าจากการเลือกวิธีสืบค้น
                               // @$perpage=$_POST['perpage'];

                                if(isset($_POST['perpage'])){    //ตรวจสอบตัวแปร perpage เพื่อหาจำนวนรายการที่จะนำไปแสดงผล
                                    $perpage = $_POST['perpage'];  //รับค่า
                                }else{
                                    $perpage = 10;                //ถ้าไม่มีให้ใช้ 10
                                }

                                 
                                if (isset($_GET['page'])) {
                                    $page = $_GET['page'];
                                }else{
                                    $page = 1;
                                }
                                $start = ($page - 1) * $perpage;

                                if(isset($_POST['save'])){    //กรณีที่มีการกดปุ่มค้นหา
                                      if($type_search==1){    //ถ้าค้นหาด้วยเลขคำสั่ง
                                         $sql="SELECT c.*,y.yname,d.dep_name
                                                FROM  flowcommand as c
                                                INNER JOIN sys_year as y ON y.yid=c.yid
                                                INNER JOIN depart as d ON d.dep_id =c.dep_id
                                                WHERE rec_id LIKE '%$txt_search%' 
                                                ORDER BY cid DESC
                                                limit $start , $perpage  ";
                                      }else if($type_search==2){    //ถ้าค้นหาด้วยชื่อคำสั่ง
                                           $sql="SELECT c.*,y.yname,d.dep_name
                                                FROM  flowcommand as c
                                                INNER JOIN sys_year as y ON y.yid=c.yid
                                                INNER JOIN depart as d ON d.dep_id =c.dep_id
                                                WHERE title LIKE '%$txt_search%'   ORDER BY cid DESC
                                                limit $start , $perpage  ";  
                                      }

                                      print $sql;
                                     
                                }else{
                                     $sql="SELECT c.*,y.yname,d.dep_name
                                      FROM  flowcommand as c
                                      INNER JOIN sys_year as y ON y.yid=c.yid
                                      INNER JOIN depart as d ON d.dep_id =c.dep_id
                                      ORDER BY c.cid DESC LIMIT $start,$perpage";
                                }
                               
                                //print $sql;
                               // $edit=1;
                                $result = dbQuery($sql);
                                while($row=dbFetchArray($result)){?>
                                    <?php $cid=$row['cid']; ?>
                                    <tr>
                                        <td><?php echo $row['cid']; ?> </td>
                                        <td> <?php echo $row['rec_id']; ?>/<?php echo $row['yname']; ?></td> 
                                      
                                        <td> <a class="text-success" href="#" onclick="load_leave_data('<?php print $cid; ?>');" data-toggle="modal" data-target=".bs-example-modal-table"> 
                                            <?php echo iconv_substr($row['title'],0,100,"UTF-8")."...";?> </a> <i class="fas fa-eye"> <?=$row['hit'];?></i></td>
                                        <td><?php echo thaiDate($row['dateout']); ?></td>
                                        <td><?=$row['dep_name']?> </td>
                                    </tr>
                                    <?php }?>
                                  <tr>

                                    <?php
                                         $sql = "SELECT cid FROM flowcommand ";
                                         $result=dbQuery($sql);
                                         $total_record = dbNumRows($result);
                                         $total_page = ceil($total_record / $perpage);
                                    ?>
                                        <td colspan=5>
                                            <center>
                                             <nav>
                                                <ul class="pagination">
                                                    <li>
                                                        <a href="flow-command-front.php?page=1"> ก่อนหน้า
                                                        <span aria-hidden="true"><i class="fas fa-arrow-alt-circle-left"></i></span>
                                                        </a>

                                                    </li>
                                                    <?php 
                                                        for($i=1;$i<=$total_page;$i++){ ?>
                                                        <li><a href="flow-command-front.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                                    <?php } ?>
                                                         <li>
                                                             <a href="flow-command-front.php?page=<?php echo $total_page;?>">ถัดไป
                                                            <span aria-hidden="true"><i class="fas fa-arrow-alt-circle-right"></i></span>
                                                            </a>
                                                         </li>
                                                </ul>
                                            </nav>
                                            </center>
                                        </td>
                                    </tr>
                        </tbody>
                    </table>
                </div>
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
