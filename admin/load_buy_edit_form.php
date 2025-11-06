<?php
// load_buy_edit_form.php (ฉบับปรับปรุง)
include 'function.php';
include '../library/database.php';
// อาจจะต้องรวมไฟล์ header.php หรือ config.php ด้วยหากโค้ดส่วนอื่นต้องการ

$buy_id = isset($_POST['buy_id']) ? $_POST['buy_id'] : 0;

if ($buy_id > 0) {
    // 1. ดึงข้อมูลสัญญาซื้อ/ขายทั้งหมดจากตาราง buy
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
                            <span class="input-group-addon">ผู้ว่าจ้าง/ผู้มีอำนาจ</span>
                            <input type="text" class="form-control" id="governer_edit" name="governer" value="<?php echo $row['governer'];?>" required > 
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">รายการซื้อ/ขาย</span>
                            <input type="text" class="form-control" id="title_edit" name="title" value="<?php echo $row['title'];?>" required > 
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
                            <span class="input-group-addon">ผู้จัดการ/ตัวแทน</span>
                            <input type="text" class="form-control" id="manager_edit" name="manager" value="<?php echo $row['manager'];?>" required > 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">ที่อยู่บริษัท (Add1)</span>
                            <input type="text" class="form-control" id="add1_edit" name="add1" value="<?php echo $row['add1'];?>" required > 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-group"> 
                            <span class="input-group-addon">ผู้ลงนาม</span>
                            <input type="text" class="form-control" id="signer_edit" name="signer" value="<?php echo $row['signer'];?>" required=""> 
                        </div>
                    </div>  
                    
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">ที่อยู่ผู้ลงนาม (Add2)</span>
                            <input type="text" class="form-control" id="add2_edit" name="add2" value="<?php echo $row['add2'];?>" required > 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">เบอร์โทรศัพท์</span>
                            <input type="text" class="form-control" id="telphone_edit" name="telphone" value="<?php echo $row['telphone'];?>" > 
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">รายละเอียดสินค้า/บริการ</span>
                            <input type="text" class="form-control" id="product_edit" name="product" value="<?php echo $row['product'];?>" required > 
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">สถานที่จัดส่ง/ปฏิบัติงาน</span>
                            <input type="text" class="form-control" id="location_edit" name="location" value="<?php echo $row['location'];?>" required > 
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
                            <span class="input-group-addon">ชื่อธนาคาร</span>
                            <input type="text" class="form-control" id="bank_edit" name="bank" value="<?php echo $row['bank'];?>" > 
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">สาขาธนาคาร</span>
                            <input type="text" class="form-control" id="brance_edit" name="brance" value="<?php echo $row['brance'];?>" > 
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">เลขที่หนังสืออนุมัติ</span>
                            <input type="text" class="form-control" id="doc_num_edit" name="doc_num" value="<?php echo $row['doc_num'];?>" > 
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">วันที่หนังสืออนุมัติ</span>
                            <input type="date" class="form-control" id="date_num_edit" name="date_num" value="<?php echo $row['date_num'];?>" > 
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