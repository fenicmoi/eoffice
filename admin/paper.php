<?php
ob_start();
date_default_timezone_set('Asia/Bangkok');
include "header.php";
$u_id = $_SESSION['ses_u_id'];
?>
<script>
	$(document).ready(function () {
		var dataTable = $('#tbNew').DataTable({
			order: [[0, 'desc']], // เรียงตาม u.puid
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
				url: "paper-serverside.php",
				type: "post",
				data: {
					u_id: '<?php echo $u_id; ?>',
					dep_id: '<?php echo $dep_id; ?>',
					sec_id: '<?php echo $sec_id; ?>',
					level_id: '<?php echo $level_id; ?>'
				},
				error: function () {
					$(".tbNew-error").html("");
					$("#tbNew").append('<tbody class="tbNew-error"><tr><th colspan="9"><center>ไม่มีข้อมูล</center></th></tr></tbody>');
					$("#tbNew").css("display", "none");
				}
			},
			"columnDefs": [
				{
					"targets": [0, 4, 7, 8],
					"orderable": false,
					"searchable": false
				}
			],
			"drawCallback": function () {
				var searchKeyword = $('.dataTables_filter input').val();
				if (searchKeyword && searchKeyword.trim() !== '') {
					var escapedKeyword = searchKeyword.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
					$('.highlight-target').each(function () {
						var html = $(this).html();
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
		<div class="panel-heading"><i class="fas fa-share-square fa-2x"></i> <strong>ส่งไฟล์เอกสาร</strong>
		</div>
<div class="panel-body">
	<ul class="nav nav-tabs">
		<li class="active"><a class="btn-danger fas fa-envelope" href="paper.php"> หนังสือเข้า</a></li>
		<li><a class="btn-danger fas fa-envelope-open" href="folder.php"> รับแล้ว</a></li>
		<li><a class="btn-danger fas fa-history" href="history.php"> ส่งแล้ว</a></li>
		<li><a class="btn-danger fas fa-globe" href="outside_all.php"> ส่งหนังสือ</a></li>
	</ul>

	<table class="table table-bordered table-hover" id="tbNew" width="100%">
		<thead>
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
		</tbody>
	</table>
</div> <!-- panel body-->
<div class="panel-footer">
	<center>
	</center>
</div>
</div> <!-- panel primary -->
</div>