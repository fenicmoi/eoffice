<?php
date_default_timezone_set('Asia/Bangkok');
include "header.php";

//checkuser login
if (!isset($_SESSION['ses_u_id'])) {
	header("Location: ../index.php");
	exit();
} else {
	$u_id = $_SESSION['ses_u_id'];
}

?>
<style>
	mark {
		background-color: #ffeb3b;
		padding: 2px 4px;
		border-radius: 2px;
		font-weight: bold;
		color: #000;
	}
</style>
<script>
	// ฟังก์ชันสำหรับไฮไลท์ข้อความที่ตรงกับคำค้นหา
	function highlightText(text, keyword) {
		if (!keyword || keyword.trim() === '') return text;
		// Escape special regex characters
		var escapedKeyword = keyword.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
		var regex = new RegExp('(' + escapedKeyword + ')', 'gi');
		return text.replace(regex, '<mark>$1</mark>');
	}

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
		});

		// ไฮไลท์ข้อความหลังจากโหลดหน้าเสร็จ
		var searchKeyword = $('#search').val();
		if (searchKeyword) {
			$('.highlight-target').each(function () {
				var originalText = $(this).text();
				var highlightedText = highlightText(originalText, searchKeyword);
				$(this).html(highlightedText);
			});
		}
	});
</script>

<div class="col-md-2">
	<?php
	$menu = checkMenu($level_id);
	include $menu;
	?>
</div>

<div class="col-md-10">
	<div class="panel panel-primary">
		<div class="panel-heading"><i class="fas fa-share-square fa-2x"></i> <strong>ส่งไฟล์เอกสาร </strong>
			<button id="hideSearch" class="btn btn-default pull-right"><i class="fas fa-search"> ค้นหา</i></button>
			<a href="folder.php" class="btn btn-default pull-right"><i class="fas fa-home"></i> หน้าหลัก</a>
		</div>
		<div class="panel-body">
			<ul class="nav nav-tabs">
				<li><a class="btn-danger fas fa-envelope" href="paper.php"> หนังสือเข้า</a></li>
				<li><a class="btn-danger fas fa-envelope-open" href="folder.php">สถานะ(รับ/คืน)</a></li>
				<li class="active"><a class="btn-danger fas fa-history" href="history.php"> ส่งแล้ว</a></li>
				<li><a class="btn-danger fas fa-globe" href="outside_all.php"> ส่งหนังสือ</a></li>
			</ul>
			<table class="table table-bordered table-hover" id="tbHistory">
				<thead>
					<tr bgcolor="black">
						<td colspan="5">
							<form class="form-inline" method="post" name="frmSearch" id="frmSearch">
								<?php
								// เก็บค่าค้นหาเพื่อแสดงใน input field
								$searchValue = isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '';
								$typeSearchValue = isset($_POST['typeSearch']) ? $_POST['typeSearch'] : '2';
								?>
								<div class="form-group">
									<select class="form-control" id="typeSearch" name="typeSearch">
										<option value="1" <?php echo ($typeSearchValue == '1') ? 'selected' : ''; ?>><i
												class="fas fa-star"></i>เลขหนังสือ</option>
										<option value="2" <?php echo ($typeSearchValue == '2') ? 'selected' : ''; ?>>
											เรื่อง</option>
									</select>
									<div class="input-group">
										<input class="form-control" id="search" name="search" type="text" size="80"
											placeholder="Keyword สั้นๆ" value="<?php echo $searchValue; ?>">
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
						<th>วันที่ส่ง</th>
						<th>เวลา</th>
						<th>ตรวจสอบ</th>
						<th>แก้ไข</th>
						<th>ยกเลิก</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sql = "SELECT p.* FROM paper p INNER JOIN section s ON p.sec_id = s.sec_id WHERE s.dep_id = ? ";
					$params = [$dep_id];
					$types = "i";

					if (isset($_POST['btnSearch'])) { //ถ้ามีการกดปุ่มค้นหา
						$typeSearch = isset($_POST['typeSearch']) ? $_POST['typeSearch'] : '';
						$txt_search = isset($_POST['search']) ? trim($_POST['search']) : '';

						if (!empty($txt_search)) {
							if ($typeSearch == 1) { //เลขหนังสือ
								$sql .= " AND p.book_no LIKE ? ORDER BY p.pid DESC";
								$params[] = "%$txt_search%";
								$types .= "s";
							} else if ($typeSearch == 2) { //ชื่อเรื่อง
								$sql .= " AND p.title LIKE ? ORDER BY p.pid DESC";
								$params[] = "%$txt_search%";
								$types .= "s";
							}
						} else {
							$sql .= " ORDER BY p.pid DESC";
						}

					} else {
						$sql .= " ORDER BY p.pid DESC";
					}

					//pagenavigation - ใช้ prepared statement
					$result = page_query($dbConn, $sql, 10, $types, $params);
					$numrow = dbNumRows($result);

					while ($rowList = dbFetchArray($result)) { ?>
						<tr>
							<td><i class="fas fa-bullseye"></i></td>
							<td class="highlight-target">
								<?php
								if ($rowList['book_no'] == null) {
									echo "...";
								} else {
									echo htmlspecialchars($rowList['book_no']);
								}
								?>
							</td>
							<td>
								<div class="highlight-target" style="font-weight: 700; margin-bottom: 5px;">
									<?php echo htmlspecialchars($rowList['title']); ?>
								</div>
								<div class="attachment-list">
									<?php
									// ดึงไฟล์แนบทั้งหมดของหนังสือเล่มนี้
									$sqlFiles = "SELECT * FROM paper_file WHERE pid = ?";
									$resFiles = dbQuery($sqlFiles, "i", [$rowList['pid']]);
									while ($fRow = dbFetchArray($resFiles)) {
										?>
										<a href="download.php?file=<?php echo urlencode($fRow['file_path']); ?>" target="_blank"
											class="btn btn-xs btn-default" style="margin-right: 2px; margin-bottom: 2px;"
											title="<?php echo htmlspecialchars($fRow['file_name']); ?>">
											<i class="fas fa-paperclip text-primary"></i>
											<small><?php echo htmlspecialchars($fRow['file_name']); ?></small>
										</a>
									<?php } ?>

									<?php if (dbNumRows($resFiles) == 0 && !empty($rowList['file'])) { ?>
										<a href="download.php?file=<?php echo urlencode($rowList['file']); ?>" target="_blank"
											class="btn btn-xs btn-default" title="ดาวน์โหลด">
											<i class="fas fa-file-pdf text-danger"></i> ไฟล์หลัก
										</a>
									<?php } ?>
								</div>
							</td>
							<td><?php echo thaiDate($rowList['postdate']); ?></td>
							<td><?php echo substr($rowList['postdate'], 10); ?></td>
							<td><a href="checklist.php?pid=<?php echo $rowList['pid']; ?>" class="btn btn-warning"
									target="_blank"><i class="fab fa-wpexplorer"></i> ติดตาม</a></td>
							<?php
							$d1 = $rowList['postdate'];
							$d2 = date('Y-m-d');
							$numday = getNumDay($d1, $d2);

							// ตรวจสอบว่าหนังสือเป็นของแผนกตนเองหรือไม่
							$isOwnSection = ($rowList['sec_id'] == $sec_id);

							//กำหนดให้แก้ไขได้ 1 วันเท่านั้น
							if ($numday > 7) { ?>
								<td>
									<center><i class="fab fa-expeditedssl fa-2x"></i></center>
								</td>
							<?php } else {
								// ถ้าไม่ใช่แผนกตนเอง ให้ปุ่มแก้ไขไม่ทำงาน
								if (!$isOwnSection) { ?>
									<td>
										<button class="btn btn-secondary" disabled style="cursor: not-allowed; opacity: 0.5;">
											<i class="fas fa-edit"></i> แก้ไข
										</button>
									</td>
								<?php } else {
									if ($rowList['insite'] == 1) { ?>
										<td><a class="btn btn-info" href="inside_all_edit.php?pid=<?php echo $rowList['pid']; ?>"><i
													class="fas fa-edit"></i>แก้ไข</a></td>
									<?php } else if ($rowList['outsite'] == 1) { ?>
											<td><a class="btn btn-info" href="outside_all_edit.php?pid=<?php echo $rowList['pid']; ?>"><i
														class="fas fa-edit"></i>แก้ไข</a></td>
									<?php } ?>
								<?php } ?>

							<?php } ?>
							<td>
								<?php if ($numday > 7) { ?>
									<center><i class="fab fa-expeditedssl fa-2x"></i></center>
								<?php } else if (!$isOwnSection) { ?>
										<!-- ถ้าไม่ใช่แผนกตนเอง ให้ปุ่มยกเลิกไม่ทำงาน -->
										<button class="btn btn-secondary" disabled style="cursor: not-allowed; opacity: 0.5;">
											<i class="fas fa-trash-alt"></i> ยกเลิก
										</button>
								<?php } else { ?>
										<a class="btn btn-default" href="in_out_del.php?pid=<?= $rowList['pid']; ?>"
											onclick="return confirm('คุณกำลังจะลบข้อมูล !'); "> <i class="fas fa-trash-alt"></i>
											ยกเลิก</a>
								<?php } ?>

							</td>
						</tr>
					<?php } //end while ?>
				</tbody>
			</table>
		</div> <!--panel-body-->
		<div class="panel-footer">
			<center>
				<a href="history.php" class="btn btn-primary">
					<i class="fas fa-home"></i> หน้าหลัก
				</a>
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
</div> <!--col-md-10-->

<?php
/*
$del=$_GET['del'];
if(isset($del)){
  echo "<script> alert('hello');</script>";
}
  */
?>