
<?php
/*if(!isset($_SESSION['ses_u_id'])){
    header("location:../index.php");
}*/
date_default_timezone_set('Asia/Bangkok');
include "header.php"; 

$u_id=$_SESSION['ses_u_id'];

require_once 'crud_FromSendProvince.php';
//checkuser();
?>
<?php    //วัตถุประสงค์
    $sqlobj="SELECT * FROM object ORDER BY obj_id";
    $resObj=$conn->query($sqlobj);
    
    //คำนำหน้าทะเบียน
    $sqlPrefex="SELECT d.dep_id,d.dep_name,d.prefex,u.firstname 
                FROM depart d
                INNER JOIN user u
                ON u.dep_id= d.dep_id
                WHERE u.u_id=".$u_id;
    //echo $sqlPrefex;
    $resPrefex=  dbQuery($sqlPrefex);
    $rowPrefex= mysqli_fetch_array($resPrefex);
    $dep_name=$rowPrefex[2];
    
    //ชั้นความเร็ว
    $sqlSpeed="SELECT * FROM speed ORDER BY speed_id";
    $resSpeed=$conn->query($sqlSpeed);
    //ชั้นความลับ
    $sqlSecret="SELECT * FROM secret ORDER BY sec_id";
    $resSecret=$conn->query($sqlSecret);
?>
        <div class="col-md-2" >
            <?php include 'menu1.php';?>
        </div>
        <div class="col-md-10">
            <div class="panel panel-default" style="margin: 20">
                <div class="panel-heading"><i class="fa fa-user-secret fa-2x" aria-hidden="true"></i>  <strong>ทะเบียนรวมหนังสือส่งปกติ</strong></div>
                <p></p>
                <div class="row">
                    <div class="col-md-2">
                        <div class="panel-body text-left ">
                            <a href="#" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modalAdd">
                             <i class="fa fa-plus" aria-hidden="true"></i>ออกเลขหนังสือส่ง
                            </a>
                        </div>
                    </div>
                    <div class="col-md-2" style="background-color: #1b6d85">
                        <i class="fa fa-user"></i> <kbd>ผู้ดูแลระบบ</kbd>
                        <h4 class="text-center"><div class="badge"><h4><?php print $numrow_admin; ?> คน</h4></div>
                    </div>
                    <div class="col-md-2" style="background-color: #1b6d85">
                        <i class="fa fa-user"></i> <kbd>สารบรรณกลาง</kbd>
                        <h4 class="text-center"><div class="badge"><h4><?php print $numrow2; ?> คน</h4></div>
                    </div>
                    <div class="col-md-2" style="background-color: #1b6d85">
                        <i class="fa fa-user"></i> <kbd>สารบรรณประจำหน่วยงาน</kbd>
                        <h4 class="text-center"><div class="badge"><h4><?php print $numrow3; ?> คน</h4></div>
                    </div>
                    <div class="col-md-2" style="background-color: #1b6d85">
                        <i class="fa fa-user"></i> <kbd>ผู้ใช้งานทั่วไป</kbd>
                        <h4 class="text-center"><div class="badge"><h4><?php print $numrow4; ?> คน</h4></div>
                    </div>
                    <div class="col-md-2" style="background-color: #1b6d85">
                        <i class="fa fa-user"></i> <kbd>รวมทั้งสิ้น</kbd>
                        <h4 class="text-center"><div class="badge"><h4><?php print $numrow5; ?> คน</h4></div>
                    </div>
                </div>
                
                <hr/>
                <table class="table table-bordered table-hover" id="myTable">
                 <thead>
                     <tr>
                         <th>สถานะ</th>
                         <th>เลขส่ง</th>
                         <th>เลขที่เอกสาร</th>
                         <th>เรื่อง</th>
                         <th>ถึง</th>
                         <th>วันที่บันทึก</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php
                        $count=1;
                        
                                
                        $sql="SELECT u.u_id,u.firstname,u.lastname,u.position,u.u_name,u.u_pass,l.level_name,s.sec_name,d.dep_name,u.status
                              FROM  user u
                              INNER JOIN  user_level l ON  u.level_id = l.level_id
                              INNER JOIN  section s ON u.sec_id=s.sec_id
                              INNER JOIN  depart d ON  u.dep_id=d.dep_id
                              ";
                        $res = $conn->query($sql);
                        while($row=$res->fetch_array()){?>
                            <tr>
                            <td><?php echo $count ?></td>
                            <td><?php echo $row['firstname']; ?></td>
                            <td><?php echo $row['lastname']; ?></td>
                            <td><?php echo $row['u_name']; ?></td>
                            <td><?php echo $row['level_name']; ?></td>
                            <td><?php echo $row['dep_name']; ?></td>
                            
                            <td><?php
                                    $status= $row['status']; 
                                    if($status==1){
                                        echo "<center><p class=\"btn btn-warning\"><i class=\"fa fa-check-square\"</i></p></center>";
                                    }else{
                                         echo "<center><p class=\"btn btn-danger\"><i class=\"fa fa-close\"></i></p></center>";
                                    }
                                ?></td>
                
                            <td><a class="btn btn-info" href="user_edit.php?edit=<?php echo $row['u_id']; ?>" onclick="return confirm('กำลังจะแก้ไขข้อมูล !'); " >
                                <i class="fa fa-pencil" aria-hidden="true"></i>  แก้ไข</a></td>
                                <td><a class="btn btn-danger" href="user_edit.php?del=<?php echo $row['u_id']; ?>" onclick="return confirm('ระบบกำลังจะลบข้อมูล !'); " >
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>   ลบ</a></td>
                            </tr>
                            <?php $count++; }?>
                 </tbody>
             </table>
                
            </div>
            <div class="well">
                คำอธิบาย: <i class="fa fa-user btn btn-warning"></i> อนุญาตใช้งาน
                         <i class="fa fa-user-times btn btn-danger"></i> ระงับการใช้งาน
            </div>
            
            
            
            
            
            <!-- Model -->
            <div id="modalAdd" class="modal fade" role="dialog" >
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header alert-success">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-send fa-2x"></i> ออกเลขหนังสือส่งปกติ</h4>
                  </div>
                  <div class="modal-body">
                      <form name="form" method="post">
                          <div class="form-group form-inline">
                              <label for="yearDoc">ปีเอกสาร : </label>;
                              <div class="input-group">
                                  <input class="form-control"  name="yearDoc" type="text" value="<?php print beYear(); ?>" disabled="">
                              </div>
                              <label for="currentDate">วันที่ :</label>
                              <div class="input-group">
                                  <input class="form-control" type="text" name="currentDate" value="<?php print DateThai();?>" disabled="">
                              </div>
                          </div>
                          <div class="form-group form-inline"> 
                                    <label for="obj_id">วัตถุประสงค์ : </label>
                                    <select name="obj_id" class="form-control" required>
                                         <?php 
                                            while ($row=$resObj->fetch_array()){
                                            echo "<option  value=".$row['obj_id'].">".$row['obj_name']."</option>";
                                         }?>
                                    </select>
                                    <label for="typeDoc">ประเภทหนังสือ :</label>
                                    <input class="form-control" name="typeDoc" type="radio" value="1" checked=""> ปกติ
                                    <input class="form-control" name="typeDoc" type="radio" value="0" disabled=""> เวียน
                          </div>
                          <div class="form-group form-inline">
                              <label for="prefex">คำนำหน้าเลข ท/บ : </label>
                              <input type="text" class="form-control" name="prefex" value="<?php  print $dep_name; ?>" disabled>
                              <label>เลขทะเบียนส่ง : <strong>ออกโดยระบบ</strong></label>
                          </div>
                          <div class="form-group form-inline">
                              <label for="speed">ชั้นความเร็ว : </label>
                              <select name="speed" class="form-control">
                                    <?php 
                                          while ($rowSpeed=$resSpeed->fetch_array()){
                                             echo "<option  value=".$rowSpeed['speed_id'].">".$rowSpeed['speed_name']."</option>";
                                         }?>
                              </select>
                              <label for="secret">ชั้นความลับ :</label>
                              <select name="secret" class="form-control">
                                    <?php
                                        while($rowSecret=$resSecret->fetch_array()){
                                            echo "<option value=".$rowSecret['sec_id'].">".$rowSecret['sec_name']."</option>";
                                        }?>
                              </select>
                          </div>
                          <div class="form-group form-inline">
                              <label for="sendto">จาก : </label>
                              <input type="text"  name="sendto" value="ผู้ว่าราชการจังหวัดพังงา" disabled>
                               <label for="recive">ถึง : </label>
                               <input type="text"  name="recive" size="50"  required placeholder="ระบุผู้รับหนังสือ">
                          </div>
                          <div class="form-group form-inline">
                               <label for="title">เรื่อง : </label>
                               <input type="text"  name="title" size="80" required placeholder="เรื่องหนังสือ">
                              <label for="refer">อ้างถึง</label>
                              <input type="text"  size="80" name="refer" ><br>
                              <label for="attachment">สิ่งที่ส่งมาด้วย</label>
                              <input type="text" size="70" name="attachment" >
                              
                          </div>
                          
                          <div class="form-group form-inline">
                              <label for="practice">ผู้เสนอ</label>
                              <input type="text" size="30"  name="practice" placeholder="ระบุผู้รับผิดชอบ" required>
                              <label for="file_location">ที่เก็บเอกสาร</label>
                              <input type="text" size="30"  name="file_location" placeholder="ระบุที่เก็บเอกสาร" required>
                          </div>
                          <div class="form-group form-inline">
                              <label for="datepicker">ดำเนินการภายใน :</label><input type="text"  id="datepicker" >
                          </div>
                          <div class="form-group form-inline">
                              <label>อื่นๆ :</label>
                              <input type="checkbox" name="follow" id="follow" value="1"> ติดตามผลการดำเนินงาน
                              <input type="checkbox" name="public" id="public" value="1"> เปิดเผยแก่บุคคลทั่วไป
                          </div>
                          <?php
                            if(isset($_GET['edit']))
                            {
                                    ?>
                                    <button type="submit" name="update">update</button>
                                    <?php
                            }
                            else
                            {
                                    ?>
                                    <center><button class="btn btn-primary btn-lg" type="submit" name="save">
                                        <i class="fa fa-database fa-2x"></i> บันทึก
                                        <input id="u_id" name="u_id" type="hidden" value="<?php echo $u_id; ?>"> 
                                        </button></center>
                                    <?php
                            }
                            ?>
                     </form>
                  </div>
                  <div class="modal-footer alert-success">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>

              </div>
            </div>
            <!-- End Model -->   
        </div>
    </div>  
<?php //include "footer.php"; ?>
  <script>
 $.datepicker.regional['th'] ={
        changeMonth: true,
        changeYear: true,
        //defaultDate: GetFxupdateDate(FxRateDateAndUpdate.d[0].Day),
        yearOffSet: 543,
        showOn: "button",
        buttonImage: '../images/calendar.gif',
        buttonImageOnly: true,
        dateFormat: 'dd M yy',
        dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
        dayNamesMin: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
        monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
        monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
        constrainInput: true,
       
        prevText: 'ก่อนหน้า',
        nextText: 'ถัดไป',
        yearRange: '-20:+0',
        buttonText: 'เลือก',
      
    };
$.datepicker.setDefaults($.datepicker.regional['th']);

  $(function() {
    $( "#datepicker" ).datepicker( $.datepicker.regional["th"] ); // Set ภาษาที่เรานิยามไว้ด้านบน
    $( "#datepicker" ).datepicker("setDate", new Date()); //Set ค่าวันปัจจุบัน
  });


    var Holidays;
 
    //On Selected Date
    //Have Check Date
    function CheckDate(date) {
        var day = date.getDate();
        var selectable = true;//ระบุว่าสามารถเลือกวันที่ได้หรือไม่ True = ได้ False = ไม่ได้
        var CssClass = '';
        
        if (Holidays != null) {

            for (var i = 0; i < Holidays.length; i++) {
                var value = Holidays[i];
                if (value == day) {

                    selectable = false;
                    CssClass = 'specialDate';
                    break;
                }
            }
        }
        return [selectable, CssClass, ''];
    }


    //=====================================================================================================
    //On Selected Date
    function SelectedDate(dateText, inst) {
        //inst.selectedMonth = Index of mounth
        //(inst.selectedMonth+1)  = Current Mounth
        var DateText = inst.selectedDay + '/' + (inst.selectedMonth + 1) + '/' + inst.selectedYear;
        //CallGetUpdateInMonth(ReFxupdateDate(dateText));
        //CallGetUpdateInMonth(DateText);
        return [dateText, inst]
    }
    //=====================================================================================================
    //Call Date in month on click image
    function OnBeforShow(input, inst) {
        var month = inst.currentMonth + 1;
        var year = inst.currentYear;
        //currentDay: 10
        //currentMonth: 6
        //currentYear: 2012
        GetDaysShows(month, year); 
       
    }
    //=====================================================================================================
    //On Selected Date
    //On Change Drop Down
    function ChangMonthAndYear(year, month, inst) {

        GetDaysShows(month, year);
    }

    //=====================================
    function GetDaysShows(month, year) {
        //CallGetDayInMonth(month, year); <<เป็น Function ที่ผมใช้เรียก ajax เพื่อหาวันใน DataBase  แต่นี้เป็นเพียงตัวอย่างจึงใช้ Array ด้านล่างแทนการ Return Json
        //อาจใช้ Ajax Call Data โดยเลือกจากเดือนและปี แล้วจะได้วันที่ต้องการ Set ค่าวันไว้คล้ายด้านล่าง
        Holidays = [1,4,6,11]; // Sample Data
    }
    //=====================================
 
  </script>