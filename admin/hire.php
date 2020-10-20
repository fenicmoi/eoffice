
<!--  ทะเบียนคุมสัญญาจ้าง -->
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
				//   $("#btnSearch").prop("disabled",false); 
			} else {
				$( "#dateSearch" ).hide( 500 );
				$( "#search" ).show( 500 );
				//   $("#search").keydown(function(){
				//     $("#btnSearch").prop("disabled",false); 
				//   });
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
        </div>  <!-- col-md-2 -->
        <div class="col-md-10">
            <div class="panel panel-primary">
                <div class="panel-heading"><i class="fas fa-shopping-cart fa-2x"></i>  <strong>ทะเบียนคุมสัญญาจ้าง </strong>
                		<a href="" class="btn btn-default  pull-right" data-toggle="modal" data-target="#modalAdd">
                     		<i class="fas fa-plus"></i> ออกเลขสัญญา
                    	</a>
						<!-- <button id="hideSearch" class="btn btn-default pull-right"><i class="fas fa-search"> ค้นหา</i></button> -->
						<a href="buy.php" class="btn btn-default pull-right"><i class="fas fa-home"></i> หน้าหลัก</a>
                </div>  
                <br>
                <table class="table table-bordered table-hover" id="tbHire">
                 <thead class="bg-info">
									 	 <tr bgcolor="black">
											<td colspan="6">
												<form class="form-inline" method="post" name="frmSearch" id="frmSearch">
													<div class="form-group">
														<select class="form-control" id="typeSearch" name="typeSearch">
															<option value="1"><i class="fas fa-star"></i> เลขที่สัญญา</option>
															<option value="2" selected>เรื่องสัญญา</option>
														</select>

														<div class="input-group">
															<input class="form-control" id="search" name="search" type="text" size="80" placeholder="Keyword สั้นๆ">
															<div class="input-group-btn">
																<button class="btn btn-primary" type="submit" name="btnSearch" id="btnSearch">
																	 <i class="fas fa-search "></i>
																</button>
															</div>
														</div>
													</div>
												</form>
											</td>
										</tr>
                                        <tr> 
                                            <th>เลขสัญญา</th>
                                            <th>รายการจ้าง</th>
                                            <th>วันที่บันทึก</th>
                                            <th>วงเงิน</th>
                                            <th>เจ้าของเรื่อง</th>
                                            <th>พิมพ์</th>
                                            <th>แก้ไข</th>
                                        </tr>
                 </thead>
                 <tbody>
                 <?php
                        //คนหา ID ล่าสุด
                        $sql = "SELECT MAX(hire_id) AS maxid FROM hire"; // query อ่านค่า id สูงสุด
                        $result = dbQuery($sql);
                        $row=dbFetchAssoc($result);
                        $last_id = $row['maxid']; // คืนค่า id ที่ insert สูงสุด
   
                        $sql="SELECT h.*,d.dep_name,y.yname
                              FROM hire h
                              INNER JOIN depart d ON d.dep_id=h.dep_id
                              INNER JOIN  year_money y ON h.yid=y.yid
                              ";
                        //ส่วนการค้นหา
									 if ( isset( $_POST[ 'btnSearch' ] ) ) { //ถ้ามีการกดปุ่มค้นหา
												@$typeSearch = $_POST[ 'typeSearch' ]; //ประเภทการค้นหา
												@$txt_search = $_POST[ 'search' ]; //กล่องรับข้อความ

											if ( @$typeSearch == 1 ) { //ทะเบียนรับ
												$sql .= " WHERE h.rec_no LIKE '%$txt_search%'   ORDER BY hire_id  DESC";
											} elseif ( @$typeSearch == 2 ) { //เลขหนังสือ
												$sql .= " WHERE h.title LIKE '%$txt_search%'     ORDER BY hire_id DESC ";
											} 
										 //print $sql;
										//$result=dbQuery($sql);
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
																						window.location.href='hire.php';
																					}
																			}); 
												</script>";
										}

										} else { //กรณีโหลดเพจ หรือไม่มีการกดปุ่มใดๆ
											switch ( $level_id ) {
												case 1: //admin
													$sql .= " ORDER BY hire_id  DESC ";
													break;
												case 2: //สารบรรณจังหวัด    ดูได้ทั้งจังหวัด
													$sql .= " ORDER BY hire_id  DESC ";
													break;
												case 3: //สารบรรณหน่วยงาน  ดูได้ทั้งหน่วยงาน
													$sql .= " WHERE d.dep_id=$dep_id ORDER BY h.hire_id  DESC  ";
													break;
												case 4: //สารบรรณกลุ่มงาน  ดูได้ทั้งหน่วย  แต่แก้ไม่ได้
													$sql .= " WHERE  d.dep_id=$dep_id ORDER BY h.hire_id  DESC  ";
													break;
												case 5: //สารบรรณกลุ่มงาน  ดูได้เฉพาะของตนเอง
													$sql .= " WHERE  d.dep_id=$dep_id   ORDER BY h.hire_id  DESC  ";
													break;
											}

											$result = page_query( $dbConn, $sql, 10 );
										}
					
					while ( $row = dbFetchArray( $result ) ) {
						?>
                            <tr>
                                <td>
                                <?php
                                    if($row['hire_id']==$last_id){
                                        echo $row['rec_no']; ?>/<?php echo $row['yname'];  
                                    }else{
                                        echo $row['rec_no']; ?>/<?php echo $row['yname'];
                                    }
                                ?>
                                 </td>
                               
                                <?php 
                                    $hire_id=$row['hire_id'];
                                   // print $hire_id;
                                ?>
                                <td>
									<a href="#" onClick="loadData('<?php print $hire_id;?>','<?php print $u_id; ?>');" 
                                            data-toggle="modal" data-target=".bs-example-modal-table">
                                        <?php echo iconv_substr($row['title'],0,200,"UTF-8")."...";?> 
                                    </a>
                                </td>  
								<td><?php echo thaiDate($row['datein']); ?></td>
                               <td><?php echo number_format($row['money']); ?></td>
								<td><?php echo $row['dep_name'];?></td>
								<td><a href="report/rep-hire-item.php?hire_id=<?php print $hire_id?>" class="btn btn-info" target="_blank"><i class="fas fa-print"></i></a></td>
                                <td><a href="#" class="btn btn-warning"><i class="fas fa-edit"></i></a></td>
                            </tr>
                        <?php } ?>
                 </tbody>
                </table>
							<div class="panel-footer">
								<center>
												<a href="hire.php" class="btn btn-primary">
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
        </div> <!-- col-md-10 -->
    </div>    <!-- end row  -->

 <!--เพิ่มข้อมูล -->
 <div id="modalAdd" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="exampleModalLabel"><i class="fa fa-list"></i> ออกเลขสัญญาจ้าง</h4>
                  </div>
                  <div class="modal-body">
                      <form method="post">
                          <label class="badge">วันที่ทำรายการ: <?php echo DateThai(); ?></label>
                          <?php 
                            $sql="SELECT *FROM depart WHERE dep_id=$dep_id";
                            $result=dbQuery($sql);
                            $row=dbFetchArray($result);
                        ?>
                          <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">หน่วยงานเจ้าของงบประมาณ</span>
                                <input type="text" class="form-control" id="dep_id" name="dep_id"  value="<?php print $row['dep_name'];?>" > 
                            </div>
                        </div>
                        <div class="form-group">
                          <div class="input-group"> 
                              <span class="input-group-addon">รายการจ้าง</span>
                              <input type="text" class="form-control" id="title" name="title"  required="">
                          </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group"> 
                                <span class="input-group-addon">วงเงินการจ้าง</span>
                                <input type="number" class="form-control" id="money" name="money" required="">  
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <div class="input-group"> 
                                <span class="input-group-addon">ผู้รับจ้าง</span>
                                <input type="text" class="form-control" id="employee" name="employee"  required="" > 
                            </div>
                        </div>     
                        <div class="form-group form-inline">
                            <div class="input-group">
                             <span class="input-group-addon"><label for="datehire">วันทำสัญญา :</label></span>
                            <input class="form-control" type="date" name="datehire"  id="datehire" onKeyDown="return false" required > 
                            </div>
                        </div>
                        <div class="form-group form-inline">
                            <div class="input-group">
                             <span class="input-group-addon"><label for="datehire">วันส่งงาน :</label></span>
                            <input class="form-control" type="date" name="date_submit"  id="date_submit" onKeyDown="return false" required > 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group"> 
                                <span class="input-group-addon">ผู้ลงนาม</span>
                                <input type="text" class="form-control" id="signer" name="signer"  placeholder="ผู้ลงนาม" value="ผู้ว่าราชการจังหวัด" required="" > 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">หลักประกันสัญญา</i></span>
                                <input type="number" class="form-control" id="guarantee" name="guarantee"  value="0"  required="" ;> 
                            </div>
                        </div>
                       
                       
                        
                            <center>
                                <button class="btn btn-success" type="submit" name="save">
                                    <i class="fa fa-save fa-2x"></i> บันทึก
                                </button>
                            </center>                                                         
                      </form>
                  </div>
                  <div class="modal-footer bg-primary">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Model -->  
    

<!--  modal แสงรายละเอียดข้อมูล -->
        <div  class="modal fade bs-example-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-info"></i> รายละเอียด</h4>
                    </div>
                    <div class="modal-body no-padding">
                        <div id="divDataview"></div>     
                    </div> <!-- modal-body -->
                    <div class="modal-footer bg-danger">
                         <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด X</button>
                    </div>
                </div>
            </div>
        </div>
<!-- จบส่วนแสดงรายละเอียดข้อมูล  -->

<?php
// ส่วนการจัดการข้อมูล
if(isset($_POST['save'])){

    $datein=date('Y-m-d');
    $title=$_POST['title'];
    $money=$_POST['money'];
    $employee=$_POST['employee'];
    $datehire=$_POST['datehire'];
    $signer=$_POST['signer'];
    $guarantee=$_POST['guarantee'];
    $date_submit=$_POST['date_submit'];
    
  
    //echo $yid[0];
    //echo "this is datein=".$datein;
    //ตัวเลขรันอัตโนมัติ
    $sql="SELECT hire_id,rec_no
          FROM hire
          WHERE yid=$yid[0]
          ORDER BY hire_id DESC
          LIMIT 1";
    //print $sql;
    //print $yid[0];
    $result=dbQuery($sql);
    $row = dbFetchAssoc($result);
    $rec_no=$row['rec_no'];

    if($rec_no==0){
       $rec_no=1;
    }else{
       $rec_no++; 
    } 
    //echo "rec_no=".$rec_no;

    
    //echo "This is $rec_no=".$rec_no;
    //dbQuery('BEGIN');
    $sql="INSERT INTO hire (rec_no,datein,title,money,employee,date_hire,signer,guarantee,date_submit,dep_id,sec_id,u_id,yid)
                VALUES($rec_no,'$datein','$title',$money,'$employee','$datehire','$signer',$guarantee,'$date_submit',$dep_id,$sec_id,$u_id,$yid[0])";
    
    
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
                    window.location.href='hire.php';
                }
            }); 
        </script>";
    }else{
        dbQuery("ROLLBACK");
        echo "<script>
        swal({
            title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
            type:'error',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='hire.php';
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
$('#divDataview').load('show_hire_detail.php',sdata);
}
</script>

