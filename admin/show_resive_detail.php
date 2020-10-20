

<?php
date_default_timezone_set('Asia/Bangkok');
// $u_id=$_SESSION['ses_u_id'];
include 'function.php';
include '../library/database.php';
//include '../library/config.php';

?>
<?php    
// รับค่ามาจาก javascript from flow-resive-province
 $u_id=$_POST['u_id'];
 $rec_id=$_POST['rec_id'];
 $book_id=$_POST['book_id'];


 $sql="SELECT  bookm.*,bookd.*,s.sec_name,s.sec_code,o.obj_name,spe.speed_name,u.firstname,sec.sec_name,dep.dep_name,year.yname
       FROM  book_master  bookm
       INNER JOIN book_detail bookd ON bookd.book_id = bookm.book_id
       INNER JOIN user u ON  u.u_id = bookm.u_id 
       INNER JOIN section s ON s.sec_id = bookm.sec_id 
       INNER JOIN object o ON o.obj_id = bookm.obj_id
       INNER JOIN speed spe ON spe.speed_id=bookm.speed_id
       INNER JOIN depart dep ON dep.dep_id = bookm.dep_id 
       INNER JOIN sys_year year ON year.yid = bookm.yid 
       INNER JOIN secret sec ON sec.sec_id = bookm.sec_id 
       WHERE bookm.book_id =$book_id ";
//echo $sql;

$result=dbQuery($sql);
$row=dbFetchArray($result);
//$status=$row['status'];
$strDate=$row['date_book'];
$dateThai=  DateThai($strDate);

$file_upload=$row['file_upload']; 
?>  
                    <!-- <div class="well"> -->

                        <center>
                         <form name="edit" action="flow-resive-province.php" method="post" enctype="multipart/form-data">   
                        <table width="auto" border="0">
                            <tr>
                                <td width="150"><kbd>เลขที่เอกสาร</kbd></td>
                                <td><label name="prefex" id="under"><?php print $row['book_no'] ?></label></td>
                            </tr>
                            <tr>
                                <td><kbd>เอกสารลงวันที่</kbd></td>
                                <td><input disabled="" type="text" class="form-group-sm" id="under" value="<?php print $row['date_book']; ?>" ></td>
                                <td><kbd>วันที่บันทึก:</kbd><input disabled="" type="text" class="form-group-sm" id="under" value="<?php print $dateThai; ?>"></td>
                            </tr>
                            <tr>
                                <td><kbd>ผู้ส่ง</kbd></td>
                                <td colspan="3"><input disabled="" type="text" class="form-group-sm" id="under" size="80" value="<?php print $row['sendfrom']; ?>"></td>
                               
                            </tr>
                            <tr>
                               
                                <td><kbd>ผู้รับ</kbd></td>
                                <td colspan="3"><input disabled="" type="text" class="form-group-sm" id="under" size="80" value="<?php print $row['sendto']; ?>"></td>
                            </tr>
                            <tr>
                                <td><kbd>เรื่อง</kbd></td>
                                <td colspan="3"><input type="text" id="under" size="80" value="<?php print $row['title'];?>" disabled></td>
                                <!-- <td colspan="3"><textarea disabled="" id="under" cols="8o" rows="3"></textarea></td> -->
                            </tr>
                            <tr>
                                
                                <td><kbd>ชั้นความลับ</kbd></td>
                                <td><input disabled="" type="text" id="under" value="<?php print $row['sec_name'];?>"></label></td>
                                <td><kbd>ชั้นความเร็ว</kbd><input disabled="" type="text" id="under" value="<?php print $row['speed_name'];?>"></td>
                            </tr>
                            <tr>
                                <td><kbd>วัตถุประสงค์</kbd></td>
                                <td><input disabled="" type="text" id="under" value="<?php print $row['obj_name'];?>"></td>
                                <td><kbd>สถานะ</kbd><input disabled="" type="text" id="under" value=""></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><kbd>อ้างถึง</kbd></td>
                                <td colspan="3"><textarea disabled="" id="under" cols="80"> <?php print $row['reference'];?></textarea></td>
                                
                            </tr>
                            <tr>
                                <td><kbd>สิ่งที่ส่งมาด้วย</kbd></td>
                                <td colspan="3"><textarea disabled="" id="under" cols="80"><?php print $row['attachment'];?></textarea></td>
                            </tr>
                            <tr>
                                <?php
                                    $practice=$row['practice'];
                                    $sql="SELECT dep_name FROM depart WHERE dep_id=$practice";
                                    print $sql;
                                    $result=dbQuery($sql);
                                    $practice=dbFetchArray($result);
                                ?>
                                <td><kbd>ผู้ปฏิบัติ</kbd></td>
                                <td><label id="under"><?php print $practice;?></label></td>
                                <td colspan="2"><label id="under"><?php // print $row['dep_name'];?></label></td>
                            </tr>
                            <tr>
                                <td><kbd>ผู้บันทึก</kbd></td>
                                <td><label id="under"><?php print $row['firstname'];?></label></td>
                                <td colspan="2"><label id="under"><?php print $row['dep_name'];?></label></td>
                            </tr>
                            <tr>
                                <td><kbd>แนบเอกสาร</kbd></td>
                                <td>
                                                       
                                        <input type="file" name="fileupload">
                                        <input type="hidden" name="book_id" value="<?php echo $boik_id;?>">
                                </td>
                                 <?php
                                    if($file_upload==null){
                                    echo "<td colspan='2'><label>ไฟล์แนบ  [ไม่มี]</label>  </td>";
                                    }else{?>
                                        <td colspan="2">
                                            <kbd>ไฟล์แนบ</kbd>
                                            <a class="btn btn-success" href="<?php print $row['file_upload']; ?>" target="_blank" ><i class="fa fa-download"></i>คลิกเพื่อดาวน์โหลด</a></td>
                                <?php } ?>    
                                   
                            </tr>
                            
                           
                        </table>
                            <center><input type="submit" class="btn btn-primary" value="บันทึกข้อมูล" name="update">
                         </form>   
                        </center>
                    <!-- </div> -->
               
<!-- form send  -->
