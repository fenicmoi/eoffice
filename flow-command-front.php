
<script type="text/javascript" language="javascript" >
			$(document).ready(function() {
				var dataTable = $('#myTable').DataTable( {
          order: [[ 0, 'desc' ], [ 0, 'asc' ]],
					"processing": true,
					"serverSide": true,
          "resonsive": true,
        
          "language": {
                "sLengthMenu": "แสดง _MENU_ เร็คคอร์ด ต่อหน้า",
                "sZeroRecords": "ไม่พบข้อมูลที่ค้นหา",
                "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ เร็คคอร์ด",
                "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 เร็คคอร์ด",
                "sInfoFiltered": "(จากเร็คคอร์ดทั้งหมด _MAX_ เร็คคอร์ด)",
                "sSearch": "ค้นหา: ",
                "oPaginate": {
                    "sFirst":    "หน้าแรก",
                    "sPrevious": "ก่อนหน้า",
                    "sNext":     "ถัดไป",
                    "sLast":     "หน้าสุดท้าย"
                }
            },
					"ajax":{
						url :"query-commandfront.php", // json datasource
						type: "post",  // method  , by default get
						error: function(){  // error handling
							$(".myTable-error").html("");
							$("#myTable").append('<tbody class="myTable-error"><tr><th colspan="3">ไม่มีข้อมูล</th></tr></tbody>');
							$("#myTable").css("display","none");
							
						}
					}
				} );
			} );
</script>

<br><br><br>
<div class ="row"
        <div  class="col-md-12">
            <div class="panel panel-primary" style="margin: 20">
                <div class="panel-heading">
                        <i class="fas fa-clipboard-list  fa-2x" aria-hidden="true"></i>  <strong>ทะเบียนคำสั่งจังหวัด</strong>
                </div> <!-- panel -heading-->
                     <table id="myTable" cellpadding="0" cellspacing="0"  class="display" width="100%">
                        <thead class="bg-info">
                            <tr>
                                <th>เลขที่คำสั่ง</th>
                                <th>เรื่อง</th>
                                <th>ลงวันที่</th>
                                <th>ไฟล์แนบ</th>
                                <th >เจ้าของเรื่อง</th>
                            </tr>
                        </thead>
                        <tfoot>
                                <th>เลขที่คำสั่ง</th>
                                <th>เรื่อง</th>
                                <th>ลงวันที่</th>
                                <th>ไฟล์แนบ</th>
                                <th>เจ้าของเรื่อง</th>
                        </tfoot>
                    </table>
            </div>
        </div>  <!-- col-md-10 -->
    </div> <!-- row -->
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
