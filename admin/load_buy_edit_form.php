<?php
// load_buy_edit_form.php
include 'function.php';
include '../library/database.php';
// ... รวมถึงไฟล์ที่จำเป็นอื่น ๆ เช่น header.php หากจำเป็นสำหรับการใช้ฟังก์ชันอื่นๆ
?>

<?php
$buy_id = isset($_POST['buy_id']) ? $_POST['buy_id'] : 0;

if ($buy_id > 0) {
    // 1. ดึงข้อมูลสัญญาซื้อ/ขาย
    $sql = "SELECT b.*, d.dep_name, y.yname
            FROM buy b
            INNER JOIN depart d ON d.dep_id=b.dep_id
            INNER JOIN year_money y ON b.yid=y.yid
            WHERE b.buy_id = " . dbEscapeString($buy_id);
    $result = dbQuery($sql);
    $row = dbFetchArray($result);

    if ($row) {
        // 2. แสดงฟอร์มแก้ไข
?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <i class="fa fa-edit"></i> แก้ไขข้อมูลสัญญาซื้อ/ขายเลขที่: **<?php echo $row['rec_no'].'/'.$row['yname']; ?>**
            </div>
            <div class="panel-body">
                <form method="post" action="buy-update.php"> 
                    <input type="hidden" name="buy_id" value="<?php echo $buy_id; ?>">
                    <input type="hidden" name="rec_no" value="<?php echo $row['rec_no']; ?>">
                    <input type="hidden" name="yname" value="<?php echo $row['yname']; ?>">
                    
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">รายการซื้อ/ขาย</span>
                            <input type="text" class="form-control" id="title_edit" name="title" value="<?php echo $row['title'];?>" required > 
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">จำนวนเงิน (บาท)</span>
                            <input type="number" step="0.01" class="form-control" id="money_edit" name="money" value="<?php echo $row['money'];?>" required > 
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">เงินโครงการ</span>
                            <input type="number" step="0.01" class="form-control" id="money_project_edit" name="money_project" value="<?php echo $row['money_project'];?>" required > 
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">คู่สัญญา/บริษัท</span>
                            <input type="text" class="form-control" id="company_edit" name="company" value="<?php echo $row['company'];?>" required > 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">วันที่ทำสัญญา</span>
                            <input type="date" class="form-control" id="date_submit_edit" name="date_submit" value="<?php echo $row['date_submit'];?>" required > 
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">วันสิ้นสุดสัญญา</span>
                            <input type="date" class="form-control" id="date_stop_edit" name="date_stop" value="<?php echo $row['date_stop'];?>" required > 
                        </div>
                    </div>
                    
                      <div class="form-group">
                        <div class="input-group"> 
                            <span class="input-group-addon">ผู้ลงนาม</span>
                            <input type="text" class="form-control" id="signer_edit" name="signer" value="<?php echo $row['signer'];?>" required=""> 
                        </div>
                    </div>  
                      
                    <center>
                        <button class="btn btn-success" type="submit" name="update_buy">
                            <i class="fa fa-save fa-2x"></i> บันทึกการแก้ไข
                        </button>
                    </center>                                                         
                </form>
            </div>
        </div>
<?php
    } else {
        echo "<div class='alert alert-danger'>ไม่พบข้อมูลสัญญาซื้อ/ขายที่ต้องการแก้ไข</div>";
    }
} else {
    echo "<div class='alert alert-danger'>ไม่พบ ID สัญญาซื้อ/ขาย</div>";
}
?>