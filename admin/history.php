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
                <li><a class="btn-danger fas fa-envelope-open" href="folder.php"> รับแล้ว</a></li>
                <li class="active"><a class="btn-danger fas fa-history" href="history.php"> ส่งแล้ว</a></li>
                <li><a class="btn-danger fas fa-paper-plane" href="inside_all.php"> ส่งภายใน</a></li>
                <li><a class="btn-danger fas fa-globe" href="outside_all.php"> ส่งภายนอก</a></li>
            </ul> 
			<table class="table table-bordered table-hover" id="tbHistory">
			<thead>
				<tr bgcolor="black">
					<td colspan="5">
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
					<th>วันที่ส่ง</th>
					<th>ตรวจสอบ</th>
					<th>แก้ไข</th>
					<th>ยกเลิก</th>
				</tr>
			</thead>
			<tbody>
<?php
$sql = "SELECT * FROM  paper WHERE sec_id=$sec_id ";

if ( isset($_POST['btnSearch' ] ) ) {
	//ถ	้ามีการกดปุ่มค้นหา
	@$typeSearch = $_POST[ 'typeSearch' ];
	//ป	ระเภทการค้นหา
	@$txt_search = $_POST[ 'search' ];
	//ก	ล่องรับข้อความ
	if ( @$typeSearch == 1 ) {
		//เลขหนังสือ
		$sql .= " AND book_no LIKE '%$txt_search%'   ORDER BY pid  DESC";
		
	}
	elseif( @$typeSearch == 2 ){
		//ช		ื่อเรื่อง
		$sql .= " AND title LIKE '%$txt_search%'     ORDER BY  pid DESC";
		
	}
	
}
else{
	
	$sql .= " ORDER BY pid DESC";
	
}

//print $sql;

$result = page_query( $dbConn, $sql, 10 );

$numrow = dbNumRows( $result );

while ( $rowList = dbFetchArray( $result ) ) {
	
	
	?>
		<tr>
			<td><i class="fas fa-bullseye"></i></td>
            <td>
				<?php 
					if($rowList['book_no']==null){
						echo "...";
					}else{
						echo $rowList['book_no'];
					}
				?>
			</td>
			<td>
				<a href="<?php print $rowList['file'];?>" target="_blank">
					<?php echo $rowList['title'];?>
				</a>
			</td>
			<td><?php echo thaiDate($rowList['postdate']);?></td>
			<td><a href="checklist.php?pid=<?php echo $rowList['pid'];?>" class="btn btn-warning" target="_blank"><i class="fab fa-wpexplorer"></i> ติดตาม</a></td>
			<?php
			$d1 = $rowList['postdate'];
			$d2 = date('Y-m-d');
			$numday = getNumDay($d1,$d2);

			//กำหนดให้แก้ไขได้ 1 วันเท่านั้น
			if ($numday > 1) {?>       
				<td><center><i class="fab fa-expeditedssl fa-2x"></i></center></td>
			<? }else{
				if($rowList['insite']==1){?>
				  <td><a class="btn btn-info" href="inside_all_edit.php?pid=<?=$rowList['pid']?>"><i class="fas fa-edit"></i>แก้ไข</a></td>
				<?}else if($rowList['outsite']==1){?>
				  <td><a class="btn btn-info" href="outside_all_edit.php?pid=<?=$rowList['pid']?>"><i class="fas fa-edit"></i>แก้ไข</a></td>
				<?}?>
				
			<? } ?>
			<td>
			    <?php if($numday > 1){?>
					<center><i class="fab fa-expeditedssl fa-2x"></i></center>
				<?}else{?>
					<a class="btn btn-default" href="in_out_del.php?pid=<?=$rowList['pid'];?>" onclick="return confirm('คุณกำลังจะลบข้อมูล !'); "> <i class="fas fa-trash-alt"></i> ยกเลิก</a>
				<?}?>
				
			</td>
		</tr>
		<?php
}

?>
	</tbody>
</table>
</div> <!--panel-body-->
<div class="panel-footer">
			<center>
				<a href="history.php" class="btn btn-primary">
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
</div> <!-- panel primary -->
</div> <!--col-md-10-->

<?php
$del=$_GET['del'];
if(isset($del)){
echo "<script> alert('hello');</script>";
}
	
?>