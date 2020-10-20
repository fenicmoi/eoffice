    
<?php  
date_default_timezone_set('Asia/Bangkok');
include "header.php";
$u_id=$_SESSION['ses_u_id'];
$pid=$_GET['pid'];

$sql="SELECT pid,title,book_no,file FROM paper  WHERE pid=$pid";
$result=dbQuery($sql);
$row=dbFetchAssoc($result);

$link_file=$row['file'];
?>
<div class="col-md-2" >
	<?php
	$menu=  checkMenu($level_id);
	include $menu;
	?>
</div>
<div class="col-md-10">
    <div class="panel panel-primary">
        <div class="panel-heading"><i class="fas fa-share-square fa-2x"></i>  <strong>ส่งเอกสารภายในจังหวัด</strong></div>
        <div class="panel-body">
             <ul class="nav nav-tabs">
                <li><a class="btn-danger fas fa-envelope"  href="paper.php"> จดหมายเข้า</a></li>
                <li><a class="btn-danger fas fa-envelope-open"  href="folder.php"> รับแล้ว</a></li>
                <li><a class="btn-danger fas fa-history" href="history.php"> ส่งแล้ว</a></li>
                <li><a class="btn-danger fas fa-paper-plane" href="inside_all.php"> ส่งภายใน</a></li>
                <li class="active"><a class="btn-danger fas fa-globe" href="outside_all.php"> ส่งภายนอก [แก้ไข]</a></li>
            </ul>
            <br>
                <form  id="fileout" name="fileout" method="post" enctype="multipart/form-data" >
                    <div class="form-group form-inline">
                        <label for="title">ชื่อเอกสาร:</label>
                        <input class="form-control" type="text" name="title" size="100%" value="<?php print $row['title'];?>">
                    </div>
                     <div class="form-group form-inline">
                        <label for="book_no">เลขหนังสือ:</label>
                        <input class="form-control" type="text" name="book_no" size="100%" value="<?php print $row['book_no'];?>">
                    </div>
                   
                            <div class="form-group form-inline">
                                <label for="fileupload">ไฟล์แนบปัจจุบัน > </label><a class="btn btn-info"  href="<?php print $link_file;?>" target="_blank"><?php print $link_file;?></a>
                            </div>
                            <div class="form-group form-inline">
                                <label for="fileupload">แก้ไขไฟล์แนบ</label>
                                <input type="file" name="fileupload">
                            </div>
                    <div class="form-group form-inline">
                        <label for="detail">รายละเอียด</label>
                        <textarea  name="detail" rows="3" cols="60">-</textarea>
                    </div>
                    <center>
                    <div class="form-group">
                
                        <input type="hidden" name="pid" id="pid" value="<?php  print $row['pid'];?>"/>  
                        <input type="submit" name="sendOut" class="btn btn-success btn-lg" value="บันทึก"/>
                    </div>
                    </center>
                </form>
            </div>
            <div class="panel-footer"></div>
        </div>
</div>    

<?php
/*++++++++++++++++++++++++++++PROCESS+++++++++++++++++++++++++++*/
if(isset($_POST['sendOut'])){//ตรวจสอบปุ่ม sendOut
    $pid=$_POST['pid'];
	$title=$_POST['title']; //ช	ื่อเอกสาร
    $date=date('YmdHis');//วันเวลาปัจจุบัน
    $detail=$_POST['detail'];
	$numrand=(mt_rand());//ส	ุ่มตัวเลข
    $dateSend=date('Y-m-d');//ว	ันที่ส่งเอกสาร  (มีปัญหายังแก้ไม่ได้)
    $book_no=$_POST['book_no'];

	if($_FILES['fileupload']['name']){
		$part="paper/";
		$type=  strrchr($_FILES['fileupload']['name'],".");
		$newname=$date.$numrand.$type;
		$part_copy=$part.$newname;
		$part_link="paper/".$newname;
        move_uploaded_file($_FILES['fileupload']['tmp_name'],$part_copy);
        $sql="UPDATE paper SET title ='$title',detail='$detail',file='$part_link',book_no='$book_no',edit='$date' WHERE pid=$pid ";
    }else{
        $sql="UPDATE paper SET title ='$title',detail='$detail',book_no='$book_no',edit='$date' WHERE pid=$pid ";
    }

    $result=  dbQuery($sql);
                 if(!$result){
                    echo "<script>
                    swal({
                     title:'มีบางอย่างผิดพลาด กรุณาตรวจสอบ',
                     type:'warning',
                     showConfirmButton:true
                     },
                     function(isConfirm){
                         if(isConfirm){
                             window.location.href='history.php';
                         }
                     }); 
                   </script>";
                 }else{
                    echo "<script>
                    swal({
                     title:'แก้ไขข้อมูลเรียบร้อยแล้ว',
                     type:'success',
                     showConfirmButton:true
                     },
                     function(isConfirm){
                         if(isConfirm){
                             window.location.href='history.php';
                         }
                     }); 
                   </script>";  
                 }  //check db 
}  //send out
	
	
	