
<!-- Modal Login -->
<div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fas fa-user-secret"></i>เข้าสู่ระบบ</h4>
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
                          <center><input type="submit" class="btn btn-success btn-lg" value="Login"/></center>
                  </form>
              </div>
              <div class="modal-footer bg-primary">
                <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
              </div>
            </div>
          </div>
        </div>