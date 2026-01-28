<?php
ob_start();
date_default_timezone_set('Asia/Bangkok');
include "header.php";
$u_id = $_SESSION['ses_u_id'];
?>
<script>
	$(document).ready(function () {
		// $("#btnSearch").prop("disabled",true); 
		$("#dateSearch").hide();
		$("tr").first().hide();


		$("#hideSearch").click(function () {
			$("tr").first().show(1000);
		});


		$('#typeSearch').change(function () {
			var typeSearch = $('#typeSearch').val();
			if (typeSearch == 4) {
				$("#dateSearch").show(500);
				$("#search").hide(500);
			} else {
				$("#dateSearch").hide(500);
				$("#search").show(500);
			}
		})
	});
</script>
<div class="col-md-2">
	<?php
	$menu = checkMenu($level_id);
	include $menu;
	?>
</div>
<?php

$sql = "SELECT p.pid,u.puid, u.pid,p.postdate,p.title,p.file,p.book_no,d.dep_name,s.sec_name,us.firstname FROM paperuser u
      INNER JOIN paper p  ON p.pid=u.pid
      INNER JOIN depart d ON d.dep_id=p.dep_id
	  INNER JOIN section s ON s.sec_id = p.sec_id
	  INNER JOIN user as us ON us.u_id = p.u_id
      WHERE u.u_id=" . (int) $u_id . " AND u.confirm=0 ";

if (isset($_POST['btnSearch'])) { //ถ้ามีการกดปุ่มค้นหา
	@$typeSearch = $_POST['typeSearch']; //ประเภทการค้นหา
	@$txt_search = $_POST['search']; //กล่องรับข้อความ
	if (@$typeSearch == 1) { //เลขที่หนังสือ
		$sql .= " AND p.book_no LIKE '%$txt_search%'   ORDER BY u.puid  DESC";
	} elseif (@$typeSearch == 2) { //ชื่อเรื่อง
		$sql .= " AND p.title LIKE '%$txt_search%'     ORDER BY u.puid  DESC";
	}
} else {
	$sql .= " ORDER BY u.puid DESC";
}

//print $sql;
$result = page_query($dbConn, $sql, 10);
$numrow = dbNumRows($result);
?>
<div class="col-md-10">
	<div class="panel panel-primary">
		<div class="panel-heading"><i class="fas fa-share-square fa-2x"></i> <strong>ส่งไฟล์เอกสาร</strong>
			<button id="hideSearch" class="btn btn-default pull-right"><i class="fas fa-search"> ค้นหา</i></button>
		</div>
		<div class="panel-body">
			<ul class="nav nav-tabs">
				<li class="active"><a class="btn-danger fas fa-envelope" href="paper.php"> หนังสือเข้า</a></li>
				<li><a class="btn-danger fas fa-envelope-open" href="folder.php"> รับแล้ว</a></li>
				<li><a class="btn-danger fas fa-history" href="history.php"> ส่งแล้ว</a></li>
				<li><a class="btn-danger fas fa-globe" href="outside_all.php"> ส่งหนังสือ</a></li>
			</ul>

			<table class="table table-bordered table-hover" id="tbNew">
				<thead>
					<tr bgcolor="black">
						<td colspan="9">
							<form class="form-inline" method="post" name="frmSearch" id="frmSearch">
								<div class="form-group">
									<select class="form-control" id="typeSearch" name="typeSearch">
										<option value="1"><i class="fas fa-star"></i>เลขหนังสือ</option>
										<option value="2" selected>เรื่อง</option>
									</select>
									<div class="input-group">
										<input class="form-control" id="search" name="search" type="text" size="80"
											placeholder="Keyword สั้นๆ">
										<div class="input-group-btn">
											<button class="btn btn-primary" type="submit" name="btnSearch"
												id="btnSearch"><i class="fas fa-search "></i></button>
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
						<th>หน่วยส่ง</th>
						<th>ตรวจสอบ</th>
						<th>วันที่ส่ง</th>
						<th>เวลา</th>
						<th>รับ</th>
						<th>คืน</th>
					</tr>
				</thead>
				<tbody>
					<?php

					while ($rowNew = dbFetchArray($result)) { ?>

						<tr>
							<td><i class="fas fa-envelope-square"></i></td>
							<td>
								<?php
								if ($rowNew['book_no'] == null) {
									echo "...";
								} else {
									echo $rowNew['book_no'];
								}
								?>
							</td>
							<td>
								<div style="font-weight: 700; margin-bottom: 5px;">
									<?php echo htmlspecialchars($rowNew['title']); ?>
								</div>
								<div class="attachment-list">
									<?php
									// ดึงไฟล์แนบทั้งหมดของหนังสือเล่มนี้
									$sqlFiles = "SELECT * FROM paper_file WHERE pid = ?";
									$resFiles = dbQuery($sqlFiles, "i", [$rowNew['pid']]);
									while ($fRow = dbFetchArray($resFiles)) {
										?>
										<a href="download.php?file=<?php echo urlencode($fRow['file_path']); ?>" target="_blank"
											class="btn btn-xs btn-default" style="margin-right: 2px; margin-bottom: 2px;"
											title="<?php echo htmlspecialchars($fRow['file_name']); ?>">
											<i class="fas fa-paperclip text-primary"></i>
											<small><?php echo htmlspecialchars($fRow['file_name']); ?></small>
										</a>
									<?php } ?>

									<?php if (dbNumRows($resFiles) == 0 && !empty($rowNew['file'])) { ?>
										<a href="download.php?file=<?php echo urlencode($rowNew['file']); ?>" target="_blank"
											class="btn btn-xs btn-default" title="ดาวน์โหลด">
											<i class="fas fa-file-pdf text-danger"></i> ไฟล์หลัก
										</a>
									<?php } ?>
								</div>
							</td>
							<td><?php echo $rowNew['dep_name']; ?></td>
							<td><a href="checklist.php?pid=<?php print $rowNew['pid']; ?>" class="badge"
									target="_blank">หน่วยรับร่วม</a></td>
							<td><?php echo thaiDate(substr($rowNew['postdate'], 0, 10)) ?></td>
							<td><?php echo substr($rowNew['postdate'], 10); ?></td>
							<?php
							if ($level_id > 5) { ?>
								<td><kbd>จำกัดสิทธิ์</kbd></td>
							<?php } else { ?>
								<td>
									<a class="btn btn-warning"
										href="recive.php?pid=<?php echo $rowNew['pid']; ?>&sec_id=<?php echo $sec_id; ?>&dep_id=<?php echo $dep_id; ?>&confirm=1">

										<i class="fas fa-check"></i> ลงรับ
									</a>
								</td>
							<?php } ?>
							<?php
							if ($level_id > 5) { ?>
								<td><kbd>จำกัดสิทธิ์</kbd></td>
							<?php } else { ?>
								<td><a class="btn btn-danger"
										href="recive.php?pid=<?php echo $rowNew['pid']; ?>&sec_id=<?php echo $sec_id; ?>&dep_id=<?php echo $dep_id; ?>&confirm=2">
										<i class="fa fa-close"></i> ส่งคืน
									</a>
								</td>
							<?php } ?>

						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div> <!-- panel body-->
		<div class="panel-footer">
			<center>
				<?php
				page_link_border("solid", "1px", "gray");
				page_link_bg_color("lightblue", "pink");
				page_link_font("14px");
				page_link_color("blue", "red");
				page_echo_pagenums(10, true);
				?>
			</center>
		</div>
	</div> <!-- panel primary -->
</div>