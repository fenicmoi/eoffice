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
	<?php
	$curdate = date( 'Y-m-d' );
	//เอกสารรับวันนี้
	$sql = "SELECT cid FROM flow_recive_group WHERE datein ='" . $curdate . "' AND sec_id=" . $sec_id;
	$result = dbQuery( $sql );
	$today = dbNumRows( $result );

	//เอกสารรับสับดาห์นี้
	$date = new DateTime( $curdate );
	$week = $date->format( "W" );
	$sql = "SELECT cid,datein FROM flow_recive_group WHERE sec_id=$sec_id AND WEEKOFYEAR(datein)=$week";
	$result = dbQuery( $sql );
	$toWeek = dbNumRows( $result );

	//เอกสารรับเดือนนี้
	$month = $date->format( "n" );
	$sql = "SELECT cid,datein FROM flow_recive_group WHERE sec_id=$sec_id AND MONTH(datein)=$month";
	$result = dbQuery( $sql );
	$toMonth = dbNumRows( $result );

	//เอกสารปีนี้
	$year = $date->format( 'Y' );
	$sql = "SELECT cid,datein FROM flow_recive_group WHERE sec_id=$sec_id AND YEAR(datein)";
	$result = dbQuery( $sql );
	$toYear = dbNumrows( $result );




	?>
</div>
<div class="col-md-10">
	<div class="panel-group">
		<div class="panel panel-success">
			<div class="panel-heading"><i class="fas fa-chart-pie fa-2x"></i> หนังสือเข้า</div>
			<div class="panel-body">
				<div class="col-md-2">
					<div class="card bg-danger">
						<i class=" fas fa-calendar-check fa-2x"></i>
						<h2 style="color: blue">
							<?php print $today;?>
						</h2>
						<h4>วันนี้</h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="card bg-danger">
						<i class="fas fa-calendar-alt fa-2x"></i>
						<h2 style="color: blue">
							<?php print $toWeek;?>
						</h2>
						<h4>สัปดาห์นี้</h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="card bg-danger">
						<i class="fas fa-calendar-plus fa-2x"></i>
						<h2 style="color: blue">
							<?php print $toMonth;?>
						</h2>
						<h4>เดือนนี้</h4>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card bg-danger">
						<i class="fab fa-font-awesome-flag  fa-2x"></i>
						<h2 style="color: blue">
							<?php print $toYear;?>
						</h2>
						<h4>ปีนี้</h4>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-success">
			<div class="panel-heading"></div>
			<div class="panel-body">
				<div class="col-md-4">
					<fieldset>
						<legend>
							<h5>ประมาณหนังสือเข้าย้อนหลัง</h5>
						</legend>
						<form class="form-inline">
							<div class="input-group col-md-8">
								<span class="input-group-addon">เดือน</span>
								<select name="repMonth" id="repMonth" class="form-control">
									<option value="">กรกฎาคม</option>
								</select>
							</div>
							<div class="input-group">
								<span class="input-group-addon">ปี</span>
								<select name="repYear" id="repYear" class="form-control">
									<option value="">2561</option>
								</select>
							</div>
						</form>
					</fieldset>
				</div>
			</div>
		</div>
	</div>
</div>