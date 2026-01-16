<?php
date_default_timezone_set('Asia/Bangkok');
include 'function.php';
include '../library/database.php';

$cid = $_POST['cid'];
$u_id = $_POST['u_id'];
$sql = "SELECT dep.*,d.dep_name,s.sec_name,y.yname,u.firstname
      FROM flow_recive_depart as dep
      INNER JOIN depart as d ON d.dep_id = dep.dep_id
      INNER JOIN section as s ON s.sec_id = dep.remark
      INNER JOIN user as u ON u.u_id = dep.u_id
      INNER JOIN sys_year as y ON y.yid = dep.yid
      WHERE dep.cid=$cid";
//print $sql;
$result = dbQuery($sql);
$row = dbFetchAssoc($result);
?>
<div class="detail-modal-container">
     <table class="detail-table">
          <tr>
               <td class="detail-label"><i class="fas fa-hashtag"></i> เลขทะเบียนรับ</td>
               <td>
                    <div class="detail-value"><?php print $row['rec_no'] ?>/<?php print $row['yname']; ?></div>
               </td>
               <td class="detail-label"><i class="fas fa-barcode"></i> เลขหนังสือ</td>
               <td>
                    <div class="detail-value"><?php print $row['book_no'] ?></div>
               </td>
          </tr>
          <tr>
               <td class="detail-label"><i class="fas fa-bookmark"></i> เรื่อง</td>
               <td colspan="3">
                    <div class="detail-value-text"><?php print $row['title'] ?></div>
               </td>
          </tr>
          <tr>
               <td class="detail-label"><i class="fas fa-paper-plane"></i> ผู้ส่ง</td>
               <td colspan="3"><input disabled type="text" value="<?php print $row['sendfrom'] ?>"></td>
          </tr>
          <tr>
               <td class="detail-label"><i class="fas fa-user-tag"></i> ผู้รับ</td>
               <td colspan="3"><input disabled type="text" value="<?php print $row['sendto'] ?>"></td>
          </tr>
          <tr>
               <td class="detail-label"><i class="far fa-calendar-alt"></i> ลงวันที่</td>
               <td>
                    <div class="detail-value"><?php print thaiDate($row['dateout']); ?></div>
               </td>
               <td class="detail-label"><i class="far fa-clock"></i> วันที่ลงรับ</td>
               <td>
                    <div class="detail-value"><?php print thaiDate($row['datein']); ?></div>
               </td>
          </tr>
          <tr>
               <td class="detail-label"><i class="fas fa-university"></i> หน่วยปฏิบัติ</td>
               <td colspan="3">
                    <div class="detail-value-text"><label id="under"><?php print $row['sec_name']; ?></label></div>
               </td>
          </tr>
          <tr>
               <td class="detail-label"><i class="fas fa-user-edit"></i> เจ้าหน้าที่ลงรับ</td>
               <td colspan="3">
                    <div class="detail-value-text">
                         <?php print $row['firstname'] ?>
                         <span class="text-muted"
                              style="font-weight: 400; font-size: 0.9rem; margin-left: 0.5rem;">(<?php print $row['time_stamp']; ?>
                              น.)</span>
                    </div>
               </td>
          </tr>
     </table>
</div>