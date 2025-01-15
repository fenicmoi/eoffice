
<?php
date_default_timezone_set('Asia/Bangkok');
include "header.php";
$u_id=$_SESSION['ses_u_id'];
?>
<script> //search option
	$( document ).ready( function () {
		// $("#btnSearch").prop("disabled",true); 
		$( "#dateSearch" ).hide();
		$( "tr" ).first().hide();


		$( "#hideSearch" ).click( function () {
			$( "tr" ).first().show( 1000 );
		} );


		$( '#typeSearch' ).change( function () {
			var typeSearch = $( '#typeSearch' ).val();
			if ( typeSearch == 4 ) {
				$( "#dateSearch" ).show( 500 );
				$( "#search" ).hide( 500 );
			} else {
				$( "#dateSearch" ).hide( 500 );
				$( "#search" ).show( 500 );
			}
		} )
	} );
</script>

<div class="col-md-2" >
 <?php
	$menu=  checkMenu($level_id);
	include $menu;
 ?>
</div>
<?php

$sql="SELECT p.pid,u.puid, u.pid,p.postdate,p.title,p.file,p.book_no,d.dep_name,s.sec_name,us.firstname FROM paperuser u
      INNER JOIN paper p  ON p.pid=u.pid
      INNER JOIN depart d ON d.dep_id=p.dep_id
	  INNER JOIN section s ON s.sec_id = p.sec_id
	  INNER JOIN user as us ON us.u_id = p.u_id
      WHERE u.u_id=$u_id AND u.confirm=0 ORDER BY u.puid DESC" ;
//print $sql;
//$result = page_query( $dbConn, $sql, 10 );
$result = dbQuery($sql);
$numrow=dbNumRows($result);
?>
 <div class="col-md-10">
	            <div class="panel panel-primary">
                <div class="panel-heading"><i class="fas fa-share-square fa-2x"></i>  <strong>ส่งไฟล์เอกสาร</strong></div>
				<div class="panel-body">                  
                            <ul class="nav nav-tabs">
                                <li class="active"  ><a class="btn-danger fas fa-envelope"  href="paper.php">  หนังสือเข้า</a></li>
                                <li><a class="btn-danger fas fa-envelope-open"  href="folder.php"> รับแล้ว</a></li>
                                <li><a class="btn-danger fas fa-history" href="history.php"> ส่งแล้ว</a></li>
                                <li><a class="btn-danger fas fa-globe" href="outside_all.php"> ส่งหนังสือ</a></li>
                            </ul>
               
			<table class="table table-bordered table-hover" id="myTable" >
				<thead>
						<tr bgcolor="#C8C5C5">
								<th></th>
								<th>ที่</th>
								<th>เรื่อง</th>
								<th>หน่วยส่ง</th>
								<th>ตรวจสอบ</th>
								<th>วันที่ส่ง</th>
								<th>เวลา</th>
								<th>รับ</th>
								<th>คืน</th>
						</tr>
				</thead>
				 <tbody>
						<?php
					 	
						 while($rowNew = dbFetchArray($result)){?>
					 					
									 <tr>
											<td><i class="fas fa-envelope-square"></i></td>
											<td>
												<?php 
													if($rowNew['book_no']==null){
														echo "...";
													}else{
														echo $rowNew['book_no'];
													}
												?>
											</td>
											<td><a href="<?php echo $rowNew['file'];?>" target="_blank">	<?php echo $rowNew['title']; ?></a></td>
											<td><?php echo $rowNew['dep_name']; ?></td>
											<td><a href="checklist.php?pid=<?php print $rowNew['pid'];?>" class="badge" target="_blank">หน่วยรับร่วม</a></td>
											<td><?php echo thaiDate(substr($rowNew['postdate'],0,10)) ?></td>
											<td><?php echo substr($rowNew['postdate'],10);?></td>
											<?php
												if($level_id>5) {?>
														<td><kbd>จำกัดสิทธิ์</kbd></td>
											 <?php } else{?>
														<td>
															<a class="btn btn-warning"
															 href="recive.php?pid=<?php echo $rowNew['pid'];?>&sec_id=<?php echo $sec_id; ?>&dep_id=<?php echo $dep_id; ?>&confirm=1">
																  
															 <i class="fas fa-check"></i> ลงรับ
															</a>
														</td>
											 <?php } ?>
											 <?php
												if($level_id>5) {?>
														<td><kbd>จำกัดสิทธิ์</kbd></td>
											 <?php } else{?>
														<td><a class="btn btn-danger" 
														       href="recive.php?pid=<?php echo $rowNew['pid'];?>&sec_id=<?php echo $sec_id; ?>&dep_id=<?php echo $dep_id; ?>&confirm=2">
															   <i class="fa fa-close"></i> ส่งคืน
															</a>
														</td>
											 <?php } ?>

										</tr>
						<?php  }?>                              
				</tbody>
		 </table>
		 </div> <!-- panel body-->
	 </div> <!-- panel primary -->
</div>
