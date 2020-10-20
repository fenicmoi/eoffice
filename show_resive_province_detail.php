

<?php
date_default_timezone_set('Asia/Bangkok');
// $u_id=$_SESSION['ses_u_id'];
include 'function.php';
include '../library/database.php';

 session_start();
    if(!isset($_SESSION['ses_u_id'])){
         header("location:../index.php");
    }
?>
<?php    
// รับค่ามาจาก javascript from flow-resive-province
 $u_id= $_POST['u_id'];
 $rec_id = $_POST['rec_id'];
 $book_id = $_POST['book_id'];
 $level_id = $_SESSION['ses_level_id'];
 //print $level_id;


 $sql="SELECT  bookm.book_id,bookd.*,o.obj_name,spe.speed_name,p.pri_name,u.firstname,s.sec_name,s.sec_code,dep.dep_name,year.yname
       FROM  book_master  bookm
       INNER JOIN book_detail bookd ON bookd.book_id = bookm.book_id
       INNER JOIN user u ON  u.u_id = bookm.u_id 
       INNER JOIN section s ON s.sec_id = bookm.sec_id 
       INNER JOIN object o ON o.obj_id = bookm.obj_id
       INNER JOIN speed spe ON spe.speed_id=bookm.speed_id
       INNER JOIN depart dep ON dep.dep_id = bookm.dep_id 
       INNER JOIN sys_year year ON year.yid = bookm.yid 
       INNER JOIN priority p ON p.pri_id = bookm.pri_id
       WHERE bookm.book_id =$book_id ";
//echo $sql;

$result=dbQuery($sql);
$row=dbFetchArray($result);
//$status=$row['status'];
$strDate=$row['date_in'];
$dateThai=  DateThai($strDate);
$book_detail_id=$row['book_detail_id'];

$file_upload=$row['file_upload']; 
?>  
                    <!-- <div class="well"> -->

                        <center>
                         <form name="edit" action="flow-resive-province.php" method="post" enctype="multipart/form-data">   
                            <table width="auto" border="0">
                                <tr>
                                    <td width="150"><label for="book_no">เลขหนังสือ</label></td>
                                    <td><label name="prefex"><?php print $row['book_no'] ?></label></td>
                                    <td width="150"><label for="book_no">เลขทะเบียนกลาง <?php print $row['book_id'] ?></label></td>
                                    <td><label name="prefex"></label></td>
                                </tr>
                                <tr>
                                    <td><label for="date_book">เอกสารลงวันที่</td></td>
                                    <td><input disabled="" type="text" class="form-group-sm" name="date_book" value="<?php print $row['date_book']; ?>" ></td>
                                    <td><label for="date_in">วันที่บันทึก:</label><input disabled="" type="text" class="form-group-sm" name="date_in" value="<?php print $row['date_in']; ?>"></td>
                                </tr>
                                <tr>
                                    <td><label for ="sendfrom">ผู้ส่ง</label></td>
                                    <td colspan="3"><input disabled="" type="text" class="form-group-sm" name="sendfrom" size="80" value="<?php print $row['sendfrom']; ?>"></td>
                                
                                </tr>
                                <tr>
                                
                                    <td><label for="sendto">ผู้รับ</label></td>
                                    <td colspan="3"><input disabled="" type="text" class="form-group-sm" name="sendto" size="80" value="<?php print $row['sendto']; ?>"></td>
                                </tr>
                                <tr>
                                    <td><label for="title">เรื่อง</label></td>
                                    <td colspan="3"><input type="text" name="title" size="80" value="<?php print $row['title'];?>" disabled></td>
                                </tr>
                                <tr>
                                    
                                    <td><label for="pri_name">ชั้นความลับ</label></td>
                                    <td><input disabled="" type="text" name="pri_name" value="<?php print $row['pri_name'];?>"></td>
                                    <td><label for="speed_name">ชั้นความเร็ว</label><input disabled="" type="text" name="speed_name" value="<?php print $row['speed_name'];?>"></td>
                                </tr>
                                <tr>
                                    <td><label>วัตถุประสงค์</label></td>
                                    <td><input disabled="" type="text" name="obj_name" value="<?php print $row['obj_name'];?>"></td>
                                    <td><label for="status">สถานะ</label><input disabled="" type="text" name="under" value=""></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><label for="reference">อ้างถึง</label></td>
                                    <td colspan="3"><textarea disabled="" name="reference" cols="80"> <?php print $row['reference'];?></textarea></td>
                                    
                                </tr>
                                <tr>
                                    <td><label for="attachment">สิ่งที่ส่งมาด้วย</label></td>
                                    <td colspan="3"><textarea disabled="" name="attachment" cols="80"><?php print $row['attachment'];?></textarea></td>
                                </tr>
                                <tr>
                                <?php
                                    $practice=$row['practice'];
                                    $sql="SELECT dep_name FROM depart WHERE dep_id=$practice";
                                   // print $sql;
                                    $result=dbQuery($sql);
                                    $practice=dbFetchArray($result);
                                ?>
                                    <td><label for="practice">หน่วยดำเนินการ</label></td>
                                    <td><label id="under"><?php print $practice['dep_name'];?></label></td>
                                    <td colspan="2"><label id="under"><?php // print $row['dep_name'];?></label></td>
                                </tr>
                                                         <tr>
                                    <td colspan="3">
                                        <label for="practice">หน่วยดำเนินการ</label>
                                         <input type="radio" name="toSomeOne" id="toSomeOne" value="3" 
                                                onclick="setEnabledTo2(this);
                                                        document.getElementById('ckToSome').style.display = 'block';
                                               "> เลือกเอง
                                        <input type="text" name="toSomeOneUser" class="mytextboxLonger" style="width:373px;" readonly disabled>
                                        <div id="ckToSome" style="display:none">
                                             <table  border="1" width="600px" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td  class="bg-primary"><center>เลือกผู้รับ</center></td>
                                                        </tr>
                                                    </table>
                                                <div id="div1" style="width:600px; height:200px; overflow:auto">
                                                    <table id="tbDepart" border="1" width="600px" >
                                                        <thead>
                                                            <th></th>
                                                            <th>ชื่อส่วนราชการ</th>
                                                        </thead>
                                                        <tbody>
                                                        <?php  
                                                        $sql="SELECT dep_id,dep_name FROM depart ORDER BY dep_name";
                                                        $result=dbQuery($sql);
                                                        $numrowOut=dbNumRows($result);
                                                        if(empty($numrowOut)){?>
                                                        <tr>
                                                            <td></td>
                                                            <td>ไม่มีข้อมูลประเภทส่วนราชการ</td>
                                                        </tr>
                                                        <?php } else { 
                                                            $i=0;
                                                            while($rowOut=dbFetchAssoc($result)){ 
                                                            $i++;
                                                            $a=$i%2;
                                                            if($a==0){?>
                                                        <tr bgcolor="#A9F5D0">
                                                            <?php }else{ ?>
                                                        <tr bgcolor="#F5F6CE">
                                                            <?php } ?>
                                                            <td   class="select_multiple_checkbox"><input type="checkbox" onclick="listSome(this,'<?php echo $rowOut['dep_id'];?>')"></td>
                                                            <td   class="select_multiple_name"><?php print $rowOut['dep_name']; ?></td>
                                                        </tr>
                                                        
                                                        <?php }}?>
                                                        </tbody>
                                                    </table>
                                                    
                                                </div>  <!-- div1 -->
                                                <table>
                                                        <tr>
                                                            <td><input class="btn-success"  style="width:77px;" type="button" value="ตกลง" onclick="document.getElementById('ckToSome').style.display = 'none';"></td>
                                                            <td><input class="btn-danger" style="width:77px;" type="button" value="ยกเลิก" onclick="document.getElementById('ckToSome').style.display = 'none';"></td>
                                                        </tr>
                                                    </table>
                                        </div> <!-- ckToSome -->
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>ผู้บันทึก</label></td>
                                    <td><label id="under"><?php print $row['firstname'];?></label></td>
                                    <td colspan="2"><label id="under"><?php print $row['dep_name'];?></label></td>
                                </tr>
                               
                                <tr>
                                    <?php 
                                        if($file_upload == '' && $level_id<=3){?>     <!-- ตรวจสอบว่าไฟล์ว่างหรือไม่  และตรวจสอบต่อไปว่าเป็นเจ้าหน้าที่สาบรรณกลางหรือไม่  ถ้าจริง ให้แสดงปุ่ม  upload -->
                                        <td colspan="3">
                                            <label for="fileupload">เอกสารแนบ</label>
                                            <div class="well">
                                                <input type="file" name="fileupload">
                                            </div>
                                            <input type="hidden" name="book_detail_id" value="<?=$book_detail_id?>">
                                        </td>
                                        <td><input class="btn btn-primary" type="submit" name="update" value="Update"></td>
                                    <?php }else{?>
                                         <td colspan="3">
                                                    <kbd>ไฟล์แนบ</kbd>
                                                    <a class="btn btn-default" href="<?php print $row['file_upload']; ?>" target="_blank" ><i class="fa fa-file fa-2x"></i> คลิกเพื่อดาวน์โหลด</a>
                                        </td>
                                    <?php }?>
                                </tr>
                            </table>
                         </form>   
                        </center>
                    <!-- </div> -->
               
<!-- form send  -->
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


<script type='text/javascript'>
       $('#tbDepart').DataTable( {
        "order": [[ 0, "desc" ]]
    } )
</script>
