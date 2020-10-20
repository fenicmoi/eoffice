
<?php
/*if(!isset($_SESSION['ses_u_id'])){
    header("location:../index.php");
}*/
date_default_timezone_set('Asia/Bangkok');
include "header.php"; 
$u_id=$_SESSION['ses_u_id'];
require_once 'crud_flownormal.php';

?>
<?php    
 $u_id=$_GET['u_id'];
 $cid=$_GET['cid'];
// $_SESSION['cid']=$cid;  //สร้างตัวแปร session เพื่อส่งค่าไปหน้าหลัก
 //echo $u_id;
 //echo "br";
 //echo $cid;
 
 $sqlDetail="
        SELECT f.cid,f.prefex,f.rec_no,f.title,s.sec_name,o.obj_name,sp.speed_name,f.refer,f.attachment,f.practice,
               f.dateout,f.dateline,f.sendfrom,f.sendto,u.firstname,sec.sec_name,d.dep_name,sy.yname,f.status,f.file_upload
        FROM flownormal f
        INNER JOIN user u  
              ON u.u_id=$u_id 
        INNER JOIN section sec 
              ON u.sec_id=sec.sec_id
        INNER JOIN depart d 
              ON sec.dep_id=d.dep_id
        INNER JOIN sys_year sy 
              ON f.yid=sy.yid 
        INNER JOIN secret s 
              ON f.sec_id=s.sec_id
        INNER JOIN object o
              ON f.obj_id=o.obj_id
        INNER JOIN speed sp
              on f.speed_id=sp.speed_id
        WHERE f.cid=$cid
        ORDER BY f.rec_no DESC
        ";  
 //echo $sqlDetail;
 $resDetail= mysqli_query($conn, $sqlDetail);
 $rowDetail= mysqli_fetch_array($resDetail);
 $strDate=  $rowDetail['dateout'];
 $dateThai=  DateThai($strDate);

$paper=$rowDetail['file_upload'];
?>
        <div class="col-md-2" >
            <?php include 'menu1.php';?>
        </div>
        <div class="col-md-10">
            <div class="panel panel-default" style="margin: 20">
                <div class="panel-heading"><i class="fa fa-envelope-open-o fa-2x" aria-hidden="true"></i>  <strong>รายละเอียด</strong></div>
                <center>
                <div class="panel-body">
                    <div class="form-group form-inlinet">
                        <form name="form" method="POST">
                            <a href="index_admin.php" class="fa fa-home btn btn-primary text-left"> หน้าหลัก</a>
                            <a href="flow-normal.php" class="fa fa-undo btn btn-primary text-left"> ย้อนกลับ[หนังสือคำสั่ง]</a>
                             <input id="cid" name="cid" type="hidden" value="<?php print $rowDetail['cid']; ?>"> 
                           </button>
                        </form>
                    </div>
                </div>
                </center>
                <div class="container">
                    <?php 
                        if(isset($_POST['edit'])){   //กรณีปุ่ม Edit ถูกกด
                            
                        }
                    ?>
                    <div class="well">
                        <center>
                                                    <!--<form name="form-detail" method="post">-->
                        <table width="900" border="0">
                            <tr>
                                <td width="150"> <label>เลขทะเบียนส่ง:</label></td>
                                <td><label name="prefex" id="under"><?php print $rowDetail['prefex'];print $rowDetail['rec_no'] ?></label></td>
                            </tr>
                            <tr>
                                <td><label>เอกสารลงวันที่</label></td>
                                <td><input disabled="" type="text" class="form-group-sm" id="under" value="<?php print $rowDetail['dateline']; ?>" ></td>
                                <td><label>วัน-เวลาที่บันทึก:</label><input disabled="" type="text" class="form-group-sm" id="under" value="<?php print $dateThai; ?>"></td>
                            </tr>
                            <tr>
                                <td><label>จาก</label></td>
                                <td colspan="3"><input disabled="" type="text" class="form-group-sm" id="under" size="100" value="<?php print $rowDetail['sendfrom']; ?>"></td>
                               
                            </tr>
                            <tr>
                               
                                <td><label>ถึง</label></td>
                                <td colspan="3"><input disabled="" type="text" class="form-group-sm" id="under" size="100" value="<?php print $rowDetail['sendto']; ?>"></td>
                            </tr>
                            <tr>
                                <td><label>เรื่อง</label></td>
                                <td colspan="3"><textarea disabled="" id="under" cols="100" rows="3"><?php print $rowDetail['title'];?></textarea></td>
                            </tr>
                            <tr>
                                
                                <td><span class="text-right">ชั้นความลับ:</span></td>
                                <td><input disabled="" type="text" id="under" value="<?php print $rowDetail[4];?>"></label></td>
                                <td><label>ชั้นความเร็ว:</label><input disabled="" type="text" id="under" value="<?php print $rowDetail['speed_name'];?>"></td>
                            </tr>
                            <tr>
                                <td><label>วัตถุประสงค์</label></td>
                                <td><input disabled="" type="text" id="under" value="<?php print $rowDetail['obj_name'];?>"></td>
                                <td><label>สถานะ</label><input disabled="" type="text" id="under" value="<?php print $staTex;?>"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><label>อ้างถึง</label></td>
                                <td colspan="3"><textarea disabled="" id="under" cols="100"> <?php print $rowDetail['refer'];?></textarea></td>
                                
                            </tr>
                            <tr>
                                <td><label>สิ่งที่ส่งมาด้วย</label></td>
                                <td colspan="3"><textarea disabled="" id="under" cols="100"><?php print $rowDetail['attachment'];?></textarea></td>
                            </tr>
                            <tr>
                                <td><label>นำเสนอ/ผู้ปฏิบัติ</label></td>
                                <td><label id="under"><?php print $rowDetail['practice'];?></label></td>
                                <?php
                                if($paper==null){
                                   echo "<td><label>ไฟล์แนบ  [ไม่มี]</label>  </td>";
                                }else{?>
                                <td><label>ไฟล์แนบ</label><a class="btn btn-info" href="<?php print $rowDetail['file_upload']; ?>" target="_blank" ><i class="fa fa-download"></i></a></td>
                                <?php } ?>
                               
                            </tr>
                            <tr>
                                <td><label>ผู้บันทึก</label></td>
                                <td><label id="under"><?php print $rowDetail['firstname'];?></label></td>
                                <td><label id="under"><?php print $rowDetail['sec_name'];?></label></td>
                                <td><label id="under"><?php print $rowDetail['dep_name'];?></label></td>
                            </tr>
                        </table>
                       
                            <!-- </form> -->
                           
                        </center>
                    </div>
                </div>
              
             </div>
        </div>  
<!-- form send  -->

<?php //include "footer.php"; ?>
  