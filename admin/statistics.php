<?php
session_start();
if (!isset($_SESSION['ses_u_id'])) {
    header("Location: ../index.php");
    exit();
}
include "../library/database.php";

// Initialize data
$visitors_today = 0;
$visitors_month = 0;
$visitors_total = 0;
$online_users = 0;

$today = date('Y-m-d');
$this_month = date('Y-m');

if (isset($dbConn) && $dbConn instanceof mysqli) {
    // 1. Visitors Today
    $res = $dbConn->query("SELECT COUNT(*) AS cnt FROM visitor_logs WHERE visit_date = '$today'");
    if ($res) {
        $row = $res->fetch_assoc();
        $visitors_today = $row['cnt'];
    }

    // 2. Visitors This Month
    $res = $dbConn->query("SELECT COUNT(*) AS cnt FROM visitor_logs WHERE visit_date LIKE '$this_month%'");
    if ($res) {
        $row = $res->fetch_assoc();
        $visitors_month = $row['cnt'];
    }

    // 3. Visitors Total
    $res = $dbConn->query("SELECT COUNT(*) AS cnt FROM visitor_logs");
    if ($res) {
        $row = $res->fetch_assoc();
        $visitors_total = $row['cnt'];
    }

    // 4. Online Users Count
    $res = $dbConn->query("SELECT COUNT(*) AS cnt FROM online_users");
    if ($res) {
        $row = $res->fetch_assoc();
        $online_users = $row['cnt'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>สถิติผู้เข้าชมเว็บไซต์</title>
    <!-- Use Tailwind CSS (matching the project style) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../css/fontawesome5.0.8/web-fonts-with-css/css/fontawesome-all.min.css">
    <style>
        body { font-family: 'Sarabun', sans-serif; background-color: #f3f4f6; }
    </style>
</head>
<body class="p-6">
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800"><i class="fas fa-chart-line text-blue-600 mr-2"></i> สถิติผู้เข้าชมเว็บไซต์</h1>
            <a href="index.php" class="text-blue-500 hover:text-blue-700"><i class="fas fa-arrow-left"></i> กลับหน้าหลักแอดมิน</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Today -->
            <div class="bg-blue-50 rounded-lg p-6 border-l-4 border-blue-500 shadow-sm flex items-center">
                <div class="rounded-full bg-blue-100 p-3 mr-4">
                    <i class="fas fa-calendar-day text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">เข้าชมวันนี้</p>
                    <p class="text-2xl font-bold text-gray-800"><?= number_format($visitors_today) ?> <span class="text-sm font-normal text-gray-500">ครั้ง</span></p>
                </div>
            </div>

            <!-- This Month -->
            <div class="bg-green-50 rounded-lg p-6 border-l-4 border-green-500 shadow-sm flex items-center">
                <div class="rounded-full bg-green-100 p-3 mr-4">
                    <i class="fas fa-calendar-alt text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">เข้าชมเดือนนี้</p>
                    <p class="text-2xl font-bold text-gray-800"><?= number_format($visitors_month) ?> <span class="text-sm font-normal text-gray-500">ครั้ง</span></p>
                </div>
            </div>

            <!-- Total -->
            <div class="bg-purple-50 rounded-lg p-6 border-l-4 border-purple-500 shadow-sm flex items-center">
                <div class="rounded-full bg-purple-100 p-3 mr-4">
                    <i class="fas fa-globe text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">เข้าชมทั้งหมด</p>
                    <p class="text-2xl font-bold text-gray-800"><?= number_format($visitors_total) ?> <span class="text-sm font-normal text-gray-500">ครั้ง</span></p>
                </div>
            </div>

            <!-- Online -->
            <div class="bg-red-50 rounded-lg p-6 border-l-4 border-red-500 shadow-sm flex items-center relative overflow-hidden">
                <div class="absolute top-0 right-0 p-2">
                    <span class="flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </span>
                </div>
                <div class="rounded-full bg-red-100 p-3 mr-4">
                    <i class="fas fa-users text-red-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">กำลังออนไลน์</p>
                    <p class="text-2xl font-bold text-gray-800"><?= number_format($online_users) ?> <span class="text-sm font-normal text-gray-500">คน</span></p>
                </div>
            </div>
        </div>

        <!-- Online Users Detail Table -->
        <h2 class="text-xl font-bold text-gray-800 mb-4"><i class="fas fa-list text-gray-600 mr-2"></i> รายละเอียดผู้กำลังออนไลน์ (15 นาทีล่าสุด)</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">IP Address</th>
                        <th class="py-3 px-6 text-left">เวลาที่เข้าใช้งานล่าสุด</th>
                        <th class="py-3 px-6 text-left">สถานะการเข้าสู่ระบบ</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    <?php
                    if (isset($dbConn) && $dbConn instanceof mysqli) {
                        $res_online = $dbConn->query("SELECT * FROM online_users ORDER BY last_activity DESC");
                        if ($res_online && $res_online->num_rows > 0) {
                            while ($row = $res_online->fetch_assoc()) {
                                $ip = $row['ip_address'];
                                $last_activity = $row['last_activity'];
                                $user_id = $row['user_id'];
                                
                                $status = $user_id ? "<span class='bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold'>เข้าสู่ระบบแล้ว (User ID: $user_id)</span>" : "<span class='bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs font-semibold'>บุคคลทั่วไป</span>";
                                
                                echo "<tr class='border-b border-gray-200 hover:bg-gray-50'>";
                                echo "<td class='py-3 px-6 text-left whitespace-nowrap font-medium'>$ip</td>";
                                echo "<td class='py-3 px-6 text-left'>$last_activity</td>";
                                echo "<td class='py-3 px-6 text-left'>$status</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='py-4 px-6 text-center text-gray-500'>ไม่มีผู้ใช้งานออนไลน์ขณะนี้</td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
