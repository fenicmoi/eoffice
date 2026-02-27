<?php
date_default_timezone_set('Asia/Bangkok');
include "header.php";

//checkuser login
if (!isset($_SESSION['ses_u_id'])) {
	header("Location: ../index.php");
	exit();
} else {
	$u_id = $_SESSION['ses_u_id'];
	$sec_id = $_SESSION['ses_sec_id'];
	$dep_id = $_SESSION['ses_dep_id'];
	$dateRecive = date('Y-m-d H:m:s');
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
		var dataTable = $('#tbFolder').DataTable({
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
				url: "folder-serverside.php",
				type: "post",
				data: {
					dep_id: '<?php echo $dep_id; ?>',
					sec_id: '<?php echo $sec_id; ?>',
					level_id: '<?php echo $level_id; ?>'
				},
				error: function () {
					$(".tbFolder-error").html("");
					$("#tbFolder").append('<tbody class="tbFolder-error"><tr><th colspan="13"><center>ไม่มีข้อมูล</center></th></tr></tbody>');
					$("#tbFolder").css("display", "none");
				}
			},
			"columnDefs": [
				{
					"targets": [0, 10, 11, 12],
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
		<div class="panel-heading"><i class="fas fa-share-square fa-2x"></i> <strong>ส่งไฟล์เอกสาร </strong>
			<a href="folder.php" class="btn btn-default pull-right"><i class="fas fa-home"></i> หน้าหลัก</a>
		</div>
		<div class="panel-body">
			<ul class="nav nav-tabs">
				<li><a class="btn-danger fas fa-envelope" href="paper.php"> หนังสือเข้า</a></li>
				<li class="active"><a class="btn-danger fas fa-envelope-open" href="folder.php">สถานะ(รับ/คืน)</a></li>
				<li><a class="btn-danger fas fa-history" href="history.php"> ส่งแล้ว</a></li>
				<li><a class="btn-danger fas fa-globe" href="outside_all.php"> ส่งหนังสือ</a></li>
			</ul>
			<table class="table table-bordered table-hover" id="tbFolder" width="100%">
				<thead>
					<tr bgcolor="#C8C5C5">
						<th></th>
						<th>ที่</th>
						<th>เรื่อง</th>
						<th>วันที่ส่ง</th>
						<th>เวลาส่ง</th>
						<th>ผู้ส่ง</th>
						<th>หน่วยส่ง</th>
						<th>วันที่(รับ/คืน)</th>
						<th>เวลา</th>
						<th>ผู้รับ</th>
						<th>การจัดการ</th>
						<th>สถานะ</th>
						<th>ตรวจสอบ</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div> <!-- panel body -->
		<div class="panel-footer">
			<center>
				<a href="folder.php" class="btn btn-primary">
					<i class="fas fa-home"></i> หน้าหลัก
				</a>
			</center>
		</div>
	</div>
	<script>
		function checklist() {
			var myWindow = window.open("ddd", "ddd", "width=600,height=400");
		}
	</script>

	<?php    //ถ้ามีการกดปุ่มและส่งค่าเปลี่ยนแปลงรายการ
	if (isset($_GET['confirm'])) {
		$pid = $_GET['pid'];
		$confirm = $_GET['confirm'];    //จะส่งค่ามาสองสถานะ  1  หรือ 2 
		if ($confirm == 1) {
			$sql = "UPDATE paperuser SET confirm = $confirm, confirmdate ='$dateRecive', msg_reject = 'ลงรับ'  WHERE pid = $pid AND dep_id = $dep_id";
		} else {
			$sql = "UPDATE paperuser SET confirm = $confirm, confirmdate ='$dateRecive', msg_reject = 'ไม่เกี่ยวข้อง'  WHERE pid = $pid AND dep_id = $dep_id";
		}
		//print $sql;
		$result = dbQuery($sql);

		if (!$result) {
			echo "<script>
        swal({
            title:'มีบางอย่างผิดพลาด !',
            type:'error',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='folder.php';
                }
            }); 
        </script>";
		} else {
			echo "<script>
        swal({
            title:'ดำเนินการเรียบร้อยแล้ว!',
            type:'success',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='folder.php';
                }
            }); 
        </script>";
		}
	}
	?>