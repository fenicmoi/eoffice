
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

$sql = "SELECT p.*,d.dep_name,s.sec_name 
        FROM paper as p 
        INNER JOIN depart as d  ON d.dep_id = p.dep_id 
        INNER JOIN section as s ON s.sec_id = p.sec_id  
        ORDER BY `p`.`pid` DESC";
//print $sql;
$result = page_query( $dbConn, $sql, 10 );
$numrow=dbNumRows($result);
?>
 <div class="col-md-10">
	            <div class="panel panel-primary">
                <div class="panel-heading"><i class="fas fa-share-square fa-2x"></i>  <strong>ตรวจสอบเอกสารที่ส่งทั้งหมดในระบบ</strong></div>
                <div class="panel-body">                  
			<table class="table table-bordered table-hover" id="tbNew" >
				<thead>
						<tr bgcolor="#C8C5C5">
								<th></th>
								<th>ที่</th>
								<th>เรื่อง</th>
								<th>หน่วยส่ง</th>
								<th>กลุ่มงาน</th>
								<th>วันที่ส่ง</th>
								<th>เวลา</th>
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
										<td><?php echo substr($rowNew['postdate'],10);?></td>
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
