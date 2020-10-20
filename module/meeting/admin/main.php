<?
session_start();
error_reporting(E_ALL ^ E_NOTICE);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<HTML>
<HEAD>
<TITLE>ระบบจองห้องประชุมออนไลน์ พัฒนาโดย www.php-mysql-program.com</TITLE>
<link href="mystyle.css" rel="stylesheet" type="text/css">
<?php 
	$name=$_SESSION['name'];
	if($name==''){
?>
<SCRIPT language="JavaScript">
	alert("กรุณา Login ก่อนเข้าใช้งานหน้านี้");
	window.parent.location='../admin.php';
</SCRIPT>
<? } ?>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-874">
</HEAD>
<? 
if($name !=''){
echo"<FRAMESET ROWS='111,*' COLS='*' FRAMESPACING='0' FRAMEBORDER='NO' BORDER='1'>";
echo"<FRAME SRC='../header_admin.php?name=$name' NAME='headframe' SCROLLING='NO' NORESIZE >";
echo"<FRAMESET ROWS='*' COLS='260,*' FRAMESPACING='0' FRAMEBORDER='NO' BORDER='1'>";
echo"<FRAME SRC='adminmenu.php?name=$name' NAME='leftframe' SCROLLING='NO' NORESIZE class='lefttext'>";
echo"<FRAME SRC='body.php' NAME='rightframe' SCROLLING='YES' NORESIZE>";
echo"</FRAMESET>";
echo"</FRAMESET>";
echo"<NOFRAMES>";
}
?>
<BODY>
</BODY></NOFRAMES>
</HTML>

