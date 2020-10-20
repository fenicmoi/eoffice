<?php
date_default_timezone_set('Asia/Bangkok');
include "header.php";
$u_id=$_SESSION['ses_u_id'];

@$cid=$_GET['cid'];
@$doctype=$_GET['doctype'];
if($doctype=="flow-circle"){
	$tb="flowcircle";
	
}elseif ($doctype=="flow-normal") {
	$tb="flownormal";
}

//
if($cid){
	//กรณีส่งจากระบบออกเลข
	$sql="SELECT title,file_upload FROM $tb  WHERE cid=$cid";
	$result=dbQuery($sql);
	$row=dbFetchAssoc($result);
	$title=$row['title'];
	$link_file=$row['file_upload'];	
}
?>
<div class="col-md-2">
<?php 
    $menu = checkMenu($level_id);
    include $menu;
?>
</div>
<div class="col-md-10">
    <div class="panel panel-primary">
        <div class="panel-heading"><i class="fas fa-share-square fa-2x"></i>  <strong>ส่งเอกสารภายในหน่วยงาน </strong></div>
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li><a class="btn-danger fas fa-envelope"  href="paper.php"> จดหมายเข้า</a></li>
                <li><a class="btn-danger fas fa-envelope-open"  href="folder.php"> รับแล้ว</a></li>
                <li><a class="btn-danger fas fa-history" href="history.php"> ส่งแล้ว</a></li>
                <li class="active"><a class="btn-danger fas fa-paper-plane" href="inside_all.php"> ส่งภายใน</a></li>
                <li><a class="btn-danger fas fa-globe" href="outside_all.php"> ส่งภายนอก</a></li>
            </ul>
            <br>
            <form name="fileIn" method="post" enctype="multipart/form-data" >
                <div class="form-group form-inline">
                    <label for="title">ชื่อเอกสาร:</label>
                    <input class="form-control" type="text" name="title" size="100%" placeholder="ใส่ชื่อเอกสาร" required="">
                </div>
                <div class="form-group form-inline">
                    <label for="book_no">เลขหนังสือ:</label>
                    <input class="form-control" type="text" name="book_no" size="100%" placeholder="ตัวอย่าง พง0017.2/ว1423 พิมพิ์ติดกัน" required="">
                </div>
                <div class="form-group form-inline">
                    <label for="to">ส่งถึง:</label>
                    <input type="radio" value="1" name="toAll" onclick="setEnabledTo(this); document.getElementById('ckToA').style.display = 'none';" checked="">ทุกหน่วย
                    <input type="radio" value="2" name="toSome" onclick="setEnabledTo(this); document.getElementById('ckToA').style.display = 'block';"> บางหน่วย
                    <input type="text" name="toSomeUser" class="mytextboxLonger" style="width:373px;" readonly disabled>
                    <img src="../images/visit.gif" width="26" height="26" onclick="document.getElementById('ckToA').style.display = 'block';" title="คลิกเลือกผู้รับ">
                    <div id="ckToA" style="display:none;">
                        <table border="1" width="599px" cellspacing="0" cellpadding="0">
                            <tr>
                                <td  class="alere alert-info"><center>เลือกชื่อผู้รับ</center></td>
                            </tr>
                        </table>
                        <div id="div1" style="width:"599px"; height:350px; overflow:auto">
                            <table border="0" cellspacing="0" cellpadding="0" width="50%" class="select_multiple_table" bgcolor="#FCFCFC">
                            <?php
                                $sql="SELECT sec_id,sec_name,dep_id FROM section WHERE dep_id=$dep_id ";
                                $result=  dbQuery($sql);
                                $numrowIN=  dbNumRows($result);
                                if(empty($numrowIN)){
                            ?>
                            <tr>
                                <td></td>
                                <td><font color="#666666">ไม่มีข้อมูลหน่วยงานย่อย.</font></td>
                            </tr>
                            <?php
                            }else{
                            $i=0;
                                while ($rowIN=dbFetchAssoc($result)){
                                    $i++;
                                    $a=$i%2;
                                    if($a==0){
                                    ?>
                                <tr bgcolor="#A9F5D0">
                                <?php
                                }else{ ?>
                                <tr bgcolor="#F5F6CE">
                                <?php } ?>
                                    <td class="select_multiple_checkbox" width="24"><input type="checkbox" onclick="listOne(this,'<?php echo $rowIN['sec_id']?>')"></td>
                                    <td class="select_multiple_name"><?php print$rowIN['sec_name']?></td>				
                                </tr>
                                <?php
                                }
                            } ?>
                            </table>
                        </div> <!--div1 -->
                            <table>
                                <tr>
                                    <td><input class="btn-success"  style="width:77px;" type="button" value="ตกลง" onclick="document.getElementById('ckToA').style.display = 'none';"></td>
                                    <td><input class="btn-danger" style="width:77px;" type="button" value="ยกเลิก" onclick="document.getElementById('ckToA').style.display = 'none';"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <?php if($cid && $link_file<>null){ ?>
                        <div class="form-group form-inline">
                            <label for="fileupload">ไฟล์แนบ</label><a href="<?php print $link_file;?>"><i class="fa fa-file fa-2x"></i></a>
                        </div>
                    <?php }else{ ?>
                        <div class="form-group form-inline">
                            <label for="fileupload">แนบไฟล์</label>
                            <input type="file" name="fileupload" required>
                        </div>
                    <?php } ?>
                            <label>ไฟล์เอกสารที่ส่งได้:</label>
                                <i class="fa fa-file-pdf-o"></i>
                                <i class="fa fa-file-excel-o"></i>
                                <i class="fa fa-file-word-o"></i>
                                <i class="fa fa-file-zip-o"></i>
                                <i class="fa fa-file-image-o"></i>
                                <i class="fa fa-file-powerpoint-o"></i>
                            <div class="form-group form-inline">
                                <label for="detail">รายละเอียด</label>
                                <textarea  name="detail" rows="3" cols="60">-</textarea>
                            </div>
                            <center>
                                <div class="form-group">
                                    <input type="hidden" name="file" value="<?php print $fileupload;?>"/>
                                    <input type="hidden" name="dep_id" value="<?php print $dep_id;?>"/>
                                    <input type="hidden" name="sec_id" value="<?php print $sec_id;?>"/>
                                    <input type="hidden" name="user_id" id="user_id" value="<?php  print $u_id;?>"/>  
                                    <input type="submit" name="send" class="btn btn-primary btn-lg" value="ส่งเอกสาร"/></div>
                            </center>
            </form>  
   </div> <!-- panel-primary -->
   <div class="panel-footer"></div>
</div>
<!-- process -->
<?php
$date=date('Y-m-d');
if(isset($_POST['send'])){ //ตรวจสอบการกดปุ่ม send  จากส่งเอกสารภายใน
	$title=$_POST['title'];
	$detail=$_POST['detail'];
	@$fileupload=$_POST['file'];
	$date=date('YmdHis');
	$sec_id=$_POST['sec_id'];
	$insite=1;//เอกสารภายใน
	$user_id=$_POST['user_id'];
	$dep_id=$_POST['dep_id'];
	@$toAll=$_POST['toAll'];
	@$toSome=$_POST['toSome'];
	@$toSomeUser=$_POST['toSomeUser'];
	@$fileupload=$_REQUEST['fileupload'];//การจัดการ fileupload
	$numrand=(mt_rand());//สุ่มตัวเลข
    @$upload=$_FILES['fileupload'];//เพิ่มไฟล์
    $book_no=$_POST['book_no'];
	
	if($upload<>''){//ถ	้ามีการ upload เอกสาร
		$part="paper/";
		$type=  strrchr($_FILES['fileupload']['name'],".");
		$newname=$date.$numrand.$type;
		$part_copy=$part.$newname;
		@$part_link="paper/".$newname;
		move_uploaded_file($_FILES['fileupload']['tmp_name'],$part_copy);
		
	}
	
	
	
	
	/*++++++++++++++++++++++     ส่งภายใน     ++++++++++++++++++++++++++++++++++*/
	
	if($toAll==1){//กรณีส่งเอกสารถึงทุกหน่วยภายใน
		if($cid && $link_file<>null){    //เป็นนการตรวจสอบว่าเป็นการส่งเอกสารผ่านทางระบบส่งหนังสือโดยตรงหรือไม่
			//ถ		้ามีการส่ง book_id มา
			$sql="INSERT INTO paper(title,detail,file,postdate,u_id,sec_id,insite,dep_id,book_no)
                              VALUE('$title','$detail','$link_file','$date',$user_id,$sec_id,$insite,$dep_id,'$book_no')";
		}else{
			//กรณีส่งเอกสารโดยไม่มีการออกเลข
			$sql="INSERT INTO paper(title,detail,file,postdate,u_id,sec_id,insite,dep_id,book_no)
                              VALUE('$title','$detail','$part_link','$date',$user_id,$sec_id,$insite,$dep_id,'$book_no')";
		}
		
		$result=dbQuery($sql);
        $lastid=dbInsertId();//ค้นนหารหัสล่าสุด
        //เลือกผู้รับตามเงื่อนไข 1.สังกัดเดียวกัน 2.ไม่ส่งให้ตัวเอง 3.ผู้รับต้องเป็นคีย์แมน 
		$sql="SELECT u_id,sec_id,dep_id,level_id,firstname,keyman FROM user
              WHERE  user.dep_id=$dep_id
              AND user.u_id <> $u_id             
			  AND keyman=1";
		$result=  dbQuery($sql);
		
		while($rowUser=dbFetchArray($result)){
			$u_id=$rowUser['u_id'];
			$sec_id=$rowUser['sec_id'];
			$dep_id=$rowUser['dep_id'];
			$sql="INSERT INTO  paperuser (pid,u_id,sec_id,dep_id) VALUES ($lastid,$u_id,$sec_id,$dep_id)  ";
			dbQuery($sql);
		}
		
		echo "<script>
           swal({
               title:'ส่งเอกสารเรียบร้อยแล้ว',
               type:'success',
               showConfirmButton:true
               },
               function(isConfirm){
                   if(isConfirm){
                       window.location.href='history.php';
                   }
               }); 
           </script>";

	}elseif($toSome==2){  //กรณีส่งเอกสารถึงบางหน่วย
		if($cid && $link_file<>null){
			$sql="INSERT INTO paper(title,detail,file,postdate,u_id,sec_id,insite,dep_id,book_no)
                  VALUES('$title','$detail','$link_file','$date',$user_id,$sec_id,$insite,$dep_id,'$book_no')";
		}else{
			$sql="INSERT INTO paper(title,detail,file,postdate,u_id,sec_id,insite,dep_id,book_no)
                  VALUES('$title','$detail','$part_link','$date',$user_id,$sec_id,$insite,$dep_id,'$book_no')";	
        }
		$result=dbQuery($sql);
		$lastid=  dbInsertId();//คนหาเลขระเบียนล่าสุด
		if(!$result){
			echo 'SQL Error';
		}else{
			$sendto=$_POST['toSomeUser'];//่ส่วนการเก็บค่า id จาก textbox
			$sendto=substr($sendto, 1);
			$c=explode("|", $sendto);
			for ($i=0;$i<count($c);$i++){
                $sql="SELECT  u.u_id,u.level_id,s.sec_id,d.dep_id
                        FROM user u 
                        INNER JOIN section s ON s.sec_id=u.sec_id
                        INNER JOIN depart d  ON d.dep_id=u.dep_id
                        WHERE s.sec_id=$c[$i]  
                        AND u.keyman=1
                        "; //สารบรรณประจำกลุ่มงานเท่านั้น
                        
                
				$result=dbQuery($sql);
				while($row=dbFetchArray($result)){
					$u_id=$row['u_id'];
					$sec_id=$row['sec_id'];
					$dep_id=$row['dep_id'];
					$sql="INSERT INTO paperuser (pid,u_id,sec_id,dep_id) VALUES ($lastid,$u_id,$sec_id,$dep_id)";
					dbQuery($sql);
				}	//while
			} //for
			echo "<script>
                swal({
                    title:'ส่งเอกสารเรียบร้อยแล้ว',
                    type:'success',
                    showConfirmButton:true
                    },
                    function(isConfirm){
                        if(isConfirm){
                            window.location.href='history.php';
                        }
                    }); 
                </script>";
			
		}//if ตรวจสอบว่ามีการบันทึกข้อมูลในตารางหลักแหล้วหรือไม่
	}//if ตรวจสอบว่าส่งถึงใคร
}//if isset

?>
<script language="JavaScript">
<!--
function setEnabledTo(obj) {
	if (obj.value=="2") {                       //ถ้ามีค่า 2
		obj.form.toSomeUser.disabled = false;   //texbox  Enabled
		obj.form.toAll.checked = false;         //toAll ไม่เช็ค
	} else {                                    //ถ้าไม่ใช่ค่า่ 2
		obj.form.toSomeUser.disabled = true;    //texbox Disabled
		obj.form.toSomeUser.value = "";         // เคลียร์ค่าใน text
		obj.form.toSome.checked = false;        //ยกเลิกเช็ค toSome
        obj.form.toAll.checked=true;
	}
}

function setEnabledTo2(obj) {
	if (obj.value=="2") {                   //กรณีเลือกตามประเภทแยกตามประเภท
		obj.form.toAll.checked = false;     //ทั้งหมด
        obj.form.toSomeOne.checked=false;   //เลือกเอก
        obj.form.toSomeUser.disabled=false;  //textbox 
        obj.form.toSomeOneUser.disabled=true;
	} else if(obj.value=="3") {             //กรณีเลือกเอง
        obj.form.toAll.checked=false;       //ทั้งหมด
		obj.form.toSome.checked = false;    //แยกตามประเภท
        obj.form.toSomeUser.disabled=true;  //textbox 
        obj.form.toSomeOneUser.disabled=false;
	}else{
        obj.form.toSome.checked = false;    //แยกตามประเภท
        obj.form.toSomeOne.checked=false;   //เลือกเอก

        obj.form.toSomeUser.disabled=true;  //textbox 
        obj.form.toSomeUser.value="";
        obj.form.toSomeOneUser.disabled=true;
        obj.form.toSomeOneUser.value="";

        
    }
}
//-->
</script>

<script type="text/javascript">
    function listOne(a,b,c) {
        m=document.fileIn.toSomeUser.value;
        
        if (a.checked) {
            if (m.indexOf(b)<0) m+='|'+b;
        
        } else {
        m=document.fileIn.toSomeUser.value.replace('|'+b,'');
        }
        z="|";
        if (m.substring(2) == c) m=m.substring(2);
        document.fileIn.toSomeUser.value=m;
    }
</script>	
<script type="text/javascript">     
    function listType(a,b,c) {     //ฟังค์ชั่นกรณีเลือกเป็นประเภท
        m=document.fileout.toSomeUser.value;
        
        if (a.checked) {
            if (m.indexOf(b)<0) m+='|'+b;
        
        } else {
        m=document.fileout.toSomeUser.value.replace('|'+b,'');
        }
        z="|";
        if (m.substring(2) == c) m=m.substring(2);
        document.fileout.toSomeUser.value=m;
    }
</script>	
<script type="text/javascript">     
    function listSome(a,b,c) {     //ฟังค์ชั่นกรณีเลือกส่วนราชการเอง
        m=document.fileout.toSomeOneUser.value;
        
        if (a.checked) {
            if (m.indexOf(b)<0) m+='|'+b;
        
        } else {
        m=document.fileout.toSomeOneUser.value.replace('|'+b,'');
        }
        z="|";
        if (m.substring(2) == c) m=m.substring(2);
        document.fileout.toSomeOneUser.value=m;
    }
</script>	