<script>
$(document).ready( function () {
    $('#tbOutside   ').DataTable();
} );
</script>     
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
                <li class="active"><a class="btn-danger fas fa-globe" href="outside_all.php"> ส่งภายนอก</a></li>
            </ul>
            <br>
                <form  id="fileout" name="fileout" method="post" enctype="multipart/form-data" >
                    <div class="form-group form-inline">
                        <label for="title">ชื่อเอกสาร:</label>
                        <input class="form-control" type="text" name="title" size="100%" placeholder="ใส่ชื่อเอกสาร" required="">
                    </div>
                     <div class="form-group form-inline">
                        <label for="book_no">เลขหนังสือ:</label>
                        <input class="form-control" type="text" name="book_no" size="100%" placeholder="ตัวอย่าง พง0017.2/ว1258 พิมพ์ติดกันหมด" required="">
                    </div>
                    <div class="form-group form-inline">
                        <label>ส่งถึง:</label>
                        <input type="radio" name="toAll"  id="toAll"  value="1" 
                            onclick="setEnabledTo2(this);
                                        document.getElementById('ckToType').style.display = 'none';
                                        document.getElementById('ckToSome').style.display = 'none';
                            ">  ทุกส่วนราชการ
                        <input type="radio" name="toSome" id="toSome" value="2"
                            onclick="setEnabledTo2(this);
                                        document.getElementById('ckToType').style.display = 'block';
                                        document.getElementById('ckToSome').style.display = 'none';
                            "> แยกตามประเภท
                        <input type="text" name="toSomeUser" class="mytextboxLonger" style="width:373px;" readonly disabled>
                        <input type="radio" name="toSomeOne" id="toSomeOne" value="3" 
                            onclick="setEnabledTo2(this);
                                        document.getElementById('ckToType').style.display = 'none';
                                        document.getElementById('ckToSome').style.display = 'block';
                            "> เลือกเอง
                        <input type="text" name="toSomeOneUser" class="mytextboxLonger" style="width:373px;" readonly disabled>
                <!-- ส่วนแสดงผลกรณีเลือกเป็นประเภทส่วนราชการ -->
                        <div id="ckToType" style="display:none">
                            <table border="1" width="599px" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td  class="alere alert-info"><center>เลือกผู้รับ</center></td>
                                </tr>
                            </table>
                        <div id="div1" style="width:599px; height:250px; overflow:auto">
                            <table border="1" width="599px">
                                <?php  
                                $sql="SELECT type_id,type_name FROM office_type ORDER BY type_id";
                                $result=dbQuery($sql);
                                $numrowOut=dbNumRows($result);
                                if(empty($numrowOut)){
                                ?>
                                <thead>
                                    <tr>
                                    <td></td>
                                    <td>ไม่มีข้อมูลประเภทส่วนราชการ</td>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                }else{
                                $i=0;
                                    while($rowOut=dbFetchAssoc($result)){
                                    $i++;
                                    $a=$i%2;
                                    if($a==0){?>
                                    <tr bgcolor="#A9F5D0">
                                    <?php }else{?>
                                    <tr bgcolor="#F5F6CE">
                                    <?php } ?>
                                        <td   class="select_multiple_checkbox"><input type="checkbox" onclick="listType(this,'<?php echo $rowOut['type_id'];?>')"></td>
                                        <td   class="select_multiple_name"><?php print $rowOut['type_name'];?></td>
                                    </tr>
                                    <?php
                                    }
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>  <!-- div1 -->
                        <table>
                            <tr>
                                <td><input class="btn-success"  style="width:77px;" type="button" value="ตกลง" onclick="document.getElementById('ckToType').style.display = 'none';"></td>
                                <td><input class="btn-danger" style="width:77px;" type="button" value="ยกเลิก" onclick="document.getElementById('ckToType').style.display = 'none';"></td>
                            </tr>
                        </table>
                </div>  <!-- ckToType -->
                <!-- จบส่วนกรณีเลือกเป็นประเภทส่วนราชการ -->
                            <div id="ckToSome" style="display:none">
                            <table  border="1" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td  class="bg-primary"><center>เลือกผู้รับ</center></td>
                                </tr>
                            </table>
                            <div id="div1">
                                <table id="tbOutside" class="display" style="width:100%">
                                    <thead>
                                        <th>No.</th>
                                        <th>ชื่อส่วนราชการ</th>
                                    </thead>
                                    <tbody>
                                    <?php  
                                        $sql="SELECT dep_id,dep_name,type_id FROM depart ORDER BY type_id";
                                        $result=dbQuery($sql);
                                        $numrowOut=dbNumRows($result);
                                        if(empty($numrowOut)){?>
                                            <tr>
                                                <td></td>
                                                <td>ไม่มีข้อมูลประเภทส่วนราชการ</td>
                                            </tr>
                                            <?php
                                        } else {
                                            $i=0;
                                            while($rowOut=dbFetchAssoc($result)){?>
                                                    <tr>
                                                        <td   class="select_multiple_checkbox"><input type="checkbox" onclick="listSome(this,'<?php echo $rowOut['dep_id'];?>')"></td>
                                                        <td   class="select_multiple_name"><?php print $rowOut['dep_name'];?></td>
                                                    </tr>
                                                    <?php 
                                            } //while
                                        } //if
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>No.</td>
                                            <td>ส่วนราชการ</td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>  <!-- div1 -->
                            <table>
                                <tr>
                                    <td><input class="btn-success"  style="width:77px;" type="button" value="ตกลง" onclick="document.getElementById('ckToSome').style.display = 'none';"></td>
                                    <td><input class="btn-danger" style="width:77px;" type="button" value="ยกเลิก" onclick="document.getElementById('ckToSome').style.display = 'none';"></td>
                                </tr>
                            </table>
                        </div> <!-- ckToSome -->
                    </div>
                    <?php 
                    if($cid && $link_file<>null){?>
                            <div class="form-group form-inline">
                                <label for="fileupload">ไฟล์แนบ</label><a class="btn btn-warning" href="<?php print $link_file;?>" target="_blank"><i class="fa fa-file fa-2x"></i></a>
                            </div>
                    <?php }else{ ?>
                            <div class="form-group form-inline">
                                <label for="fileupload">แนบไฟล์</label>
                                <input type="file" name="fileupload" required>
                            </div>
                    <?php } ?>
                    <label>ไฟล์เอกสารที่ส่งได้:</label>
                        <i class="fa fa-file-pdf-o "></i>
                        <i class="fa fa-file-excel-o "></i>
                        <i class="fa fa-file-word-o "></i>
                        <i class="fa fa-file-zip-o "></i>
                        <i class="fa fa-file-image-o "></i>
                        <i class="fa fa-file-powerpoint-o "></i>
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
                        <input type="submit" name="sendOut" class="btn btn-primary btn-lg" value="ส่งเอกสาร"/>
                    </div>
                    </center>
                </form>
            </div>
            <div class="panel-footer"></div>
        </div>
</div>    

<?php
/*++++++++++++++++++++++++++++       ส่งภายนอก      +++++++++++++++++++++++++++*/


if(isset($_POST['sendOut'])){//ตรวจสอบปุ่ม sendOut
	$title=$_POST['title']; //ช	ื่อเอกสาร
	$detail=$_POST['detail'];//รายละเอียด
	$date=date('YmdHis');//ว	ันเวลาปัจจุบัน
	$sec_id=$_POST['sec_id'];//ร	หัสแผนกที่ส่ง
	$outsite=1;//ก	ำหนดค่าเอกสาร insite=ภายใน   outsite = ภายนอก
	$user_id=$_POST['user_id'];//ร	หัสผู้ใช้
	$dep_id=$_POST['dep_id'];//ร	หัสหน่วยงาน
	
	@$toAll=$_POST['toAll'];//ส	่งเอกสารถึงทุกคน
	@$toSome=$_POST['toSome'];//ส	่งตามประเภท
	@$toSomeOne=$_POST['toSomeOne'];//ส	่งแบบเลือกเอง
	
	@$toSomeUser=$_POST['toSomeUser'];//ช	่องส่งแยกประเภทตามหน่วยงาน
	@$toSomeOneUser=$_POST['toSomeOneUser'];//ช	่องรับรหัสแบบเลือกเอง
	
	@$fileupload=$_POST['file'];//ไ	ฟล์เอกสาร
	$numrand=(mt_rand());//ส	ุ่มตัวเลข
	@$upload=$_FILES['fileupload'];//เ	พิ่มไฟล์
    $dateSend=date('Y-m-d');//ว	ันที่ส่งเอกสาร  (มีปัญหายังแก้ไม่ได้)
    $book_no=$_POST['book_no'];
	
	//$	book_id=$_GET['book_id'];
	

	if($upload<>''){
		
		$part="paper/";
		
		$type=  strrchr($_FILES['fileupload']['name'],".");
		//เ		อาชื่อเก่าออกให้เหลือแต่นามสกุล
		$newname=$date.$numrand.$type;
		//ต		ั้งชื่อไฟล์ใหม่โดยใช้เวลา 
		$part_copy=$part.$newname;
		
		$part_link="paper/".$newname;
		
		move_uploaded_file($_FILES['fileupload']['tmp_name'],$part_copy);
		//ค		ัดลอกไฟล์ไป Server
	}
	
	
	if($toAll!=''){
		//สงเอกสารถึงทุกส่วนราชการ
		if($cid && $link_file<>null){
			//ถ			้ามีการส่ง book_id มา
			$sql="INSERT INTO paper(title,detail,file,postdate,u_id,sec_id,outsite,dep_id,book_no)
                              VALUE('$title','$detail','$link_file','$date',$user_id,$sec_id,$outsite,$dep_id,'$book_no')";
			
		}else{
			//กรณีส่งเอกสารโดยไม่มีการออกเลข
			$sql="INSERT INTO paper(title,detail,file,postdate,u_id,sec_id,outsite,dep_id,book_no)
                              VALUE('$title','$detail','$part_link','$date',$user_id,$sec_id,$outsite,$dep_id,'$book_no')";
		}
		
		
		//print $sql;
		
		$result=dbQuery($sql);
		$lastid=dbInsertId();
		//เลข ID จากตาราง paper ล่าสุด
		//เลือก User ทั้งหมด  1 ต้องเป็นระดับ 3 (ประจำส่วนราชการ) 2.มีสิทธิ์รับ (keyman=1)  3.ไม่ส่งให้ตัวเอง 
		$sql="SELECT  u.u_id,u.firstname,u.keyman,s.sec_id,d.dep_id,d.dep_name  
                FROM user u 
                INNER JOIN section s ON s.sec_id=u.sec_id
                INNER JOIN depart d  ON d.dep_id=u.dep_id
                WHERE u.keyman=1 
                AND d.dep_id<>$dep_id 
                AND u.level_id <= 3
                AND u.keyman=1";

        
		$result=  dbQuery($sql);
		while($rowUser=  dbFetchArray($result)){
			$u_id=$rowUser['u_id'];
			$sec_id=$rowUser['sec_id'];
			$dep_id=$rowUser['dep_id'];
			$tb="paperuser";
			$sql="insert into $tb (pid,u_id,sec_id,dep_id) values ($lastid,$u_id,$sec_id,$dep_id)";
			$dbquery= dbQuery($sql);
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
        
	}  //if
	
	
	
	if($toSome!=''){
		//ส		่งเอกสารแยกตามประเภทหน่วยงาน
		if($cid && $link_file<>null){
			
			$sql="INSERT INTO paper(title,detail,file,postdate,u_id,outsite,sec_id,dep_id,book_no)
                        VALUES('$title','$detail','$link_file','$dateSend',$user_id,$outsite,$sec_id,$dep_id,'$book_no')";
		}else{
			$sql="INSERT INTO paper(title,detail,file,postdate,u_id,outsite,sec_id,dep_id,book_no)
                  VALUES('$title','$detail','$part_link','$dateSend',$user_id,$outsite,$sec_id,$dep_id,'$book_no')";
		}
		//print "คำสั่งส่งข้อมูลให้บางหน่วยงาน". $sqlSend;
		$result=dbQuery($sql);
		$lastid=  dbInsertId();
		//คนหาเลขระเบียนล่าสุด
		$sendto=$_POST['toSomeUser'];
		//สงมาจาก textbox 
		$sendto=substr($sendto, 1);
		$c=explode("|", $sendto);
		
		for ($i=0;$i<count($c);$i++){	   //1.ต้องเป็นประเภทที่กำหนด 2.ต้องไม่ใช่หน่วยส่ง 3.ผู้รับต้องระดับเป็นสารบรรณหน่วยงาน 4.มีสิทธิ์รับเอกสาร
			$sql="SELECT  u.u_id,u.firstname,u.keyman,s.sec_id,d.dep_id,d.type_id
                        FROM user u 
                        INNER JOIN section s ON s.sec_id=u.sec_id
                        INNER JOIN depart d  ON d.dep_id=u.dep_id
                        INNER JOIN office_type t    ON t.type_id=d.type_id
                        WHERE d.type_id=$c[$i] 
                        AND d.dep_id<>$dep_id 
                        AND u.level_id <= 3
                        AND u.keyman=1";
			
			
			// 			print $sql;
			
			$result=dbQuery($sql);
			
			while ( $row=dbFetchArray($result)) {
				$tb="paperuser";
				$u_id=$row['u_id'];
				$sec_id=$row['sec_id'];
				$dep_id=$row['dep_id'];
				$sql="insert into $tb (pid,u_id,sec_id,dep_id) values ($lastid,$u_id,$sec_id,$dep_id)";
				dbQuery($sql);
			}
		}
		
		
		echo "<script>
                swal({
                    title:'เรียบร้อย',
                    type:'success',
                    showConfirmButton:true
                    },
                    function(isConfirm){
                        if(isConfirm){
                            window.location.href='history.php';
                        }
                    }); 
                </script>";
		
		
	}
	
	
	
	if($toSomeOne!=''){
		//ส		่งเอกสารแบบเลือกเอง
		if($cid<>''){
			
			$sql="INSERT INTO paper(title,detail,file,postdate,u_id,outsite,sec_id,dep_id,book_no)
                       VALUES('$title','$detail','$link_file','$dateSend',$user_id,$outsite,$sec_id,$dep_id,'$book_no')";
			
		}
		else{
			
			$sql="INSERT INTO paper(title,detail,file,postdate,u_id,outsite,sec_id,dep_id,book_no)
                       VALUES('$title','$detail','$part_link','$dateSend',$user_id,$outsite,$sec_id,$dep_id,'$book_no')";
			
		}
		
		
		// 		print $sql;
		
		
		$result=dbQuery($sql);
		
		
		$lastid=  dbInsertId();
		//ค		้นหาเลขระเบียนล่าสุด
		$sendto=$toSomeOneUser;
		
		$sendto=  substr($sendto,1);
		
		$c=  explode("|",$sendto);
		
		for ($i=0;$i<count($c);$i++){
			
			
			$sql="SELECT  u.u_id,u.firstname,s.sec_id,d.dep_id,d.dep_name  
                      FROM user u 
                      INNER JOIN section s ON s.sec_id=u.sec_id
                      INNER JOIN depart d  ON d.dep_id=u.dep_id
                      WHERE u.dep_id=$c[$i] AND u.level_id =3";
			//ก			รณีส่งภายนอก  ต้องส่งให้ สารบรรณประจำหน่วยงานเท่านั้น
			// 			print $sql;
			
			// 			echo "<br>";
			
			$result=dbQuery($sql);
			
			while($row=dbFetchArray($result)){
				
				$u_id=$row['u_id'];
				
				$sec_id=$row['sec_id'];
				
				$dep_id=$row['dep_id'];
				
				$sql="INSERT INTO paperuser (pid,u_id,sec_id,dep_id) VALUES ($lastid,$u_id,$sec_id,$dep_id)";
				
				dbQuery($sql);
				
			}
			
		}
		
		echo "<script>
                swal({
                    title:'เรียบร้อย',
                    type:'success',
                    showConfirmButton:true
                    },
                    function(isConfirm){
                        if(isConfirm){
                            window.location.href='history.php';
                        }
                    }); 
                </script>";
		
		
	}
	
}


?>
<!-- end process -->
<script type='text/javascript'>
       $('#tbOutside').DataTable( {
        "order": [[ 0, "desc" ]]
    } )
</script>   

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



