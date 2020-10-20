<?php
include "header.php";
$yid=chkYearMonth(); 
$u_id=$_SESSION['ses_u_id'];
?>
<script>
	$( document ).ready( function () {
		// $("#btnSearch").prop("disabled",true); 
		$( "#dateSearch" ).hide();
		$( "tr" ).first().hide();


		$( "#hideSearch" ).click( function () {
			$( "tr" ).first().show( 1000 );
		} );


		$( '#typeSearch' ).change( function () {
			var typeSearch = $( '#typeSearch' ).val();
			if ( typeSearch == 4 ) {
				$( "#dateSearch" ).show( 500 );
				$( "#search" ).hide( 500 );
			} else {
				$( "#dateSearch" ).hide( 500 );
				$( "#search" ).show( 500 );
			}
		} )
	} );
</script>
    <div class="row">
        <div class="col-md-2" >
             <?php
                 $menu=  checkMenu($level_id);
				 include $menu;
			 ?>
        </div>
        <div class="col-md-10">
            <div class="panel panel-primary" style="margin: 20">
                <div class="panel-heading"><i class="fa fa-volume-up fa-2x" aria-hidden="true"></i>  <strong>เลขเอกสารประกวดราคา</strong>
                		<a href="" class="btn btn-default  pull-right" data-toggle="modal" data-target="#modalAdd">
                            <i class="fa fa-plus" aria-hidden="true"></i> ออกเลขเอกสาร</a>
						<button id="hideSearch" class="btn btn-default pull-right"><i class="fas fa-search"> ค้นหา</i></button>
						<a href="announce.php" class="btn btn-default pull-right"><i class="fas fa-home"></i> หน้าหลัก</a>
                </div> 
                <br>
                <table class="table table-bordered table-hover" id="tbHire">
                 <thead class="bg-info">
					<tr bgcolor="black">
						<td colspan="5">
							<form class="form-inline" method="post" name="frmSearch" id="frmSearch">
								<div class="form-group">
									<select class="form-control" id="typeSearch" name="typeSearch">
										<option value="1"><i class="fas fa-star"></i> เลขที่เอกสาร</option>
										<option value="2" selected>เรื่อง</option>
									</select>

								<div class="input-group">
								<input class="form-control" id="search" name="search" type="text" size="80" placeholder="Keyword สั้นๆ">
								<div class="input-group-btn">
									<button class="btn btn-primary" type="submit" name="btnSearch" id="btnSearch">
											<i class="fas fa-search "></i>
									</button>
								</div>
						    </form>
						</td>
					</tr>
                     <tr>
                         <th>เลขประกาศ</th>
                         <th>ชื่องาน</th>
                         <th>สิ้นสุดยื่นซอง</th>
                         <th>หน่วยงาน</th>
						 <th>พิมพ์</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                        $sql="SELECT h.*,d.dep_name,y.yname
                              FROM announce h
                              INNER JOIN depart d ON d.dep_id=h.dep_id
                              INNER JOIN year_money y ON y.yid=h.yid
                              ";
                         //ส่วนการค้นหา
							 if ( isset( $_POST[ 'btnSearch' ] ) ) { //ถ้ามีการกดปุ่มค้นหา
									@$typeSearch = $_POST[ 'typeSearch' ]; //ประเภทการค้นหา
									@$txt_search = $_POST[ 'search' ]; //กล่องรับข้อความ

									if ( @$typeSearch == 1 ) { //ทะเบียนรับ
										$sql .= " WHERE h.rec_no LIKE '%$txt_search%'   ORDER BY h.hire_id  DESC";
									} elseif ( @$typeSearch == 2 ) { //เลขหนังสือ
										$sql .= " WHERE h.title LIKE '%$txt_search%'     ORDER BY h.hire_id DESC ";
									} 
										$result = page_query( $dbConn, $sql, 10 );
										$numrow = dbNumRows( $result );
										if ( $numrow == 0 ) {
											echo "<script>
													swal({
															title:'ไม่พบข้อมูล!',
															type:'warning',
															text:'กรุณาตรวจสอบคำค้น...หรือเลือกเงื่อนไขการค้นหาใหม่อีกครั้งนะครับ',
															showConfirmButton:true
														},
													function(isConfirm){
															if(isConfirm){
																window.location.href='buy.php';
															}
													}); 
												</script>";
										}

										} else { //กรณีโหลดเพจ หรือไม่มีการกดปุ่มใดๆ
											switch ( $level_id ) {
												case 1: //admin
													$sql .= " ORDER BY h.hire_id  DESC ";
													break;
												case 2: //สารบรรณจังหวัด    ดูได้ทั้งจังหวัด
													$sql .= " ORDER BY h.hire_id  DESC ";
													break;
												case 3: //สารบรรณหน่วยงาน  ดูได้ทั้งหน่วยงาน
													$sql .= " WHERE d.dep_id=$dep_id ORDER BY h.hire_id  DESC  ";
													break;
												case 4: //สารบรรณกลุ่มงาน  ดูได้ทั้งหน่วย  แต่แก้ไม่ได้
													$sql .= " WHERE  d.dep_id=$dep_id ORDER BY h.hire_id   DESC  ";
													break;
												case 5: //สารบรรณกลุ่มงาน  ดูได้เฉพาะของตนเอง
													$sql .= " WHERE  d.dep_id=$dep_id ORDER BY h.hire_id  DESC  ";
													break;
											}

											$result = page_query( $dbConn, $sql, 10 );
                                        }
                        $result = page_query( $dbConn, $sql, 10 );
                        while($row=dbFetchArray($result)){?>
                            <tr>
                                <td>
                                <?php echo $row['rec_no'];?>/<?php echo $row['yname']; ?>
                                 </td>
                                <td>
                                    <?php $hire_id=$row['hire_id'];?>
                                    <a href="#" 
                                            onClick="loadData('<?php print $hire_id;?>','<?php print $u_id; ?>');" 
                                            data-toggle="modal" data-target=".bs-example-modal-table">
                                           <?php echo iconv_substr($row['title'],0,150,"UTF-8")."...";?> 
                                    </a>
                                </td>                  <!-- ชื่องาน -->        
                                <td><?php echo thaiDate($row['date_pre_end']);?></td> 
                                <td><?php echo $row['dep_name'];?></td>  
																<td>
																	<a href="report/rep-announce-item.php?hire_id=<?php print $hire_id?>" class="btn btn-warning" target="_blank"><i class="fas fa-print"></i>
																	</a>
																</td>
                            </tr>
                        <?php
}
?>
                 </tbody>
                </table>
								<div class="panel-footer">
												<center>
													<a href="announce.php" class="btn btn-primary">
													 <i class="fas fa-home"></i> หน้าหลัก
													</a>
													<?php 
													page_link_border("solid","1px","gray");
													page_link_bg_color("lightblue","pink");
													page_link_font("14px");
													page_link_color("blue","red");
													page_echo_pagenums(10,true); 
													?>
												</center>
								</div>
            </div>


            <!-- Model -->
            <!-- -ข้อมูลผู้ใช้ -->
            <div id="modalAdd" class="modal fade"  role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-list"></i> ออกเลขประกาศ</h4>
                  </div>
                  <div class="modal-body">
                      <form method="post">
                          <label for="">วันที่ทำรายการ: <?php echo DateThai();?></label>
                        <div class="form-group">
                          <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-list"></span></span>
                              <input type="text" class="form-control" id="title" name="title"  placeholder="เรื่อง"  required="">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="input-group">
                              <span class="input-group-addon"><span class="	glyphicon glyphicon-map-marker"></span></span>
                              <input type="text" class="form-control" id="place_buy" name="place_buy"  placeholder="สถานที่ขายแบบ"  required="">
                          </div>
                        </div>
                         <div class="form-group">
                           <div class="form-group form-inline">
                            <label for="date_start">วันที่ขายแบบ :</label><input class="form-control" type="date" name="date_start"  id="date_start" onKeyDown="return false" required>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-group form-inline">
                            <label for="date_end">วันที่สิ้นสุดให้แบบ :</label><input class="form-control" type="date" name="date_end"  id="date_end" onKeyDown="return false" required >
                           </div>
                        </div>
                         <div class="form-group">
                          <div class="input-group">
                              <span class="input-group-addon"><span class="	glyphicon glyphicon-map-marker"></span></span>
                              <input type="text" class="form-control" id="place_pre" name="place_pre"  placeholder="สถานที่ยื่นซอง"  required="">
                          </div>
                        </div>
                        <div class="form-group">
                           <div class="form-group form-inline">
                            <label for="date_pre_start">วันที่เริ่มยื่นซอง:</label><input class="form-control" type="date" name="date_pre_start"  id="date_pre_start" onKeyDown="return false" required >
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-group form-inline">
                            <label for="date_pre_end">วันที่สิ้นสุดยื่นซอง:</label><input class="form-control" type="date" name="date_pre_end"  id="date_pre_end" onKeyDown="return false" required >
                           </div>
                        </div>
                     
                        <?php 
                            $sql="SELECT * FROM depart WHERE dep_id=$dep_id";
                            $result=dbQuery($sql);
                            $row=dbFetchArray($result);
                        ?>
                        <div class="form-group">
                            <div class="input-group">
                                 <span class="input-group-addon"><span class="fa fa-building"></span></span>
                                <input type="text" class="form-control" id="dep_id" name="dep_id"  value="<?php print $row['dep_name'];?>" > 
                            </div>
                        </div>
                            <center>
                                <button class="btn btn-success btn-lg" type="submit" name="save">
                                    <i class="fas fa-save fa-2x"></i> บันทึก
                                </button>
                            </center>                                                         
                      </form>
                  </div>
                  <div class="modal-footer bg-primary">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด X</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Model -->   
        </div>
    </div>  
    <!--  modal แสงรายละเอียดข้อมูล -->
        <div  class="modal fade bs-example-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-info"></i> รายละเอียด</h4>
                    </div>
                    <div class="modal-body no-padding">
                        <div id="divDataview"></div>     
                    </div> <!-- modal-body -->
                    <div class="modal-footer bg-primary">
                         <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด X</button>
                    </div>
                </div>
            </div>
        </div>
<!-- จบส่วนแสดงรายละเอียดข้อมูล  -->
<?php
// ส่วน[ันทึกข้อมูล
if(isset($_POST['save'])){

    
	$datein=date('Y-m-d');   
	$title=$_POST['title'];            //เรื่อง
	$place_buy=$_POST['place_buy'];    //สถานที่ขายแบบ
	$date_start=$_POST['date_start'];  //วันที่เริ่มขายแบบ
	$date_end=$_POST['date_end'];      //วันที่หยุดขายแบบ
	$place_pre=$_POST['place_pre'];    //สถานที่ยื่นซอง
	$date_pre_start=$_POST['date_pre_start'];   //วันที่เริ่มยื่นซอง
	$date_pre_end=$_POST['date_pre_end'];       //วันที่หยุดรับซอง
	
	
	/*   $sql="SELECT hire_id,rec_no
          FROM announce      
          WHERE yid=$yid[0]
          ORDER BY hire_id DESC
          LIMIT 1";
    //print $sql;
    
    $result=dbQuery($sql);
    $row=dbFetchAssoc($result);
    $rec_no=$row['rec_no'];

    if($rec_no==0){
       $rec_no=1;
    }else{
        $rec_no++; 
    } 
*/
       //ตัวเลขรันอัตโนมัติ
    $sql="SELECT hire_id,rec_no
          FROM announce
          WHERE yid=$yid[0]
          ORDER BY hire_id DESC
          LIMIT 1";
    //print $sql;
    
    $result=dbQuery($sql);
    $row = dbFetchAssoc($result);
    $rec_no=$row['rec_no'];

    if($rec_no==0){
       $rec_no=1;
    }else{
       $rec_no++; 
    } 
    //echo "rec_no=".$rec_no;
       
	
	dbQuery('BEGIN');
	$sql="INSERT INTO  announce(rec_no,datein,title,place_buy,date_start,date_end,place_pre,date_pre_start,date_pre_end,dep_id,sec_id,u_id,yid)
                VALUES($rec_no,'$datein','$title','$place_buy','$date_start','$date_end','$place_pre','$date_pre_start','$date_pre_end',$dep_id,$sec_id,$u_id,$yid[0])";
	//echo $sql;
	
	$result=dbQuery($sql);
	if($result){
		dbQuery("COMMIT");
		echo "<script>
        swal({
            title:'เรียบร้อย',
            type:'success',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='announce.php';
                }
            }); 
        </script>";
	}
	else{
		dbQuery("ROLLBACK");
		echo "<script>
        swal({
            title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
            type:'error',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='announce.php';
                }
            }); 
        </script>";
	}
	
}
?>

<script type="text/javascript">
function loadData(hire_id,u_id) {
    var sdata = {
        hire_id : hire_id,
        u_id : u_id 
    };
$('#divDataview').load('show_announce_detail.php',sdata);
}
</script>
