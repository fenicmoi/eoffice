<?php
date_default_timezone_set('Asia/Bangkok');
include "header.php";
?>
<style>
    .file-upload-row {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-remove-file {
        color: #e74a3b;
        cursor: pointer;
        font-size: 1.2em;
    }

    .btn-remove-file:hover {
        color: #be2617;
    }
</style>
<script>
    $(document).ready(function () {
        // Function to add new file row
        $("#add-file-btn").click(function () {
            const newRow = `
                <div class="file-upload-row">
                    <input type="file" name="fileupload[]" class="form-control">
                    <i class="fas fa-minus-circle btn-remove-file" title="ลบไฟล์นี้"></i>
                </div>
            `;
            $("#file-upload-container").append(newRow);
        });

        // Function to remove file row
        $(document).on('click', '.btn-remove-file', function () {
            $(this).closest('.file-upload-row').remove();
        });

        // Confirm delete existing file
        $(".btn-delete-existing").click(function (e) {
            if (!confirm('ยืนยันลาลบไฟล์นี้?')) {
                e.preventDefault();
            }
        });
    });
</script>
<?php



//checkuser login
if (!isset($_SESSION['ses_u_id'])) {
    header("Location: ../index.php");
    exit();
} else {
    $u_id = $_SESSION['ses_u_id'];
    $pid = $_GET['pid'];
}

// --- HANDLE FILE DELETION ---
if (isset($_GET['action']) && $_GET['action'] == 'del_file' && isset($_GET['fid'])) {
    $fid = (int) $_GET['fid'];
    // Get file path
    $sql_f = "SELECT file_path FROM paper_file WHERE fid = $fid";
    $res_f = dbQuery($sql_f);
    if ($row_f = dbFetchAssoc($res_f)) {
        $file_path = $row_f['file_path'];
        // Delete physical file
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        // Delete DB record
        $sql_del = "DELETE FROM paper_file WHERE fid = $fid";
        dbQuery($sql_del);

        // Sync Legacy Main File Column
        $sql_main = "SELECT file FROM paper WHERE pid = $pid";
        $res_main = dbQuery($sql_main);
        if ($row_main = dbFetchAssoc($res_main)) {
            if ($row_main['file'] == $file_path) {
                dbQuery("UPDATE paper SET file='' WHERE pid = $pid");
            }
        }

    }
    // Redirect to avoid re-submit
    echo "<script>window.location.href='outside_all_edit.php?pid=$pid';</script>";
    exit;
}
// ----------------------------

$sql = "SELECT pid,title,book_no,file FROM paper  WHERE pid=$pid";

$result = dbQuery($sql);
$row = dbFetchAssoc($result);

$link_file = $row['file'];

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

// 3. Get Current Recipients
$currentDepIds = [];
$sqlRecipients = "SELECT DISTINCT dep_id FROM paperuser WHERE pid = $pid";
$resRecipients = dbQuery($sqlRecipients);
while ($rowRec = dbFetchArray($resRecipients)) {
    $currentDepIds[] = $rowRec['dep_id'];
}
$jsonCurrentDepIds = json_encode($currentDepIds);
?>
<div class="col-md-2">
    <?php
    $menu = checkMenu($level_id);
    include $menu;
    ?>
</div>
<div class="col-md-10">
    <div class="panel panel-primary">
        <div class="panel-heading"><i class="fas fa-share-square fa-2x"></i> <strong>ส่งเอกสารภายในจังหวัด</strong>
        </div>
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li><a class="btn-danger fas fa-envelope" href="paper.php"> จดหมายเข้า</a></li>
                <li><a class="btn-danger fas fa-envelope-open" href="folder.php"> รับแล้ว</a></li>
                <li><a class="btn-danger fas fa-history" href="history.php"> ส่งแล้ว</a></li>
                <li class="active"><a class="btn-danger fas fa-globe" href="outside_all.php"> ส่งภายนอก [แก้ไข]</a></li>
            </ul>
            <br>
            <form id="fileout" name="fileout" method="post" enctype="multipart/form-data">
                <div class="form-group form-inline">
                    <label for="title">ชื่อเอกสาร:</label>
                    <input class="form-control" type="text" name="title" size="100%"
                        value="<?php print $row['title']; ?>">
                </div>
                <div class="form-group form-inline">
                    <label for="book_no">เลขหนังสือ:</label>
                    <input class="form-control" type="text" name="book_no" size="100%"
                        value="<?php print $row['book_no']; ?>">
                </div>

                <div class="form-group">
                    <label>ไฟล์แนบเดิม:</label>
                    <ul>
                        <?php
                        // 1. Show Main File (Legacy)
                        if (!empty($row['file'])) {
                            echo "<li><a href='{$row['file']}' target='_blank'>{$row['file']}</a> (ไฟล์หลัก)</li>";
                        }
                        // 2. Show Additional Files (paper_file)
                        $sql_pf = "SELECT * FROM paper_file WHERE pid = $pid";
                        $res_pf = dbQuery($sql_pf);
                        while ($row_pf = dbFetchAssoc($res_pf)) {
                            echo "<li>
                                        <a href='{$row_pf['file_path']}' target='_blank'>{$row_pf['file_name']}</a> 
                                        <a href='outside_all_edit.php?pid=$pid&action=del_file&fid={$row_pf['fid']}' class='text-danger btn-delete-existing' title='ลบไฟล์'><i class='fas fa-times'></i></a>


                                      </li>";
                        }
                        ?>
                    </ul>
                </div>

                <div class="form-group">
                    <label>ส่งถึง (แก้ไข):</label>
                    <div class="row">
                        <!-- Left Column: Treeview Selection -->
                        <div class="col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">เลือกหน่วยงาน</div>
                                <div class="panel-body" style="max-height: 500px; overflow-y: auto;">
                                    <div class="form-group"
                                        style="position: sticky; top: 0; background: white; z-index: 10; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                            <input type="text" id="global-search" class="form-control"
                                                placeholder="ค้นหาหน่วยงานทั้งหมดที่นี่...">
                                        </div>
                                    </div>
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

                <div class="form-group">
                    <label for="fileupload">แนบไฟล์เพิ่ม:</label>

                    <div id="file-upload-container">
                        <div class="file-upload-row">
                            <input type="file" name="fileupload[]" class="form-control">
                        </div>
                    </div>
                    <button type="button" id="add-file-btn" class="btn btn-sm btn-success" style="margin-top: 5px;">
                        <i class="fas fa-plus"></i> เพิ่มไฟล์
                    </button>
                    <small class="text-muted" style="display: block; margin-top: 5px;">
                        * สามารถแนบได้หลายไฟล์พร้อมกัน
                    </small>
                </div>

                <div class="form-group form-inline">
                    <label for="detail">รายละเอียด</label>
                    <textarea name="detail" rows="3" cols="60">-</textarea>
                </div>
                <center>
                    <div class="form-group">

                        <input type="hidden" name="pid" id="pid" value="<?php print $row['pid']; ?>" />
                        <input type="submit" name="sendOut" class="btn btn-primary btn-lg" value="บันทึก" />
                        <a href="history.php" class="btn btn-danger btn-lg">ยกเลิก</a>
                    </div>
                </center>
            </form>
        </div>
        <div class="panel-footer"></div>
    </div>
</div>

<?php
/*++++++++++++++++++++++++++++PROCESS+++++++++++++++++++++++++++*/

if (isset($_POST['sendOut'])) {                   //ตรวจสอบปุ่ม sendOut
    $pid = $_POST['pid'];                         //รหัสเอกสารส่งที่ต้องการแก้ไข
    $title = $_POST['title'];                     //ช	ื่อเอกสาร
    $date = date('YmdHis');                       //วันเวลาปัจจุบัน
    $detail = $_POST['detail'];                   //รายละเอียด
    $book_no = $_POST['book_no'];                 //เลขที่หนังสือ
    $upload_dir = "paper/";

    // 1. Update Key Details
    $sql = "UPDATE paper SET title ='$title', detail='$detail', book_no='$book_no', edit='$date' WHERE pid=$pid ";
    dbQuery($sql);

    // 2. Handle Recipient Updates
    // Get New Selection
    $new_dep_ids = isset($_POST['dep_ids']) ? $_POST['dep_ids'] : [];
    // Validate integers
    $new_dep_ids = array_map('intval', $new_dep_ids);
    $new_dep_ids = array_unique($new_dep_ids);

    // Get Old Selection
    $old_dep_ids = [];
    $sql_old = "SELECT DISTINCT dep_id FROM paperuser WHERE pid = $pid";
    $res_old = dbQuery($sql_old);
    while ($row_old = dbFetchAssoc($res_old)) {
        $old_dep_ids[] = (int) $row_old['dep_id'];
    }

    // Calculate Diff
    $to_add = array_diff($new_dep_ids, $old_dep_ids);
    $to_remove = array_diff($old_dep_ids, $new_dep_ids);

    // ACTION: Remove
    if (!empty($to_remove)) {
        $remove_list = implode(',', $to_remove);
        $sql_del_user = "DELETE FROM paperuser WHERE pid = $pid AND dep_id IN ($remove_list)";
        dbQuery($sql_del_user);
    }

    // ACTION: Add
    if (!empty($to_add)) {
        foreach ($to_add as $target_dep_id) {
            if ($target_dep_id > 0) {
                // Insert specific users (Level 3 - Saraban) in that department
                $sql_users = "SELECT u.u_id, u.firstname, s.sec_id, d.dep_id
                               FROM user u 
                               INNER JOIN section s ON s.sec_id=u.sec_id
                               INNER JOIN depart d  ON d.dep_id=u.dep_id
                               WHERE u.dep_id=$target_dep_id AND u.level_id = 3";
                $result_users = dbQuery($sql_users);
                while ($row = dbFetchArray($result_users)) {
                    $u_id_to = $row['u_id'];
                    $sec_id_to = $row['sec_id'];
                    $dep_id_to = $row['dep_id'];

                    $sql_insert_user = "INSERT INTO paperuser (pid, u_id, sec_id, dep_id) VALUES ($pid, $u_id_to, $sec_id_to, $dep_id_to)";
                    dbQuery($sql_insert_user);
                }
            }
        }
    }

    $uploaded_files = [];
    $allowed_extensions = array('pdf', 'png', 'jpg', 'jpeg', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', '7z', 'rar', 'zipx');

    if (isset($_FILES['fileupload']) && is_array($_FILES['fileupload']['name'])) {
        foreach ($_FILES['fileupload']['name'] as $key => $filename) {
            if ($_FILES['fileupload']['error'][$key] === UPLOAD_ERR_NO_FILE)
                continue;

            $tmp_name = $_FILES['fileupload']['tmp_name'][$key];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (in_array($ext, $allowed_extensions)) {
                $date_prefix = date("YmdHis");
                $random_num = mt_rand(100000, 999999);
                $new_filename = $date_prefix . "_" . $random_num . "_" . $key . "." . $ext;
                $target_path = $upload_dir . $new_filename;

                if (move_uploaded_file($tmp_name, $target_path)) {
                    // Insert into paper_file
                    $sql_file = "INSERT INTO paper_file (pid, file_path, file_name, upload_date) VALUES ('$pid', '$target_path', '$filename', NOW())";
                    dbQuery($sql_file);

                    // Sync Legacy Main File Column (if empty)
                    $sql_chk = "SELECT file FROM paper WHERE pid = $pid";
                    $res_chk = dbQuery($sql_chk);
                    if ($row_chk = dbFetchAssoc($res_chk)) {
                        if (empty($row_chk['file'])) {
                            dbQuery("UPDATE paper SET file='$target_path' WHERE pid = $pid");
                        }
                    }

                }
            }
        }
    }





    if (!$result) {
        echo "<script>
                    swal({
                     title:'มีบางอย่างผิดพลาด กรุณาตรวจสอบ',
                     type:'warning',
                     showConfirmButton:true
                     },
                     function(isConfirm){
                         if(isConfirm){
                             window.location.href='history.php';
                         }
                     }); 
                   </script>";
    } else {
        echo "<script>
                    swal({
                     title:'แก้ไขข้อมูลเรียบร้อยแล้ว',
                     type:'success',
                     showConfirmButton:true
                     },
                     function(isConfirm){
                         if(isConfirm){
                             window.location.href='history.php';
                         }
                     }); 
                   </script>";
    }  //check db 
}  //send out
?>
<script type="text/javascript">
    // Data from PHP
    const orgData = <?php echo $jsonTreeData; ?>;
    const currentDepIds = <?php echo $jsonCurrentDepIds; ?>; // Array of currently selected dep_ids

    document.addEventListener('DOMContentLoaded', function () {
        const treeContainer = document.getElementById('org-tree');
        const selectedList = document.getElementById('selected-list');
        const selectedCount = document.getElementById('selected-count');

        // Function to Create Tree Structure (Same as outside_all.php)
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
                typeLabel.onclick = function () { toggleBtn.click(); };

                headerDiv.appendChild(toggleBtn);
                headerDiv.appendChild(typeCheckbox);
                headerDiv.appendChild(typeLabel);
                li.appendChild(headerDiv);

                // --- Department Group ---
                if (type.departments && type.departments.length > 0) {
                    const deptGroup = document.createElement('div');
                    deptGroup.className = 'dept-group';
                    deptGroup.style.paddingLeft = "30px";
                    deptGroup.style.display = "none";


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
                        deptCheckbox.dataset.refName = dept.name;
                        deptCheckbox.style.marginRight = "5px";

                        // Check if in current list using loose equality for string/int types
                        if (currentDepIds.some(id => id == dept.id)) {
                            deptCheckbox.checked = true;
                        }

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

        // Initial Update
        updatePreview();

        // --- Event Handling ---

        function updatePreview() {
            const checkedBoxes = document.querySelectorAll('.dept-checkbox:checked');
            selectedCount.textContent = checkedBoxes.length;

            selectedList.innerHTML = '';

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
                    box.checked = false;
                    updatePreview();
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

            if (target.classList.contains('type-checkbox')) {
                const typeId = target.dataset.typeId;
                const children = document.querySelectorAll('.dept-checkbox.type-' + typeId);
                children.forEach(child => {
                    child.checked = target.checked;
                });
            }

            updatePreview();
        });
        // --- Global Search Handler ---
        const globalSearchInput = document.getElementById('global-search');
        if (globalSearchInput) {
            globalSearchInput.addEventListener('keyup', function () {
                const filter = this.value.trim().toLowerCase();

                // Perform search on all category LIs
                const categoryLIs = treeContainer.querySelectorAll(':scope > ul > li');

                categoryLIs.forEach(li => {
                    const group = li.querySelector('.dept-group');
                    if (!group) return;

                    // If search is empty, show all and collapse
                    if (filter === "") {
                        li.style.display = '';
                        group.style.display = 'none';
                        const toggleBtn = li.querySelector('button.btn-default i');
                        if (toggleBtn) toggleBtn.className = 'fa fa-plus';

                        // Also show all departments inside
                        group.querySelectorAll('li').forEach(deptLi => {
                            deptLi.style.display = '';
                        });
                        return;
                    }

                    let hasMatch = false;
                    const departments = group.querySelectorAll('li');

                    departments.forEach(deptLi => {
                        const text = deptLi.textContent.toLowerCase();
                        if (text.indexOf(filter) > -1) {
                            deptLi.style.display = '';
                            hasMatch = true;
                        } else {
                            deptLi.style.display = 'none';
                        }
                    });

                    if (hasMatch) {
                        li.style.display = '';
                        group.style.display = 'block'; // Expand if match found
                        const toggleBtn = li.querySelector('button.btn-default i');
                        if (toggleBtn) toggleBtn.className = 'fa fa-minus';
                    } else {
                        li.style.display = 'none';
                    }
                });
            });
        }
    });
</script>