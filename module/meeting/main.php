<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

?>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<TITLE>ระบบจองห้องประชุมออนไลน์</TITLE>
<link href="mystyle.css" rel="stylesheet" type="text/css">
<?php
 $name=$_SESSION['name'];

if($name !=''){
echo"<FRAMESET ROWS='111,*' COLS='*' FRAMESPACING='0' FRAMEBORDER='NO' BORDER='1'>";
echo"<FRAME SRC='header_admin.php?name=$name' NAME='headframe' SCROLLING='NO' NORESIZE >";
echo"<FRAMESET ROWS='*' COLS='260,*' FRAMESPACING='0' FRAMEBORDER='NO' BORDER='1'>";
echo"<FRAME SRC='usermenu.php?name=$name' NAME='leftframe' SCROLLING='NO' NORESIZE class='lefttext'>";
echo"<FRAME SRC='fillform.php' NAME='rightframe' SCROLLING='YES' NORESIZE>";
echo"</FRAMESET>";
echo"</FRAMESET>";
echo"<NOFRAMES>";
}
?>
<BODY>
</BODY></NOFRAMES>
</HTML>

