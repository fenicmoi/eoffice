<?php
// This file is loaded via AJAX into the modal body
include "../library/database.php";
include "../library/config.php";

$u_id = $_GET['edit'];
// Fetch user data
$sql = "SELECT u.*, d.dep_name, s.sec_name, o.type_id
        FROM user u 
        INNER JOIN depart d ON d.dep_id = u.dep_id
        INNER JOIN section s ON s.sec_id = u.sec_id
        INNER JOIN office_type o ON o.type_id = d.type_id
        WHERE u.u_id = ?";
$result = dbQuery($sql, "i", [(int) $u_id]);
$getROW = dbFetchAssoc($result);

$dep_id = $getROW['dep_id'];
$sec_cur = $getROW['sec_id']; // current section
$type_id = $getROW['type_id']; // current office type
$status = $getROW['status'];
$level_id = $getROW['level_id'];
$keyman = $getROW['keyman'];

?>

<form id="editUserForm" method="post" action="user_update_action.php">
    <input type="hidden" name="u_id" value="<?php echo $u_id; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>สถานะการใช้งาน</label>
                <label class="radio-inline"><input type="radio" name="status" value="1" <?php echo ($status == 1) ? 'checked' : ''; ?>> ใช้งาน</label>
                <label class="radio-inline"><input type="radio" name="status" value="0" <?php echo ($status == 0) ? 'checked' : ''; ?>> ระงับการใช้งาน</label>
            </div>

            <div class="form-group">
                <label>สิทธิ์การใช้งาน</label>
                <select name="level" class="form-control">
                    <option value="1" <?php echo ($level_id == 1) ? 'selected' : ''; ?>>ผู้ดูแลระบบ</option>
                    <option value="2" <?php echo ($level_id == 2) ? 'selected' : ''; ?>>สารบรรณกลาง</option>
                    <option value="3" <?php echo ($level_id == 3) ? 'selected' : ''; ?>>สารบรรณประจำหน่วยงาน</option>
                    <option value="4" <?php echo ($level_id == 4) ? 'selected' : ''; ?>>สารบรรณประจำกลุ่มงาน</option>
                    <option value="5" <?php echo ($level_id == 5) ? 'selected' : ''; ?>>ผู้ใช้ทั่วไป</option>
                </select>
            </div>

            <div class="form-group">
                <label>สิทธิ์การรับเอกสาร (Keyman)</label>
                <label class="radio-inline"><input type="radio" name="keyman" value="1" <?php echo ($keyman == 1) ? 'checked' : ''; ?>> มีสิทธิ์</label>
                <label class="radio-inline"><input type="radio" name="keyman" value="0" <?php echo ($keyman == 0) ? 'checked' : ''; ?>> ไม่มีสิทธิ์</label>
            </div>

            <hr>

            <div class="form-group">
                <label>ประเภทส่วนราชการ</label>
                <select name="province" id="edit_province" class="form-control" required>
                    <option value="">- เลือก -</option>
                    <?php
                    $sql = "SELECT * FROM office_type ORDER BY type_id";
                    $res = dbQuery($sql);
                    while ($row = dbFetchAssoc($res)) {
                        $selected = ($row['type_id'] == $type_id) ? 'selected' : '';
                        echo "<option value='{$row['type_id']}' $selected>{$row['type_name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>ชื่อส่วนราชการ</label>
                <select name="amphur" id="edit_amphur" class="form-control" required>
                    <?php
                    // Pre-load distinct departments based on current type
                    $sql = "SELECT * FROM depart WHERE type_id = ? ORDER BY dep_name";
                    $res = dbQuery($sql, 'i', [$type_id]);
                    while ($row = dbFetchAssoc($res)) {
                        $selected = ($row['dep_id'] == $dep_id) ? 'selected' : '';
                        echo "<option value='{$row['dep_id']}' $selected>{$row['dep_name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>หน่วยงานย่อย</label>
                <select name="district" id="edit_district" class="form-control" required>
                    <?php
                    // Pre-load sections based on current department
                    $sql = "SELECT * FROM section WHERE dep_id = ? ORDER BY sec_name";
                    $res = dbQuery($sql, 'i', [$dep_id]);
                    while ($row = dbFetchAssoc($res)) {
                        $selected = ($row['sec_id'] == $sec_cur) ? 'selected' : '';
                        echo "<option value='{$row['sec_id']}' $selected>{$row['sec_name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>ชื่อ</label>
                        <input type="text" name="firstname" class="form-control"
                            value="<?php echo htmlspecialchars($getROW['firstname']); ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>นามสกุล</label>
                        <input type="text" name="lastname" class="form-control"
                            value="<?php echo htmlspecialchars($getROW['lastname']); ?>" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>ตำแหน่ง</label>
                <input type="text" name="position" class="form-control"
                    value="<?php echo htmlspecialchars($getROW['position']); ?>">
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>ชื่อผู้ใช้</label>
                        <input type="text" name="u_name" class="form-control"
                            value="<?php echo htmlspecialchars($getROW['u_name']); ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>รหัสผ่าน (เว้นว่างหากไม่เปลี่ยน)</label>
                        <input type="password" name="u_pass" class="form-control" placeholder="******">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                    value="<?php echo htmlspecialchars($getROW['email']); ?>" required>
            </div>

            <div class="form-group">
                <label>เบอร์โทร</label>
                <input type="text" name="telphone" class="form-control"
                    value="<?php echo htmlspecialchars($getROW['telphone']); ?>">
            </div>

            <input type="hidden" name="date_user" value="<?php echo date('Y-m-d'); ?>">

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                <button type="submit" name="update" class="btn btn-primary"><i class="fa fa-save"></i>
                    บันทึกการแก้ไข</button>
            </div>

        </div>
    </div>
</form>

<script>
    // Modern Dropdown Logic using Fetch API
    document.getElementById('edit_province').addEventListener('change', function () {
        loadDropdown('amphur', this.value, 'edit_amphur');
        // Clear next level
        document.getElementById('edit_district').innerHTML = '<option value="">- เลือก -</option>';
    });

    document.getElementById('edit_amphur').addEventListener('change', function () {
        loadDropdown('district', this.value, 'edit_district');
    });

    function loadDropdown(type, val, targetId) {
        if (!val) return;

        fetch('api_location.php?data=' + type + '&val=' + val)
            .then(response => response.json())
            .then(data => {
                let options = '<option value="">- เลือก -</option>';
                data.forEach(item => {
                    options += `<option value="${item.id}">${item.name}</option>`;
                });
                document.getElementById(targetId).innerHTML = options;
                // Refresh selectpicker if used (optional, depends on if we use standard select or bootstrap-select in modal)
                // $('#' + targetId).selectpicker('refresh'); 
            })
            .catch(error => console.error('Error:', error));
    }
</script>