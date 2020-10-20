<br>
<?php  
//$user_send=$_SESSION['ses_u_id'];     //มีตัวแปรตัวนี้แล้วจาก  insite_all.php
//echo $user_send;
?>
<form  id="fileout" name="fileout" action="crud_paper.php" method="post" enctype="multipart/form-data" >
    <div class="form-group form-inline">
        <label for="title">ชื่อเอกสาร:</label>
        <input class="form-control" type="text" name="title" size="60" placeholder="ใส่ชื่อเอกสาร" value="<?php print $title; ?>" required="">
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
							<td  class="alere alert-info"><center>เลือกชื่อผู้รับ</center></td>
						</tr>
					</table>
                <div id="div1" style="width:599px; height:250px; overflow:auto">
                    <table border="1" width="599px">
                        
                        <?php  
                        $sqlOut="SELECT type_id,type_name FROM office_type ORDER BY type_id";
                        $resultOut=mysqli_query($conn,$sqlOut);
                        $numrowOut=mysqli_num_rows($resultOut);
                        if(empty($numrowOut)){?>
                        <thead>
                            <tr>
                                <td></td>
                                <td>ไม่มีข้อมูลประเภทส่วนราชการ</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php } else { 
                            $i=0;
                            while($rowOut=mysqli_fetch_assoc($resultOut)){ 
                            $i++;
                            $a=$i%2;
                            if($a==0){?>
                        <tr bgcolor="#A9F5D0">
                            <?php }else{ ?>
                        <tr bgcolor="#F5F6CE">
                            <?php } ?>
                            <td   class="select_multiple_checkbox"><input type="checkbox" onclick="listType(this,'<?php echo $rowOut['type_id'];?>')"></td>
                            <td   class="select_multiple_name"><?php print $rowOut['type_name']; ?></td>
                        </tr>
                        
                        <?php }}?>
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
             <table  border="1" width="599px" cellspacing="0" cellpadding="0">
						<tr>
							<td  class="alere alert-info"><center>เลือกชื่อผู้รับ</center></td>
						</tr>
					</table>
                <div id="div1" style="width:599px; height:350px; overflow:auto">
                    <table id="tableDepart" border="1" width="599px">
                        <thead>
                            <th></th>
                            <th>ชื่อส่วนราชการ</th>
                        </thead>
                        <tbody>
                        <?php  
                        $sqlOut="SELECT dep_id,dep_name FROM depart ORDER BY dep_name";
                        $resultOut=mysqli_query($conn,$sqlOut);
                        $numrowOut=mysqli_num_rows($resultOut);
                        if(empty($numrowOut)){?>
                        <tr>
                            <td></td>
                            <td>ไม่มีข้อมูลประเภทส่วนราชการ</td>
                        </tr>
                        <?php } else { 
                            $i=0;
                            while($rowOut=mysqli_fetch_assoc($resultOut)){ 
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
    </div>
    <div class="form-group form-inline">
        <label for="fileupload">แนบไฟล์</label>
        <input type="file" name="fileupload"  class="alert-success form-control">
    </div>
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
        <input type="hidden" name="file" value="<?php print $fileupload; ?>"/>
        <input type="hidden" name="dep_id" value="<?php print $dep_id; ?>"/>
        <input type="hidden" name="sec_id" value="<?php print $sec_id; ?>"/>
        <input type="hidden" name="user_id" id="user_id" value="<?php  print $user_send; ?>"/>  
        <input type="submit" name="sendOut" class="btn btn-primary btn-lg" value="ส่งเอกสาร"/>
    </div>
    </center>
</form>    
    <script type='text/javascript'>
        $(document).ready(function(){
    $('#tableDepart').DataTable(
        {
           "oLanguage": {
                 "oPaginate": {
                        "sFirst": "หน้าแรก",
                         "sLast": "หน้าสุดท้าย",
                         "sNext": "ถัดไป",
                         "sPrevious": "กลับ"
                               }
                         }
      }
                
        );
    })
    
    </script>                                