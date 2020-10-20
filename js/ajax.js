// JavaScript Document
$(document).ready(function(){
	// ส่วนของจังหวัดเมื่อมีการเปลี่ยนแปลง
	$("#Proviance").change(function(){
		$("#Subdistrict").empty();//ล้างข้อมูล
		$("#Postcode").empty();//ล้างข้อมูล
		$("#DisID").val("");//ล้างข้อมูล
		$("#SubID").val("");//ล้างข้อมูล
		$("#PostID").val("");//ล้างข้อมูล
		$.ajax({
			  url: "getdata.php",//ที่อยู่ของไฟล์เป้าหมาย
			  global: false,
			  type: "GET",//รูปแบบข้อมูลที่จะส่ง
			  data: ({ID : $(this).val(),TYPE : "District"}), //ข้อมูลที่ส่ง  { ชื่อตัวแปร : ค่าตัวแปร }
			  dataType: "JSON", //รูปแบบข้อมูลที่ส่งกลับ xml,script,json,jsonp,text
			  async:false,
			  success: function(jd) { //แสดงข้อมูลเมื่อทำงานเสร็จ โดยใช้ each ของ jQuery
							var opt="<option value=\"0\" selected=\"selected\">---เลือกอำเภอ---</option>";
							$.each(jd, function(key, val){
								opt +="<option value='"+ val["AMPHUR_ID"] +"'>"+val["AMPHUR_NAME"]+"</option>"
    						});
							$("#District").html( opt );//เพิ่มค่าลงใน Select ของอำเภอ
		   	  }
		});	
		$("#ProID").val($(this).val()); //กำหนดค่า ID ของจังหวัดที่เลือกให้กับ Textfield ของจังหวัด
	});
	// ส่วนของอำเภอเมื่อมีการเปลี่ยนแปลง
	$("#District").change(function(){
		$("#Subdistrict").empty();
		$("#Postcode").empty();
		$("#SubID").val("");
		$("#PostID").val("");
		$.ajax({
			  url: "getdata.php",
			  global: false,
			  type: "GET",
			  data: ({ID : $(this).val(),TYPE : "Subdistrict"}),
			  dataType: "JSON",
			  async:false,
			  success: function(jd) {
							var opt="<option value=\"0\" selected=\"selected\">---เลือกตำบล---</option>";
							$.each(jd, function(key, val){
								opt +="<option value='"+ val["DISTRICT_ID"] +"'>"+val["DISTRICT_NAME"]+"</option>"
    						});
							$("#Subdistrict").html( opt );
		   	  }
		 });
		 $("#DisID").val($(this).val());
	});
	// ส่วนของตำบลเมื่อมีการเปลี่ยนแปลง
	$("#Subdistrict").change(function(){
		$("#PostID").val("");
		$.ajax({
			  url: "getdata.php",
			  type: "GET",
			  data: ({ID : $("#District").val(),TYPE : "Postcode"}),
			  dataType: "JSON",
			  success: function(jd) {
							var opt="<option value=\"0\" selected=\"selected\">---เลือกรหัสไปรษณีย์---</option>";
							$.each(jd, function(key, val){
								opt +="<option value='"+ val["POST_CODE"] +"'>"+val["POST_CODE"]+"</option>"
    						});
							$("#Postcode").html( opt );
		   	  }
		 });
		 $("#SubID").val($("#Subdistrict").val());
	});
	// ส่วนของรหัสไปรษณีย์เมื่อมีการเปลี่ยนแปลง
	$("#Postcode").change(function(){
		$("#PostID").val($(this).val());
	});
});
//ส่วนของ function เพื่อเพิ่มข้อมูลจังหวัดเข้าไปก่อน
function Add(){
		$.ajax({
			  url: "getdata.php",
			  global: false,
			  type: "GET",
			  data: ({TYPE : "Proviance"}),
			  dataType: "JSON",
			  async:false,
			  success: function(jd) {
							var opt="<option value=\"0\" selected=\"selected\">---เลือกจังหวัด---</option>";
							$.each(jd, function(key, val){
								opt +="<option value='"+ val["PROVINCE_ID"] +"'>"+val["PROVINCE_NAME"]+"</option>"
    						});
							$("#Proviance").html( opt );
		   	  }
		});
}
