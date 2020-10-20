<!-- หนังสือรับถึงจังหวัด -->
<?php
include "header.php";
$u_id = $_SESSION[ 'ses_u_id' ];
?>

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

<?php
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
<div class="col-md-10">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<i class="fas fa-university fa-2x" aria-hidden="true"></i> <strong>หนังสือรับ [ถึงจังหวัด]</strong>
					:::สำหรับหนังสือราชการที่ส่งถึง ผวจ
			<div class="btn-group pull-right">
					<a href="" class="btn btn-default" data-toggle="modal" data-target="#modalAdd"><i class="fa fa-plus "></i> ลงรับ</a>
				<div class="btn-group">
					<button class="btn btn-default  dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-print"></i> รายงาน      
                            <span class="caret"></span></button>
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
		<div class="panel-body">
			<table class="table table-bordered table-hover">
				<thead class="bg-info">
					<tr bgcolor="black">
						<td colspan="8">
							<form class="form-inline" method="post" name="frmSearch" id="frmSearch">
								<div class="form-group">
									<select class="form-control" id="typeSearch" name="typeSearch">
										<option value="1"><i class="fas fa-star"></i> เลขรับ</option>
										<option value="2">เลขส่ง</option>
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
						<th>เลขรับ</th>
						<th>เลขส่ง</th>
						<th>เรื่อง</th>
						<th>จาก</th>
						<th>ลงวันที่</th>
						<th>แก้ไข</th>
						<th>สถานะ</th>
					</tr>
				</thead>
				<tbody>
					<?php
						
					####ส่วนการแสดงผล
					$count = 1;
					$sql = "SELECT m.book_id,m.rec_id,m.dep_id,m.u_id,d.book_no,d.title,d.sendfrom,d.sendto,d.date_book,d.date_in,d.date_line,
					               d.practice,d.status,s.sec_code,y.yname
                  FROM book_master m
                  INNER JOIN book_detail d ON d.book_id = m.book_id
                  INNER JOIN section s ON s.sec_id = m.sec_id 
                  INNER JOIN sys_year y ON y.yid = m.yid ";

					
					//กรณีมีการกดปุ่มค้นหา
					if ( isset( $_POST[ 'btnSearch' ] ) ) { //ถ้ามีการกดปุ่มค้นหา
						@$typeSearch = $_POST[ 'typeSearch' ]; //ประเภทการค้นหา
						@$txt_search = $_POST[ 'search' ]; //กล่องรับข้อความ
						@$dateStart = $_POST[ 'dateStart' ];
						@$dateEnd = $_POST[ 'dateEnd' ];

						if ( @$typeSearch == 1 ) { //ทะเบียนรับ
							if($level_id <= 2){
								$sql .= " WHERE m.rec_id LIKE '%$txt_search%'  ORDER BY m.book_id  DESC";
							}else{
								$sql .= " WHERE m.rec_id LIKE '%$txt_search%'  AND m.dep_id=$dep_id  ORDER BY m.book_id  DESC";
							}
						} elseif ( @$typeSearch == 2 ) { //เลขหนังสือ
							if($level_id <=2){
								$sql .= " WHERE d.book_no LIKE '%$txt_search%'  ORDER BY m.book_id DESC ";
							}else{
								$sql .= " WHERE d.book_no LIKE '%$txt_search%'   AND m.dep_id=$dep_id  ORDER BY m.book_id DESC ";
							}
						} elseif ( @$typeSearch == 3 ) { //เรื่อง
							if($level_id <=2){
								$sql .= " WHERE d.title LIKE '%$txt_search%'  ORDER BY m.book_id DESC ";
							}else{
								$sql .= " WHERE d.title LIKE '%$txt_search%'   AND m.dep_id=$dep_id  ORDER BY m.book_id DESC ";
							}
						} elseif ( @$typeSearch == 4 ) { //ตามเวลา
							if($level_id <= 2){
								$sql .= " WHERE  (d.date_book BETWEEN '$dateStart' AND '$dateEnd')  ORDER BY m.book_id DESC ";
							}else{
								$sql .= " WHERE  (d.date_book BETWEEN '$dateStart' AND '$dateEnd') AND m.dep_id=$dep_id  ORDER BY m.book_id DESC ";
							}
						}

						//$result=dbQuery($sql);
						$result = page_query( $dbConn, $sql, 100 );
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
                                                            window.location.href='flow-resive-province.php';
                                                        }
                                                    }); 
                                                </script>";
						}

					} else { //กรณีโหลดเพจ หรือไม่มีการกดปุ่มใดๆ
						switch ( $level_id ) {
							case 1: //admin
								$sql .= " WHERE m.type_id=1 ORDER BY m.book_id DESC ";
								break;
							case 2: //สารบรรณจังหวัด    ดูได้ทั้งจังหวัด
								$sql .= " WHERE m.type_id=1 ORDER BY m.book_id DESC ";
								break;
							case 3: //สารบรรณหน่วยงาน  ดูได้ทั้งหน่วยงาน
								$sql .= " WHERE m.type_id=1 AND m.dep_id=$dep_id ORDER BY m.book_id DESC  ";
								break;
							case 4: //สารบรรณกลุ่มงาน  ดูได้ทั้งหน่วย  แต่แก้ไม่ได้
								$sql .= " WHERE m.type_id=1 AND m.dep_id=$dep_id ORDER BY m.book_id DESC  ";
								break;
							case 5: //สารบรรณกลุ่มงาน  ดูได้เฉพาะของตนเอง
								$sql .= " WHERE m.type_id=1 AND m.dep_id=$dep_id AND m.u_id=$u_id ORDER BY m.book_id DESC  ";
								break;
						}
						
						$result = page_query( $dbConn, $sql, 10 );
					}
					
					while ( $row = dbFetchArray( $result ) ) {
						?>
					<?php $rec_id=$row['rec_id']; ?>
					<!-- กำหนดตัวแปรเพื่อส่งไปกับลิงค์ -->
					<?php $book_id=$row['book_id']; ?>
					<!-- กำหนดตัวแปรเพื่อส่งไปกับลิงค์ -->
					<tr>
						<td>
							<?php echo $row['rec_id']; ?>/<?php echo $row['yname'];?>
						</td>
						<td>
							<?php echo $row['book_no']; ?>
						</td>
						<td>
							<a href="#" onclick="load_leave_data('<?php print $u_id;?>','<?php print $rec_id; ?>','<?php print $book_id; ?>');" data-toggle="modal" data-target=".bs-example-modal-table">
								<?php echo $row['title'];?>
							</a>

						</td>
						<td>
							<?php echo $row['sendfrom']; ?>
						</td>
						<td>
							<?php echo thaiDate($row['date_book']); ?>
						</td>
						<!--  ส่วนตรวจสอบจำนวนวันที่กำหนดให้แก้ไขได้ไม่เกิน 7 วัน  -->
						<?php
						$d1 = $row[ 'date_in' ];
						$d2 = date( 'Y-m-d' );
						$numday = getNumDay( $d1, $d2 );
						?>
						<td>
							<?php 
							 if($level_id>3){
								  echo '<i class="fas fa-ban"></i>ไม่มีสิทธิ์';
							 }else{
								  if($numday >= $dayEdit){  //$dayEdit เอามาจากค่า config
										echo '<i class="fab fa-expeditedssl fa-2x"></i>';
									}else{
										echo '<a href="show_resive_province_edit.php?book_id='.$book_id.'"><i class="btn btn-info fas fa-edit"></i></a>';
									}
							 }
						  ?>
						</td>
						<td>
							<?php 
                if($row['status']==0){
                   echo "<i class='btn btn-danger fa fa-envelope'></i>";
                }else if($row['status']==1){
                   echo "<i class='btn btn-success fa fa-envelope-open'></i>";
                }else{
                   echo "<i class='btn btn-warning fa fa-reply'></i>";
                }
              ?>
						</td>
					</tr>

					<?php } ?>
					<tr>
						<td colspan="8">
							<center>
								<a href="flow-resive-province.php" class="btn btn-primary"><i class="fas fa-home"></i></a>
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


		</div>
		<!-- panal-body -->
		<div class="panel-footer">
			<kbd>หมายเหตุ >></kbd> <i class='btn btn-danger fa fa-envelope'></i >รอรับ  
                       <i class='btn btn-success fa fa-envelope-open'></i>รับแล้ว
			<i class='btn btn-warning fa fa-reply'></i>ส่งคืน
			<i class="fab fa-expeditedssl fa-2x"></i>เกินกำหนดแก้ไข (3 วัน)
		</div>
		<!-- footer -->
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
										<div class="input-group">
											<span class="input-group-addon"><i class="far fa-calendar-alt"></i> ปีเอกสาร</span>
											<input class="form-control" name="yearDoc" type="text" value="<?php print $yname; ?>" disabled="">
										</div>
									</div>
								</td>
								<td>
								</td>
								<td>
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="far fa-calendar-alt"></i> วันที่ลงรับ</span>
											<input class="form-control" type="text" name="date_in" id="date_in" value="<?php print DateThai();?>">
										</div>
									</div>
								</td>
								<td>

								</td>
							</tr>
							<tr>
								<td colspan="2">
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="fas fa-folder"></i> ประเภทหนังสือ</span>
											<input name="typeDoc" type="radio" value="1" checked=""> ปกติ
											<input name="typeDoc" type="radio" value="2"> เวียน
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<div class="form-group">
										<div class="input-group col-xs-8 ">
											<span class="input-group-addon">เลขที่เอกสาร</span>
											<input class="form-control" type="text" name="book_no" id="book_no" required>
										</div>
									</div>
								</td>
							</tr>
							<?php
							//ชั้นความเร็ว
							$sql = "SELECT * FROM speed ORDER BY speed_id";
							$result = dbQuery( $sql );
							?>
							<td>
								<div class="form-group">
									<div class="input-group col-xs-4 ">
										<span class="input-group-addon"><i class="fas fa-space-shuttle"></i> ชั้นความเร็ว</span>
										<select name="speed_id" id="speed_id">
											<?php 
                                                        while ($rowSpeed= dbFetchArray($result)){
                                                            echo "<option  value=".$rowSpeed['speed_id'].">".$rowSpeed['speed_name']."</option>";
                                                    }?>
										</select>
									</div>
								</div>
							</td>
							<?php
							//ชั้นความลับ
							$sql = "SELECT * FROM priority ORDER BY pri_id";
							$result = dbQuery( $sql );
							?>
							<td>
								<div class="form-group">
									<div class="input-group col-xs-4 ">
										<span class="input-group-addon"><i class="fas fa-user-secret"></i> ชั้นความลับ</span>
										<select name="pri_id" id="pri_id">
											<?php
											while ( $rowSecret = dbFetchArray( $result ) ) {
												echo "<option value=" . $rowSecret[ 'pri_id' ] . ">" . $rowSecret[ 'pri_name' ] . "</option>";
											}
											?>
										</select>
									</div>
								</div>
							</td>
							<td>
								<?php
								//วัตถุประสงค์
								$sql = "SELECT * FROM object ORDER BY obj_id";
								$result = dbQuery( $sql )
								?>
								<div class="form-group">
									<div class="input-group col-xs-4 ">
										<span class="input-group-addon"><i class="fas fa-crosshairs"></i> วัตถุประสงค์</span>
										<select name="obj_id" required>
											<?php 
                                                    while ($row= dbFetchArray($result)){
                                                        echo "<option  value=".$row['obj_id'].">".$row['obj_name']."</option>";
                                                }?>
										</select>
									</div>
								</div>
							</td>
							<tr>
								<td colspan="3">
									<div class="form-group">
										<div class="input-group col-xs-8 ">
											<span class="input-group-addon"><i class="fas fa-user"></i> ผู้ส่ง</span>
											<input class="form-control" type="text" name="sendfrom" id="sendfrom" size="50" require placeholder="ระบุผู้ส่ง" required>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<div class="form-group">
										<div class="input-group col-xs-8 ">
											<span class="input-group-addon"><i class="far fa-user"></i> ผู้รับ</span>
											<input class="form-control" type="text" name="sendto" id="sendto" placeholder="ระบุผู้รับหนังสือ" value="ผู้ว่าราชการจังหวัดพังงา">
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<div class="form-group">
										<div class="input-group col-xs-12 ">
											<span class="input-group-addon"><i class="far fa-user"></i> เรื่อง</span>
											<input class="form-control" type="text" name="title" id="title" size="80" placeholder="เรื่องหนังสือ" required>
										</div>
									</div>
								</td>

							</tr>
							<tr>
								<td colspan="3">
									<div class="form-group">
										<div class="input-group col-xs-12 ">
											<span class="input-group-addon"><i class="fas fa-university"></i> เจ้าของเรื่อง</span>
											<input class="form-control" type="text" name="owner" id="owner" size="80" placeholder="หน่วยงานผู้ออกหนังสือ" required>
										</div>
									</div>
								</td>

							</tr>
							<tr>
								<td colspan="3">
									<div class="form-group">
										<div class="input-group col-xs-6 ">
											<span class="input-group-addon"><i class="far fa-calendar"></i> ลงวันที่</span>
											<input class="form-control bg-danger" type="date" name="date_book" id="date_book" onKeyDown="return false" required>
											<span class="input-group-addon"><i class="fas fa-exclamation-triangle"></i>กดเลือกปฏิทิน</span>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<div class="form-group">
										<div class="input-group col-xs-12 ">
											<span class="input-group-addon"><i class="fas fa-share-alt"></i> อ้างถึง</span>
											<input class="form-control" type="text" name="refer" id="refer" value="-">
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<div class="form-group">
										<div class="input-group col-xs-12 ">
											<span class="input-group-addon"><i class="fab fa-wpforms"></i> สิ่งที่ส่งมาด้วย</span>
											<input class="form-control" type="text" name="attachment" value="-">
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<div class="form-group">
										<div class="input-group col-xs-8">
											<span class="input-group-addon"><i class="fab fa-wpforms"></i> หน่วยปฏิบัติ</span>
											 <select name="dep_id" id="dep__id" class="selectpicker" data-live-search="true" title="โปรดระบุ" required >
												<?php
													$sql_dep ="SELECT dep_id,dep_name FROM depart";
													$result_dep = dbQuery($sql_dep);
													while ($row_dep = dbFetchArray($result_dep)) {?>
														<option value="<?php echo $row_dep['dep_id'];?>">
															<?php echo $row_dep['dep_name'];?>
														</option>
											<?php }?>
											</select>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<label>อื่นๆ :</label>
									<input type="checkbox" name="follow" id="follow" value="1" checked> ติดตามผลการดำเนินงาน
									<input type="checkbox" name="open" id="open" value="1" checked> เปิดเผยแก่บุคคลทั่วไป
								</td>
							</tr>
						</table><br>
						<center>
							<button class="btn btn-success" type="submit" name="save">
                                    <i class="fa fa-database"></i> ตกลง
                                    <input id="u_id" name="u_id" type="hidden" value="<?php echo $u_id; ?>"> 
                                    <input id="sec_id" name="u_id" type="hidden" value="<?php echo $sec_id; ?>"> 
                                    <input id="dep_id" name="u_id" type="hidden" value="<?php echo $dep_id; ?>"> 
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

<!-- Modal report 1  -->
<div id="myReport" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content ">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><i class="fa fa-print"></i> รายงานทะเบียนหนังสือรับ</h4>
			</div>
			<div class="modal-body">
				<form class="form-inline" role="form" id="form_other" name="form_other" method="POST" action="report/rep-resive-province.php" target="_blank">
					<span>เลือกวันที่</span>
					<input class="form-control" id="dateprint" name="dateprint" type="date">
					<button type="submit" class="btn btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-floppy-saved"></span>&nbspตกลง
                                </button>
				


					<input type="hidden" name="yid" value="<?=$yid?>">
					<input type="hidden" name="uid" value="<?=$uid?>">

					</td>
					<input type="hidden" name="username" value="<?=$username?>">
					</td>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<!-- end myReport -->

<!-- Modal report 2  -->
<div id="myReport1" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content ">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><i class="fa fa-print"></i> รายงานทะเบียนหนังสือรับ [ตามช่วงเวลา]</h4>
			</div>
			<div class="modal-body">
				<form class="form-inline" role="form" id="form_other" name="form_other" method="POST" action="report/rep-resive-province-mount.php" target="_blank">
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
								<input class="form-control" id="dateEnd" name="dateEnd" type="date">
							</div>
						</div>
						<button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-search"></i>
                        </button>
					

					</center>
					<input type="hidden" name="yid" value="<?=$yid?>">
					<input type="hidden" name="uid" value="<?=$uid?>">
					</td>
					<input type="hidden" name="username" value="<?=$username?>">
					</td>
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
				<h4 class="modal-title"><i class="fa fa-info"></i> รายละเอียด</h4>
			</div>
			<div class="modal-body no-padding">
				<div id="divDataview">
					<!-- สวนสำหรับแสดงผลรายละเอียด   อ้างอิงกับไฟล์  show_command_detail.php -->
				</div>
			</div>
			<!-- modal-body -->
			<div class="modal-footer bg-primary">
				<button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
			</div>
		</div>
	</div>
</div>
</div>
<?php //include "footer.php"; ?>


<!-- ส่วนเพิ่มข้อมูล  -->
<?php
if ( isset( $_POST[ 'save' ] ) ) { //กดปุ่มบันทึกจากฟอร์มบันทึก

	//#######  ข้อมูลสำหรับตาราง book_master ########################################
	$type_id = 1; //ชนิดของหนังสือ  1  หนังสือรับ-ถึงจังหวัด
	/*$dep_id=$_SESSION['dep_id'];     //รหัสหน่วยงาน   รับค่ามาจาก session จาก header แล้ว
	$sec_id=$_SESSION['sec_id'];       //รหัสกลุ่มงาน  */
	$uid = $_POST[ 'u_id' ]; //รหัสผู้ใช้
	$obj_id = $_POST[ 'obj_id' ]; //รหัสวัตถุประสงค์
	$pri_id = $_POST[ 'pri_id' ]; //รหัสชั้นความลับ
	$yid = $_POST[ 'yid' ]; //รหัสปีปัจจุบัน
	$typeDoc = $_POST[ 'typeDoc' ]; //รหัสประเภทหนังสือ   1ปกติ 2 เวียน
	$speed_id = $_POST[ 'speed_id' ];

	//(1) เลือกข้อมูลเพื่อรันเลขรับ  โดยมีเงื่อนไขให้ตรงกับหน่วยงานของผู้ใช้ ###########################
	$sql = "SELECT rec_id FROM book_master WHERE   yid=$yid  ORDER BY book_id DESC LIMIT 1";
	//print $sql;
	$result = dbQuery( $sql );
	$rowRun = dbFetchArray( $result );
	$rec_id = $rowRun[ 'rec_id' ];
	if ( $rec_id == 0 ) {
		$rec_id = 1;
	} else {
		$rec_id++;
	}



	// ##### ตาราง book_master

	$sql = "SHOW TABLE STATUS LIKE 'book_master'"; //ส่วนหา ID ล่าสุด
	$result = dbQuery( $sql );
	$row = dbFetchAssoc( $result );
	$book_id = ( int )$row[ 'Auto_increment' ];

	//#######  ข้อมูลสำหรับตาราง book_detail  #########################################
	// $book_id=dbInsertId($dbConn);  //เลือก ID ล่าสุดจากตาราง book_master
	$book_no = $_POST[ 'book_no' ]; // หมายเลขประจำหนังสือ
	$title = $_POST[ 'title' ]; // เรื่อง   
	$owner = $_POST[ 'owner' ]; // เจ้าของเรื่อง
	$date_in = date( 'Y-m-d' ); //วันที่ลงรับ
	$date_book = $_POST[ 'date_book' ]; // เอกสารลงวันที่
	$sendfrom = $_POST[ 'sendfrom' ]; // ผู้ส่ง
	$sendto = $_POST[ 'sendto' ]; // ผู้รับ
	$refer = $_POST[ 'refer' ]; // อ้างถึง

	$follow = $_POST[ 'follow' ]; // ติดตามหนังสือ
	$publice_book = $_POST[ 'open' ]; // เปิดเผยหนังสือ
	$attachment = $_POST[ 'attachment' ]; //เอกสารแนบ

	// $practice=$_POST['toSomeOneUser'];         // ผู้ปฏิบัติ
	$practice = $_POST[ 'dep_id' ];


	// $fileupload=$_REQUEST['fileupload'];  //การจัดการ fileupload
	@$fileupload = $_POST[ 'fileupload' ];
	@$upload = $_FILES[ 'fileupload' ]; //เพิ่มไฟล์


	if ( $upload != '' ) {

		$date = date( 'Y-m-d' ); //กำหนดรูปแบบวันที่
		$numrand = ( mt_rand() ); //สุ่มตัวเลข
		$part = "recive-to-province/"; //โฟลเดอร์เก็บเอกสาร
		$type = strrchr( $_FILES[ 'fileupload' ][ 'name' ], "." ); //เอาชื่อเก่าออกให้เหลือแต่นามสกุล
		$newname = $date . $numrand . $type; //ตั้งชื่อไฟล์ใหม่โดยใช้เวลา
		$part_copy = $part . $newname;
		$part_link = "recive-to-province/" . $newname;
		move_uploaded_file( $_FILES[ 'fileupload' ][ 'tmp_name' ], $part_copy ); //คัดลอกไฟล์ไป Server
	} else {
		$part_copy = '';
	}

	$datelout = date( 'Y-m-d H:i:s' );


	//transection
	dbQuery( 'BEGIN' );

	$sql = "INSERT INTO book_master (rec_id,type_id,dep_id,sec_id,u_id,obj_id,pri_id,yid,typeDoc,speed_id) 
                      VALUES ($rec_id,$type_id,$dep_id,$sec_id,$u_id,$obj_id,$pri_id,$yid,$typeDoc,$speed_id)";
	$result1 = dbQuery( $sql );

	$date_line = date( 'Y-m-d H:i:s' );
	$sql = "INSERT INTO book_detail (book_id,book_no,title,owner,sendfrom,sendto,reference,attachment,date_book,date_in,practice,follow,publice_book,status,date_line,file_upload)
                               VALUES($book_id,'$book_no','$title','$owner','$sendfrom','$sendto','$refer','$attachment','$date_book','$date_in','$practice','$follow','$publice_book',0,'$date_line','$part_copy')";
	// echo $sql;
	$result2 = dbQuery( $sql );

	if ( $result1 && $result2 ) {
		dbQuery( "COMMIT" );
		echo "<script>
            swal({
                title:'เรียบร้อย',
                type:'success',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='flow-resive-province.php';
                    }
                }); 
            </script>";
	} else {
		dbQuery( "ROLLBACK" );
		echo "<script>
            swal({
                title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
                type:'error',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='flow-resive-province.php';
                    }
                }); 
            </script>";
	}
}


//กรณีลงรับหนังสือ
/*if(isset($_POST['resive'])){
   $book_detail_id = $_POST['book_detail_id'];
    $date=date('Y-m-d');
   $sql="UPDATE book_detail SET date_line='$date',status=1 WHERE book_detail_id=$book_detail_id";  //1 ยอมรับหนังสือ
   //echo $sql;
       $result=dbQuery($sql);
        if($result){
           echo "<script>
           swal({
               title:'ลงทะเบียนรับเรียบร้อยแล้ว',
               type:'success',
               showConfirmButton:true
               },
               function(isConfirm){
                   if(isConfirm){
                       window.location.href='flow-resive-province.php';
                   }
               }); 
           </script>";
       }else{
           echo "<script>
           swal({
               title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
               type:'error',
               showConfirmButton:true
               },
               function(isConfirm){
                   if(isConfirm){
                       window.location.href='flow-resive-province.php';
                   }
               }); 
           </script>";
       } 
}*/


//กรณีส่งคืนหนังสือ
/*if(isset($_POST['reply'])){
    $book_detail_id = $_POST['book_detail_id'];
    $date=date('Y-m-d');
    $sql="UPDATE book_detail SET date_line='$date', status=2 WHERE book_detail_id=$book_detail_id";  //1 ยอมรับหนังสือ
    //echo $sql;
        $result=dbQuery($sql);
         if($result){
            echo "<script>
            swal({
                title:'ส่งคืนหนังสือแล้ว',
                type:'success',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='flow-resive-province.php';
                    }
                }); 
            </script>";
        }else{
            echo "<script>
            swal({
                title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
                type:'error',
                showConfirmButton:true
                },
                function(isConfirm){
                    if(isConfirm){
                        window.location.href='flow-resive-province.php';
                    }
                }); 
            </script>";
        }    
 }
*/

?>


<!-- ส่วนนำข้อมูลไปแสดงผลบน Modal -->
<script type="text/javascript">
	function load_leave_data( u_id, rec_id, book_id ) {
		var sdata = {
			u_id: u_id,
			rec_id: rec_id,
			book_id: book_id
		};
		$( '#divDataview' ).load( 'show_resive_province_detail.php', sdata );
	}
</script>



<script type="text/javascript">
	function make_autocom( autoObj, showObj ) {
		var mkAutoObj = autoObj;
		var mkSerValObj = showObj;
		new Autocomplete( mkAutoObj, function () {
			this.setValue = function ( id ) {
				document.getElementById( mkSerValObj ).value = id;
				// ถ้ามี id ที่ได้จากการเลือกใน autocomplete 
				if ( id != "" ) {
					// ส่งค่าไปคิวรี่เพื่อเรียกข้อมูลเพิ่มเติมที่ต้องการ โดยใช้ ajax 
					$.post( "g_fulldata.php", {
						id: id
					}, function ( data ) {
						if ( data != null && data.length > 0 ) { // ถ้ามีข้อมูล
							// นำข้อมูลไปแสดงใน textbox ที่่เตรียมไว้
							$( "#province_id" ).val( data[ 0 ].id );
							$( "#province_name_th" ).val( data[ 0 ].name_th );
						}
					} );
				} else {
					// ล้างค่ากรณีไม่มีการส่งค่า id ไปหรือไม่มีการเลือกจาก autocomplete
					$( "#province_id" ).val( "" );
					$( "#province_name_th" ).val( "" );
				}
			}
			if ( this.isModified )
				this.setValue( "" );
			if ( this.value.length < 1 && this.isNotClick )
				return;
			return "gdata.php?q=" + encodeURIComponent( this.value );
		} );
	}

	// การใช้งาน
	// make_autocom(" id ของ input ตัวที่ต้องการกำหนด "," id ของ input ตัวที่ต้องการรับค่า");
	make_autocom( "show_province", "h_province_id" );
</script>
<?php mysqli_close($dbConn); ?>