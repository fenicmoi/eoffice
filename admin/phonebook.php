<?php
include '../chksession.php';
include 'header.php';
?>

<div class="row">
    <div class="col-md-2">
        <?php
        $menu = checkMenu($level_id);
        include $menu;
        ?>
    </div>
    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fas fa-address-book"></i> สมุดโทรศัพท์จังหวัดพัทลุง</h3>
            </div>
            <div class="panel-body" style="padding: 0;">
                <iframe src="https://www.phone.phatthalung.go.th/" style="width: 100%; height: 80vh; border: none;"
                    title="สมุดโทรศัพท์จังหวัดพัทลุง">
                </iframe>
            </div>
            <div class="panel-footer text-right">
                <small>แหล่งข้อมูล: <a href="https://www.phone.phatthalung.go.th/"
                        target="_blank">www.phone.phatthalung.go.th</a></small>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>