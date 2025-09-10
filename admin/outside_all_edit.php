    <?php
    date_default_timezone_set('Asia/Bangkok');
    include "header.php";

    //checkuser login
    if (!isset($_SESSION['ses_u_id'])) {
        header("Location: ../index.php");
        exit();
    } else {
        $u_id = $_SESSION['ses_u_id'];
        $pid = $_GET['pid'];
    }


    $sql = "SELECT pid,title,book_no,file FROM paper  WHERE pid=$pid";
    $result = dbQuery($sql);
    $row = dbFetchAssoc($result);

    $link_file = $row['file'];
    ?>
    <div class="col-md-2">
        <?php
        $menu =  checkMenu($level_id);
        include $menu;
        ?>
    </div>
    <div class="col-md-10">
        <div class="panel panel-primary">
            <div class="panel-heading"><i class="fas fa-share-square fa-2x"></i> <strong>ส่งเอกสารภายในจังหวัด</strong></div>
            <div class="panel-body">
                <ul class="nav nav-tabs">
                    <li><a class="btn-danger fas fa-envelope" href="paper.php"> จดหมายเข้า</a></li>
                    <li><a class="btn-danger fas fa-envelope-open" href="folder.php"> รับแล้ว</a></li>
                    <li><a class="btn-danger fas fa-history" href="history.php"> ส่งแล้ว</a></li>
                    <li><a class="btn-danger fas fa-paper-plane" href="inside_all.php"> ส่งภายใน</a></li>
                    <li class="active"><a class="btn-danger fas fa-globe" href="outside_all.php"> ส่งภายนอก [แก้ไข]</a></li>
                </ul>
                <br>
                <form id="fileout" name="fileout" method="post" enctype="multipart/form-data">
                    <div class="form-group form-inline">
                        <label for="title">ชื่อเอกสาร:</label>
                        <input class="form-control" type="text" name="title" size="100%" value="<?php print $row['title']; ?>">
                    </div>
                    <div class="form-group form-inline">
                        <label for="book_no">เลขหนังสือ:</label>
                        <input class="form-control" type="text" name="book_no" size="100%" value="<?php print $row['book_no']; ?>">
                    </div>

                    <div class="form-group form-inline">
                        <label for="fileupload">ไฟล์แนบปัจจุบัน > </label><a class="btn btn-info" href="<?php print $link_file; ?>" target="_blank"><?php print $link_file; ?></a>
                    </div>
                    <div class="form-group form-inline">
                        <label for="fileupload">แก้ไขไฟล์แนบ</label>
                        <input type="file" name="fileupload">
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
        $numrand = (mt_rand());                       //สุ่มตัวเลข
        $dateSend = date('Y-m-d');                    //วันที่ส่งเอกสาร  (มีปัญหายังแก้ไม่ได้)
        $book_no = $_POST['book_no'];                 //เลขที่หนังสือ
        // @$upload=$_FILES['fileupload'];             //Directory สำหรับเก็บไฟล์เอกสาร
        $upload_dir = "paper/";

        /*
	if($_FILES['fileupload']['name']){
		$part="paper/";
		$type=  strrchr($_FILES['fileupload']['name'],".");
		$newname=$date.$numrand.$type;
		$part_copy=$part.$newname;
		$part_link="paper/".$newname;
        move_uploaded_file($_FILES['fileupload']['tmp_name'],$part_copy);
        $sql="UPDATE paper SET title ='$title',detail='$detail',file='$part_link',book_no='$book_no',edit='$date' WHERE pid=$pid ";
    }else{
        $sql="UPDATE paper SET title ='$title',detail='$detail',book_no='$book_no',edit='$date' WHERE pid=$pid ";
    }


*/

        //ตรวจสอบว่าการแนบไฟล์มาหรือไม่
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileupload'])) {
            $upload = $_FILES['fileupload'];

            $filename = $_FILES['fileupload']['name'];
            // --- ดึงนามสกุล (ตัวพิมพ์เล็ก) ---
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            // --- รายการนามสกุลที่อนุญาต (รูปภาพ + เอกสาร) ---
            $allowed = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx');
            // --- ตรวจสอบว่าไฟล์อยู่ในรายการอนุญาตไหม ---
            if (!in_array($ext, $allowed)) {
                echo "<script>alert('ไม่อนุญาตให้อัปโหลดไฟล์ .$ext'); window.history.back();</script>";
                exit;
            }

            if ($upload['error'] !== UPLOAD_ERR_OK) {                                    // ตรวจสอบข้อผิดพลาดการอัพโหลด
                die("เกิดข้อผิดพลาดในการอัพโหลด: " . $upload['error']);
            }

            // ตรวจสอบนามสกุลไฟล์
            $allowed_extensions = array('pdf', 'png', 'jpg', 'xls', 'xlsx', 'doc', 'docx', 'zip', '7z', 'rar', 'zipx');
            $file_extension = strtolower(pathinfo($upload['name'], PATHINFO_EXTENSION));

            if (!in_array($file_extension, $allowed_extensions)) {
                die("<script> alert('ไฟล์ดังกล่าวไม่ได้รับการอนุญาต กรุณาติดต่อ Admin')</script>");
            }

            // ตั้งชื่อไฟล์ใหม่ไม่ให้ซ้ำ
            $date = date("YmdHis"); // รูปแบบปีเดือนวันชั่วโมงนาทีวินาที
            $random_num = mt_rand(100000, 999999); // สุ่มตัวเลข 6 หลัก
            $new_filename = $date . "_" . $random_num . "." . $file_extension;

            // พาธเต็มรูปแบบสำหรับบันทึกไฟล์
            $link_file = $upload_dir . $new_filename;
            // echo $destination;

            // ย้ายไฟล์ไปยังพาธปลายทาง
            if (move_uploaded_file($upload['tmp_name'], $link_file)) {
                echo "อัพโหลดสำเร็จ! ชื่อไฟล์: " . $new_filename;
            } else {
                echo "เกิดข้อผิดพลาดในการบันทึกไฟล์";
            }
            $sql = "UPDATE paper SET title ='$title',detail='$detail',file='$link_file',book_no='$book_no',edit='$date' WHERE pid=$pid ";
        } else {  //กรณีไม่ได้แนบไฟล์ใดๆ
            $sql = "UPDATE paper SET title ='$title',detail='$detail',book_no='$book_no',edit='$date' WHERE pid=$pid ";
        }



        $result =  dbQuery($sql);
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
