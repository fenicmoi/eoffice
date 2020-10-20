
<?php
date_default_timezone_set('Asia/Bangkok');
include "header.php";
$u_id=$_SESSION['ses_u_id'];
@$cid=$_GET['cid'];
@$doctype=$_GET['doctype'];
if($doctype=="flow-circle"){
	$tb="flowcircle";
	
}elseif ($doctype=="flow-normal") {
	$tb="flownormal";
}

//
if($cid){
	//ก	รณีส่งจากระบบออกเลข
	$sql="SELECT title,file_upload FROM $tb  WHERE cid=$cid";
	$result=dbQuery($sql);
	$row=dbFetchAssoc($result);
	$title=$row['title'];
	$link_file=$row['file_upload'];
	
}

?>
<div class="col-md-2" >
 <?php
$menu=  checkMenu($level_id);
//echo $menu;
include $menu;
?>
</div>
<?php

$sql="SELECT u.puid, u.pid,p.postdate,p.title,p.file,d.dep_name,s.sec_name,us.firstname FROM paperuser u
      INNER JOIN paper p  ON p.pid=u.pid
      INNER JOIN depart d ON d.dep_id=p.dep_id
			INNER JOIN section s ON s.sec_id = p.sec_id
		  INNER JOIN user as us ON us.u_id = p.u_id
      WHERE u.u_id=$u_id AND u.confirm=0 ORDER BY u.puid" ;
//print $sql;
$result = page_query( $dbConn, $sql, 10 );
$numrow=dbNumRows($result);
?>
 <div class="col-md-10">
	            <div class="panel panel-primary">
                <div class="panel-heading"><i class="fas fa-share-square"></i>  <strong>ส่งไฟล์เอกสาร  :ส่งไฟล์เอกสารภายในจังหวัด</strong></div>
                <div class="panel-body">                  
                            <ul class="nav nav-tabs">
                                <li class="active"  ><a class="btn-danger fas fa-envelope"  href="newpaper.php"> เอกสารเข้าใหม่</a></li>
                                <li><a class="btn-danger fas fa-envelope-open" data-toggle="tab" href="#menu1"> เอกสารรับแล้ว</a></li>
                                <li><a class="btn-danger fas fa-history"data-toggle="tab" href="#menu2"> ติดตามการส่ง</a></li>
                                <li><a class="btn-danger fas fa-paper-plane"data-toggle="tab" href="#menu3"> ส่งเอกสาร(ภายใน)</a></li>
                                <li><a class="btn-danger fas fa-globe" data-toggle="tab" href="#menu4"> ส่งเอกสาร (ภายนอก)</a></li>
                            </ul>
               
			<table class="table table-bordered table-hover" id="tbNew" >
				<thead>
						<tr bgcolor="#C8C5C5">
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
