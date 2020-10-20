<?php


 /*+++++++++++เอกสารภายนอก ++++++++++++++++++++*/

 $sql="SELECT u.puid,u.pid,p.postdate,p.title,p.file,d.dep_name FROM paperuser u
             INNER JOIN paper p ON p.pid=u.pid
             INNER JOIN depart d ON d.dep_id=p.dep_id
             WHERE u.dep_id=$dep_id AND u.confirm=0 AND p.outsite=1 ORDER BY u.puid";  
$result=dbQuery($sql);
?>
<div>เอกสารส่งจากภายนอก</div>
<table class="table table-bordered table-hover" id="outside">
    <thead>
        <tr>
            <th>ที่</th>
            <th>เรื่อง</th>
            <th>ผู้ส่ง</th>
            <th>ไฟล์</th>
            <th>วันที่ส่ง</th>
            <th>รับเอกสาร</th>
        </tr>
    </thead>
     <tbody>
        <?php
         $count=1;
         while($row = dbFetchArray($result)){?>
               <tr>
                  <td><?php echo $count;?></td>
                  <td><?php echo $row['title']; ?></td>
                  <td><?php echo $row['dep_name']; ?></td>
                  <td><a href="<?php print $row['file'];?>" target="_blank"><i class="fa fa-file-pdf-o"></i></a></td>
                  <td><?php echo DateThai($row['postdate']); ?></td>
                  <?php
                    if($level_id>3) {?>
                        <td><kbd>จำกัดสิทธิ์</kbd></td>
                   <?php } else{?>
                        <td><a class="btn btn-primary" href="recive.php?pid=<?php echo $row['pid']; ?>&sec_id=<?php echo $sec_id; ?>&dep_id=<?php echo $dep_id; ?>">ลงรับ</a></td>
                   <?php } ?>
                  
                </tr>
        <?php $count++; }?>                              
    </tbody>
 </table>

<script type='text/javascript'>
       $('#outside').DataTable( {
        "order": [[ 0, "desc" ]]
    } )
</script>   