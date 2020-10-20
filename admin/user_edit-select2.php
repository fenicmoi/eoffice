<?php
include 'header.php';
$u_id = $_GET['edit'];
?>
    <div class="row">
        <div class="col-md-2" >
             <?php  //ตรวจสอบสิทธิ์การใช้งานเมนู
                $menu = checkMenu($level_id);
                include $menu;
             ?>
        </div>
       
        <div class="col-md-10">
            <div class="panel panel-primary" style="margin: 20">
                <div class="panel-heading"><i class="fa fa-user-secret fa-2x" aria-hidden="true"></i>  <strong>แก้ไขผู้ใช้งาน</strong></div>
                <p></p>
                <div class="panel-body">
                    <form class="alert-info" method="post" style="width:600px;margin: auto;">
                            <div class="input-group">
                                <label for="status"><i class="fa fa-cog"></i>สถานะการใช้งาน</label>
                                <?php
                                 $sql = "SELECT u.* , d.dep_name,s.sec_name,o.type_id
                                        FROM user u 
                                        INNER JOIN depart d ON  d.dep_id=u.dep_id
                                        INNER JOIN section s ON s.sec_id=u.sec_id
                                        INNER JOIN office_type o ON o.type_id = d.type_id
                                        WHERE u.u_id=$u_id";
                                 $result = dbQuery($sql);
                                 $getROW = dbFetchAssoc($result);

                                 $dep_id = $getROW['dep_id'];
                                 $sec_cur = $getROW['sec_id'];
                                 $type_id = $getROW['type_id'];
                                 $status = $getROW['status'];

                                    if ($status == 1) {
                                        echo '<input type="radio" id="status" name="status" value="1" checked>ใช้งาน ';
                                        echo '<input type="radio" id="status" name="status" value="0" >ระงับการใช้งาน';
                                    } else {
                                        echo '<input type="radio" id="status" name="status" value="1">ใช้งาน ';
                                        echo '<input type="radio" id="status" name="status" value="0" checked>ระงับการใช้งาน';
                                    }

                                ?>
                            <div class="form-group form-inline">
                                    <label for="level_name"><i class="fas fa-cog"></i> สิทธิ์การใช้งาน : </label>
                                    <?php 
                                    $level = $getROW['level_id'];
                                    if ($level_id <= 2) {
                                        ?>
                                        <input type="radio" name="level"  id="level" value="1" <?php if ($level == 1) {
                                            echo 'checked';
                                        } ?> > ผู้ดูแลระบบ
                                        <input type="radio" name="level"  id="level" value="2" <?php if ($level == 2) {
                                            echo 'checked';
                                        } ?> > สารบรรณกลาง
                                        <input type="radio" name="level"  id="level" value="3" <?php if ($level == 3) {
                                            echo 'checked';
                                        } ?>> สารบรรณประจำหน่วยงาน
                                        <input type="radio" name="level"  id="level" value="4" <?php if ($level == 4) {
                                            echo 'checked';
                                        } ?>> สารบรรณประจำกลุ่มงาน
                                        <input type="radio" name="level"  id="level" value="5" <?php if ($level == 5) {
                                            echo 'checked';
                                        } ?>> ผู้ใช้ทั่วไป
                                    <?php
                                    } else {
                                        ?>
                                        <input type="radio" name="level"  id="level" value="3" <?php if ($level == 3) {
                                            echo 'checked';
                                        } ?>> สารบรรณประจำหน่วยงาน
                                        <input type="radio" name="level"  id="level" value="4" <?php if ($level == 4) {
                                            echo 'checked';
                                        } ?>> สารบรรณประจำกลุ่มงาน
                                        <input type="radio" name="level"  id="level" value="5" <?php if ($level == 5) {
                                            echo 'checked';
                                        } ?>> ผู้ใช้ทั่วไป
                                    <?php
                                    } ?>
                            </div>
                            <div class="form-group form-inline">
                                 <?php $keyman = $getROW['keyman']; ?>
                                <label><i class="fas fa-cog"></i> สิทธิ์การรับเอกสาร ระดับหน่วยงาน/กลุ่มงาน</label>
                                <input type="radio" id="keyman" name="keyman" value="1" <?php  if ($keyman == 1) {
                                        echo 'checked';
                                    } ?>>มีสิทธิ์
                                <input type="radio" id="keyman" name="keyman" value="0" <?php  if ($keyman == 0) {
                                        echo 'checked';
                                    } ?>>ไม่มีสิทธิ์
                            </div>

                        <div class="form-group form-inline">
                            <div class="input-group">  
                                <span class="input-group-addon">ประเภทหน่วยงาน</span>
                                <select class="form-control select2-single" id="province">
                                    <option id="province_list"> -- Select --</option>
                                </select>
                            </div>
                        </div> 
    
                          <br>
                          <br>
                          <div class="form-group form-inline">
                               <label for="firstname">ชื่อ :</label>
                              <div class="input-group">
                                  <input class="form-control" type="text" name="firstname" id="firstname" size="25" value="<?php echo $getROW['firstname']; ?>">
                              </div>
                                 <label for="lastname">นามสกุล</label>
                              <div class="input-group">
                                  <input class="form-control" type="text" name="lastname" id="lastname" size="20" value="<?php echo $getROW['lastname']; ?>">
                              </div>
                          </div>
                          <div class="form-group form-inline">
                               <label for="position">ตำแหน่ง :</label>
                              <div class="input-group">
                                 <input class="form-control" type="text" name="position" id="position" size="40" value="<?php echo $getROW['position']; ?>">
                              </div>
                          </div>
                          <div class="form-group form-inline">
                              <label for="u_name">ชื่อผู้ใช้ :</label>
                              <div class="input-group">
                                  <input class="form-control" type="text"  name="u_name" id="u_name"  value="<?php echo $getROW['u_name']; ?>">
                              </div>
                              <label for="u_pass">รหัสผ่าน :</label>
                              <div class="input-group">
                                  <input class="form-control" type="text" name="u_pass" id="u_pass"  value="<?php echo $getROW['u_pass']; ?>">
                              </div>
                          </div> 
                          <div class="form-group form-inline">
                              <label for="email">E-mail</label>
                              <div class="input-group">
                                  <input class="form-control" type="email" name="email" id="email" value="<?php echo $getROW['email']; ?>">
                              </div>
                          </div>
                          <div class="form-group form-inline">
                              <label for="date_create">วันที่แก้ไข</label>
                              <div class="input-group">
                                  <input class="form-control" type="text" name="date_user" id="date_user" value="<?php echo date('Y-m-d'); ?>">
                              </div>
                          </div>
                        </div>
                                    <center>
                                        <button class="btn btn-success btn-lg" type="submit" name="save">
                                            <i class="fa fa-save"></i> บันทึก
                                        </button>
                                        <a class="btn btn-danger btn-lg" href="user.php"><i class="fas fa-times-circle"></i> ยกเลิก</a>
                                    </center>
                      </form>
                </div>
              </div>
            </div>
        </div>
    </div>  

    <?php  //ส่วน update ข้อมูล
        if (isset($_POST['save'])) {
            if ($level_id <= 2) {  //กรณีเป็นผู้ดูแลระบบ  id จะเป็น 1  เพราะต้องจัดการได้ทั้งจังหวัด
                @$type_id = $_POST['province'];
                @$dep_id = $_POST['amphur'];
                $sec_id = $_POST['district'];

                $sec_id = $_POST['district'];
                $level_id = $_POST['level'];
                $u_name = $_POST['u_name'];
                $u_pass = $_POST['u_pass'];
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $position = $_POST['position'];
                $date_create = $_POST['date_user'];
                $status = $_POST['status'];
                $email = $_POST['email'];
                $keyman = $_POST['keyman'];
                echo 'sec1';
            } else {
                $sec_id = $_POST['district'];
                $level_id = $_POST['level'];
                $u_name = $_POST['u_name'];
                $u_pass = $_POST['u_pass'];
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $position = $_POST['position'];
                $date_create = $_POST['date_user'];
                $status = $_POST['status'];
                $email = $_POST['email'];
                $keyman = $_POST['keyman'];
                echo 'sec2';
            }
            $sql = "UPDATE user 
                      SET sec_id=$sec_id,
                        dep_id=$dep_id,
                        level_id=$level_id,
                        u_name='$u_name',
                        u_pass='$u_pass',
                        firstname='$firstname',
                        lastname='$lastname',
                        position='$position',
                        date_create='$date_create',
                        status='$status',
                        email='$email',
                        keyman='$keyman'
                        
                      WHERE u_id = $u_id
                      ";
            // echo $sql;
            $result = dbQuery($sql);
            if (!$result) {
                echo "<script>
                    swal({
                     title:'มีบางอย่างผิดพลาด กรุณาตรวจสอบ',
                     type:'warning',
                     showConfirmButton:true
                     },
                     function(isConfirm){
                         if(isConfirm){
                             window.location.href='user.php';
                         }
                     }); 
                   </script>";
            } else {
                echo "<script>
                    swal({
                     title:'แก้ไขข้อมูลเรียบร้อยแล้ว',
                     type:'success',
                     showConfirmButton:true
                     },
                     function(isConfirm){
                         if(isConfirm){
                             window.location.href='user.php';
                         }
                     }); 
                   </script>";
            }  //check db
        } //check button
    ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
	
	<script>
			
			$(function(){
				
				//เรียกใช้งาน Select2
				$(".select2-single").select2();
				
				//ดึงข้อมูล province จากไฟล์ get_data.php
				$.ajax({
					url:"get_data.php",
					dataType: "json", //กำหนดให้มีรูปแบบเป็น Json
					data:{show_province:'show_province'}, //ส่งค่าตัวแปร show_province เพื่อดึงข้อมูล จังหวัด
					success:function(data){
						
						//วนลูปแสดงข้อมูล ที่ได้จาก ตัวแปร data
						$.each(data, function( index, value ) {
							//แทรก Elements ใน id province  ด้วยคำสั่ง append
							  $("#province").append("<option value='"+ value.id +"'> " + value.name + "</option>");
						});
					}
				});
				
				
				//แสดงข้อมูล อำเภอ  โดยใช้คำสั่ง change จะทำงานกรณีมีการเปลี่ยนแปลงที่ #province
				$("#province").change(function(){

					//กำหนดให้ ตัวแปร province มีค่าเท่ากับ ค่าของ #province ที่กำลังถูกเลือกในขณะนั้น
					var province_id = $(this).val();
					
					$.ajax({
						url:"get_data.php",
						dataType: "json",//กำหนดให้มีรูปแบบเป็น Json
						data:{province_id:province_id},//ส่งค่าตัวแปร province_id เพื่อดึงข้อมูล อำเภอ ที่มี province_id เท่ากับค่าที่ส่งไป
						success:function(data){
							
							//กำหนดให้ข้อมูลใน #amphur เป็นค่าว่าง
							$("#amphur").text("");
							
							//วนลูปแสดงข้อมูล ที่ได้จาก ตัวแปร data  
							$.each(data, function( index, value ) {
								
								//แทรก Elements ข้อมูลที่ได้  ใน id amphur  ด้วยคำสั่ง append
								  $("#amphur").append("<option value='"+ value.id +"'> " + value.name + "</option>");
							});
						}
					});

				});
				
				//แสดงข้อมูลตำบล โดยใช้คำสั่ง change จะทำงานกรณีมีการเปลี่ยนแปลงที่  #amphur
				$("#amphur").change(function(){
					
					//กำหนดให้ ตัวแปร amphur_id มีค่าเท่ากับ ค่าของ  #amphur ที่กำลังถูกเลือกในขณะนั้น
					var amphur_id = $(this).val();
					
					$.ajax({
						url:"get_data.php",
						dataType: "json",//กำหนดให้มีรูปแบบเป็น Json
						data:{amphur_id:amphur_id},//ส่งค่าตัวแปร amphur_id เพื่อดึงข้อมูล ตำบล ที่มี amphur_id เท่ากับค่าที่ส่งไป
						success:function(data){
							
							  //กำหนดให้ข้อมูลใน #district เป็นค่าว่าง
							  $("#district").text("");
							  
							//วนลูปแสดงข้อมูล ที่ได้จาก ตัวแปร data  
							$.each(data, function( index, value ) {
								
							  //แทรก Elements ข้อมูลที่ได้  ใน id district  ด้วยคำสั่ง append
							  $("#district").append("<option value='" + value.id + "'> " + value.name + "</option>");
							  
							});
						}
					});
					
				});
				
				//คำสั่ง change จะทำงานกรณีมีการเปลี่ยนแปลงที่  #district 
				$("#district").change(function(){
					
					//นำข้อมูลรายการ จังหวัด ที่เลือก มาใส่ไว้ในตัวแปร province
					var province = $("#province option:selected").text();
					
					//นำข้อมูลรายการ อำเภอ ที่เลือก มาใส่ไว้ในตัวแปร amphur
					var amphur = $("#amphur option:selected").text();
					
					//นำข้อมูลรายการ ตำบล ที่เลือก มาใส่ไว้ในตัวแปร district
					var district = $("#district option:selected").text();
					
					//ใช้คำสั่ง alert แสดงข้อมูลที่ได้
					alert("คุณได้เลือก :  จังหวัด : " + province + " อำเภอ : "+ amphur + "  ตำบล : " + district );
					
				});
				
				
			});
			
	</script>
<?php include '../footer.php'; ?>


