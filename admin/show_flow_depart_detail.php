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
     <form name="edit" action="FlowResiveDepart.php" method="post" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
          <input type="hidden" name="cid" value="<?php echo $cid; ?>">
          <input type="hidden" name="u_id" value="<?php echo $u_id; ?>">

          <table class="detail-table">
               <tr>
                    <td class="detail-label"><i class="fas fa-hashtag"></i> เลขทะเบียนรับ</td>
                    <td>
                         <div class="detail-value"><?php print $row['rec_no'] ?>/<?php print $row['yname']; ?></div>
                    </td>
                    <td class="detail-label"><i class="fas fa-barcode"></i> เลขหนังสือ</td>
                    <td>
                         <input type="text" class="form-control" name="book_no"
                              value="<?php echo htmlspecialchars($row['book_no']); ?>">
                    </td>
               </tr>
               <tr>
                    <td class="detail-label"><i class="fas fa-bookmark"></i> เรื่อง</td>
                    <td colspan="3">
                         <input type="text" class="form-control" name="title"
                              value="<?php echo htmlspecialchars($row['title']); ?>">
                    </td>
               </tr>
               <tr>
                    <td class="detail-label"><i class="fas fa-paper-plane"></i> ผู้ส่ง</td>
                    <td colspan="3"><input type="text" class="form-control" name="sendfrom"
                              value="<?php echo htmlspecialchars($row['sendfrom']); ?>"></td>
               </tr>
               <tr>
                    <td class="detail-label"><i class="fas fa-user-tag"></i> ผู้รับ</td>
                    <td colspan="3"><input type="text" class="form-control" name="sendto"
                              value="<?php echo htmlspecialchars($row['sendto']); ?>"></td>
               </tr>
               <tr>
                    <td class="detail-label"><i class="far fa-calendar-alt"></i> ลงวันที่</td>
                    <td>
                         <input type="date" class="form-control" name="dateout" value="<?php echo $row['dateout']; ?>">
                    </td>
                    <td class="detail-label"><i class="far fa-clock"></i> วันที่ลงรับ</td>
                    <td>
                         <div class="detail-value"><?php print thaiDate($row['datein']); ?></div>
                    </td>
               </tr>
               <tr>
                    <td class="detail-label"><i class="fas fa-university"></i> หน่วยปฏิบัติ</td>
                    <td colspan="3">
                         <select class="form-control selectpicker" data-live-search="true" name="remark"
                              style="width: 100%;">
                              <option value="">-- เลือกหน่วยปฏิบัติ --</option>
                              <?php
                              // Assuming $row['dep_id'] is available or using session dep_id? 
                              // The existing query joins section s ON s.sec_id = dep.remark
                              // We should load sections for the current department.
                              // $dep_id is not in $_POST, but in $row['dep_id']
                              $current_dep_id = $row['dep_id'];
                              $sql_s = "SELECT * FROM section WHERE dep_id = $current_dep_id ORDER BY sec_name";
                              $res_s = dbQuery($sql_s);
                              while ($r_s = dbFetchArray($res_s)) {
                                   $selected = ($r_s['sec_id'] == $row['remark']) ? "selected" : "";
                                   echo "<option value='" . $r_s['sec_id'] . "' $selected>" . $r_s['sec_name'] . "</option>";
                              }
                              ?>
                         </select>
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
               <tr>
                    <td colspan="4" style="padding-top: 2rem;">
                         <hr style="border-top: 1px solid #eaecf4; margin-bottom: 2rem;">

                         <div class="text-center">
                              <button class="btn btn-warning btn-lg" type="submit" name="btnUpdate"
                                   style="min-width: 160px; font-weight: 700; border-radius: 30px;">
                                   <i class="fas fa-save"></i> บันทึกแก้ไข
                              </button>
                         </div>
                    </td>
               </tr>
          </table>
     </form>
</div>
<script>
     $('.selectpicker').selectpicker(); // Initialize selectpicker
</script>