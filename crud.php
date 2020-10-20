<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>jstree basic demos</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
</head>
<body>

	<h1>Basic JsTree Create Update Delete</h1>
	
	<div class="col-md-12">
		<button type="button" class="btn btn-success btn-sm" onclick="demo_create();"><i class="glyphicon glyphicon-asterisk"></i> เพิ่ม</button>
		<button type="button" class="btn btn-warning btn-sm" onclick="demo_rename();"><i class="glyphicon glyphicon-pencil"></i> แก้ไข</button>
		<button type="button" class="btn btn-danger btn-sm" onclick="demo_delete();"><i class="glyphicon glyphicon-remove"></i> ลบ</button>
	</div>

	<hr>

	<div id="frmt"></div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
	
	<script>

        function demo_create() {
            
              var ref = $('#frmt').jstree(true),
                      sel = ref.get_selected();
              if(!sel.length) { 
                  
                  alert('กรุณาเลือก  Node ที่ต้องการ เพิ่มข้อมูล');
                  
                  return false;

              }
              
              sel = sel[0];
              
              sel = ref.create_node(sel, {"type":"file"});
              
              if(sel) {
                ref.edit(sel);
              }
        }
        
        function demo_rename() {
                var ref = $('#frmt').jstree(true),
                        sel = ref.get_selected();
                if(!sel.length) {
                     alert('กรุณาเลือก   Node ที่ต้องการ แก้ไขข้อมูล');
                     return false;
                }
                sel = sel[0];
                ref.edit(sel);
        }
        
        function demo_delete() {

            var ref = $('#frmt').jstree(true),

            sel = ref.get_selected();
    
            if(!sel.length) {

                  alert('กรุณาเลือก  Node ที่ต้องการ ลบข้อมูล');
                  return false;
                
            }else{

                if(confirm("คุณต้องการลบข้อมูลใช่หรือไม่")){
                    if(sel == 1){
                        
                        alert('ไม่สามารถ ลบ  Root Node ได้');
                        
                        return false;
                        
                    }else{
                        ref.delete_node(sel);
                    }
                }
            }
        }
        
        

	$('#frmt').jstree({
         
         'core' : {
               'data' : {
                'url' : 'crud_response.php?operation=get_node',
                 "dataType" : "json"
               }
               ,'check_callback' : true,
         }
	}).on('create_node.jstree', function (e, data) {
		
          $.get('crud_response.php?operation=create_node', { 'id' : data.node.id, 'parent' : data.node.parent, 'text' : data.node.text })
            .done(function (d) {
               data.instance.set_id(data.node,d);
            })
            .fail(function () {
				
              data.instance.refresh();
			   console.log(data);
            });
			
    }).on('rename_node.jstree', function (e, data) {
            
        $.get('crud_response.php?operation=rename_node', { 'id' : data.node.id, 'text' : data.text })
            .fail(function () {
                
              data.instance.refresh();
        });
            
    }).on('delete_node.jstree', function (e, data) {


	    $.get('crud_response.php?operation=delete_node', { 'id' : data.node.id})
		
            .fail(function () {
                
              data.instance.refresh();
        });
		
    });
	
	</script>
</body>
</html>