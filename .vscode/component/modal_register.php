<!-- Modal Add -->
<div id="modalAdd" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fas fa-smile text-waning"></i> แบบลงทะเบียนหน่วยงาน/เจ้าหน้าที่สารบรรณ</h4>
              </div>
              <div class="modal-body">
                  <form method="post">
                      <div class="panel-group" id="accordion">
                          <div class="panel panel-success">
                              <h4 class="panel-title">
                                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">ส่วนที่ 1 ข้อมูลหน่วยงาน </a>
                              </h4>
                          </div>
                          <div id="collapse1" class="panel-collapse collapse">
                              <div class="panel-body">
                                  <fieldset>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">ชื่อส่วนราชการ/หน่วยงาน</span>
                                              <input class="form-control" type="text" name="depart" required>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">เลขประจำส่วนราชการ</span>
                                              <input class="form-control" type="text" name="book_no" placeholder="ตัวอย่าง พท 0017" required >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">ที่อยู่สำนักงาน</span>
                                              <input class="form-control" type="text" name="address" required>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">เบอร์โทรศัพท์</span>
                                              <input class="form-control" type="text" name="o_tel" placeholder="ตัวอย่าง 074-613409" required >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">เบอร์โทรสาร</span>
                                              <input class="form-control" type="text" name="o_fax" placeholder="ตัวอย่าง 074-613409" required >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">Website</span>
                                              <input class="form-control" type="text" name="website" placeholder="ตัวอย่าง www.phatthalung.go.th">
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">E-mail ทางการ</span>
                                              <input class="form-control" type="email" name="email" placeholder="อีเมลล์ทางการของหน่วยงาน"  required>
                                          </div>
                                        </div>
                                  </fieldset>
                              </div>
                          </div>
                           <div class="panel panel-default">
                              <h4 class="panel-title">
                                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">ส่วนที่ 2 ข้อมูลเจ้าหน้าที่สารบรรณประจำหน่วยงาน </a>
                              </h4>
                          </div>
                          <div id="collapse2" class="panel-collapse collapse">
                              <div class="panel-body">
                                  <fieldset>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">ชื่อ</span>
                                              <input class="form-control" type="text" name="fname" required>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">นามสกุล</span>
                                              <input class="form-control" type="text" name="lname" required >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">ตำแหน่ง</span>
                                              <input class="form-control" type="text" name="position"  required >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">เบอร์สำนักงาน</span>
                                              <input class="form-control" type="text" name="tel" placeholder="ตัวอย่าง 0-7648-1421" required >
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">เบอร์มือถือ</span>
                                              <input class="form-control" type="text" name="fax" placeholder="ตัวอย่าง 0-7648-1421" required >
                                          </div>
                                        </div>
                                        <!-- <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">username</span>
                                              <input class="form-control" type="text" name="username" placeholder="ประกอบด้วยตัวอักษรภาษาอังกฤษและตัวเลข 8 หลัก">
                                          </div>
                                        </div> -->
                                        <!-- <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">password</span>
                                              <input class="form-control" type="text" name="password" placeholder="ประกอบด้วยตัวอักษรภาษาอังกฤษและตัวเลข 8 หลัก" required>
                                          </div>
                                        </div> -->
                                  </fieldset>
                              </div>
                          </div>
                      </div>
                          <br>
                              <center><input type="submit"  name="add" class="btn btn-success btn-lg" value="ตกลง"/></center>
                  </form>
              </div>
              <div class="modal-footer bg-primary">
                <button type="button" class="btn btn-danger" data-dismiss="modal">X</button>
              </div>
            </div>
          </div>
        </div> 