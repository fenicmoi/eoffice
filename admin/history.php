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
	$(document).ready(function () {
		var dataTable = $('#tbHistory').DataTable({
			order: [[0, 'desc']], // เรียงตาม pid (ที่ซ่อนไว้ หรือใช้ค่า default)
			"processing": true,
			"serverSide": true,
			"responsive": true,
			"language": {
				"sLengthMenu": "แสดง _MENU_ เร็คคอร์ด ต่อหน้า",
				"sZeroRecords": "ไม่พบข้อมูลที่ค้นหา",
				"sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ เร็คคอร์ด",
				"sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 เร็คคอร์ด",
				"sInfoFiltered": "(จากเร็คคอร์ดทั้งหมด _MAX_ เร็คคอร์ด)",
				"sSearch": "ค้นหา (เรื่อง/เลขที่): ",
				"oPaginate": {
					"sFirst": "หน้าแรก",
					"sPrevious": "ก่อนหน้า",
					"sNext": "ถัดไป",
					"sLast": "หน้าสุดท้าย"
				}
			},
			"ajax": {
				url: "history-serverside.php",
				type: "post",
				data: {
					dep_id: '<?php echo $dep_id; ?>',
					sec_id: '<?php echo $sec_id; ?>'
				},
				error: function () {
					$(".tbHistory-error").html("");
					$("#tbHistory").append('<tbody class="tbHistory-error"><tr><th colspan="9"><center>ไม่มีข้อมูล</center></th></tr></tbody>');
					$("#tbHistory").css("display", "none");
				}
			},
			"columnDefs": [
				{
					"targets": [0, 6, 7, 8],
					"orderable": false,
					"searchable": false
				}
			],
			"drawCallback": function () {
				// Highlight text if there's a search keyword
				var searchKeyword = $('.dataTables_filter input').val();
				if (searchKeyword && searchKeyword.trim() !== '') {
					var escapedKeyword = searchKeyword.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
					$('.highlight-target').each(function () {
						var html = $(this).html();
						// Replace only outside HTML tags (to not break markup like <a> or <i>)
						var highlightedHtml = html.replace(new RegExp("(?![^<]+>)(" + escapedKeyword + ")", "gi"), "<mark>$1</mark>");
						$(this).html(highlightedHtml);
					});
				}
			}
		});
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
			<a href="folder.php" class="btn btn-default pull-right"><i class="fas fa-home"></i> หน้าหลัก</a>
		</div>
		<div class="panel-body">
			<ul class="nav nav-tabs">
				<li><a class="btn-danger fas fa-envelope" href="paper.php"> หนังสือเข้า</a></li>
				<li><a class="btn-danger fas fa-envelope-open" href="folder.php">สถานะ(รับ/คืน)</a></li>
				<li class="active"><a class="btn-danger fas fa-history" href="history.php"> ส่งแล้ว</a></li>
				<li><a class="btn-danger fas fa-globe" href="outside_all.php"> ส่งหนังสือ</a></li>
			</ul>
			<table class="table table-bordered table-hover" id="tbHistory" width="100%">
				<thead>
					<tr bgcolor="#C8C5C5">
						<th></th>
						<th>ที่</th>
						<th>เรื่อง</th>
						<th>หน่วยส่ง</th>
						<th>วันที่ส่ง</th>
						<th>เวลา</th>
						<th>ตรวจสอบ</th>
						<th>แก้ไข</th>
						<th>ยกเลิก</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div> <!--panel-body-->
		<div class="panel-footer">
			<center>
				<a href="history.php" class="btn btn-primary">
					<i class="fas fa-home"></i> หน้าหลัก
				</a>
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