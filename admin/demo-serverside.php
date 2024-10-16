<?php include "header.php";?>
<script type="text/javascript" language="javascript" >
			$(document).ready(function() {
				var dataTable = $('#myTable').DataTable( {
					"order": [[ 0, "desc" ]],
					"processing": true,
					"serverSide": true,
					"ajax":{
						url :"serverside1.php", // json datasource
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
	<body>
		<div class="header"><h1>DataTable demo (Server side) in Php,Mysql and Ajax By fordev22.com  </h1></div>
		<div class="container">
			<table id="myTable" cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
					<thead>
						<tr>
							<th>u_id</th>
							<th>firstname</th>
							<th>lastname</th>
							<th>position</th>
						</tr>
					</thead>
					<tfoot>
							<th>u_id</th>
							<th>firstname</th>
							<th>lastname</th>
							<th>position</th>
					</tfoot>
			</table>
		</div>
	</body>
</html>