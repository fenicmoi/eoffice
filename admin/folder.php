<?php
date_default_timezone_set('Asia/Bangkok');
include "header.php";
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
<div class="col-md-2" >
 <?php
	$menu=  checkMenu($level_id);
	include $menu;
 ?>
</div>
 <div class="col-md-10">
	<div class="panel panel-primary">
        <div class="panel-heading"><i class="fas fa-share-square fa-2x"></i>  <strong>ส่งไฟล์เอกสาร </strong>
            <button id="hideSearch" class="btn btn-default pull-right"><i class="fas fa-search"> ค้นหา</i></button>
			<a href="folder.php" class="btn btn-default pull-right"><i class="fas fa-home"></i> หน้าหลัก</a>
        </div>
        <div class="panel-body">                  
            <ul class="nav nav-tabs">
                <li><a class="btn-danger fas fa-envelope"  href="paper.php"> จดหมายเข้า</a></li>
                <li class="active"><a class="btn-danger fas fa-envelope-open" href="folder.php"> รับแล้ว</a></li>
                <li><a class="btn-danger fas fa-history" href="history.php"> ส่งแล้ว</a></li>
                <li><a class="btn-danger fas fa-paper-plane" href="inside_all.php"> ส่งภายใน</a></li>
                <li><a class="btn-danger fas fa-globe" href="outside_all.php"> ส่งภายนอก</a></li>
            </ul>        
			<table class="table table-bordered table-hover" id="tbFolder">
				<thead>
					<tr bgcolor="black">
						<td colspan="8">
							<form class="form-inline" method="post" name="frmSearch" id="frmSearch">
								<div class="form-group">
									<select class="form-control" id="typeSearch" name="typeSearch">
										<option value="1"><i class="fas fa-star"></i>เลขหนังสือ</option>
										<option value="2" selected>เรื่อง</option>
									</select>
									<div class="input-group">
										<input class="form-control" id="search" name="search" type="text" size="80" placeholder="Keyword สั้นๆ">
										<div class="input-group-btn">
											<button class="btn btn-primary" type="submit" name="btnSearch" id="btnSearch"><i class="fas fa-search "></i></button>
										</div>
									</div>
								</div>
							</form>
						</td>
					</tr>
					<tr bgcolor="#C8C5C5">
						<th></th>
						<th>ที่</th>
						<th>เรื่อง</th>
						<th>วันที่เข้า</th>
						<th>วันที่รับ</th>
						<th>หน่วยส่ง</th>
						<th>กลุ่ม/กอง</th>
						<th>ผู้ส่ง</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sql="SELECT p.postdate,u.puid,u.pid,u.confirmdate,p.title,p.file,p.book_no,d.dep_name,s.sec_name,us.firstname FROM paperuser u
						INNER JOIN paper p ON p.pid=u.pid
						INNER JOIN depart d ON d.dep_id=p.dep_id
						INNER JOIN section s ON s.sec_id=p.sec_id
						INNER JOIN user us  ON us.u_id=p.u_id
						WHERE u.dep_id=$dep_id AND u.u_id=$u_id  AND u.confirm=1 ";
						if ( isset($_POST['btnSearch' ] ) ) { //ถ้ามีการกดปุ่มค้นหา
							@$typeSearch = $_POST[ 'typeSearch' ]; //ประเภทการค้นหา
							@$txt_search = $_POST[ 'search' ]; //กล่องรับข้อความ
								if ( @$typeSearch == 1 ) { //เลขที่หนังสือ
									$sql .= " AND p.book_no LIKE '%$txt_search%'   ORDER BY u.puid  DESC";
								}elseif( @$typeSearch == 2 ){ //ชื่อเรื่อง
										$sql .= " AND p.title LIKE '%$txt_search%'     ORDER BY u.puid  DESC";
								}
						}else{
							$sql .= " ORDER BY u.puid DESC";
						}
						$result = page_query( $dbConn, $sql, 10 );
						?>
						<?php                                    
							while($rowf = dbFetchArray($result)){?>
							<tr>
								<td><i class="far fa-envelope-open"></i></td>
								<td>
									<?php 
										if($rowf['book_no']==null){
											echo "...";
										}else{
											echo $rowf['book_no'];
										}
									?>
								</td>
								<td><a href="<?php echo $rowf['file'];?>" target="_blank"><?php echo $rowf['title']; ?></a></td>
								<td><?php echo thaiDate($rowf['postdate']); ?></td>
								<td><?php echo thaiDate($rowf['confirmdate']); ?></td>
								<td><?php echo $rowf['dep_name'];?></td>
								<td><?php echo $rowf['sec_name'];?></td>
								<td><?php echo $rowf['firstname']; ?></td>
							</tr>
						<?php } ?>
						</tbody>
			</table>
		</div> <!-- panel body -->
		<div class="panel-footer">
			<center>
				<a href="folder.php" class="btn btn-primary">
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
<script>
function checklist() {
    var myWindow = window.open("ddd", "ddd", "width=600,height=400");
}
</script>