// เพิ่มข้อมูลส่วนหนังสือรับหน่วยงาน 
$(document).ready(function(){
	$('#submit').on('click', function(){
		var firstname = $('#firstname').val();
		var yid = $('#yid').val();
		var book_no = $('#book_no').val();
		var title = $('#title').val();
		var sendfrom = $('#sendfrom').val();
		var sendto =$('#sendto').val();
		var practice = $('#sendto').val();
		var dateout = $('#dateout').val();
		var datein = new Date(YYYY-MM-DD);
		
		if(firstname == '' || lastname == '' || address == ''){
			alert("Please complete the required field!");
		}else{
			$.post('save.php', {firstname: firstname, lastname: lastname, address: address}, function(data){
				alert(data);
				$('#firstname').val('');
				$('#lastname').val('');
				$('#address').val('');
			});
		}
	})
});






$yid = $_POST[ 'yid' ]; //รหัสปีปัจจุบัน
	$book_no = $_POST[ 'book_no' ]; // หมายเลขประจำหนังสือ
	$title = $_POST[ 'title' ]; // เรื่อง   

	$sendfrom = $_POST[ 'sendfrom' ]; // ผู้ส่ง
	$sendto = $_POST[ 'sendto' ]; // ผู้รับ
	$practice = $_POST[ 'practice' ]; // ผู้ปฏิบัติ

	$dateout = $_POST[ 'datepicker' ]; // เอกสารลงวันที่
	$datein = date( 'Y-m-d' );
	$remark = $_POST[ 'remark' ];