
<?php
date_default_timezone_set('Asia/Bangkok');
include "header.php";
$u_id=$_SESSION['ses_u_id'];
?>
<div class="col-md-2" >
 <?php
	$menu=  checkMenu($level_id);
	include $menu;
 ?>
</div>
<?php

$sql="SELECT u.puid, u.pid,p.postdate,p.title,p.file,p.book_no,d.dep_name,s.sec_name,us.firstname FROM paperuser u
      INNER JOIN paper p  ON p.pid=u.pid
      INNER JOIN depart d ON d.dep_id=p.dep_id
	  INNER JOIN section s ON s.sec_id = p.sec_id
	  INNER JOIN user as us ON us.u_id = p.u_id
      WHERE u.u_id=$u_id AND u.confirm=0 ORDER BY u.puid DESC" ;
//print $sql;
$result = page_query( $dbConn, $sql, 10 );
$numrow=dbNumRows($result);
?>
 <div class="col-md-10">
	            <div class="panel panel-primary">
                <div class="panel-heading"><i class="fas fa-share-square fa-2x"></i>  <strong>ส่งไฟล์เอกสาร</strong></div>
                <div class="panel-body">                  
                            <ul class="nav nav-tabs">
                                <li class="active"  ><a class="btn-danger fas fa-envelope"  href="paper.php">  จดหมายเข้า</a></li>
                                <li><a class="btn-danger fas fa-envelope-open"  href="folder.php"> รับแล้ว</a></li>
                                <li><a class="btn-danger fas fa-history" href="history.php"> ส่งแล้ว</a></li>
                                <li><a class="btn-danger fas fa-paper-plane" href="inside_all.php"> ส่งภายใน</a></li>
                                <li><a class="btn-danger fas fa-globe" href="outside_all.php"> ส่งภายนอก</a></li>
                            </ul>
               
			<table class="table table-bordered table-hover" id="tbNew" >
				<thead>
						<tr bgcolor="#C8C5C5">
								<th></th>
								<th>ที่</th>
								<th>เรื่อง</th>
								<th>หน่วยส่ง</th>
								<th>กลุ่มงาน</th>
								<th>วันที่ส่ง</th>
								<th>รับเอกสาร</th>
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
											<td><?php echo $rowNew['sec_name'];?></td>
											<td><?php echo thaiDate(substr($rowNew['postdate'],0,10)) ?></td>
											<?php
												if($level_id>5) {?>
														<td><kbd>จำกัดสิทธิ์</kbd></td>
											 <?php } else{?>
														<td><a class="btn btn-success" href="recive.php?pid=<?php echo $rowNew['pid']; ?>&sec_id=<?php echo $sec_id; ?>&dep_id=<?php echo $dep_id; ?>"><i class="fas fa-check"></i> ลงรับ</a></td>
											 <?php } ?>

										</tr>
						<?php  }?>                              
				</tbody>
		 </table>
		 </div> <!-- panel body-->
		<div class="panel-footer">
			<center>
				<?php 
						page_link_border("solid","1px","gray");
						page_link_bg_color("lightblue","pink");
						page_link_font("14px");
						page_link_color("blue","red");
						page_echo_pagenums(10,true); 
				?>
			</center>
		</div>
	 </div> <!-- panel primary -->
</div>
