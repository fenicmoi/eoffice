<?
require_once('PHPMailer/PHPMailerAutoload.php');
    $mail = new PHPMailer();
	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "tls"; //ตรงส่วนนี้ผมไม่แน่ใจ ลองเปลี่ยนไปมาใช้งานได้
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587;  //ตรงส่วนนี้ผมไม่แน่ใจ ลองเปลี่ยนไปมาใช้งานได้
	$mail->isHTML();
	$mail->CharSet = "utf-8"; //ตั้งเป็น UTF-8 เพื่อให้อ่านภาษาไทยได้
	$mail->Username = "fenics128@gmail.com"; //ให้ใส่ Gmail ของคุณเต็มๆเลย
	$mail->Password = "password"; // ใส่รหัสผ่าน
	$mail->SetFrom = ('no-reply@domaintest.com'); //ตั้ง email เพื่อใช้เป็นเมล์อ้างอิงในการส่ง ใส่หรือไม่ใส่ก็ได้ เพราะผมก็ไม่รู้ว่ามันแาดงให้เห็นตรงไหน
	$mail->FromName = "Sender Person"; //ชื่อที่ใช้ในการส่ง
	$mail->Subject = "ทดสอบการส่งอีเมล์";  //หัวเรื่อง emal ที่ส่ง
	$mail->Body = "ได้แล้วครับ หลังจากที่งมกับ Code นี้มานานแสนนาน</b>"; //รายละเอียดที่ส่ง
	$mail->AddAddress('dataofphangnga@gmail.com','Recive Name'); //อีเมล์และชื่อผู้รับ
	
	//ส่วนของการแนบไฟล์ ซึ่งทดสอบแล้วแนบได้จริงทั้งไฟล์ .rar , .jpg , png ซึ่งคงมีหลายนามสกุลที่แนบได้
	$mail->AddAttachment("files/1.rar");
	$mail->AddAttachment("files/2.rar");
	$mail->AddAttachment("files/1.jpg");
	$mail->AddAttachment("files/2.png");


	//ตรวจสอบว่าส่งผ่านหรือไม่
	if ($mail->Send()){
	echo "ข้อความของคุณได้ส่งพร้อมไฟล์แนบแล้วจ้า";
	}else{
	echo "การส่งไม่สำเร็จ";
	}
?>