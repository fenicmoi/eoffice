<?php
/**
 * Menu Configuration for eOffice
 * Centralized array for managing navigation menus across different user levels.
 */

// Levels Mapping: 1: Admin, 2: Manager, 3: Staff, 4: Regular, 5: Guest/Other

function getMenuConfig($level_id, $dep_id)
{
    // Dynamic data for badges (if needed)
    $num_row_new_books = 0;
    if ($level_id == 3) {
        $sql = "SELECT COUNT(*) as total
              FROM book_master m
              INNER JOIN book_detail d ON d.book_id = m.book_id
              INNER JOIN section s ON s.sec_id = m.sec_id
              WHERE m.type_id=1 AND d.status ='' AND d.practice=$dep_id";
        $result = dbQuery($sql);
        $row = dbFetchAssoc($result);
        $num_row_new_books = $row['total'];
    }

    $menus = [
        [
            'id' => 'collapse1',
            'title' => ($level_id == 1) ? 'Administrator' : (($level_id == 2) ? 'ตั้งค่าระบบ' : 'Setup'),
            'icon' => 'fa fa-cog',
            'allowed_levels' => [1, 2, 3, 4, 5],
            'items' => [
                ['title' => 'หน้าหลัก', 'url' => 'index_admin.php', 'icon' => 'fas fa-home', 'allowed_levels' => [1, 2, 3, 4, 5], 'btn_class' => ($level_id == 1) ? 'btn-primary' : 'btn-danger'],
                ['title' => 'จัดการปีปฏิทิน-ทะเบียนเอกสาร', 'url' => 'year.php', 'icon' => 'fas fa-calendar-alt', 'allowed_levels' => [1]],
                ['title' => 'จัดการปีปฏิทิน-ทะเบียนสัญญา', 'url' => 'year-buy.php', 'icon' => 'fas fa-calendar-alt', 'allowed_levels' => [1]],
                ['title' => 'ข้อมูลหน่วยงาน', 'url' => "depart_edit.php?dep_id=$dep_id", 'icon' => 'fa fa-info', 'allowed_levels' => [3]],
                ['title' => 'วัตถุประสงค์', 'url' => 'object.php', 'icon' => 'fas fa-key', 'allowed_levels' => [1]],
                ['title' => 'ชั้นความเร็ว', 'url' => 'speed.php', 'icon' => 'fas fa-paper-plane', 'allowed_levels' => [1]],
                ['title' => 'ชั้นความลับ', 'url' => 'secret.php', 'icon' => 'fas fa-low-vision', 'allowed_levels' => [1]],
                ['title' => 'ประเภทหน่วยงาน', 'url' => 'officeType.php', 'icon' => 'fas fa-building', 'allowed_levels' => [1]],
                ['title' => 'หน่วยงานในจังหวัด', 'url' => 'depart.php', 'icon' => 'fas fa-building', 'allowed_levels' => [1]],
                ['title' => 'กลุ่มงาน/สาขาย่อย', 'url' => 'section.php', 'icon' => 'fa fa-sitemap', 'allowed_levels' => [1, 2, 3]],
                ['title' => 'กลุ่มผู้ใช้งาน', 'url' => 'user_group.php', 'icon' => 'fas fa-users', 'allowed_levels' => [1]],
                ['title' => 'ผู้ใช้งาน', 'url' => 'user.php', 'icon' => 'fas fa-user', 'allowed_levels' => [1, 2, 3], 'btn_class' => ($level_id == 1) ? 'btn-primary' : 'btn-danger'],
                ['title' => 'ผู้บริหาร', 'url' => 'boss.php', 'icon' => 'fas fa-user-circle', 'allowed_levels' => [1]],
                ['title' => 'เครื่องแม่ข่าย', 'url' => 'server-status.php', 'icon' => 'fas fa-server', 'allowed_levels' => [1]],
                ['title' => 'ข้อมูลทั่วไป', 'url' => 'static.php', 'icon' => 'fas fa-chart-pie', 'allowed_levels' => [1]],
                ['title' => 'สำรองฐานข้อมูล', 'url' => 'backup.php', 'icon' => 'fas fa-database', 'allowed_levels' => [1]],
            ]
        ],
        [
            'id' => 'collapse2',
            'title' => 'ทะเบียนคุมสัญญา',
            'icon' => 'fa fa-credit-card',
            'allowed_levels' => [1, 2, 3, 4, 5],
            'items' => [
                ['title' => 'สัญญาจ้าง', 'url' => 'hire.php', 'icon' => 'far fa-arrow-alt-circle-right', 'allowed_levels' => [1, 2, 3, 4, 5]],
                ['title' => 'สัญญาซื้อ/ขาย', 'url' => 'buy.php', 'icon' => 'far fa-arrow-alt-circle-right', 'allowed_levels' => [1, 2, 3, 4, 5]],
                ['title' => 'เอกสารประกวดราคา', 'url' => 'announce.php', 'icon' => 'far fa-arrow-alt-circle-right', 'allowed_levels' => [3]],
            ]
        ],
        [
            'id' => 'collapse3',
            'title' => 'ระบบงานสารบรรณ',
            'icon' => 'fa fa-briefcase',
            'allowed_levels' => [1, 2, 3, 4, 5],
            'items' => [
                ['title' => 'หนังสือรับจังหวัด', 'url' => 'flow-resive-province.php', 'icon' => 'far fa-arrow-alt-circle-right', 'allowed_levels' => [1, 2, 3, 4, 5]],
                ['title' => 'หนังสือรับหน่วยงาน', 'url' => 'FlowResiveDepart.php', 'icon' => 'far fa-arrow-alt-circle-right', 'allowed_levels' => [1, 2, 3, 4, 5]],
                ['title' => 'หนังสือรับกลุ่มงาน', 'url' => 'flow-resive-group.php', 'icon' => 'far fa-arrow-alt-circle-right', 'allowed_levels' => [1, 2, 3, 4, 5]],
                ['divider' => true, 'allowed_levels' => [1, 3]],
                ['title' => 'หนังสือเข้าใหม่', 'badge' => $num_row_new_books, 'url' => 'FlowResiveProvince.php', 'allowed_levels' => [3], 'btn_class' => 'btn-warning'],
                ['title' => 'ทะเบียนหนังสือรับจังหวัด', 'url' => 'flow-resive-depart.php', 'allowed_levels' => [3], 'btn_class' => 'btn-warning'],
                ['divider' => true, 'allowed_levels' => [3]],
                ['title' => 'หนังสือส่ง[เวียน]', 'url' => 'flow-circle.php', 'icon' => 'far fa-arrow-alt-circle-right', 'allowed_levels' => [1, 2, 3, 4, 5], 'btn_class' => ($level_id == 3) ? 'btn-info' : 'btn-primary'],
                ['title' => 'หนังสือส่ง[ปกติ]', 'url' => 'flow-normal.php', 'icon' => 'far fa-arrow-alt-circle-right', 'allowed_levels' => [1, 2, 3, 4, 5], 'btn_class' => ($level_id == 3) ? 'btn-info' : 'btn-primary'],
                ['title' => 'ออกเลข[หน่วยงาน]', 'url' => 'underconstruction.php', 'icon' => 'far fa-arrow-alt-circle-right', 'allowed_levels' => [1, 2, 5]],
                ['title' => 'เลขหนังสือส่ง[หน่วยงาน]', 'url' => 'underconstruction.php', 'icon' => 'far fa-arrow-alt-circle-right', 'allowed_levels' => [4]],
                ['title' => 'ออกเลขคำสั่ง', 'url' => 'flow-command.php', 'icon' => 'far fa-arrow-alt-circle-right', 'allowed_levels' => [1]],
                ['title' => 'เลขคำสั่งจังหวัด', 'url' => 'flow-command.php', 'icon' => 'far fa-arrow-alt-circle-right', 'allowed_levels' => [2, 4, 5]],
                ['title' => 'ทะเบียนคำสั่งจังหวัด', 'url' => 'flow-command.php', 'icon' => 'far fa-arrow-alt-circle-right', 'allowed_levels' => [3]],
            ]
        ],
        [
            'id' => 'collapse4',
            'title' => ($level_id == 4) ? 'ส่งเอกสาร' : 'ระบบรับ-ส่งเอกสาร',
            'icon' => ($level_id == 4) ? 'fa fa-paper-plane' : 'fa fa-id-card',
            'allowed_levels' => [1, 2, 3, 4, 5],
            'items' => [
                ['title' => 'เอกสารทั้งหมด', 'url' => 'paper-all.php', 'icon' => 'fas fa-envelope', 'allowed_levels' => [1]],
                ['title' => 'จดหมายเข้า', 'url' => 'paper.php', 'icon' => 'fas fa-envelope', 'allowed_levels' => [1]],
                ['title' => 'หนังสือเข้า', 'url' => 'paper.php', 'icon' => 'fas fa-envelope', 'allowed_levels' => [2, 3, 4, 5]],
                ['title' => 'รับแล้ว', 'url' => 'folder.php', 'icon' => 'far fa-envelope-open', 'allowed_levels' => [1, 2, 3, 4, 5]],
                ['title' => 'ส่งแล้ว', 'url' => 'history.php', 'icon' => 'fas fa-folder-open', 'allowed_levels' => [1, 3, 4, 5]],
                ['title' => 'ส่งภายใน', 'url' => 'inside_all.php', 'icon' => 'fas fa-home', 'allowed_levels' => [1, 2]],
                ['title' => 'ส่งภายนอก', 'url' => 'outside_all.php', 'icon' => 'fas fa-paper-plane', 'allowed_levels' => [1, 2]],
                ['title' => 'ส่งหนังสือ', 'url' => 'outside_all.php', 'icon' => 'fas fa-paper-plane', 'allowed_levels' => [3, 4, 5]],
                ['title' => 'ระบบติดตามแฟ้ม', 'url' => 'follow.php', 'icon' => 'far fa-arrow-alt-circle-right', 'allowed_levels' => [1]],
                ['title' => 'ตรวจแฟ้ม[สำหรับเลขาฯ]', 'url' => 'follow-check.php', 'icon' => 'far fa-arrow-alt-circle-right', 'allowed_levels' => [1]],
            ]
        ],
        [
            'id' => 'collapse_prov_office_main',
            'title' => 'หนังสือสำนักงานจังหวัด',
            'icon' => 'fas fa-building',
            'allowed_levels' => [1, 2, 3, 4, 5],
            'items' => [
                ['title' => 'หนังสือส่งปกติ', 'url' => 'normaloffice.php', 'icon' => 'far fa-arrow-alt-circle-right', 'allowed_levels' => [1, 2, 3, 4]],
                ['title' => 'หนังสือส่งเวียน', 'url' => 'circleoffice.php', 'icon' => 'far fa-arrow-alt-circle-right', 'allowed_levels' => [1, 2, 3, 4]],
            ]
        ],
        [
            'id' => 'collapse_prov_office',
            'title' => 'สำนักงานจังหวัด',
            'icon' => 'fab fa-app-store',
            'condition' => ($dep_id == 1),
            'allowed_levels' => [3, 4],
            'items' => [
                ['title' => 'ทะเบียนหนังสือส่ง[เวียน]', 'url' => 'circleoffice.php', 'allowed_levels' => [3], 'btn_class' => 'btn-warning'],
                ['title' => 'ทะเบียนหนังสือส่ง[ปกติ]', 'url' => 'flow-normal.php', 'allowed_levels' => [3], 'btn_class' => 'btn-warning'],
                ['title' => 'ทะเบียนคำสั่งจังหวัด', 'url' => 'flow-command.php', 'allowed_levels' => [3], 'btn_class' => 'btn-warning'],
                ['title' => 'ทะเบียนหนังสือส่ง', 'url' => 'flow-depart.php', 'icon' => 'far fa-arrow-alt-circle-right', 'allowed_levels' => [4]],
                ['title' => 'ระบบนัดงานผู้บริหาร', 'url' => '', 'icon' => 'far fa-arrow-alt-circle-right', 'target' => '_blank', 'allowed_levels' => [4]],
                ['title' => 'ระบบลงประกาศ', 'url' => '', 'allowed_levels' => [4]],
                ['title' => 'ระบบจองห้องประชุม', 'url' => 'http://mbrs.phatthalung.go.th/', 'icon' => 'far fa-arrow-alt-circle-right', 'target' => '_blank', 'allowed_levels' => [4]],
            ]
        ],
        [
            'id' => 'collapse5',
            'title' => 'ระบบสนับสนุนอื่นๆ',
            'icon' => 'fab fa-app-store',
            'allowed_levels' => [1, 2, 5],
            'items' => [
                ['title' => 'รายนามผู้บริหาร', 'url' => '#', 'icon' => 'far fa-arrow-alt-circle-right', 'allowed_levels' => [1]],
                ['title' => 'ระบบนัดงานผู้บริหาร', 'url' => 'http://www.phangnga.go.th/calendar/', 'icon' => 'far fa-arrow-alt-circle-right', 'target' => '_blank', 'allowed_levels' => [1]],
            ]
        ],
        [
            'id' => 'collapse6',
            'title' => 'คู่มือการใช้งาน',
            'icon' => 'fas fa-book',
            'allowed_levels' => [1, 2, 3, 4, 5],
            'items' => [
                ['title' => 'E-Office', 'url' => 'https://shorturl.at/WEZe3', 'icon' => 'far fa-arrow-alt-circle-right', 'target' => '_blank', 'allowed_levels' => [3]],
            ]
        ],
        [
            'id' => 'collapse7',
            'title' => ($level_id == 1) ? 'ประกาศ' : 'ประกาศ/ประชาสัมพันธ์',
            'icon' => ($level_id == 1) ? 'fas fa-bullhorn' : 'fas fa-book',
            'allowed_levels' => [1, 2, 3, 4, 5],
            'items' => [
                ['title' => 'ลงประกาศ', 'url' => 'flow-buy.php', 'icon' => 'far fa-arrow-alt-circle-right', 'allowed_levels' => [1, 2, 3, 4, 5]],
            ]
        ],
        [
            'id' => 'collapse8',
            'title' => 'จองห้องประชุม',
            'icon' => 'fas fa-gopuram',
            'allowed_levels' => [1, 2, 3, 4, 5],
            'items' => [
                ['title' => 'จัดการห้อง', 'url' => 'meet_room.php', 'icon' => 'fas fa-cogs', 'allowed_levels' => [1]],
                ['title' => 'จัดการอุปกรณ์', 'url' => '#', 'icon' => 'fas fa-cogs', 'allowed_levels' => [1]],
                ['title' => 'จัดการเวลา', 'url' => '#', 'icon' => 'fas fa-cogs', 'allowed_levels' => [1]],
                ['title' => 'คำขอใช้ห้องประชุม', 'url' => 'meet_wait.php', 'icon' => 'fas fa-rss', 'allowed_levels' => [1]],
                ['title' => 'ปฏิทินห้องประชุม', 'url' => 'meet_index.php', 'icon' => 'fas fa-calendar', 'allowed_levels' => [1]],
                ['title' => 'จองห้องประชุม', 'url' => 'meet_index.php', 'icon' => 'fas fa-marker', 'allowed_levels' => [1]],
                ['title' => 'ห้องประชุม', 'url' => 'meet_room_user.php', 'icon' => 'fas fa-kaaba', 'allowed_levels' => [1]],
                ['title' => 'รายการรอยืนยัน', 'url' => 'flow-buy.php', 'icon' => 'fas fa-cogs', 'allowed_levels' => [1]],
                ['title' => 'รายการอนุมัติแล้ว', 'url' => 'flow-buy.php', 'icon' => 'fas fa-cogs', 'allowed_levels' => [1]],
                ['title' => 'รายการไม่อนุมัติ', 'url' => 'flow-buy.php', 'icon' => 'fas fa-cogs', 'allowed_levels' => [1]],
                ['html' => '<h5>อยู่ระหว่างการปรับปรุง</h5>', 'allowed_levels' => [4, 5]],
            ]
        ],
        [
            'id' => 'collapse9',
            'title' => 'ระบบจองรถราชการ',
            'icon' => 'fas fa-car',
            'allowed_levels' => [2],
            'items' => [
                ['title' => 'รถราชการ', 'url' => '', 'icon' => 'fas fa-cog', 'allowed_levels' => [2]],
                ['title' => 'ผู้ขับขี่', 'url' => '', 'icon' => 'fas fa-cog', 'allowed_levels' => [2]],
                ['title' => 'ปฏิทินการใช้รถ', 'url' => '', 'icon' => 'fas fa-car', 'allowed_levels' => [2]],
            ]
        ],
    ];

    return $menus;
}
