<!-- หนังสือรับถึงจังหวัด -->

<?php
include "header.php";
$u_id = $_SESSION[ 'ses_u_id' ];
$cid=$_GET["cid"];

$sql = "SELECT * FROM flow_recive_depart WHERE cid=$cid";
$result = dbQuery($sql);
$row=dbFetchAssoc($result);

?>
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
	<div class="panel panel-danger">
		<div class="panel-heading"><i class="fas fa-edit fa-2x" aria-hidden="true"></i> <strong>หนังสือรับหน่วยงาน [แก้ไข]</strong>
		</div>
		<div class="panel-body bg-info">
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
								<label for="date_in">วันที่ลงรับ:</label><input type="text" name="date_in" id="date_in" value="<?php print thaiDate($row['datein']);?>" disabled="">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">ทบ/รับ</span>
									<input class="form-control" type="text" name="book_no" id="book_no" value="<?php echo $row['rec_no']; ?>" disabled >
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
									<span class="input-group-addon">เลขที่หนังสือ</span>
									<input type="text" class="form-control" name="book_no" id="book_no" value="<?php echo $row['book_no'];?>">
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">ผู้ส่ง</span>
									<input type="text" class="form-control" name="sendfrom" id="sendfrom" value="<?php echo $row['sendfrom'];?>">
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon"> ผู้รับ</span>
									<input type="text" class="form-control" name="sendto" id="sendto" size="50"  value="<?php echo $row['sendto'];?>">
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">เรื่อง</span>
									<input type="text" class="form-control" name="title" id="title" size="80" value="<?php echo $row['title'];?>">
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<div class="form-group">
								<div class="input-group col-xs-4">
									<span class="input-group-addon">ลงวันที่</span>
									<input class="form-control" type="date" name="datepicker" id="datepicker" value=<?php echo $row['dateout'];?>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<div class="form-group">
								<div class="input-group col-xs-6">
									<span class="input-group-addon">มอบให้กลุ่ม</span>
									<select class="form-control" id="secid" name="secid">
										<?php
										$sql="SELECT * FROM  section WHERE dep_id=$dep_id ";
                        				$result=dbQuery($sql);
										while ( $row1 = dbFetchArray( $result ) ) {
											   $sec = $row['remark']; ?>
                                               <option <?php if($sec == $row1['sec_id']){ echo "selected";}?> value="<?php echo $row1['sec_id'];?>" > <?php echo $row1['sec_name'];?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<div class="form-group">
								<div class="input-group col-xs-6">
									<span class="input-group-addon">ผู้ปฏิบัติ</span>
									<input type="text" class="form-control" name="practice" id="practice" size="80" value="<?php  print $row['practice'];?>">
								</div>
							</div>
						</td>
					</tr>
				</table><br>
				<center>
					<button class="btn btn-primary" type="submit" name="save">
             			<i class="fa fa-save"></i> บันทึก
             			<input id="yid" name="yid" type="hidden" value="<?php echo $yid; ?>"> 
						<input id="cid" name="cid" type="hidden" value="<?php echo $cid; ?>">
           			</button>
					<a class="btn btn-danger" href="FlowResiveDepart.php"><i class="fas fa-undo"></i> ยกเลิก</a>
				</center>
			</form>
		</div>
		<div class="panel-footer bg-danger">
			<center><i class="fas fa-bullhorn"></i> ระบบอนุญาตให้แก้ไขเอกสารได้ภายในกำหนด 3 วัน</center>
		</div>
	</div>

<?php   //process
if(isset($_POST['save'])){
	$book_no = $_POST['book_no'];
	$sendfrom = $_POST['sendfrom'];
	$sendto = $_POST['sendto'];
	$title = $_POST['title'];
	$dateout = $_POST['datepicker'];
	$remark = $_POST['secid'];
	$practice = $_POST['practice'];
	$cid = $_POST['cid'];

	$sql = "UPDATE flow_recive_depart
			SET 
			   book_no = '$book_no',
			   title = '$title',
			   sendfrom = '$sendfrom',
			   sendto = '$sendto',
			   practice = '$practice',
			   dateout = '$dateout',
			   remark = $remark  
			WHERE
			   cid = $cid" ;
	$result = dbQuery($sql);
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
?>	