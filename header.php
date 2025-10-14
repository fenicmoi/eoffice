<?php
// Security headers and session cookie params must be sent before any output
// Set secure headers (adjust to your environment as needed)
if (!headers_sent()) {
    header("X-Frame-Options: SAMEORIGIN");
    header("X-Content-Type-Options: nosniff");
    header("Referrer-Policy: no-referrer-when-downgrade");
    header("Permissions-Policy: geolocation=(), microphone=()");
    // Basic CSP - tune sources to match your assets; avoid 'unsafe-inline' when possible
    header("Content-Security-Policy: default-src 'self'; script-src 'self' https:; style-src 'self' 'unsafe-inline' https:; img-src 'self' data: https:; font-src 'self' https:; connect-src 'self' https:;");
    // HSTS only if using HTTPS
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
    }
}

// Session cookie security settings (call before session_start)
$secureFlag = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
$cookieParams = [
    'lifetime' => 0,
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'] ?? '',
    'secure' => $secureFlag,
    'httponly' => true,
    'samesite' => 'Lax'
];
if (version_compare(PHP_VERSION, '7.3.0', '>=')) {
    session_set_cookie_params($cookieParams);
} else {
    // fallback for older PHP: set_secure and httponly only
    session_set_cookie_params(0, '/', $_SERVER['HTTP_HOST'] ?? '', $secureFlag, true);
}

// Start session only if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/library/config.php';
require_once __DIR__ . '/library/database.php';

// CSRF token creation / rotation
if (empty($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token_time']) || ($_SESSION['csrf_token_time'] + 1800) < time()) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    $_SESSION['csrf_token_time'] = time();
}

// Helper: escape output
function e($s) {
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="ระบบสารบรรณจังหวัดพัทลุง">
  <meta name="author" content="ระบบ e-Office">
  <link rel="icon" href="images/favicon.png">
  <title><?php echo e($title ?? 'E-Office'); ?></title>

  <!-- Styles (keep small critical CSS here) -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/dataTables.css">
  <link rel="stylesheet" href="css/fontawesome-all.min.css">
  <link href="https://fonts.googleapis.com/css?family=Taviraj" rel="stylesheet">
  <link rel="stylesheet" href="css/sweetalert.css">
  <style>
    body { font-family: 'Taviraj', serif; padding-top:70px; background:#f8f9fa; }
    .navbar-brand img{ height:36px; width:auto; margin-right:8px; }
    .modal-header.bg-primary { background:#007bff; color:#fff; }
    .panel { margin-bottom:0; }
  </style>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainNav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">
        <img src="images/logo.png" alt="logo">
        <?php echo e($title ?? 'E-Office'); ?>
      </a>
    </div>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="nav navbar-nav">
        <li><a href="index.php?menu=1"><i class="fas fa-home"></i> หน้าแรก</a></li>
        <li><a href="index.php?menu=2"><i class="fas fa-retweet"></i> คำสั่งจังหวัด</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fas fa-users"></i> ลงทะเบียน <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="index.php?menu=3"><i class="fas fa-check-circle"></i> ตรวจสอบหน่วยงานที่ลงทะเบียน</a></li>
            <li><a href="#" data-toggle="modal" data-target="#modalAdd"><i class="fas fa-key"></i> ลงทะเบียนหน่วยงาน/เจ้าหน้าที่</a></li>
          </ul>
        </li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="#" data-toggle="modal" data-target="#modelRule"><i class="fas fa-info-circle"></i> ข้อตกลงการใช้งาน</a></li>
        <li><a href="#" data-toggle="modal" data-target="#myModal"><i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบ</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <!-- Modal ข้อตกลง -->
  <div id="modelRule" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modelRuleLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title" id="modelRuleLabel"><i class="fas fa-info-circle"></i> ข้อตกลงการใช้งาน</h4>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
          <p>เพื่อให้ระบบทำงานได้อย่างมีประสิทธิภาพ กรุณาปฏิบัติตามข้อกำหนดพื้นฐานต่อไปนี้</p>
          <ul>
            <li>ใช้งานบน Chrome / Firefox (Desktop) เพื่อประสบการณ์ที่ดีที่สุด</li>
            <li>เจ้าหน้าที่สารบรรณควรเพิ่มหน่วยงานย่อยก่อนใช้งาน</li>
            <li>กำหนดผู้ใช้อย่างน้อย 1 คนต่อกลุ่มงาน</li>
          </ul>
        </div>
        <div class="modal-footer bg-primary">
          <button type="button" class="btn btn-light" data-dismiss="modal">ปิด / รับทราบ</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Login -->
  <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title" id="myModalLabel"><i class="fas fa-user-lock"></i> เข้าสู่ระบบ</h4>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
          <form method="post" action="checkUser.php" autocomplete="off" novalidate>
            <div class="form-group">
              <label class="sr-only" for="username">Username</label>
              <input id="username" name="username" class="form-control" type="text" placeholder="username" required>
            </div>
            <div class="form-group">
              <label class="sr-only" for="password">Password</label>
              <input id="password" name="password" class="form-control" type="password" placeholder="password" required>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-success btn-block">Login</button>
            </div>
          </form>
        </div>
        <div class="modal-footer bg-primary">
          <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Add (register) -->
  <div id="modalAdd" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title" id="modalAddLabel"><i class="fas fa-user-plus"></i> ลงทะเบียนหน่วยงาน/เจ้าหน้าที่</h4>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
          <form method="post" novalidate>
            <input type="hidden" name="csrf_token" value="<?php echo e($_SESSION['csrf_token']); ?>">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group"><label>ชื่อส่วนราชการ/หน่วยงาน</label><input class="form-control" name="depart" required></div>
                <div class="form-group"><label>เลขประจำส่วนราชการ</label><input class="form-control" name="book_no" placeholder="ตัวอย่าง พท 0017" required></div>
                <div class="form-group"><label>ที่อยู่สำนักงาน</label><input class="form-control" name="address" required></div>
                <div class="form-group"><label>เบอร์ติดต่อสำนักงาน</label><input class="form-control" name="o_tel" placeholder="074-613409" required></div>
                <div class="form-group"><label>เบอร์โทรสาร</label><input class="form-control" name="o_fax" placeholder="074-613409"></div>
                <div class="form-group"><label>Website</label><input class="form-control" name="website"></div>
                <div class="form-group"><label>E-mail ทางการ</label><input class="form-control" type="email" name="email" required></div>
              </div>
              <div class="col-md-6">
                <div class="form-group"><label>ชื่อ</label><input class="form-control" name="fname" required></div>
                <div class="form-group"><label>นามสกุล</label><input class="form-control" name="lname" required></div>
                <div class="form-group"><label>ตำแหน่ง</label><input class="form-control" name="position" required></div>
                <div class="form-group"><label>เบอร์สำนักงาน</label><input class="form-control" name="tel" placeholder="0-7648-1421"></div>
                <div class="form-group"><label>เบอร์มือถือ</label><input class="form-control" name="fax" placeholder="08x-xxx-xxxx"></div>
              </div>
            </div>
            <div class="text-center mt-3">
              <button type="submit" name="add" class="btn btn-primary btn-lg">ตกลง</button>
            </div>
          </form>
        </div>
        <div class="modal-footer bg-primary">
          <button type="button" class="btn btn-light" data-dismiss="modal">ปิด</button>
        </div>
      </div>
    </div>
  </div>

<?php
// 처리: registration form handling (server-side validation + CSRF + prepared statements)
if (isset($_POST['add'])) {
    // CSRF check
    if (empty($_POST['csrf_token']) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        echo "<script>swal('ข้อผิดพลาด','การยืนยันแบบฟอร์มล้มเหลว (CSRF)','error');</script>";
        exit;
    }

    // Trim inputs
    $depart = trim($_POST['depart'] ?? '');
    $book_no = trim($_POST['book_no'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $office_tel = trim($_POST['o_tel'] ?? '');
    $office_fax = trim($_POST['o_fax'] ?? '');
    $website = trim($_POST['website'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $fname = trim($_POST['fname'] ?? '');
    $lname = trim($_POST['lname'] ?? '');
    $position = trim($_POST['position'] ?? '');
    $tel = trim($_POST['tel'] ?? '');
    $fax = trim($_POST['fax'] ?? '');
    $status = 0;

    // server-side validation
    $errors = [];

    $lengths = [
      'depart' => 150,
      'book_no' => 30,
      'address' => 255,
      'office_tel' => 20,
      'office_fax' => 20,
      'website' => 150,
      'email' => 100,
      'fname' => 100,
      'lname' => 100,
      'position' => 100,
      'tel' => 20,
      'fax' => 20
    ];

    foreach ($lengths as $field => $max) {
        $val = $$field ?? '';
        if (is_string($val) && mb_strlen($val) > $max) {
            $errors[] = "ข้อมูล {$field} ยาวเกินกำหนด (สูงสุด {$max} ตัวอักษร)";
        }
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "รูปแบบอีเมลไม่ถูกต้อง";
    }

    $phonePattern = '/^[0-9\-\s\(\)\+]{6,20}$/';
    if ($office_tel !== '' && !preg_match($phonePattern, $office_tel)) $errors[] = "เบอร์โทรสำนักงานไม่ถูกต้อง";
    if ($office_fax !== '' && !preg_match($phonePattern, $office_fax)) $errors[] = "เบอร์โทรสารไม่ถูกต้อง";
    if ($tel !== '' && !preg_match($phonePattern, $tel)) $errors[] = "เบอร์สำนักงานไม่ถูกต้อง";
    if ($fax !== '' && !preg_match($phonePattern, $fax)) $errors[] = "เบอร์มือถือไม่ถูกต้อง";

    $bookNoPattern = '/^[\p{L}0-9\s\-\/]{1,30}$/u';
    if ($book_no !== '' && !preg_match($bookNoPattern, $book_no)) $errors[] = "เลขประจำส่วนราชการ (book_no) มีอักขระต้องห้าม";

    if (!empty($errors)) {
        $msg = implode("\\n", array_map('e', $errors));
        echo "<script>swal('ข้อมูลไม่ถูกต้อง', '". $msg ."', 'error');</script>";
        // regenerate token
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['csrf_token_time'] = time();
        exit;
    }

    $success = false;

    // Use prepared statements (require $conn to be mysqli instance)
    if (isset($conn) && ($conn instanceof mysqli)) {
        $sql = "INSERT INTO register_staf (depart,book_no,address,office_tel,office_fax,website,fname,lname,position,tel,fax,email,status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $types = str_repeat('s', 12) . 'i';
            $stmt->bind_param($types,
                $depart, $book_no, $address, $office_tel, $office_fax,
                $website, $fname, $lname, $position, $tel, $fax, $email, $status
            );
            $success = $stmt->execute();
            if (!$success) error_log('DB insert error: '.$stmt->error);
            $stmt->close();
        } else {
            error_log('Prepare failed: '.$conn->error);
        }
    } else {
        error_log('No mysqli connection available - prepared statements required');
    }

    // regenerate CSRF token after use
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    $_SESSION['csrf_token_time'] = time();

    if ($success) {
        echo "<script>swal('ลงทะเบียนเรียบร้อย','จังหวัดพัทลุงจะชี้แจงแนวทางการใช้งานอีกครั้ง','success').then(()=>{window.location.href='list_user.php'});</script>";
    } else {
        echo "<script>swal('ลงทะเบียนไม่สำเร็จ','เกิดข้อผิดพลาดภายในระบบ','error').then(()=>{window.location.href='index.php'});</script>";
    }
}
?>

</div> <!-- /.container-fluid -->

<!-- Scripts moved to end for better loading; keep order: jquery -> bootstrap -> plugins -->
<script defer src="js/jquery.min.js"></script>
<script defer src="js/bootstrap.min.js"></script>
<script defer src="js/dataTables.js"></script>
<script defer src="js/sweetalert.min.js"></script>
<script defer src="js/text-hilight.js"></script>
<script defer src="js/script_dropdown.js"></script>
</body>
</html>
