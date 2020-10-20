<?php
if(!isset($_SESSION['ses_u_id'])){
    header("location:index.php");
}
include_once 'function.php';

// fetch records
$sql = "SELECT * FROM object ORDER BY obj_id";
$result = dbQuery($sql);

// delete record
if (isset($_GET['langid'])) {
    $sql = "DELETE FROM tbl_language WHERE id=" . $_GET['langid'];
    @mysqli_query($con, $sql);
    header("Location: index.php");
}
?>
<div class="container" style="margin-top: 20px;">
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-default">
            <div class="panel-heading"><h3>จัดการวัตถุประสงค์</h3></div>
            <span class="text-success"><?php if (isset($success)) { echo $success; } ?></span>
            <span class="text-danger"><?php if (isset($error)) { echo $error; } ?></span>
            <div class="panel-body text-right">
                 <a href="add_object.php" class="btn btn-default" data-toggle="modal" data-target="#modalAdd">
                     <i class="fa fa-plus" aria-hidden="true"></i>เพิ่มวัตถุประสงค์
                 </a>
            </div>
  
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ที่</th>
                        <th>วัตถุประสงค์</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $cont=1;
                while($row = mysqli_fetch_array($result)) { ?>
                <tr>
                    <td><?php echo $cont; ?></td>
                    <td><?php echo $row['obj_name']; ?></td>
                    <td>
                        <a class="btn btn-default"  href="object_edit.php?obj_id=<?php echo $row['obj_id']; ?>">
                            <i class="fa fa-pencil" aria-hidden="true"></i>   แก้ไข</a>
                    </td>
                    <td>
                        <a class="btn btn-danger" href="javascript: delete_obj(<?php echo $row['obj_id']; ?>)">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>   ลบ
                        </a>
                    </td>
                </tr>
                <?php $cont++; } ?>
                </tbody>
            </table>
            <div class="panel-footer">
                <span class="badge"><?php echo mysqli_num_rows($result) . " เรคคอร์ด"; ?></span>
            </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add -->
<div id="modalAdd" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">เพิ่มวัตถุประสงค์</h4>
      </div>
      <div class="modal-body">
          <form class="form-group" method="post" action="object_insert.php">
              <input class="form-control" id="txtObjname" name="txtObjname" type="text" placeholder="ใส่ชื่อวัตถุประสงค์" required>
              <p></p>
              <center><input type="submit" class="btn btn-primary" value="บันทึกข้อมูล"></center>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="fa fa-times fa-2x""></i>
        </button>
      </div>
    </div>

  </div>
</div> <!--model -->









<script type="text/javascript">
function delete_obj(id)
{
    if (confirm('คุณต้องการลบข้อมูลหรือไม่?'))
    {
        window.location.href = 'index.php?langid=' + id;
    }
}
</script>
</body>
</html>