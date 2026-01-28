<link rel="stylesheet" href="../css/note.css">
<?php
include '../chksession.php';
require_once '../library/database.php';
require_once '../library/security.php';
require_once 'function.php';
$u_id = $_SESSION['ses_u_id'];
$level_id = $_SESSION['ses_level_id'];
$dep_id = $_SESSION['ses_dep_id'];
$sec_id = $_SESSION['ses_sec_id'];
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<style>
    :root {
        --primary: #4e73df;
        --primary-dark: #224abe;
        --secondary: #858796;
        --success: #1cc88a;
        --info: #36b9cc;
        --warning: #f6c23e;
        --danger: #e74a3b;
        --light: #f8f9fc;
        --dark: #5a5c69;
        --card-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    body {
        background-color: var(--light);
        color: var(--dark);
        font-family: 'Sarabun', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    .dashboard-container {
        padding: 20px 0;
    }

    .main-content {
        background: transparent;
    }

    /* Enhanced Card Styles */
    .stat-card {
        border: none;
        border-radius: 12px;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        margin-bottom: 24px;
        overflow: hidden;
        border-left: 5px solid transparent;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.2);
    }

    .stat-card-primary {
        border-left-color: var(--primary);
    }

    .stat-card-success {
        border-left-color: var(--success);
    }

    .stat-card-info {
        border-left-color: var(--info);
    }

    .stat-card-warning {
        border-left-color: var(--warning);
    }

    .stat-card-danger {
        border-left-color: var(--danger);
    }

    .stat-card .panel-body {
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--dark);
        line-height: 1.2;
    }

    .stat-label {
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 5px;
    }

    .stat-icon {
        color: #dddfeb;
        transition: var(--transition);
    }

    .stat-card:hover .stat-icon {
        color: var(--primary);
        opacity: 0.2;
    }

    .section-title {
        color: var(--primary);
        font-weight: 700;
        margin-bottom: 25px;
        padding-bottom: 10px;
        border-bottom: 2px solid #eaecf4;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Search Section UI Refinement */
    .search-panel {
        border-radius: 15px;
        box-shadow: var(--card-shadow);
        border: none;
        background: white;
    }

    .search-panel .panel-heading {
        border-radius: 15px 15px 0 0 !important;
        padding: 20px;
    }

    .search-input-group {
        border-radius: 30px;
        overflow: hidden;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .search-input-group .form-control {
        border: none;
        height: 50px;
        padding-left: 20px;
    }

    .search-input-group .input-group-addon {
        background: white;
        border: none;
        padding-left: 20px;
    }

    /* Result Card Styling */
    .search-result-card {
        border: 1px solid #e3e6f0 !important;
        border-radius: 12px !important;
        box-shadow: 0 0.15rem 1rem 0 rgba(58, 59, 69, 0.05) !important;
        margin-bottom: 20px !important;
        background: #fff;
        transition: var(--transition);
        overflow: hidden;
        border-left: 4px solid var(--primary) !important;
    }

    .search-result-card:hover {
        box-shadow: 0 0.5rem 1.5rem 0 rgba(58, 59, 69, 0.1) !important;
        transform: translateY(-2px);
    }

    .highlight-target {
        background-color: #fff3cd;
        padding: 0 2px;
        border-radius: 3px;
    }

    .result-badge {
        font-size: 14px;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
        margin-right: 5px;
        margin-bottom: 5px;
    }

    .recipient-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 15px;
        margin-right: 5px;
        margin-bottom: 8px;
        font-weight: 600;
        width: 100%;
        border-left: 3px solid transparent;
    }

    .badge-type {
        background: #e0e7ff;
        color: #4338ca;
    }

    .badge-reg {
        background: #f3e8ff;
        color: #7e22ce;
    }

    .badge-practice {
        background: #dcfce7;
        color: #15803d;
    }

    /* Shot Menu Refinement */
    .menu-card {
        text-align: center;
        padding: 25px 15px;
        border-radius: 12px;
        background: white;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        transition: var(--transition);
        cursor: pointer;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        border: 1px solid #eff2f7;
    }

    .menu-card:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-5px);
    }

    .menu-card i {
        font-size: 2.5rem;
        margin-bottom: 15px;
        transition: var(--transition);
    }

    .menu-card h5 {
        font-weight: 600;
        margin: 0;
    }
</style>
<div class="row">
    <div class="col-md-2">
        <?php  //ตรวจสอบสิทธิ์การใช้งานเมนู
        $menu = checkMenu($level_id);
        include $menu;
        ?>
    </div>
    <div class="col-md-10">
        <div class="container-fluid">
            <?php
            $sql = "SELECT COUNT(puid) AS pcount FROM paperuser WHERE confirm = 0 AND dep_id = ? AND sec_id = ?";
            $result = dbQuery($sql, "ii", [(int) $dep_id, (int) $sec_id]);
            $row = dbFetchArray($result);
            ?>
            <?php
            // ========== NEW STATISTICS SECTION ==========
            // Query for Active Users
            $sqlActiveUsers = "SELECT COUNT(*) as active_users FROM user_online";
            $resultActiveUsers = dbQuery($sqlActiveUsers);
            $rowActiveUsers = dbFetchArray($resultActiveUsers);
            $activeUsers = $rowActiveUsers['active_users'] ?? 0;

            // Query for Circular Documents (Used in original section below)
            $sqlCircularDocs = "SELECT COUNT(*) as circular_docs FROM flowcircle";
            $resultCircularDocs = dbQuery($sqlCircularDocs);
            $rowCircularDocs = dbFetchArray($resultCircularDocs);
            $circularDocs = $rowCircularDocs['circular_docs'] ?? 0;

            // Query for Active Agencies (distinct dep_id from user_online)
            $sqlActiveAgencies = "SELECT COUNT(DISTINCT dep_id) as active_agencies FROM user_online WHERE dep_id != 0";
            $resultActiveAgencies = dbQuery($sqlActiveAgencies);
            $rowActiveAgencies = dbFetchArray($resultActiveAgencies);
            $activeAgencies = $rowActiveAgencies['active_agencies'] ?? 0;

            // Query for New Received Books (formerly in section 2)
            $sqlNewBooks = "SELECT COUNT(*) as num_new
                            FROM book_master m
                            INNER JOIN book_detail d ON d.book_id = m.book_id
                            WHERE m.type_id=1 AND d.status ='' AND d.practice = ?";
            $resultNewBooks = dbQuery($sqlNewBooks, "i", [(int) $dep_id]);
            $rowNewBooks = dbFetchArray($resultNewBooks);
            $numNewReceived = $rowNewBooks['num_new'] ?? 0;
            ?>

            <!-- Statistics Overview Section -->
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <span>
                            <i class="fas fa-th-large"></i> แผงควบคุมและสถิติ
                        </span>
                        <div class="header-actions">
                            <span
                                style="font-size: 13px; color: var(--secondary); font-weight: normal; margin-right: 15px;">
                                <i class="far fa-clock"></i> <span
                                    id="stats-timestamp"><?php echo date('d/m/Y H:i:s'); ?></span>
                            </span>
                            <button id="refresh-stats-btn" class="btn btn-sm btn-outline-primary"
                                style="border-radius: 20px; padding: 5px 15px;">
                                <i class="fas fa-sync-alt"></i> อัพเดทข้อมูล
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Online Users Card -->
                <div class="col-md-3 mb-4">
                    <div class="panel stat-card stat-card-primary">
                        <div class="panel-body">
                            <div>
                                <div class="stat-label text-primary">ผู้ใช้งานออนไลน์</div>
                                <div class="stat-value" id="stat-active-users"><?php echo $activeUsers; ?></div>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-users fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Online Agencies Card -->
                <div class="col-md-3 mb-4">
                    <div class="panel stat-card stat-card-success" data-toggle="modal"
                        data-target="#modalActiveAgencies" style="cursor: pointer;">
                        <div class="panel-body">
                            <div>
                                <div class="stat-label text-success">หน่วยงานที่ออนไลน์</div>
                                <div class="stat-value" id="stat-active-agencies"><?php echo $activeAgencies; ?></div>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-building fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- New Documents Card -->
                <div class="col-md-3 mb-4">
                    <a href="paper.php" style="text-decoration: none;">
                        <div class="panel stat-card stat-card-danger">
                            <div class="panel-body">
                                <div>
                                    <div class="stat-label text-danger">เอกสารเข้าใหม่</div>
                                    <div class="stat-value"><?php echo $row['pcount'] ?? 0; ?></div>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-envelope-open-text fa-3x"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- New Received Books Card -->
                <div class="col-md-3 mb-4">
                    <a href="FlowResiveProvince.php" style="text-decoration: none;">
                        <div class="panel stat-card stat-card-info">
                            <div class="panel-body">
                                <div>
                                    <div class="stat-label text-info">หนังสือเข้าใหม่</div>
                                    <div class="stat-value"><?php echo $numNewReceived; ?></div>
                                </div>
                                <div class="stat-icon">
                                    <i class="fas fa-book-reader fa-3x"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Document Search Section -->
        <style>
            mark {
                background-color: #ffeb3b;
                padding: 2px 4px;
                border-radius: 2px;
                font-weight: bold;
                color: #000;
            }

            .search-result-card {
                border-left: 4px solid #4e73df;
                margin-bottom: 15px;
                transition: all 0.3s ease;
            }

            .search-result-card:hover {
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
                transform: translateY(-2px);
            }

            .recipient-badge {
                display: inline-block;
                padding: 5px 10px;
                border-radius: 15px;
                font-size: 12px;
                margin: 3px;
            }

            .status-received {
                background-color: #28a745;
                color: white;
            }

            .status-returned {
                background-color: #dc3545;
                color: white;
            }

            .status-pending {
                background-color: #6c757d;
                color: white;
            }
        </style>

        <script>
            function highlightText(text, keyword) {
                if (!keyword || keyword.trim() === '') return text;
                var escapedKeyword = keyword.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                var regex = new RegExp('(' + escapedKeyword + ')', 'gi');
                return text.replace(regex, '<mark>$1</mark>');
            }

            $(document).ready(function () {
                var searchKeyword = $('#doc-search').val();
                if (searchKeyword) {
                    $('.highlight-target').each(function () {
                        var originalText = $(this).text();
                        var highlightedText = highlightText(originalText, searchKeyword);
                        $(this).html(highlightedText);
                    });
                }
            });
        </script>

        <div class="row">
            <div class="col-md-12">
                <div class="panel search-panel">
                    <div class="panel-heading"
                        style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white;">
                        <h4 style="margin: 0; font-weight: 700; display: flex; align-items: center;">
                            <i class="fas fa-search-location fa-lg" style="margin-right: 15px; opacity: 0.8;"></i>
                            <span>ค้นหาและติดตามหนังสือราชการ</span>
                        </h4>
                    </div>
                    <div class="panel-body" style="padding: 30px;">
                        <form method="post" action="" class="form-horizontal">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group" style="margin-right: 10px;">
                                        <label for="doc_type"
                                            style="font-weight: 700; color: var(--dark); margin-bottom: 8px; display: block;">
                                            <i class="fas fa-filter text-primary"></i> เลือกประเภทเอกสาร
                                        </label>
                                        <select class="form-control" id="doc_type" name="doc_type"
                                            style="border-radius: 8px; height: 45px; border: 1px solid #d1d3e2;">
                                            <?php $selectedType = isset($_POST['doc_type']) ? $_POST['doc_type'] : 'paper'; ?>
                                            <option value="paper" <?php echo ($selectedType == 'paper') ? 'selected' : ''; ?>>หนังสือในระบบรับส่ง</option>
                                            <option value="province" <?php echo ($selectedType == 'province') ? 'selected' : ''; ?>>หนังสือรับจังหวัด</option>
                                            <option value="depart" <?php echo ($selectedType == 'depart') ? 'selected' : ''; ?>>หนังสือรับหน่วยงาน</option>
                                            <option value="group" <?php echo ($selectedType == 'group') ? 'selected' : ''; ?>>หนังสือรับกลุ่มงาน</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="margin-right: 10px;">
                                        <label for="doc-search"
                                            style="font-weight: 700; color: var(--dark); margin-bottom: 8px; display: block;">
                                            <i class="fas fa-keyboard text-primary"></i> เลขที่หนังสือ หรือ ชื่อเรื่อง
                                        </label>
                                        <div class="input-group search-input-group" style="border: 1px solid #d1d3e2;">
                                            <span class="input-group-addon"><i
                                                    class="fas fa-search text-secondary"></i></span>
                                            <input type="text" class="form-control" id="doc-search" name="doc_search"
                                                placeholder="ระบุคำที่ต้องการค้นหา..."
                                                value="<?php echo isset($_POST['doc_search']) ? htmlspecialchars($_POST['doc_search']) : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label style="display: block; margin-bottom: 8px;">&nbsp;</label>
                                        <button type="submit" name="btn_doc_search" class="btn btn-primary btn-block"
                                            style="height: 45px; border-radius: 8px; font-weight: 700; box-shadow: 0 4px 6px rgba(78, 115, 223, 0.2);">
                                            <i class="fas fa-search"></i> ค้นหาข้อมูล
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <?php
                        if (isset($_POST['btn_doc_search']) && !empty($_POST['doc_search'])) {
                            $searchKeyword = trim($_POST['doc_search']);
                            $docType = isset($_POST['doc_type']) ? $_POST['doc_type'] : 'paper';

                            $numResults = 0;
                            $resultSearch = null;

                            // Query based on document type
                            if ($docType == 'paper') {
                                // หนังสือในระบบรับส่ง (ใช้ LEFT JOIN เพื่อความชัวร์ว่าเจอทุกเล่ม)
                                $sqlSearch = "SELECT p.pid as doc_id, p.book_no, p.title, p.postdate, p.file,
                                                     COALESCE(d.dep_name, 'ไม่ระบุหน่วยงาน') as sender_dept, 
                                                     COALESCE(s.sec_name, '') as sender_section,
                                                     COALESCE(us.firstname, 'ไม่ระบุ') as sender_name, 'paper' as doc_type,
                                                     COALESCE(d.dep_name, 'ไม่ระบุหน่วยงาน') as reg_dep_name, '' as practice
                                              FROM paper p
                                              LEFT JOIN depart d ON d.dep_id = p.dep_id
                                              LEFT JOIN section s ON s.sec_id = p.sec_id
                                              LEFT JOIN user us ON us.u_id = p.u_id
                                              WHERE (p.book_no LIKE ? OR p.title LIKE ?)
                                              ORDER BY p.postdate DESC
                                              LIMIT 20";

                                $searchParam = "%$searchKeyword%";
                                $resultSearch = dbQuery($sqlSearch, "ss", [$searchParam, $searchParam]);
                            } elseif ($docType == 'province') {
                                // หนังสือรับจังหวัด (book_master + book_detail)
                                $sqlSearch = "SELECT m.book_id as doc_id, d.book_no, d.title, d.date_in as postdate, 
                                                     d.sendfrom as sender_dept, '' as sender_section,
                                                     '' as sender_name, 'province' as doc_type, d.file_location as file,
                                                     dep.dep_name as reg_dep_name, s.sec_name as practice
                                              FROM book_master m
                                              INNER JOIN book_detail d ON d.book_id = m.book_id
                                              INNER JOIN depart dep ON dep.dep_id = m.dep_id
                                              INNER JOIN section s ON s.sec_id = m.sec_id
                                              WHERE m.type_id = 1 AND (d.book_no LIKE ? OR d.title LIKE ?)
                                              ORDER BY d.date_in DESC
                                              LIMIT 20";

                                $searchParam = "%$searchKeyword%";
                                $resultSearch = dbQuery($sqlSearch, "ss", [$searchParam, $searchParam]);
                            } elseif ($docType == 'depart') {
                                // หนังสือรับหน่วยงาน
                                $sqlSearch = "SELECT fr.cid as doc_id, fr.book_no, fr.title, fr.datein as postdate,
                                                     fr.sendfrom as sender_dept, '' as sender_section,
                                                     '' as sender_name, 'depart' as doc_type, '' as file,
                                                     d.dep_name as reg_dep_name, s.sec_name as practice
                                              FROM flow_recive_depart fr
                                              INNER JOIN depart d ON d.dep_id = fr.dep_id
                                              INNER JOIN section s ON s.sec_id = fr.remark
                                              WHERE (fr.book_no LIKE ? OR fr.title LIKE ?)
                                              ORDER BY fr.datein DESC
                                              LIMIT 20";

                                $searchParam = "%$searchKeyword%";
                                $resultSearch = dbQuery($sqlSearch, "ss", [$searchParam, $searchParam]);
                            } elseif ($docType == 'group') {
                                // หนังสือรับกลุ่มงาน
                                $sqlSearch = "SELECT fr.cid as doc_id, fr.book_no, fr.title, fr.datein as postdate,
                                                     fr.sendfrom as sender_dept, '' as sender_section,
                                                     us.firstname as sender_name, 'group' as doc_type, '' as file,
                                                     d.dep_name as reg_dep_name, fr.practice as assigned_person_id
                                              FROM flow_recive_group fr
                                              INNER JOIN depart d ON d.dep_id = fr.dep_id
                                              INNER JOIN user us ON us.u_id = fr.practice
                                              WHERE (fr.book_no LIKE ? OR fr.title LIKE ?)
                                              ORDER BY fr.datein DESC
                                              LIMIT 20";

                                $searchParam = "%$searchKeyword%";
                                $resultSearch = dbQuery($sqlSearch, "ss", [$searchParam, $searchParam]);
                            }

                            if ($resultSearch) {
                                $numResults = dbNumRows($resultSearch);
                            }

                            if ($numResults > 0) {
                                $typeLabel = '';
                                switch ($docType) {
                                    case 'paper':
                                        $typeLabel = 'หนังสือในระบบรับส่ง';
                                        break;
                                    case 'province':
                                        $typeLabel = 'หนังสือรับจังหวัด';
                                        break;
                                    case 'depart':
                                        $typeLabel = 'หนังสือรับหน่วยงาน';
                                        break;
                                    case 'group':
                                        $typeLabel = 'หนังสือรับกลุ่มงาน';
                                        break;
                                }

                                echo "<div class='alert' style='background-color: #e0e7ff; color: #4338ca; border-radius: 12px; border: none; font-weight: 600; margin-top: 25px;'>";
                                echo "<i class='fas fa-check-circle'></i> พบรายการเอกสาร <strong>$numResults</strong> รายการ";
                                echo " ประเภท <span class='badge' style='background: var(--primary);'>$typeLabel</span>";
                                echo "</div>";

                                while ($rowDoc = dbFetchArray($resultSearch)) {
                                    $docId = $rowDoc['doc_id'];
                                    $isBookMaster = ($docType != 'paper');
                                    ?>
                                    <div class="panel panel-default search-result-card">
                                        <div class="panel-body" style="padding: 25px;">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div style="display: flex; align-items: start; margin-bottom: 15px;">
                                                        <div
                                                            style="background: #f0f7ff; color: #007bff; width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 15px; flex-shrink: 0;">
                                                            <i class="fas fa-file-alt fa-lg"></i>
                                                        </div>
                                                        <div>
                                                            <h4
                                                                style="margin: 0 0 10px 0; color: #2d3748; font-weight: 800; font-size: 20px;">
                                                                <span
                                                                    class="highlight-target"><?php echo htmlspecialchars($rowDoc['book_no'] ?? 'ไม่ระบุเลขที่'); ?></span>
                                                            </h4>
                                                            <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                                                                <span class="result-badge badge-type"><i class="fas fa-tag"></i>
                                                                    <?php echo $typeLabel; ?></span>
                                                                <span class="result-badge badge-reg"><i
                                                                        class="fas fa-university"></i>
                                                                    <?php echo htmlspecialchars($rowDoc['reg_dep_name']); ?></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div style="padding-left: 60px;">
                                                        <p
                                                            style="font-size: 22px; line-height: 1.4; color: #1a202c; margin-bottom: 15px; font-weight: 700;">
                                                            <a href="download.php?file=<?php echo urlencode($rowDoc['file']); ?>"
                                                                target="_blank" class="highlight-target"
                                                                style="color: inherit; text-decoration: none;">
                                                                <?php echo htmlspecialchars($rowDoc['title']); ?>
                                                            </a>
                                                        </p>

                                                        <?php if ($docType == 'paper') { ?>
                                                            <div class="attachment-list" style="margin-bottom: 15px;">
                                                                <?php
                                                                $sqlFiles = "SELECT * FROM paper_file WHERE pid = ?";
                                                                $resFiles = dbQuery($sqlFiles, "i", [(int) $rowDoc['doc_id']]);
                                                                while ($fRow = dbFetchArray($resFiles)) {
                                                                    ?>
                                                                    <a href="download.php?file=<?php echo urlencode($fRow['file_path']); ?>"
                                                                        target="_blank" class="btn btn-xs btn-outline-secondary"
                                                                        style="margin-right: 5px; margin-bottom: 5px; padding: 4px 10px; border-radius: 5px; background: #f8fafc;"
                                                                        title="<?php echo htmlspecialchars($fRow['file_name']); ?>">
                                                                        <i class="fas fa-paperclip text-primary"
                                                                            style="font-size: 12px;"></i>
                                                                        <span
                                                                            style="font-size: 13px;"><?php echo htmlspecialchars($fRow['file_name']); ?></span>
                                                                    </a>
                                                                <?php } ?>
                                                            </div>
                                                        <?php } ?>

                                                        <div class="result-details"
                                                            style="display: grid; grid-template-columns: 1fr; gap: 12px;">
                                                            <div style="font-size: 17px; color: #4a5568;">
                                                                <i class="fas fa-calendar-alt"
                                                                    style="width: 24px; color: var(--primary);"></i>
                                                                <strong>วันที่ส่ง:</strong>
                                                                <?php echo thaiDate($rowDoc['postdate']); ?>
                                                            </div>
                                                            <div style="font-size: 17px; color: #4a5568;">
                                                                <i class="fas fa-building"
                                                                    style="width: 24px; color: var(--primary);"></i>
                                                                <strong>หน่วยส่ง:</strong>
                                                                <?php echo htmlspecialchars($rowDoc['sender_dept']); ?>
                                                            </div>
                                                            <div style="font-size: 17px; color: #4a5568;">
                                                                <i class="fas fa-user"
                                                                    style="width: 24px; color: var(--primary);"></i>
                                                                <strong>ผู้ส่ง:</strong>
                                                                <?php echo htmlspecialchars($rowDoc['sender_name']); ?>
                                                            </div>
                                                            <?php if ($docType != 'paper') { ?>
                                                                <div
                                                                    style="font-size: 17px; color: #15803d; margin-top: 8px; background: #f0fdf4; padding: 12px 15px; border-radius: 10px; border-left: 4px solid #15803d;">
                                                                    <i class="fas fa-user-tag" style="width: 24px;"></i>
                                                                    <strong><?php echo ($docType == 'group') ? 'ผู้รับมอบหมาย:' : 'หน่วยดำเนินการ:'; ?></strong>
                                                                    <span
                                                                        style="font-weight: 800;"><?php echo ($docType == 'group') ? htmlspecialchars($rowDoc['sender_name']) : htmlspecialchars($rowDoc['practice']); ?></span>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4"
                                                    style="border-left: 1px dashed #e2e8f0; min-height: 150px; padding-left: 30px;">
                                                    <?php if ($docType == 'paper') { ?>
                                                        <h5 style="margin-top: 0;"><i class="fas fa-share-square"></i> ส่งถึงหน่วยงาน:
                                                        </h5>
                                                        <?php
                                                        // Get recipients - only for 'paper' type
                                                        $sqlRecipients = "SELECT pu.confirm, pu.confirmdate,
                                                                                d.dep_name, s.sec_name,
                                                                                u.firstname as receiver_name
                                                                        FROM paperuser pu
                                                                        INNER JOIN depart d ON d.dep_id = pu.dep_id
                                                                        INNER JOIN section s ON s.sec_id = pu.sec_id
                                                                        LEFT JOIN user u ON u.u_id = pu.u_id
                                                                        WHERE pu.pid = ?
                                                                        ORDER BY pu.confirmdate DESC";

                                                        $resultRecipients = dbQuery($sqlRecipients, "i", [(int) $rowDoc['doc_id']]);
                                                        $numRecipients = dbNumRows($resultRecipients);

                                                        if ($numRecipients > 0) {
                                                            while ($rowRecip = dbFetchArray($resultRecipients)) {
                                                                $statusClass = '';
                                                                $statusText = '';

                                                                if ($rowRecip['confirm'] == 1) {
                                                                    $statusClass = 'status-received';
                                                                    $statusText = '✓ รับแล้ว';
                                                                } elseif ($rowRecip['confirm'] == 2) {
                                                                    $statusClass = 'status-returned';
                                                                    $statusText = '↩ ส่งคืน';
                                                                } else {
                                                                    $statusClass = 'status-pending';
                                                                    $statusText = '⏳ รอรับ';
                                                                }

                                                                echo "<div class='recipient-badge $statusClass' title='" . htmlspecialchars($rowRecip['sec_name']) . "'>";
                                                                echo htmlspecialchars($rowRecip['dep_name']) . " (" . htmlspecialchars($rowRecip['sec_name']) . ") - $statusText";
                                                                echo "</div>";
                                                            }
                                                        } else {
                                                            echo "<p style='color: #999;'><em>ยังไม่มีหน่วยงานรับ</em></p>";
                                                        }
                                                    } else {
                                                        echo "<div class='text-center' style='padding: 20px; color: #858796; opacity: 0.7;'>";
                                                        echo "<i class='fas fa-info-circle fa-2x mb-2'></i><br>";
                                                        echo "<small>ข้อมูลประเภทนี้ไม่มีการติดตามผู้รับในระบบ</small>";
                                                        echo "</div>";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo "<div class='alert alert-warning' style='margin-top: 20px;'>";
                                echo "<i class='fas fa-exclamation-triangle'></i> ไม่พบหนังสือที่ตรงกับคำค้นหา \"<strong>" . htmlspecialchars($searchKeyword) . "</strong>\"";
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>


        <?php
        // Section 2: Legacy Counters (Removed as per user request)
        // This section used to contain NEW DOCUMENTS and NEW RECEIVED BOOKS which are now moved to the top row.
        ?>
        <div class="row" style="margin-top: 30px;">
            <div class="col-md-12">
                <div class="section-title">
                    <span>
                        <i class="fas fa-th-list"></i> เมนูทางลัด (Quick Access)
                    </span>
                </div>

                <div class="row">
                    <!-- Column 1: Document Management -->
                    <div class="col-md-3">
                        <div class="menu-card" data-toggle="collapse" data-target="#menu1" style="cursor: pointer;">
                            <i class="fas fa-briefcase text-primary"></i>
                            <h5>ทะเบียนหนังสือ</h5>
                            <small class="text-secondary">หนังสือส่งและคำสั่ง</small>
                        </div>
                        <div id="menu1" class="collapse" style="margin-top: 10px;">
                            <div class="list-group list-group-flush shadow-sm"
                                style="border-radius: 10px; overflow: hidden;">
                                <a href="flow-circle.php" class="list-group-item list-group-item-action"><i
                                        class="fas fa-share-alt text-primary" style="width: 20px;"></i> หนังสือส่ง
                                    [เวียน]</a>
                                <a href="flow-normal.php" class="list-group-item list-group-item-action"><i
                                        class="fas fa-paper-plane text-info" style="width: 20px;"></i> หนังสือส่ง
                                    [ปกติ]</a>
                                <a href="flow-command.php" class="list-group-item list-group-item-action"><i
                                        class="fas fa-gavel text-warning" style="width: 20px;"></i>
                                    ออกเลขคำสั่งจังหวัด</a>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: Contracts -->
                    <div class="col-md-3">
                        <div class="menu-card" data-toggle="collapse" data-target="#menu2" style="cursor: pointer;">
                            <i class="fas fa-file-contract text-success"></i>
                            <h5>ทะเบียนสัญญา</h5>
                            <small class="text-secondary">สัญญาจ้างและซื้อขาย</small>
                        </div>
                        <div id="menu2" class="collapse" style="margin-top: 10px;">
                            <div class="list-group list-group-flush shadow-sm"
                                style="border-radius: 10px; overflow: hidden;">
                                <a href="hire.php" class="list-group-item list-group-item-action"><i
                                        class="fas fa-user-cog text-success" style="width: 20px;"></i>
                                    ทะเบียนสัญญาจ้าง</a>
                                <a href="buy.php" class="list-group-item list-group-item-action"><i
                                        class="fas fa-shopping-cart text-info" style="width: 20px;"></i>
                                    ทะเบียนสัญญาซื้อขาย</a>
                            </div>
                        </div>
                    </div>

                    <!-- Column 3: Meetings -->
                    <div class="col-md-3">
                        <div class="menu-card" data-toggle="collapse" data-target="#menu4" style="cursor: pointer;">
                            <i class="fas fa-handshake text-info"></i>
                            <h5>จองห้องประชุม</h5>
                            <small class="text-secondary">ระบบจองห้องประชุม</small>
                        </div>
                        <div id="menu4" class="collapse" style="margin-top: 10px;">
                            <div class="list-group list-group-flush shadow-sm"
                                style="border-radius: 10px; overflow: hidden;">
                                <a href="meet_index.php" class="list-group-item list-group-item-action"><i
                                        class="fas fa-calendar-alt text-info" style="width: 20px;"></i>
                                    ปฏิทินและจองห้อง</a>
                            </div>
                        </div>
                    </div>

                    <!-- Column 4: Phonebook -->
                    <div class="col-md-3">
                        <a href="phonebook.php" style="text-decoration: none;">
                            <div class="menu-card">
                                <i class="fas fa-address-book text-warning"></i>
                                <h5>สมุดโทรศัพท์</h5>
                                <small class="text-secondary">ค้นหาเบอร์โทรศัพท์</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- row -->
</div>


<?php
if ($level_id == 1) {
    //ตรวจสอบปีเอกสาร
    list($yid, $yname, $ystatus) = chkYear();


    $sql = 'SELECT 
                        COUNT(IF(level_id=1,1,null)) AS c1,
                        COUNT(IF(level_id=2,1,null)) AS c2,
                        COUNT(IF(level_id=3,1,null)) AS c3,
                        COUNT(IF(level_id=4,1,null)) AS c4,
                        COUNT(IF(level_id=5,1,null)) AS c5
                    FROM user';
    $result = dbQuery($sql);
    $row = dbFetchArray($result);
    $c1 = $row['c1'];
    $c2 = $row['c2'];
    $c3 = $row['c3'];
    $c4 = $row['c4'];
    $c5 = $row['c5'];

    $sum = $c1 + $c2 + $c3 + $c4 + $c5;

    // New Summary Query
    $sqlBook = "SELECT COUNT(*) as all_books FROM book_master";
    $resBook = dbQuery($sqlBook);
    $rowBook = dbFetchArray($resBook);

    $sqlToday = "SELECT COUNT(*) as today_books FROM book_detail WHERE date_in = CURDATE()";
    $resToday = dbQuery($sqlToday);
    $rowToday = dbFetchArray($resToday);

    // Count Departs
    $sqlDep = "SELECT COUNT(*) as all_dep FROM depart";
    $resDep = dbQuery($sqlDep);
    $rowDep = dbFetchArray($resDep);
    ?>

    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12">
            <div class="section-title">
                <span><i class="fas fa-user-shield"></i> สรุปข้อมูลสำหรับผู้ดูแลระบบ (Admin Summary)</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="border-left: 5px solid var(--info);">
                <div class="stat-card-body">
                    <div class="stat-card-info">
                        <div class="stat-card-label" style="color: var(--info);">หนังสือทั้งหมด</div>
                        <div class="stat-card-value"><?php echo number_format($rowBook['all_books']); ?></div>
                    </div>
                    <div class="stat-card-icon">
                        <i class="fas fa-book fa-2x" style="color: #dddfeb;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="border-left: 5px solid var(--success);">
                <div class="stat-card-body">
                    <div class="stat-card-info">
                        <div class="stat-card-label" style="color: var(--success);">หนังสือเข้าวันนี้</div>
                        <div class="stat-card-value"><?php echo number_format($rowToday['today_books']); ?></div>
                    </div>
                    <div class="stat-card-icon">
                        <i class="fas fa-calendar-check fa-2x" style="color: #dddfeb;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="border-left: 5px solid var(--warning);">
                <div class="stat-card-body">
                    <div class="stat-card-info">
                        <div class="stat-card-label" style="color: var(--warning);">หน่วยงานทั้งหมด</div>
                        <div class="stat-card-value"><?php echo number_format($rowDep['all_dep']); ?></div>
                    </div>
                    <div class="stat-card-icon">
                        <i class="fas fa-building fa-2x" style="color: #dddfeb;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="border-left: 5px solid var(--secondary);">
                <div class="stat-card-body">
                    <div class="stat-card-info">
                        <div class="stat-card-label" style="color: var(--secondary);">ผู้ใช้งานทั้งหมด</div>
                        <div class="stat-card-value"><?php echo number_format($sum); ?></div>
                    </div>
                    <div class="stat-card-icon">
                        <i class="fas fa-users-cog fa-2x" style="color: #dddfeb;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .huge {
            font-size: 30px;
            font-weight: bold;
        }
    </style>

    <div class="row" style="margin-top: 30px;"> <!-- สถิติข้อมูล -->
        <div class="col-md-12">
            <div class="panel shadow-sm" style="border-radius: 12px; border: none; overflow: hidden;">
                <div class="panel-heading"
                    style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; padding: 15px 20px;">
                    <h4 style="margin: 0; font-weight: 700; display: flex; align-items: center;">
                        <i class="fas fa-chart-pie fa-lg" style="margin-right: 15px; opacity: 0.8;"></i>
                        <span>แผงควบคุมผู้ดูแลระบบ (Admin Panel)</span>
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-hover"
                                style="border-radius: 8px; overflow: hidden; border: 1px solid #e3e6f0;">
                                <thead style="background-color: #f8f9fc;">
                                    <tr>
                                        <th style="color: var(--primary); font-weight: 700;">ประเภทผู้ใช้งาน</th>
                                        <th style="color: var(--primary); font-weight: 700;">จำนวน (คน)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><i class="fas fa-user-shield text-danger" style="width: 20px;"></i> ผู้ดูแลระบบ
                                        </td>
                                        <td style="font-weight: 600;"><?= $row['c1']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-building text-primary" style="width: 20px;"></i> สารบรรณจังหวัด
                                        </td>
                                        <td style="font-weight: 600;"><?= $row['c2']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-university text-info" style="width: 20px;"></i> สารบรรณหน่วยงาน
                                        </td>
                                        <td style="font-weight: 600;"><?= $row['c3']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-users text-warning" style="width: 20px;"></i> สารบรรณกลุ่มฝ่าย
                                        </td>
                                        <td style="font-weight: 600;"><?= $row['c4']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-user text-secondary" style="width: 20px;"></i> ผู้ใช้ทั่วไป
                                        </td>
                                        <td style="font-weight: 600;"><?= $row['c5']; ?></td>
                                    </tr>
                                    <tr style="background-color: #f8f9fc; font-weight: 800; border-top: 2px solid #e3e6f0;">
                                        <td>รวมทั้งหมด</td>
                                        <td style="color: var(--primary);"><?= number_format($sum); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> <!-- col-md-6 -->
                        <div class="col-md-6">
                            <div id="piechart"></div>
                            <script type="text/javascript" src="../js/chart/loader.js"></script>
                            <script type="text/javascript">
                                // Load google charts
                                google.charts.load('current', { 'packages': ['corechart'] });
                                google.charts.setOnLoadCallback(drawChart);

                                // Draw the chart and set the chart values
                                function drawChart() {
                                    var data = google.visualization.arrayToDataTable([
                                        ['Task', 'Hours per Day'],
                                        ['ผู้ดูแลระบบ', <?= $c1; ?>],
                                        ['สารบรรณจังหวัด', <?= $c2; ?>],
                                        ['สารบรรณหน่วยงาน', <?= $c3; ?>],
                                        ['สารบรรณกลุ่ม', <?= $c4; ?>],
                                        ['ผู้ใช้ทั่วไป', <?= $c5; ?>]
                                    ]);

                                    // Optional; add a title and set the width and height of the chart
                                    var options = { 'title': 'สัดส่วนผู้ใช้งาน', 'width': 550, 'height': 400 };

                                    // Display the chart inside the <div> element with id="piechart"
                                    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                                    chart.draw(data, options);
                                }
                            </script>
                        </div> <!-- col-md-6 -->
                    </div> <!-- row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div id="depart" style="width: 100%; height: 350px;"></div>
                            <script type="text/javascript">
                                google.charts.setOnLoadCallback(drawChartDepart);
                                function drawChartDepart() {
                                    var data = google.visualization.arrayToDataTable([
                                        ['Type', 'Count'],
                                        <?php
                                        $sqlType = "SELECT t.type_name, COUNT(d.dep_id) as count 
                                                            FROM office_type t 
                                                            LEFT JOIN depart d ON t.type_id = d.type_id 
                                                            GROUP BY t.type_id";
                                        $resultType = dbQuery($sqlType);
                                        while ($rowType = dbFetchArray($resultType)) {
                                            echo "['" . $rowType['type_name'] . "', " . $rowType['count'] . "],";
                                        }
                                        ?>
                                    ]);

                                    var options = {
                                        title: 'จำนวนส่วนราชการ (แยกตามประเภท)',
                                        pieHole: 0.4,
                                        width: '100%',
                                        height: 350
                                    };

                                    var chart = new google.visualization.PieChart(document.getElementById('depart'));
                                    chart.draw(data, options);
                                }
                            </script>
                        </div>
                        <?php
                        // Removed duplicate chart code
                        ?>
                    </div> <!-- panel-body -->
                    <div class="panel-footer"></div>
                </div> <!-- class panel -->
            </div> <!-- col-md-12 -->
        </div> <!-- row -->
        <?php
} ?> <!-- end if -->
</div> <!-- container  -->
</div>

<!-- Active Agencies Modal -->
<div id="modalActiveAgencies" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #5a5c69, #373840); color: white;">
                <button type="button" class="close" data-dismiss="modal"
                    style="color: white; opacity: 1;">&times;</button>
                <h4 class="modal-title"><i class="fas fa-building"></i> หน่วยงานที่กำลังใช้งานระบบ</h4>
            </div>
            <div class="modal-body" style="max-height: 450px; overflow-y: auto;">
                <div id="agencies-modal-content">
                    <div class="text-center" style="padding: 20px;">
                        <i class="fas fa-spinner fa-spin fa-2x"></i> กำลังโหลดข้อมูล...
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #f8f9fc;">
                <div class="pull-left" style="font-weight: 500;">
                    อัพเดทเมื่อ: <span id="agencies-modal-timestamp">-</span>
                </div>
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิดหน้าต่าง</button>
            </div>
        </div>
    </div>
</div>

<script src="js/dashboard_refresh.js"></script>