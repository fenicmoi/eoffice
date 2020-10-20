
function autoTabTel(obj,typeCheck){
    /* กำหนดรูปแบบข้อความโดยให้ _ แทนค่าอะไรก็ได้ แล้วตามด้วยเครื่องหมาย
    หรือสัญลักษณ์ที่ใช้แบ่ง เช่นกำหนดเป็น  รูปแบบเลขที่บัตรประชาชน
    4-2215-54125-6-12 ก็สามารถกำหนดเป็น  _-____-_____-_-__
    รูปแบบเบอร์โทรศัพท์ 08-4521-6521 กำหนดเป็น __-____-____
    หรือกำหนดเวลาเช่น 12:45:30 กำหนดเป็น __:__:__
    ตัวอย่างข้างล่างเป็นการกำหนดรูปแบบเลขบัตรประชาชน
    */
        if(typeCheck==1){
            var pattern=new String("_-____-_____-_-__"); // กำหนดรูปแบบในนี้
            var pattern_ex=new String("-"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้     
        }else{
            var pattern=new String("_-____-____"); // กำหนดรูปแบบในนี้  0-7648-1421
            var pattern_ex=new String("-"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้                 
        }
        var returnText=new String("");
        var obj_l=obj.value.length;
        var obj_l2=obj_l-1;
        for(i=0;i<pattern.length;i++){           
            if(obj_l2==i && pattern.charAt(i+1)==pattern_ex){
                returnText+=obj.value+pattern_ex;
                obj.value=returnText;
            }
        }
        if(obj_l>=pattern.length){
            obj.value=obj.value.substr(0,pattern.length);           
        }
}

function setEnabledTo(obj) {
	if (obj.value=="2") {
		obj.form.toSomeUser.disabled = false;
		obj.form.toAll.checked = false;
	} else {
		obj.form.toSomeUser.disabled = true;
		obj.form.toSomeUser.value = "";
		obj.form.toSome.checked = false;
	}
}


function setEnabledTo2(obj) {
	if (obj.value=="2") {                   //กรณีเลือกตามประเภทแยกตามประเภท
		obj.form.toAll.checked = false;     //ทั้งหมด
        obj.form.toSomeOne.checked=false;   //เลือกเอก
        obj.form.toSomeUser.disabled=false;  //textbox 
        obj.form.toSomeOneUser.disabled=true;
	} else if(obj.value=="3") {             //กรณีเลือกเอง
        obj.form.toAll.checked=false;       //ทั้งหมด
		obj.form.toSome.checked = false;    //แยกตามประเภท
        obj.form.toSomeUser.disabled=true;  //textbox 
        obj.form.toSomeOneUser.disabled=false;
	}else{
        obj.form.toSome.checked = false;    //แยกตามประเภท
        obj.form.toSomeOne.checked=false;   //เลือกเอก

        obj.form.toSomeUser.disabled=true;  //textbox 
        obj.form.toSomeUser.value="";
        obj.form.toSomeOneUser.disabled=true;
        obj.form.toSomeOneUser.value="";

        
    }
}


 function listOne(a,b,c) {
        m=document.file.toSomeUser.value;
        
        if (a.checked) {
            if (m.indexOf(b)<0) m+='|'+b;
        
        } else {
        m=document.file.toSomeUser.value.replace('|'+b,'');
        }
        z="|";
        if (m.substring(2) == c) m=m.substring(2);
        document.file.toSomeUser.value=m;
    }
    
    
function listType(a,b,c) {     //ฟังค์ชั่นกรณีเลือกเป็นประเภท
        m=document.fileout.toSomeUser.value;
        
        if (a.checked) {
            if (m.indexOf(b)<0) m+='|'+b;
        
        } else {
        m=document.fileout.toSomeUser.value.replace('|'+b,'');
        }
        z="|";
        if (m.substring(2) == c) m=m.substring(2);
        document.fileout.toSomeUser.value=m;
    }
    
  function listSome(a,b,c) {     //ฟังค์ชั่นกรณีเลือกส่วนราชการเอง
        m=document.fileout.toSomeOneUser.value;
        
        if (a.checked) {
            if (m.indexOf(b)<0) m+='|'+b;
        
        } else {
        m=document.fileout.toSomeOneUser.value.replace('|'+b,'');
        }
        z="|";
        if (m.substring(2) == c) m=m.substring(2);
        document.fileout.toSomeOneUser.value=m;
    }


