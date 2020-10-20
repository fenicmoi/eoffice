<form id="member" action="login.php">
	<?php
		if(isset($_SESSION['ses_level_id'])){?>
	<b>สำหรับผู้ดูแลระบบ</b><br>
	&raquo; <a href="new-article.php">เพิ่มบทความใหม่</a><br>
	&raquo; <a href="#">รายการแจ้งลบ</a><br>
	&raquo; <a href="logout.php"></a>
		<?php }else if(isset($_SESSION['']){ ?>
</form>