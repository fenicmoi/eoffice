
    <div class="row">
        <div class="col-md-2">
            <?php  //ตรวจสอบสิทธิ์การใช้งานเมนู
                $menu=  checkMenu($level_id);
                include $menu;
            ?>
        </div>
        <div class="col-md-10">
            <div class="container-fluid">
              
               <div class="jumbotron">
                <h1>มาเริ่มต้นกัน</h1> 
                <p>ยินดีต้อนรับสู่ระบบบริหารเอกสารจังหวัดพังงา (Eoffice 2.0) </p> 
              </div>

               <div class="row">
                    <div class="col-md-4">
                        <img src="../images/manual.png" height="200" width="400" class="img-rounded" alt="Cinque Terre">
                        <div class="well">
                            <center><h4>คู่มือการใช้งาน</h4></center>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <img src="../images/setting.png" height="200" width="400" class="img-rounded" alt="Cinque Terre">
                        <div class="well">
                            <center><h4>การตั้งค่าเบื้องต้น</h4></center>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <img src="../images/exp.png" height="200" width="400" class="img-rounded" alt="Cinque Terre">
                        <div class="well">
                            <center><h4>คำชี้แจง</h4></center>
                        </div>
                    </div>
               </div>
             
            </div> <!-- container  -->
        </div>