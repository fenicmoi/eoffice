<?php
include '../chksession.php';
include '../library/database.php';
header("Content-type:text/html; charset=UTF-8");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

if (isset($_GET['q']) && $_GET['q'] != "") {
    $q = urldecode($_GET["q"]);

    $pagesize = 50;
    $sql = "SELECT dep_id, dep_name FROM depart 
            WHERE dep_name LIKE ? 
            ORDER BY dep_name LIMIT ?";

    $searchTerm = "%" . $q . "%";
    $result = dbQuery($sql, "si", [$searchTerm, $pagesize]);

    if ($result && dbNumRows($result) > 0) {
        while ($row = dbFetchAssoc($result)) {
            // กำหนดฟิลด์ที่ต้องการส่ง่กลับ ปกติจะใช้ primary key ของ ตารางนั้น
            $id = $row["dep_id"]; // 

            // จัดการกับค่า ที่ต้องการแสดง 
            $name = trim($row["dep_name"]);// ตัดช่องวางหน้าหลัง
            $name = addslashes($name); // ป้องกันรายการที่ ' ไม่ให้แสดง error
            $name = htmlspecialchars($name); // ป้องกันอักขระพิเศษ

            // กำหนดรูปแบบข้อความที่แใดงใน li ลิสรายการตัวเลือก
            $display_name = preg_replace("/(" . $q . ")/i", "<b>$1</b>", $name);
            echo "
                <li onselect=\"this.setText('$name').setValue('$id')\">
                    $display_name
                </li>
            ";
        }
    }
    $mysqli->close();
}
?>