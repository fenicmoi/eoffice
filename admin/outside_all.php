<script>
    $(document).ready(function () {
        // No longer needed as we removed the old table
        // $('#tbOutside').DataTable(); 
    });
</script>
<?php
date_default_timezone_set('Asia/Bangkok');
include "header.php";

// checkuser login
if (!isset($_SESSION['ses_u_id'])) {
    header("Location: ../index.php");
    exit();
} else {
    // ป้องกัน XSS ในค่า $u_id ที่มาจาก session
    $u_id = htmlspecialchars($_SESSION['ses_u_id'], ENT_QUOTES, 'UTF-8');

    // ใช้ FILTER_VALIDATE_INT เพื่อตรวจสอบและทำความสะอาดค่าที่รับมา
    @$cid = filter_input(INPUT_GET, 'cid', FILTER_VALIDATE_INT);
    @$doctype = filter_input(INPUT_GET, 'doctype', FILTER_SANITIZE_STRING);

    // ตรวจสอบความถูกต้องของ $cid 
    if ($cid === false) {
        $cid = null;
    }
}

if ($doctype == "flow-circle") {
    $tb = "flowcircle";
} elseif ($doctype == "flow-normal") {
    $tb = "flownormal";
} else {
    // กำหนดค่าเริ่มต้นหรือจัดการกรณีที่ไม่ถูกต้อง
    $tb = null;
}

// ส่วนที่ 1: การใช้ Prepared Statements ในส่วนดึงข้อมูล
if ($cid && $tb) {
    // ใช้ Prepared Statement เพื่อป้องกัน SQL Injection
    $sql = "SELECT title,file_upload FROM $tb  WHERE cid=?";
    $result = dbQuery($sql, 'i', [$cid]); // 'i' คือ integer สำหรับ $cid

    if ($result) {
        $row = dbFetchAssoc($result);
        if ($row) {
            // ป้องกัน XSS เมื่อแสดงผล
            $title = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
            $link_file = htmlspecialchars($row['file_upload'], ENT_QUOTES, 'UTF-8');
        }
        dbFreeResult($result);
    }
}

// --- Prepare Data for Treeview ---
$treeData = [];

// 1. Get Office Types
$sqlType = "SELECT * FROM office_type ORDER BY type_id";
$resultType = dbQuery($sqlType);
while ($rowType = dbFetchArray($resultType)) {
    $tid = $rowType['type_id'];
    $treeData[$tid] = [
        'id' => $tid,
        'name' => $rowType['type_name'],
        'departments' => []
    ];
}

// 2. Get Departments
$sqlDep = "SELECT dep_id, dep_name, type_id FROM depart ORDER BY dep_id";
$resultDep = dbQuery($sqlDep);
while ($rowDep = dbFetchArray($resultDep)) {
    $tid = $rowDep['type_id'];
    if (isset($treeData[$tid])) {
        $treeData[$tid]['departments'][] = [
            'id' => $rowDep['dep_id'],
            'name' => $rowDep['dep_name']
        ];
    }
}
// Convert to JSON for JS
$jsonTreeData = json_encode(array_values($treeData));
?>
<div class="col-md-2">
    <?php
    $level_id = isset($_SESSION['ses_level_id']) ? $_SESSION['ses_level_id'] : 0; // ควรดึง level_id จาก session
    $menu = checkMenu($level_id);           //check permision menu
    include $menu;                          //include menu
    ?>
</div>
<div class="col-md-10">
    <div class="panel panel-primary">
        <div class="panel-heading"><i class="fas fa-share-square fa-2x"></i>
            <strong>ส่งหนังสือระหว่างส่วนราชการ</strong>
        </div>
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li><a class="btn-danger fas fa-envelope" href="paper.php"> หนังสือเข้า</a></li>
                <li><a class="btn-danger fas fa-envelope-open" href="folder.php">สถานะ(รับ/คืน)</a></li>
                <li><a class="btn-danger fas fa-history" href="history.php"> ส่งแล้ว</a></li>
                <li class="active"><a class="btn-danger fas fa-globe" href="outside_all.php"> ส่งหนังสือ</a></li>
            </ul>
            <br>
            <form id="fileout" name="fileout" method="post" enctype="multipart/form-data"
                action="outside_all.php?<?php echo isset($_SERVER['QUERY_STRING']) ? htmlspecialchars($_SERVER['QUERY_STRING']) : ''; ?>">
                <div class="form-group form-inline">
                    <label for="title">เรื่อง:</label>
                    <input class="form-control" type="text" name="title" size="100%" placeholder="ใส่ชื่อเรื่อง"
                        required="">
                </div>
                <div class="form-group form-inline">
                    <label for="book_no">เลขหนังสือ:</label>
                    <input class="form-control" type="text" name="book_no" size="100%" placeholder="โปรดระบุ"
                        required=""
                        value="<?php echo isset($_POST['book_no']) ? htmlspecialchars($_POST['book_no'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                </div>

                <div class="form-group">
                    <label>ส่งถึง:</label>
                    <div class="row">
                        <!-- Left Column: Treeview Selection -->
                        <div class="col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">เลือกหน่วยงาน</div>
                                <div class="panel-body" style="max-height: 500px; overflow-y: auto;">
                                    <div id="org-tree">
                                        <!-- Treeview will be rendered here by JS -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Selected List Preview -->
                        <div class="col-md-6">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    หน่วยงานที่เลือก (<span id="selected-count">0</span>)
                                </div>
                                <div class="panel-body" style="max-height: 500px; overflow-y: auto;">
                                    <ul id="selected-list" class="list-group">
                                        <li class="list-group-item text-muted">ยังไม่ได้เลือกหน่วยงาน</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                if ($cid && isset($link_file) && $link_file <> null) { ?>
                    <div class="form-group form-inline">
                        <label for="fileupload">ไฟล์แนบ</label><a class="btn btn-warning"
                            href="<?php print htmlspecialchars($link_file, ENT_QUOTES, 'UTF-8'); ?>" target="_blank"><i
                                class="fa fa-file fa-2x"></i></a>
                    </div>
                <?php } else { ?>
                    <div class="form-group form-inline">
                        <label for="fileupload">แนบไฟล์</label>
                        <input type="file" name="fileupload" required>
                    </div>
                <?php } ?>
                <div class="form-group form-inline">
                    <label for="detail">รายละเอียด</label>
                    <textarea name="detail" rows="3"
                        cols="60"><?php echo isset($_POST['detail']) ? htmlspecialchars($_POST['detail'], ENT_QUOTES, 'UTF-8') : '-'; ?></textarea>
                </div>
                <center>
                    <div class="form-group">
                        <input type="hidden" name="file"
                            value="<?php echo isset($fileupload) ? htmlspecialchars($fileupload, ENT_QUOTES, 'UTF-8') : ''; ?>" />
                        <input type="hidden" name="dep_id"
                            value="<?php echo isset($dep_id) ? htmlspecialchars($dep_id, ENT_QUOTES, 'UTF-8') : ''; ?>" />
                        <input type="hidden" name="sec_id"
                            value="<?php echo isset($sec_id) ? htmlspecialchars($sec_id, ENT_QUOTES, 'UTF-8') : ''; ?>" />
                        <input type="hidden" name="user_id" id="user_id"
                            value="<?php echo htmlspecialchars($u_id, ENT_QUOTES, 'UTF-8'); ?>" />
                        <input type="submit" name="sendOut" class="btn btn-primary btn-lg" value="ส่งเอกสาร" />
                    </div>
                </center>
            </form>
        </div>
        <div class="panel-footer"></div>
    </div>
</div>

<?php
/*++++++++++++++++++++++++++++ส่งภายนอก+++++++++++++++++++++++++++*/

if (isset($_POST['sendOut'])) {           //ตรวจสอบปุ่ม sendOut

    // **ส่วนที่ 2: ทำความสะอาดค่าที่รับจาก POST ก่อนใช้งาน**
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING); // ชื่ออเอกสาร
    $detail = filter_input(INPUT_POST, 'detail', FILTER_SANITIZE_STRING); // รายละเอียด
    $date = date('YmdHis');               // วันเวลาปัจจุบันที่จะเอาไปใส่ในระบบว่าส่งมาเมื่อไหร่
    $sec_id = filter_input(INPUT_POST, 'sec_id', FILTER_VALIDATE_INT); // รหัสแผนกที่ส่ง (ต้องเป็นตัวเลข)
    $outsite = 1;                         // กำหนดค่าเอกสาร insite=ภายใน outsite = ภายนอก
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT); // ไอดีผู้ใช้ (ต้องเป็นตัวเลข)
    $dep_id = filter_input(INPUT_POST, 'dep_id', FILTER_VALIDATE_INT); // ไอดีหน่วยงาน (ต้องเป็นตัวเลข)
    $book_no = filter_input(INPUT_POST, 'book_no', FILTER_SANITIZE_STRING); // เลขหนังสือ

    @$fileupload = filter_input(INPUT_POST, 'file', FILTER_SANITIZE_STRING);                // ไฟล์เอกสาร (ชื่อไฟล์เดิม)
    $dateSend = date('Y-m-d');                    // วันที่ส่งเอกสาร

    $link_file = ''; // กำหนดค่าเริ่มต้น
    // **ส่วนที่ 3: ปรับปรุงการจัดการไฟล์อัปโหลด**
    if (isset($_FILES['fileupload'])) {
        $err = $_FILES['fileupload']['error'];

        if ($err === UPLOAD_ERR_OK) {
            $upload = $_FILES['fileupload'];
            $upload_dir = "paper/";

            $filename = $upload['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $allowed_extensions = array('pdf', 'png', 'jpg', 'jpeg', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', '7z', 'rar', 'zipx');

            if (!in_array($ext, $allowed_extensions)) {
                echo "<script>alert('ไม่อนุญาตให้อัปโหลดไฟล์ .$ext'); window.history.back();</script>";
                exit;
            }

            $date_prefix = date("YmdHis");
            $random_num = mt_rand(100000, 999999);
            $new_filename = $date_prefix . "_" . $random_num . "." . $ext;
            $link_file = $upload_dir . $new_filename;

            if (!move_uploaded_file($upload['tmp_name'], $link_file)) {
                echo "<script>alert('เกิดข้อผิดพลาดในการบันทึกไฟล์'); window.history.back();</script>";
                exit;
            }
        } elseif ($err === UPLOAD_ERR_NO_FILE) {
            if (!empty($fileupload)) {
                $link_file = $fileupload;
            }
        } elseif ($err === UPLOAD_ERR_INI_SIZE || $err === UPLOAD_ERR_FORM_SIZE) {
            echo "<script>alert('ไฟล์มีขนาดใหญ่เกินกว่าที่ระบบกำหนด (Upload Max Size)'); window.history.back();</script>";
            exit;
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดไฟล์ (Error Code: $err)'); window.history.back();</script>";
            exit;
        }
    }

    // Check if recipients are selected
    if (isset($_POST['dep_ids']) && is_array($_POST['dep_ids']) && count($_POST['dep_ids']) > 0) {

        // **ใช้ Prepared Statements ในการ INSERT ลง paper (Master Record)**
        $sql_insert = "INSERT INTO paper(title, detail, file, postdate, u_id, outsite, sec_id, dep_id, book_no)
                       VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $types = "sssiiiiis";
        $params = [$title, $detail, $link_file, $date, $user_id, $outsite, $sec_id, $dep_id, $book_no];
        $result = dbQuery($sql_insert, $types, $params);

        if ($result === true) {
            $lastid = dbInsertId();

            // Loop through selected Department IDs
            foreach ($_POST['dep_ids'] as $target_dep_id) {
                $target_dep_id = (int) $target_dep_id;
                if ($target_dep_id > 0) {
                    // **ใช้ Prepared Statements ในการ SELECT User ในหน่วยงานนั้น**
                    // ค้นหาสารบรรณประจำหน่วยงานเท่านั้น (Level 3)
                    $sql_users = "SELECT u.u_id, u.firstname, s.sec_id, d.dep_id
                                   FROM user u 
                                   INNER JOIN section s ON s.sec_id=u.sec_id
                                   INNER JOIN depart d  ON d.dep_id=u.dep_id
                                   WHERE u.dep_id=? AND u.level_id = 3";

                    $result_users = dbQuery($sql_users, 'i', [$target_dep_id]);

                    if ($result_users) {
                        while ($row = dbFetchArray($result_users)) {
                            $u_id_to = $row['u_id'];
                            $sec_id_to = $row['sec_id'];
                            $dep_id_to = $row['dep_id'];
                            // Insert into paperuser
                            $sql_insert_user = "INSERT INTO paperuser (pid, u_id, sec_id, dep_id) VALUES (?, ?, ?, ?)";
                            dbQuery($sql_insert_user, 'iiii', [$lastid, $u_id_to, $sec_id_to, $dep_id_to]);
                        }
                        dbFreeResult($result_users);
                    }
                }
            }

            echo "<script>
                    swal({
                        title:'ส่งเอกสารเรียบร้อยแล้ว',
                        type:'success',
                        showConfirmButton:true
                        },
                        function(isConfirm){
                            if(isConfirm){
                                window.location.href='history.php';
                            }
                        }); 
                    </script>";
        } else {
            echo "<script>alert('บันทึกข้อมูลไม่สำเร็จ');</script>";
        }

    } else {
        echo "<script>alert('กรุณาเลือกผู้รับอย่างน้อย 1 รายการ'); window.history.back();</script>";
    }
}
?>

<script type="text/javascript">
    // Data from PHP
    const orgData = <?php echo $jsonTreeData; ?>;

    document.addEventListener('DOMContentLoaded', function () {
        const treeContainer = document.getElementById('org-tree');
        const selectedList = document.getElementById('selected-list');
        const selectedCount = document.getElementById('selected-count');

        // Function to Create Tree Structure
        function renderTree(data, container) {
            const list = document.createElement('ul');
            list.style.listStyleType = "none";
            list.style.paddingLeft = "5px";

            data.forEach(type => {
                const li = document.createElement('li');
                li.style.marginTop = "10px";
                li.style.borderBottom = "1px solid #eee";
                li.style.paddingBottom = "5px";

                // --- Type Header Row ---
                const headerDiv = document.createElement('div');
                headerDiv.style.display = "flex";
                headerDiv.style.alignItems = "center";
                headerDiv.style.marginBottom = "5px";

                // Collapse Button
                const toggleBtn = document.createElement('button');
                toggleBtn.className = 'btn btn-xs btn-default';
                toggleBtn.innerHTML = '<i class="fa fa-plus"></i>';
                toggleBtn.style.marginRight = "5px";
                toggleBtn.onclick = function (e) {
                    e.preventDefault();
                    const group = li.querySelector('.dept-group');
                    if (group.style.display === 'none') {
                        group.style.display = 'block';
                        toggleBtn.innerHTML = '<i class="fa fa-minus"></i>';
                    } else {
                        group.style.display = 'none';
                        toggleBtn.innerHTML = '<i class="fa fa-plus"></i>';
                    }
                };

                // Type Checkbox (Select All in Type)
                const typeCheckbox = document.createElement('input');
                typeCheckbox.type = 'checkbox';
                typeCheckbox.className = 'type-checkbox';
                typeCheckbox.dataset.typeId = type.id;
                typeCheckbox.style.marginRight = "5px";

                // Type Label
                const typeLabel = document.createElement('strong');
                typeLabel.textContent = type.name;
                typeLabel.style.cursor = "pointer";
                typeLabel.onclick = function () { toggleBtn.click(); }; // Click label to toggle

                headerDiv.appendChild(toggleBtn);
                headerDiv.appendChild(typeCheckbox);
                headerDiv.appendChild(typeLabel);
                li.appendChild(headerDiv);

                // --- Department Group ---
                if (type.departments && type.departments.length > 0) {
                    const deptGroup = document.createElement('div');
                    deptGroup.className = 'dept-group';
                    deptGroup.style.paddingLeft = "30px";
                    deptGroup.style.display = "none"; // Default to hidden


                    // Search Input
                    const searchDiv = document.createElement('div');
                    searchDiv.style.marginBottom = "5px";
                    const searchInput = document.createElement('input');
                    searchInput.type = 'text';
                    searchInput.className = 'form-control input-sm';
                    searchInput.placeholder = 'ค้นหา...';
                    searchInput.style.width = '100%';
                    searchInput.onkeyup = function () {
                        const filter = this.value.toLowerCase();
                        const items = deptGroup.querySelectorAll('li');
                        items.forEach(item => {
                            const text = item.textContent.toLowerCase();
                            item.style.display = text.indexOf(filter) > -1 ? '' : 'none';
                        });
                    };
                    searchDiv.appendChild(searchInput);
                    deptGroup.appendChild(searchDiv);

                    // Dept List
                    const deptList = document.createElement('ul');
                    deptList.style.listStyleType = "none";
                    deptList.style.paddingLeft = "0";

                    type.departments.forEach(dept => {
                        const deptLi = document.createElement('li');

                        const deptCheckbox = document.createElement('input');
                        deptCheckbox.type = 'checkbox';
                        deptCheckbox.className = 'dept-checkbox type-' + type.id;
                        deptCheckbox.name = 'dep_ids[]';
                        deptCheckbox.value = dept.id;
                        deptCheckbox.dataset.refName = dept.name; // For preview
                        deptCheckbox.style.marginRight = "5px";

                        const deptName = document.createElement('span');
                        deptName.textContent = dept.name;

                        deptLi.appendChild(deptCheckbox);
                        deptLi.appendChild(deptName);
                        deptList.appendChild(deptLi);
                    });

                    deptGroup.appendChild(deptList);
                    li.appendChild(deptGroup);
                }

                list.appendChild(li);
            });

            container.appendChild(list);
        }

        // Render Tree
        renderTree(orgData, treeContainer);

        // --- Event Handling ---

        function updatePreview() {
            const checkedBoxes = document.querySelectorAll('.dept-checkbox:checked');
            selectedCount.textContent = checkedBoxes.length;

            selectedList.innerHTML = ''; // Clear list

            if (checkedBoxes.length === 0) {
                selectedList.innerHTML = '<li class="list-group-item text-muted">ยังไม่ได้เลือกหน่วยงาน</li>';
                return;
            }

            checkedBoxes.forEach(box => {
                const li = document.createElement('li');
                li.className = 'list-group-item';
                li.innerHTML = '<i class="fa fa-check text-success"></i> ' + box.dataset.refName;

                // Add remove button in preview
                const removeBtn = document.createElement('i');
                removeBtn.className = 'fa fa-times text-danger pull-right';
                removeBtn.style.cursor = 'pointer';
                removeBtn.onclick = function () {
                    box.checked = false; // Uncheck master
                    updatePreview(); // Update view
                    // Also uncheck parent if it was checked
                    const typeId = box.className.match(/type-(\d+)/)[1];
                    const parent = document.querySelector('.type-checkbox[data-type-id="' + typeId + '"]');
                    if (parent) parent.checked = false;
                };

                li.appendChild(removeBtn);
                selectedList.appendChild(li);
            });
        }

        treeContainer.addEventListener('change', function (e) {
            const target = e.target;

            // Case 1: Type Checkbox clicked -> Toggle all children
            if (target.classList.contains('type-checkbox')) {
                const typeId = target.dataset.typeId;
                const children = document.querySelectorAll('.dept-checkbox.type-' + typeId);
                children.forEach(child => {
                    child.checked = target.checked;
                });
            }

            // Case 2: Dept Checkbox clicked -> Update Parent state (optional)
            if (target.classList.contains('dept-checkbox')) {
                // Logic to auto-check parent if all children checked, or unchecked if one unchecked
            }

            // Update Preview on any change
            updatePreview();
        });
    });
</script>