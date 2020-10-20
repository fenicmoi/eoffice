<!-- หนังสือรับกลุ่มงาน -->
<script type="text/javascript" src="datePicket.js"></script>
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
		<div class="panel-heading"><i class="fa fa-university fa-2x"></i> <strong>หนังสือรับกลุ่มงาน</strong>
			<div class="btn-group btn-grouop-lg pull-right">
				<a href="flow-resive-group.php" class="btn btn-default"><i class="fas fa-home"></i>หน้าแรก</a>
				<a href="" class="btn btn-default" data-toggle="modal" data-target="#modalAdd">
					<i class="fa fa-plus"></i> ลงทะเบียนรับ
        		</a>
			
				<div class="btn-group"></div>
				<button class="btn btn-default  dropdown-toggle" type="button" data-toggle="dropdown">
					<i class="fas fa-print"></i> รายงาน<span class="caret"></span>
				</button>
			
				<ul class="dropdown-menu">
					<li><a href="#" data-toggle="modal" data-target="#myReport"><i class="fas fa-calendar"></i> ประจำวัน</a></li>
					<li><a href="#" data-toggle="modal" data-target="#myReport1"><i class="fas fa-calendar-alt"></i> ตามช่วงเวลา</a></li>
				</ul>
				<a href="statis-flow-resive-group.php" class="btn btn-default"><i class="fas fa-chart-pie"></i>สถิติข้อมูล</a>
					<button id="hideSearch" class="btn btn-default"><i class="fas fa-search"></i>ค้นหา</button>
			</div>
		</div>
	</div>
	<table class="table table-bordered table-hover" id="tbRecive">
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
				<th>ผู้ปฏิบัติ</th>
				<th>สถานะ</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$count = 1;
			$sql = "SELECT fr.*,y.yname,u.firstname FROM flow_recive_group as fr 
                    INNER JOIN sys_year as y ON  y.yid=fr.yid 
                    INNER JOIN user as u ON u.u_id=fr.practice
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
                           window.history.back();
                         }
                    }); 
                  </script>";
				}

			} else { //กรณีโหลดเพจ หรือไม่มีการกดปุ่มใดๆ

				$sql .= " WHERE fr.sec_id=$sec_id ORDER BY fr.cid DESC";
			}

			$result = page_query( $dbConn, $sql, 10 );
			while ( $row = dbFetchArray( $result ) ) {?>
			<tr>
				<td> <?php echo $row['rec_no']; ?>/<?php echo $row['yname']; ?> </td>
				<td> <?php echo $row['book_no']; ?> </td>
			<?php
			 $cid=$row['cid']; 
			
			//check จำนวนวัน
			 $d1 = $row[ 'datein' ];
			 $d2 = date( 'Y-m-d' );
			 $numday = getNumDay( $d1, $d2 );
			 ?>
				<td>
					<?php if($numday > 3){?>
						<a class="text-success" href="#" onClick="load_leave_data('<?php print $cid;?>','<?php print $u_id; ?>');" data-toggle="modal" data-target=".bs-example-modal-table">
							<?php echo $row['title'];?>
						</a>
					<?php }else{?>
						<a class="text-primary" href="#" onClick="load_leave_data('<?php print $cid;?>','<?php print $u_id; ?>');" data-toggle="modal" data-target=".bs-example-modal-table">
						<?php echo $row['title'];?> <i class="fas fa-edit"></i>[แก้ไข]
					</a>
					<?php }?>
					
				</td>
				<td> <?php echo $row['firstname']; ?> </td>
				<td>
					<?php
					if ( $row[ 'status' ] == 0 ) { ?>
						<a class="btn btn-danger btn-block" href="?close=<?php echo $row['cid']; ?>"><i class="far fa-question-circle"></i></a>
					<?php }else{ ?>
						<a class="btn btn-warning btn-block" href="?open=<?php echo $row['cid']; ?>"><i class="far fa-thumbs-up"></i></a>
					<?php } ?>
				</td>
			</tr>

			<?php  } ?>
			<tr>
				<td colspan="6">
					<center>
						<?php 
								page_link_border("solid","1px","gray");
								page_link_bg_color("lightblue","pink");
								page_link_font("14px");
								page_link_color("blue","red");
								page_echo_pagenums(6,true); 
							?>
					</center>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="panel-footer">
		<center><kbd>1.คลิกปุ่มเพื่อเปลี่ยนสถานะ</kbd> ::<i class="far fa-question-circle"></i>=อยู่ระหว่างดำเนินการ::<i class="far fa-thumbs-up"></i>=ดำเนินการเสร็จแล้ว</center>
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
						<div class="form-group col-md-6">
							<div class="input-group">
								<span class="input-group-addon">ปีเอกสาร</span>
								<input class="form-control" name="yearDoc" type="text" value="<?php print $yname; ?>" disabled="">
							</div>
						</div>
						<div class="form-group col-md-4">
							<div class="input-group">
								<span class="input-group-addon">วันที่ลงรับ</span>
								<input class="form-control" type="text" name="date_in" id="date_in" value="<?php print DateThai();?>">
							</div>
						</div>
						<div class="form-group col-md-6">
							<div class="input-group">
								<span class="input-group-addon"><i class="fas fa-list-ol"></i></span>
								<input class="form-control" type="text" name="book_no" id="book_no" placeholder="เลขที่หนังสือ" required>
							</div>
						</div>
						<div class="form-group col-md-4">
							<div class="input-group">
								<span class="input-group-addon">ลงวันที่</span>
								<input class="form-control" type="date" name="datepicker" id="datepicker" required>
							</div>
						</div>
						<div class="form-group col-md-12">
							<div class="input-group">
								<span class="input-group-addon">เรื่อง</span>
								<input class="form-control" type="text" name="title" id="title" placeholder="เรื่องหนังสือ" required>
							</div>
						</div>
						<div class="form-group col-md-8">
							<div class="input-group">
								<span class="input-group-addon">ผู้ส่ง</span>
								<input class="form-control" type="text" name="sendfrom" id="sendto" placeholder="ระบุผู้รับหนังสือ">
							</div>
						</div>
						<div class="form-group col-md-8">
							<div class="input-group">
								<span class="input-group-addon">ผู้รับ</span>
								<input class="form-control" type="text" name="sendto" id="sendto" placeholder="ระบุผู้รับหนังสือ" value="ผู้ว่าราชการจังหวัดพังงา">
							</div>
						</div>

						<div class="form-group col-md-8">
							<div class="input-group">
								<span class="input-group-addon">เจ้าของเรื่อง</span>
								<input class="form-control" type="text" name="owner" id="owner" placeholder="ส่วนราชการเจ้าของเรื่อง" required>
							</div>
						</div>

						<?php
						$sql = "SELECT u_id,sec_id,dep_id,firstname FROM user WHERE sec_id=$sec_id";
						$result = dbQuery( $sql );
						?>
						<div class="form-group col-md-5">
							<div class="input-group">
								<span class="input-group-addon">ผู้ปฏิบัติ</span>
								<select class="form-control" name="practice">
									<?php
									while ( $row = dbFetchArray( $result ) ) {?>
									<option value="<?=$row['u_id']?>">
										<?php echo $row['firstname'];?>
									</option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-md-12">
							<center>
								<button class="btn btn-success" type="submit" name="save"><i class="fas fa-save"></i> บันทึก
                                        <input id="yid" name="yid" type="hidden" value="<?php echo $yid; ?>"> 
                                        </button>
								<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> ยกเลิก</button>
							</center>
						</div>
					</form>
				</div>
				<div class="modal-footer bg-info">
					<!-- <button type="button" class="btn btn-danger" data-dismiss="modal">X</button> -->
				</div>
			</div>

		</div>
	</div>
	<!-- End Model -->
</div>
<!-- col-md-10 -->

<!-- รายงานประจำวัน-->
<div id="myReport" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content ">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><i class="fa fa-print"></i> รายงานทะเบียนหนังสือรับ[กลุ่มงาน]</h4>
			</div>
			<div class="modal-body">
				<form class="form-inline" role="form" id="form_other" name="form_other" method="POST" action="report/rep-resive-group.php" target="_blank">
					<center>
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">เลือกวัน</span>
								<input class="form-control" id="dateprint" name="dateprint" type="date" value="<?=$pDate;?> ">
							</div>
						</div>
						<button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-search"></i>
              </button>
					
					</center>

					<input type="hidden" name="yid" value="<?=$yid?>">
					<input type="hidden" name="uid" value="<?=$uid?>">
					<input type="hidden" name="username" value="<?=$username?>">
				</form>
			</div>
			<div class="modal-footer bg-primary">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<!-- end myReport -->

<!-- รายงานตามช่วงเวลา-->
<div id="myReport1" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content ">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><i class="fa fa-print"></i> รายงานทะเบียนหนังสือรับ[กลุ่มงาน] ตามช่วงเวลา</h4>
			</div>
			<div class="modal-body">
				<form class="form-inline" role="form" id="form_other" name="form_other" method="POST" action="report/rep-resive-group-mount.php" target="_blank">
					<center>
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">วันเริ่มต้น</span>
								<input class="form-control" id="dateStart" name="dateStart" type="date">
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon">วันสิ้นสุด</span>
								<input class="form-control" id="dateStart" name="dateEnd" type="date">
							</div>
						</div>
						<button type="submit" class="btn btn-success btn-lg">
                   <i class="fas fa-search"></i>
               </button>
					
					</center>
					<input type="hidden" name="yid" value="<?php print $yid?>">
					<input type="hidden" name="uid" value="<?php print $uid?>">
					</td>
					<input type="hidden" name="username" value="<?=$username?>">
					</td>
				</form>
			</div>
			<div class="modal-footer bg-primary">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
					<!-- สวนสำหรับแสดงผลรายละเอียด   อ้างอิงกับไฟล์  show_command_detail.php -->
				</div>
			</div>
			<!-- modal-body -->
			<div class="modal-footer bg-primary">
				<button type="button" class="btn btn-danger" data-dismiss="modal">close X</button>
			</div>
		</div>
	</div>
</div>

<?php //include "footer.php"; ?>

<!-- Update  -->
<?php
if ( isset( $_POST[ 'update' ] ) ) { //กดปุ่มบันทึกจากฟอร์มบันทึก
	$cid = $_POST[ 'cid' ];
	$book_no = $_POST['book_no'];
	$title = $_POST['title'];
	$sendfrom = $_POST['sendfrom'];
	$sendto = $_POST['sendto'];
	$dateout = $_POST['dateout'];
	$datein = $_POST['datein'];
	$practice = $_POST['practice'];


	$sql = "UPDATE flow_recive_group 
			SET
				title = '$title',
				sendfrom = '$sendfrom',
				sendto = '$sendto',
				dateout = '$dateout',
				datein = '$datein',
				practice = $practice
			
			WHERE cid=$cid ";
	$result = dbQuery( $sql );

	if ( $result ) {
		echo "<script>
            swal({
                title:'Update เรียบร้อยแล้ว',
                type:'success',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='flow-resive-group.php';
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
                        window.location.href='flow-resive-group.php';
                    }
                }); 
            </script>";
	}
}

?>

<!-- ส่วนเพิ่มข้อมูล  -->
<?php
if ( isset( $_POST[ 'save' ] ) ) { //กดปุ่มบันทึกจากฟอร์มบันทึก
	$yid = $_POST[ 'yid' ]; //รหัสปีปัจจุบัน
	$book_no = $_POST[ 'book_no' ]; // หมายเลขประจำหนังสือ
	$title = $_POST[ 'title' ]; // เรื่อง   
	$owner = $_POST[ 'owner' ]; //ส่วนราชการเจ้าของเรื่อง 
	$sendfrom = $_POST[ 'sendfrom' ]; // ผู้ส่ง
	$sendto = $_POST[ 'sendto' ]; // ผู้รับ
	$practice = $_POST[ 'practice' ]; // ผู้ปฏิบัติ

	$dateout = $_POST[ 'datepicker' ]; // เอกสารลงวันที่
	$datein = date( 'Y-m-d' );

	//(1) เลือกข้อมูลเพื่อรันเลขรับ  โดยมีเงื่อนไขให้ตรงกับหน่วยงานของผู้ใช้ ###########################
	$sql = "SELECT rec_no FROM flow_recive_group WHERE dep_id=$dep_id and sec_id=$sec_id  and yid=$yid  ORDER  BY cid DESC";
	//echo $sql;
	$result = dbQuery( $sql );
	$row = dbFetchArray( $result );
	$rec_no = $row[ 'rec_no' ];
	$rec_no++;

	$sql = "INSERT INTO flow_recive_group(rec_no,book_no,title,owner,sendfrom,sendto,practice,dateout,datein,dep_id,sec_id,u_id,yid) 
                                    VALUES ($rec_no,'$book_no','$title','$owner','$sendfrom','$sendto','$practice','$dateout','$datein',$dep_id,$sec_id,$u_id,$yid)";
	//print $sql;              

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
                        window.location.href='flow-resive-group.php';
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
                        window.location.href='flow-resive-group.php';
                    }
                }); 
            </script>";
	}
}
?>
<?php
if ( isset( $_GET[ 'close' ] ) ) {
	$cid = $_GET[ 'close' ];
	$sql = "UPDATE  flow_recive_group SET status=1 WHERE cid=$cid";
	$result = dbQuery( $sql );
	echo "<script>
    swal({
     title:'เรียบร้อย',
     type:'success',
     showConfirmButton:true
     },
     function(isConfirm){
         if(isConfirm){
             window.location.href='flow-resive-group.php';
         }
     }); 
   </script>";
}

if ( isset( $_GET[ 'open' ] ) ) {
	$cid = $_GET[ 'open' ];
	$sql = "UPDATE  flow_recive_group SET status=0 WHERE cid=$cid";
	$result = dbQuery( $sql );
	echo "<script>
    swal({
     title:'เรียบร้อย',
     type:'success',
     showConfirmButton:true
     },
     function(isConfirm){
         if(isConfirm){
             window.location.href='flow-resive-group.php';
         }
     }); 
   </script>";
}
?>

<!-- ส่วนนำข้อมูลไปแสดงผลบน Modal -->
<script type="text/javascript">
	function load_leave_data( cid, u_id ) {
		var sdata = {
			cid: cid,
			u_id: u_id
		};
		$( '#divDataview' ).load( 'show_flow_group_detail.php', sdata );
	}
</script>