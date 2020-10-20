
<?php
include "header.php"; 
 include 'library/pagination.php';
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
                        <i class="fas fa-clipboard-list  fa-2x" aria-hidden="true"></i>  <strong>ประกาศ/ข่าวสาร/แถลงการณ์</strong>
                </div> <!-- panel -heading-->
                <div class="panel-body">
                     <table class="table table-bordered table-hover" id="tbCommand">
                <thead>
                    <tr>
                        <th>เลขที่อ้างอิง</th>
                        <th>เรื่อง</th>
                        <th>วันที่เผยแพร่</th>
                        <th>เจ้าของเรื่อง</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $sql="SELECT c.*,y.yname,d.dep_name FROM  flowbuy as c 
                          INNER JOIN sys_year as y ON y.yid=c.yid
                          INNER JOIN depart as d ON d.dep_id=c.dep_id";
                    $sql.=" ORDER BY c.cid DESC";
                    $result = page_query( $dbConn, $sql, 20 );                      
                    while($row=dbFetchArray($result)){?>
                        <tr>
                            <td> <?php echo $row['rec_id'];?>/<?php echo $row['yname'];?></td> 
                            <td> <a href="admin/<?php echo $row['file_upload'];?>" target="_blank"> <?php echo $row['title'];?> </a></td>
                            <td><?php echo thaiDate($row['dateout']);?></td>
                            <td> <?php echo $row['dep_name'];?></td>
                          </tr>
                    <?php  } ?>
                </tbody>
            </table>
                </div> <!--div body -->
                <div class="panel-footer">
                         <center>
                        <a href="flow-buy-front.php" class="btn btn-primary"><i class="fas fa-home"></i> หน้าหลัก</a>
                        <?php 
                            page_link_border("solid","1px","gray");
                            page_link_bg_color("lightblue","pink");
                            page_link_font("14px");
                            page_link_color("blue","red");
                            page_echo_pagenums(10,true); 
                        ?>
                        </center>
                </div>
            </div>
        </div>  <!-- col-md-10 -->
    </div>  <!-- container -->