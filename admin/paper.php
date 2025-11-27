<?php
date_default_timezone_set('Asia/Bangkok');
// **ปรับปรุง: ใช้ Require แทน Include เพื่อให้แน่ใจว่า Header ถูกโหลดเสมอ**
require "header.php";

// check login
if (!isset($_SESSION['ses_u_id'])) {
    header("Location: ../index.php");
    exit();
} else {
    // **✅ ปรับปรุงความปลอดภัย: ใช้ (int) สำหรับ ID เพื่อป้องกัน SQL Injection**
    $u_id = (int)$_SESSION['ses_u_id'];
    $dep_id = (int)$_SESSION['ses_dep_id'];
    
    // กำหนดค่า $level_id จาก Session และ Cast เป็น int
    $level_id = isset($_SESSION['ses_level_id']) ? (int)$_SESSION['ses_level_id'] : 0; 
    
}

// **ฟังก์ชัน JS สำหรับโหลดฟอร์มปฏิเสธ (Reject Form)**
// **ปรับปรุง: ส่ง pid, puid, และ dep_id ไปที่ show_rejectpaper.php อย่างปลอดภัย**
?>

<div class="col-md-2" >
 <?php
    // ตอนนี้ $level_id ถูกกำหนดค่าแล้ว
	$menu = checkMenu($level_id); 
	include $menu;
 ?>
</div>

 <div class="col-md-10">
	<div class="panel panel-primary">
        <div class="panel-heading"><i class="fas fa-share-square fa-2x"></i>  <strong>ส่งไฟล์เอกสาร</strong></div>
		<div class="panel-body">                  
            <ul class="nav nav-tabs">
                <li class="active"  ><a class="btn-danger fas fa-envelope"  href="paper.php">หนังสือเข้า</a></li>
                <li><a class="btn-danger fas fa-envelope-open"  href="folder.php">สถานะ(รับ/คืน)</a></li>
                <li><a class="btn-danger fas fa-history" href="history.php"> ส่งแล้ว</a></li>
                <li><a class="btn-danger fas fa-globe" href="outside_all.php"> ส่งหนังสือ</a></li>
            </ul>
        
            <table class="table table-bordered table-hover" id="myTable" >
                <thead>
                    <tr bgcolor="#C8C5C5">
                        <th>ลำดับ (ซ่อน)</th>
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
                    <!-- ข้อมูลจะถูกโหลดโดย DataTables -->
                </tbody>
            </table>
        </div> 
	</div> 
 </div>


<!-- Modal สำหรับเหตุผลการส่งคืน -->
<div  class="modal fade bs-example-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-info"></i> เหตุผลการส่งคืน</h4>
            </div>
            <div class="modal-body no-padding">
                <div id="divDataview"> </div>     
            </div> <div class="modal-footer bg-danger">
                 <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด X</button>
            </div>
        </div>
    </div>
</div>

<?php 
// ส่วนของ Logic การส่งคืนหนังสือ (Reject)
if(isset($_POST['btnReject'])){
    // **✅ ปรับปรุงความปลอดภัย: ใช้ (int) สำหรับ ID และ dbEscapeString สำหรับ String**
    $pid = (int)$_POST["pid"];   	 	
    $puid = (int)$_POST["puid"]; 			
    $dep_id_post = (int)$_POST["dep_id"];	
    $msg_reject = dbEscapeString($_POST["msg_reject"]);		
    
    $dateRecive = date('Y-m-d H:i:s'); // แก้ไข H:m:s เป็น H:i:s สำหรับนาที
    
    // **ปรับปรุง SQL: ใช้ Prepared Statements หรืออย่างน้อยใช้ dbEscapeString กับตัวแปรทั้งหมด**
    // (ในตัวอย่างนี้ใช้ dbEscapeString เพื่อให้เข้ากับโครงสร้างโค้ดเดิม)
    $sql =  " UPDATE paperuser 
              SET confirm = 2, confirmdate = '$dateRecive', msg_reject = '$msg_reject'
              WHERE pid = $pid AND u_id = $u_id AND dep_id = $dep_id_post";
    
    $result = dbQuery($sql);
    if($result){
        echo "<script>
        swal({
            title:'เรียบร้อย',
            text:'ดำเนินการส่งคืนเรียบร้อยแล้ว',
            icon:'success',
            type:'success',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='paper.php';
                }
            }); 
        </script>";
    }
    else{
        // **ปรับปรุง: ควร Log error จริง ๆ ด้วย เช่น error_log(dbError());**
        echo "<script>
        swal({
            title:'มีบางอย่างผิดพลาด! กรุณาตรวจสอบ',
            text: 'ไม่สามารถอัปเดตฐานข้อมูลได้ โปรดติดต่อผู้ดูแลระบบ', // เพิ่มข้อความที่ช่วยผู้ใช้
            type:'error',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='paper.php';
                }
            }); 
        </script>";
    }
}
?>

<script type="text/javascript" language="javascript" >

    // ฟังก์ชันสำหรับเปิด Modal และโหลดข้อมูลการส่งคืน
	function loadData(pid, puid, dep_id) {
        // ใช้ $.post แทน .load เพื่อความยืดหยุ่น
        $.post('show_rejectpaper.php', {
            pid: pid,
            puid: puid,
            dep_id: dep_id
        }, function(data) {
            $('#divDataview').html(data);
            $('.bs-example-modal-table').modal('show'); // เปิด Modal ด้วย jQuery
        });
	}

    $(document).ready(function() {
        var dataTable = $('#myTable').DataTable( {
            "processing": true,
            "serverSide": true,
            "bDestroy": true, 
            "searching": true, 
            "resonsive": true,
            "language": {
                "sLengthMenu": "แสดง _MENU_ เร็คคอร์ด ต่อหน้า",
                "sZeroRecords": "ไม่พบข้อมูลที่ค้นหา",
                "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ เร็คคอร์ด",
                "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 เร็คคอร์ด",
                "sInfoFiltered": "(จากเร็คคอร์ดทั้งหมด _MAX_ เร็คคอร์ด)",
                "sSearch": "ค้นหา: ",
                "oPaginate": {
                    "sFirst":    "หน้าแรก",
                    "sPrevious": "ก่อนหน้า",
                    "sNext":     "ถัดไป",
                    "sLast":     "หน้าสุดท้าย"
                }
            },
            "ajax":{
                url :"paper-serverside.php", // file server side
                type: "post",
                // ส่งตัวแปร $u_id และ $dep_id ที่ปลอดภัยไปที่ server side
                data: {
                    u_id: "<?php echo $u_id; ?>", 
                    dep_id: "<?php echo $dep_id; ?>"
                },
                error: function(xhr, error, code) { 
                    console.log("DataTables Error: ", error, code);
                    // alert('เกิดข้อผิดพลาดในการโหลดข้อมูล. กรุณาตรวจสอบ Console'); // ไม่ใช้ alert()
                }
            },
            "columnDefs": [ 
                {
                    "targets": [ 0 ], // คอลัมน์ลำดับ (puid หรือ pid) ที่ใช้ในการจัดเรียง
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [ 4, 7, 8 ], // ตรวจสอบ, รับ, คืน (คอลัมน์ที่มีปุ่ม)
                    "orderable": false 
                }
            ],
            // จัดเรียงตามคอลัมน์ที่ 5 (postdate/วันที่ส่ง) ล่าสุด 
            // **FIXED: อ้างอิงตาม Index ที่นับจาก 0 ของ <thead> (คอลัมน์ วันที่ส่ง คือ Index 5)**
            "order": [[ 5, "desc" ]] 
        });

        // **ปรับปรุง: ใช้ SweetAlert แทน confirm() สำหรับปุ่มยืนยัน**
        $('#myTable').on('click', '.btn-confirm-action', function(e){
            e.preventDefault();
            const url = $(this).attr('href');
            swal({
                title: 'ยืนยันการรับหนังสือ',
                text: 'คุณต้องการยืนยันการรับหนังสือนี้หรือไม่? การดำเนินการนี้ไม่สามารถยกเลิกได้',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }, function(isConfirm){
                if (isConfirm) {
                    window.location.href = url;
                }
            });
        });
    });
</script>