
<!--  ระบบติดตามแฟ้มงาน -->
<?php
include "header.php";
$yid=chkYear();
$u_id=$_SESSION['ses_u_id'];
?>
<div class="row">
    <div class="col-md-2" >
        <?php
        $menu=  checkMenu($level_id);
        include $menu;
        ?>
    </div>  <!-- col-md-2 -->

    <div class="col-md-10">
        <img src="../images/underconstruction.png" class="img-rounded" alt="Cinque Terre"> 
    </div> <!-- col-md-10 -->
</div>    <!-- end row  -->


