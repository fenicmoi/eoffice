<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script>
	$(document).ready(function(){
		first();                   // เมื่อ page ถูกโหลดจะทำฟังก์ชัน first ก่อน
		$('#btnAdd').click(first); // เมื่อ click จะสร้าง element ขึ้นมาใหม่(สร้างอินพุตใหม่)
		$('#btnSend').click(send); //เมื่อคลิกจะทำฟังก์ชัน send
	});
	
	function first(){
		var id = $('#cover div').length+1;            // นับว่ามี tag div กี่อันแล้ว แล้ว +1
		var wrapper = $("<div id=\"field"+id+"\">");  // สร้าง div
		var parag   = $("<p>เบอร์โทร\""+id+"\"</p>");   // สร้าง p
		var text    = $("<input type='text' name=\"tel"+id+"\" />"); // สร้าง input
		var btnDel  = $("<input type='button' value='del' id=\"btn"+id+"\"/>"); 
		btnDel.click(function(){
			$(this).parent().remove();			
		});
		
		wrapper.append(parag);   
		wrapper.append(text);
		wrapper.append(btnDel);
		$('#cover').append(wrapper);
	}
	
	function send(){  //นับ div ทั้งหมดก่อนส่ง
		var id= $('#cover div').length;
		var hiddens = $("<input type='hidden' name='hidden' value=\""+id+"\"/>");
		$('form').append(hiddens);
		$('form').submit(); 
	}
</script>
</head>
<body>
<form method="post" action="test2.php">
   <div id="cover"> 
   </div>
   <input type="button" id="btnAdd" value="add" />
</form>
   <input type="button" id="btnSend" value="send"/>
</body>
</html>