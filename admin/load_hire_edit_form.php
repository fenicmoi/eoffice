<?php
include 'function.php';
include '../library/database.php';
// ... รวมถึงไฟล์ที่จำเป็นอื่น ๆ

$hire_id = isset($_POST['hire_id']) ? $_POST['hire_id'] : 0;

if ($hire_id > 0) {
    // 1. ดึงข้อมูลสัญญาจ้าง
    $sql = "SELECT h.*, d.dep_name, y.yname
            FROM hire h
            INNER JOIN depart d ON d.dep_id=h.dep_id
            INNER JOIN year_money y ON h.yid=y.yid
            WHERE h.hire_id = " . dbEscapeString($hire_id);
    $result = dbQuery($sql);
    $row = dbFetchArray($result);

    if ($row) {
        // 2. แสดงฟอร์มแก้ไข (ใช้ Modal structure ของคุณ)
?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="fa fa-edit"></i> แก้ไขข้อมูลสัญญาจ้างเลขที่: **<?php echo $row['rec_no'].'/'.$row['yname']; ?>**
            </div>
            <div class="panel-body">
                <form method="post" action="hire-update.php"> <input type="hidden" name="hire_id" value="<?php echo $hire_id; ?>">
                    
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">หน่วยงานเจ้าของงบประมาณ</span>
                            <input type="text" class="form-control" value="<?php echo $row['dep_name'];?>" disabled> 
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group"> 
                            <span class="input-group-addon">รายการจ้าง</span>
                            <input type="text" class="form-control" id="title_edit" name="title" value="<?php echo $row['title'];?>" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group"> 
                            <span class="input-group-addon">วงเงินการจ้าง</span>
                            <input type="number" class="form-control" id="money_edit" name="money" value="<?php echo $row['money'];?>" required="">  
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group"> 
                            <span class="input-group-addon">ผู้รับจ้าง</span>
                            <input type="text" class="form-control" id="employee_edit" name="employee" value="<?php echo $row['employee'];?>" required="" > 
                        </div>
                    </div>     
                    <div class="form-group form-inline">
                        <div class="input-group">
                            <span class="input-group-addon"><label for="datehire_edit">วันทำสัญญา :</label></span>
                            <input class="form-control" type="date" name="datehire" id="datehire_edit" value="<?php echo $row['date_hire'];?>" required > 
                        </div>
                    </div>
                    <div class="form-group form-inline">
                        <div class="input-group">
                            <span class="input-group-addon"><label for="datesubmit_edit">วันส่งงาน :</label></span>
                            <input class="form-control" type="date" name="date_submit" id="datesubmit_edit" value="<?php echo $row['date_hire'];?>" required > 
                        </div>
                    </div>
                      <div class="form-group">
                        <div class="input-group"> 
                            <span class="input-group-addon">ผู้ลงนาม</span>
                            <input type="text" class="form-control" id="signer_edit" name="signer" value="<?php echo $row['signer'];?>" required="" > 
                        </div>
                    </div>  
                      <div class="form-group">
                        <div class="input-group"> 
                            <span class="input-group-addon">หลักประกันสัญญา</span>
                            <input type="number" class="form-control" id="guarantee_edit" name="guarantee" value="<?php echo $row['guarantee'];?>" required="">  
                        </div>
                    </div>
                    
                    <center>
                        <button class="btn btn-success" type="submit" name="update_hire">
                            <i class="fa fa-save fa-2x"></i> บันทึกการแก้ไข
                        </button>
                    </center>                                                         
                </form>
            </div>
        </div>
<?php
    } else {
        echo "<div class='alert alert-danger'>ไม่พบข้อมูลสัญญาจ้างที่ต้องการแก้ไข</div>";
    }
} else {
    echo "<div class='alert alert-danger'>ไม่พบ ID สัญญาจ้าง</div>";
}
?>