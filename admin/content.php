<?php

?>
<div class="row">
        <div class="col-md-4">
          <div class="jumbotron">
             <center>
             <img class="img-rounded" src="images/eoffice.png"   width="304" height="200"> 
             <h3>ระบบงานสารบรรณ</h3>
             </center>
          </div>
        </div>
        <div class="col-md-4">
        <div class="jumbotron">
            <center>
            <img class="img-rounded" src="images/sendfile1.jpg"  width="304" height="200"> 
            <h3>ระบบส่งเอกสาร</h3>
            </center>
          </div>
        </div>
        <div class="col-md-4">
        <div class="jumbotron">
            <center>
            <img class="img-rounded" src="images/meetroom.jpg"  width="304" height="200"> 
            <h3>ระบบจองห้องประชุม</h3>
            </center>
          </div>
        </div>
      </div>

        <div class="col-md-4">
          <div class="jumbotron">
             <center>
             <img class="img-rounded" src="images/search.jpeg"   width="304" height="200"> 
             <h3>ระบบติดตามแฟ้ม</h3>
             </center>
          </div>
        </div>
        
        <div class="col-md-4">
        <div class="jumbotron">
            <center>
            <img class="img-rounded" src="images/phone.jpg"  width="304" height="200"> 
            <h3>สมุดโทรศัพท์</h3>
            </center>
          </div>
        </div>
        <div class="col-md-4">
        <div class="jumbotron">
            <center>
            <img class="img-rounded" src="images/calendar.jpg"  width="304" height="200"> 
            <h3>ระบบวาระงานผู้บริหาร</h3>
            </center>
          </div>
        </div>
      </div>
 <!-- Modal Login -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-user-secret"></i>เข้าสู่ระบบ</h4>
              </div>
              <div class="modal-body">
                  <form method="post" action="checkUser.php">
                      <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                          <input class="form-control" type="text" name="username" placeholder="username"  >
                      </div>
                      <br>
                      <div class="input-group">
                         <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                         <input class="form-control" type="password" name="password" placeholder="password"  >
                      </div>
                      <br>
                          <center><input type="submit" class="btn btn-primary btn-lg glyphicon glyphicon-log-i " value="ตกลง"/></center>
                  </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
              </div>
            </div>

          </div>
        </div>
