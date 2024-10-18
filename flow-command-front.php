<?php include "header.php";?>
<script type="text/javascript" language="javascript" >
			$(document).ready(function() {
				var dataTable = $('#myTable').DataTable( {
					"order": [[ 0, "desc" ]],
					"processing": true,
					"serverSide": true,
					"ajax":{
						url :"query-commandfront.php", // json datasource
						type: "post",  // method  , by default get
						error: function(){  // error handling
							$(".myTable-error").html("");
							$("#myTable").append('<tbody class="myTable-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
							$("#myTable").css("display","none");
							
						}
					}
				} );
			} );
</script>

<?php
include "admin/function.php"; 
//ตรวจสอบปีเอกสาร
list($yid,$yname,$ystatus)=chkYear();  
$yid=$yid;
$yname=$yname;
$ystatus=$ystatus;
?>
<br><br><br>
        <div  class="col-md-12">
            <div class="panel panel-primary" style="margin: 20">
                <div class="panel-heading">
                        <i class="fas fa-clipboard-list  fa-2x" aria-hidden="true"></i>  <strong>ทะเบียนคำสั่งจังหวัด</strong>
                </div> <!-- panel -heading-->
                     <table id="myTable" cellpadding="0" cellspacing="0"  class="display" width="100%">
                        <thead class="bg-info">
                            <tr>
                                <th width="5%">เลขที่คำสั่ง</th>
                                <th width="60%">เรื่อง</th>
                                <th width="5%">ไฟล์แนบ</th>
                                <th width="10%">ลงวันที่</th>
                                <th width="20%">เจ้าของเรื่อง</th>
                            </tr>
                        </thead>
                       
                    </table>
            </div>
        </div>  <!-- col-md-10 -->
    </div>  <!-- container -->


 <!-- Modal แสดงรายละเอียด -->
  <div  class="modal fade bs-example-modal-table" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-info"></i> รายละเอียดคำสั่ง</h4>
        </div>
        <div class="modal-body no-padding">
            <div id="divDataview"></div>     <!-- สวนสำหรับแสดงผลรายละเอียด   อ้างอิงกับไฟล์  show_command_detail.php -->
        </div> <!-- modal-body -->
        <div class="modal-footer bg-primary">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!--end Modal  -->
<script type="text/javascript">
function load_leave_data(cid) {
                    var sdata = {
                      cid: cid,
                    };
                    $('#divDataview').load('show_command_detail-front.php', sdata);
                  }
</script>
