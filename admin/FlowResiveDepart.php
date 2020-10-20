<!-- หนังสือรับถึงหน่วยงาน-->

<?php
include "header.php";
$u_id = $_SESSION[ 'ses_u_id' ];

//ตรวจสอบปีเอกสาร
list( $yid, $yname, $ystatus ) = chkYear();
$yid = $yid;
$yname = $yname;
$ystatus = $ystatus;
?>

<div class="col-md-2">
	<?php
		$menu = checkMenu( $level_id );
		include $menu;
	?>
</div>
<script>
	$( document ).ready( function () {
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
<div class="col-md-10">	
	<div class="panel panel-primary">
		<div class="panel-heading"><i class="fas fa-book fa-2x" aria-hidden="true"></i> <strong>หนังสือรับหน่วยงาน</strong> 
			:::ใช้คุมทะเบียนหนังสือรับสำหรับส่วนราชการต่าง ๆ  ที่ยังไม่มีระบบคุมเอกสาร
			<div class="btn-group pull-right">
				<a href="" class="btn btn-default " data-toggle="modal" data-target="#modalAdd">
							<i class="fa fa-plus" aria-hidden="true"></i> ลงทะเบียนรับ
				</a>
			
				<div class="btn-group">
					<button class="btn btn-default  dropdown-toggle" type="button" data-toggle="dropdown">
						<i class="fas fa-print"></i> รายงาน<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li><a href="#" data-toggle="modal" data-target="#myReport"><i class="fas fa-calendar"></i> ประจำวัน</a>
						</li>
						<li><a href="#" data-toggle="modal" data-target="#myReport1"><i class="fas fa-calendar-alt"></i> ตามช่วงเวลา</a>
						</li>
					</ul>
				</div>
				<button id="hideSearch" class="btn btn-default"><i class="fas fa-search"> ค้นหา</i></button>
			</div>
		</div>
		<table class="table table-bordered table-hover">
			<thead class="bg-info">
				<tr bgcolor="black">
					<td colspan="8">
						<form class="form-inline" method="post" name="frmSearch" id="frmSearch">
							<div class="form-group">
								<select class="form-control" id="typeSearch" name="typeSearch">
									<option value="1"> เลขทะเบียนรับ</option>
									<option value="2"> เลขเอกสาร</option>
									<option value="3" selected>ชื่อเรื่อง</option>
									<option value="4">ตามช่วงเวลา</option>
								</select>
								<div class="input-group">
									<input class="form-control" id="search" name="search" type="text" size="80" placeholder="Keyword สั้นๆ">
									<div class="input-group" id="dateSearch">
										<span class="input-group-addon"><i class="fas fa-calendar-alt"></i>วันที่เริ่มต้น</span>
										<input class="form-control" id="dateStart" name="dateStart" type="date">
										<span class="input-group-addon"><i class="fas fa-calendar-alt"></i>วันที่สิ้นสุด</span>
										<input class="form-control" id="dateEnd" name="dateEnd" type="date">
									</div>
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
					<th>ท/บ รับ</th>
					<th>เลขที่เอกสาร</th>
					<th>เรื่อง</th>
					<th>ลงวันที่</th>
					<th>หน่วยปฏิบัติ</th>
					<th>แก้ไข</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$sql = "SELECT fr.*,y.yname,s.sec_name FROM flow_recive_depart as fr 
                        INNER JOIN sys_year as y ON  y.yid=fr.yid 
                        INNER JOIN section as s ON s.sec_id=fr.remark
						";

				//กรณีมีการกดปุ่มค้นหา
				if ( isset( $_POST[ 'btnSearch' ] ) ) { //ถ้ามีการกดปุ่มค้นหา
					@$typeSearch = $_POST[ 'typeSearch' ]; //ประเภทการค้นหา
					@$txt_search = $_POST[ 'search' ]; //กล่องรับข้อความ
					@$dateStart = $_POST[ 'dateStart' ]; //วันที่เริ้มค้นหา
					@$dateEnd = $_POST[ 'dateEnd' ]; //วันที่สิ้นสุดการค้นหา

					if ( @$typeSearch == 1 ) { //ทะเบียนรับ
						$sql .= " WHERE fr.rec_no LIKE '%$txt_search%'  AND fr.dep_id=$dep_id";
					} elseif ( @$typeSearch == 2 ) { //เลขหนังสือ
						$sql .= " WHERE fr.book_no LIKE '%$txt_search%'   AND fr.dep_id=$dep_id";
					} elseif ( @$typeSearch == 3 ) { //เรื่อง
						$sql .= " WHERE fr.title LIKE '%$txt_search%'   AND fr.dep_id=$dep_id";
					} elseif ( @$typeSearch == 4 ) { //ตามเวลา
						$sql .= " WHERE  (fr.datein BETWEEN '$dateStart' AND '$dateEnd') AND fr.dep_id=$dep_id ";
					}

					$sql .= " ORDER BY fr.cid DESC";
					$result = page_query($dbConn,$sql,10);
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
                           window.history.back();
                         }
                    }); 
                    </script>";
					}

				} else { //กรณีโหลดเพจ หรือไม่มีการกดปุ่มใดๆ
					$sql .= " WHERE fr.dep_id= $dep_id  ORDER BY fr.cid  DESC";
				}

				$result = page_query( $dbConn, $sql, 10 );
				$numrow = dbNumRows($result);
				if($numrow == 0){?>
					<tr><td colspan="6"><center><h5>ไม่มีข้อมูล</h5></center></td></tr>
				<?php }else{
					while ( $row = dbFetchArray( $result ) ) {?>
					<tr>
						<td><?php echo $row['rec_no']; ?>/<?php echo $row['yname'];?></td>
						<td><?php echo $row['book_no']; ?></td>
						<?php 
							$cid=$row['cid'];
							$title=$row['title'];
						?>
						<td>
							<a class="text-primary" href="#" onClick="load_leave_data('<?php print $cid;?>','<?php print $u_id; ?>');" data-toggle="modal" data-target=".bs-example-modal-table">
								<?php echo $row['title'];?>
							</a>
						</td>
						<td>
							<?php echo thaiDate($row['dateout']);?>
						</td>
						<td>
							<?php echo $row['sec_name']; ?>
						</td>
						<!--  ส่วนตรวจสอบจำนวนวันที่กำหนดให้แก้ไขได้ไม่เกิน 7 วัน  -->
						<?php
						$d1 = $row[ 'datein' ];
						$d2 = date( 'Y-m-d' );
						$numday = getNumDay( $d1, $d2 );
						?>
						<td>
							<?php 
						if($level_id>3){
								echo '<i class="fas fa-ban"></i>ไม่มีสิทธิ์';
							}else{
								if($numday >= $dayEdit){
									echo '<i class="fab fa-expeditedssl fa-2x"></i>';
								}else{
									echo '<a href="FlowResiveDepart-edit.php?cid='.$cid.'");"><i class="btn btn-warning fas fa-edit"></i></a>';
								}
							}
						?>
						</td>
					</tr>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
		<div class="panel-footer">
			<center>
				<a href="FlowResiveDepart.php" class="btn btn-primary"><i class="fas fa-home"></i></a>
				<?php 
					page_link_border("solid","1px","gray");
					page_link_bg_color("lightblue","pink");
					page_link_font("14px");
					page_link_color("blue","red");
					page_echo_pagenums(6,true); 
				?>
			</center>
		</div>
	</div>
	<!-- class panel -->

	<!-- Model -->
	<!-- เพิ่มหนังสือ -->
	<div id="modalAdd" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus-circle"></i> ลงทะเบียนรับ</h4>
				</div>
				<div class="modal-body bg-success">
					<form name="form" method="post" enctype="multipart/form-data">
						<table width="100%">
							<tr>
								<td>
									<div class="form-group">
										<label for="yearDoc">ปีเอกสาร : </label> <input name="yearDoc" type="text" value="<?php print $yname; ?>" disabled="">
									</div>
								</td>
								<td></td>
								<td>
									<div class="form-group">
										<label for="date_in">วันที่ลงรับ:</label><input type="text" name="date_in" id="date_in" value="<?php print DateThai();?>" disabled="">
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="fas fa-list-ol"></i></span>
											<input class="form-control" type="text" name="book_no" id="book_no" placeholder="เลขที่หนังสือ" required>
										</div>
									</div>
								</td>
								<td></td>
								<td><label>เลขทะเบียนรับ : <kbd>ออกโดยระบบ</kbd></label>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="fas fa-user-secret"></i></span>
											<input type="text" class="form-control" name="sendfrom" id="sendfrom" placeholder="ระบุผู้ส่ง" required>
										</div>
									</div>
								</td>
							</tr>
							<?php
								$sql = "SELECT dep_name FROM  depart  WHERE dep_id = $dep_id ";
								$result = dbQuery($sql);
								$row =  dbFetchAssoc($result);
							?>
							<tr>
								<td colspan="3">
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="fas fa-user"></i></span>
											<input type="text" class="form-control" name="sendto" id="sendto" size="50" value="<?php echo $row['dep_name'];?>">
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="fas fa-list"></i></span>
											<input type="text" class="form-control" name="title" id="title" size="80" placeholder="เรื่องหนังสือ" required>
										</div>
									</div>
								</td>

							</tr>
							<tr>
								<td colspan="3">
									<div class="form-group">
										<div class="input-group col-xs-4">
											<span class="input-group-addon"><label>ลงวันที่</label></span>
											<input class="form-control" type="date" name="datepicker" id="datepicker" onKeyDown="return false" required>
										</div>
									</div>
								</td>
							</tr>
							<?php 
                                $sql="SELECT sec_id,sec_name FROM  section WHERE dep_id=$dep_id ORDER BY dep_id DESC";
                                $result=dbQuery($sql);
                            ?>
							<tr>
								<td colspan="3">
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><label>มอบให้กลุ่ม</label></span>
											<select class="form-control" id="remark" name="remark">
												<?php
												while ( $row = dbFetchArray( $result ) ) {?>
												<option value="<?php echo $row['sec_id']?>">
													<?php echo $row['sec_name']?>
												</option>
												<?php } ?>
											</select>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="fas fa-user"></i></span>
											<input type="text" class="form-control" name="practice" placeholder="ระบุเจ้าหน้าที่ผู้ปฏิบัติ" required>
										</div>
									</div>
								</td>
							</tr>
						</table><br>
						<center>
							<button class="btn btn-primary btn-lg" type="submit" name="save">
                                <i class="fa fa-save fa-2x"></i> บันทึก
                                <input id="yid" name="yid" type="hidden" value="<?php echo $yid; ?>"> 
                            </button>
						</center>
					</form>
				</div>
				<div class="modal-footer bg-primary">
					<button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
				</div>
			</div>
		</div>
	</div>
	<!-- End Model -->

</div> <!-- col-md-10 -->

<!-- Modal report -->
<div id="myReport" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content ">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><i class="fa fa-print"></i> รายงานทะเบียนหนังสือรับ</h4>
			</div>
			<div class="modal-body">
			    <center>
				<form class="form" role="form" id="form_other" name="form_other" method="POST" action="report/rep-flow-recive-depart.php" target="_blank">
					<div class="form-group">
						<div class="input-group col-xs-6">
							<span class="input-group-addon">เลือกวันที่</span>
							<input class="form-control" id="dateprint" name="dateprint" type="date" onKeyDown="return false">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span><label>เลือกช่วงเวลา [กรณีต้องการสั่งพิมพ์เป็นรอบเช้า/บ่าย]</label></span><br>
							ช่วงเช้า &nbsp<input class="radio-inline" type="radio" name="rep_time" value="1">08:30-12:00<br>
							ช่วงบ่าย &nbsp<input class="radio-inline" type="radio" name="rep_time" value="2">13:00-16:30
						</div>
					</div>
					<button type="submit" class="btn btn-danger"><i class="fas fa-print"></i>ตกลง</button>
					<input type="hidden" name="yid" value="<?php echo $yid?>">
					<input type="hidden" name="uid" value="<?php echo $uid?>">
					<input type="hidden" name="username" value="<?=$username?>">
				</form>
				</center>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<!-- end myReport -->

<!-- Modal report -->
<div id="myReport1" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content ">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><i class="fa fa-print"></i> รายงานทะเบียนหนังสือรับ [ตามช่วงเวลา]</h4>
			</div>
			<div class="modal-body">
				<form class="form-inline" role="form" id="form_other" name="form_other" method="POST" action="report/rep-flow-recive-depart-month.php" target="_blank">
					<span>วันที่เริ่มต้น</span>
					<input class="form-control" id="dateStart" name="dateStart" type="date">
					<span>วันที่สิ้นสุด</span>
					<input class="form-control" id="dateEnd" name="dateEnd" type="date">
					<button type="submit" class="btn btn-danger"><i class="fas fa-print"></i> ตกลง</button>
					<input type="hidden" name="yid" value="<?php echo $yid?>">
					<input type="hidden" name="uid" value="<?php echo $uid?>">
					<input type="hidden" name="username" value="<?=$username?>">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<!-- end myReport -->
<!--  modal แสงรายละเอียดข้อมูล -->
<div class="modal fade bs-example-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><i class="fa fa-info fa-2x"></i> รายละเอียด</h4>
			</div>
			<div class="modal-body no-padding">
				<div id="divDataview">

				</div>
			</div>
			<!-- modal-body -->
			<div class="modal-footer bg-primary">
				<button type="button" class="btn btn-danger" data-dismiss="modal">close X</button>
			</div>
		</div>
	</div>
</div>
</div>
<?php //include "footer.php"; ?>


<!-- ส่วนเพิ่มข้อมูล  -->
<?php
if ( isset( $_POST[ 'save' ] ) ) { //กดปุ่มบันทึกจากฟอร์มบันทึก


	$yid = $_POST[ 'yid' ]; //รหัสปีปัจจุบัน
	$book_no = $_POST[ 'book_no' ]; // หมายเลขประจำหนังสือ
	$title = $_POST[ 'title' ]; // เรื่อง   

	$sendfrom = $_POST[ 'sendfrom' ]; // ผู้ส่ง
	$sendto = $_POST[ 'sendto' ]; // ผู้รับ
	$practice = $_POST[ 'practice' ]; // ผู้ปฏิบัติ

	$dateout = $_POST[ 'datepicker' ]; // เอกสารลงวันที่
	$datein = date( 'Y-m-d' );
	$remark = $_POST[ 'remark' ];
	$time_stamp = date("H:i:s");

	//(1) เลือกข้อมูลเพื่อรันเลขรับ  โดยมีเงื่อนไขให้ตรงกับหน่วยงานของผู้ใช้ ###########################
	$sql = "SELECT rec_no FROM flow_recive_depart WHERE dep_id=$dep_id and yid=$yid  ORDER  BY cid DESC";
	//echo $sql;
	$result = dbQuery( $sql );
	$row = dbFetchArray( $result );
	$rec_no = $row[ 'rec_no' ];
	$rec_no++;


	$sql = "INSERT INTO flow_recive_depart(rec_no,book_no,title,sendfrom,sendto,practice,dateout,datein,dep_id,sec_id,u_id,yid,remark,time_stamp) 
            VALUES ($rec_no,'$book_no','$title','$sendfrom','$sendto','$practice','$dateout','$datein',$dep_id,$sec_id,$u_id,$yid,$remark,'$time_stamp')";                         
	$result = dbQuery( $sql );


	if ( $result ) {
		echo "<script>
            swal({
                title:'เรียบร้อย',
                type:'success',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='FlowResiveDepart.php';
                    }
                }); 
            </script>";
	} else {
		echo "<script>
            swal({
                title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
                type:'error',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='FlowResiveDepart.php';
                    }
                }); 
            </script>";
	}
}

include("footer.php");
?>


<!-- ส่วนนำข้อมูลไปแสดงผลบน Modal -->
<script type="text/javascript">
	function load_leave_data( cid, u_id ) {
		var sdata = {
			cid: cid,
			u_id: u_id
		};
		$( '#divDataview' ).load( 'show_flow_depart_detail.php', sdata );
	}
</script>