
<?php
//ฟอร์มจองห้อง
session_start();
$dep_id=( isset($_SESSION['ses_dep_id']) ) ? $_SESSION['ses_dep_id']:'';

include 'function.php';
include "../library/database.php";

$u_id=$_POST['u_id'];
$level_id=$_POST['level_id'];


?>

<form method="post" action="meet_index.php" enctype="multipart/form-data">
	<label for="">วันที่ทำรายการ: <?php echo DateThai();?></label>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="fas fa-list"></i></span>
            <input type="text" class="form-control" id="subject" name="subject"  placeholder="ประชุมเรื่อง"  required="">
        </div>
    </div>
       <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="fas fa-list"></i>ประเภท</span>
            <select class="select" id="catgory" name="catgory" required="">
                <option value="1">ประชุมระดมความคิด </option>
                <option value="2">ประชุม VCS </option>
                <option value="3">ประชุมกรมการจังหวัด </option>
                <option value="4">ประชุมแก้ปัญหา </option>
                <option value="5">ประชุมตัดสินใจ </option>
                <option value="6">ประชุมฝึกอบรม </option>
                <option value="7">ประชุมรับนโยบาย/ผู้ตรวจ</option>
            </select>
        </div>
    </div>
     <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><i class="fas fa-user-circle"></i></span>
            <input type="text" class="form-control" id="้head" name="head"  placeholder="ประธานในที่ประชุม"  required="">
        </div>
    </div>     
	 <div class="form-group">
        <div class="input-group col-xs-3">
            <span class="input-group-addon"><i class="fas fa-sort-numeric-up"></i></span>
            <input type="number" class="form-control" id="้numpeople" name="numpeople"  placeholder="จำนวนผู้ร่วมประชุม"  required="" onKeyPress="check_number()">
        </div>
    </div>      
	 <div class="form-group">
        <div class="input-group col-xs-6">
            <span class="input-group-addon"><i class="fas fa-hospital"></i> ห้องที่ใช้ประชุม</span>
			<select class="form-control"  id="room_id" name="room_id">
				<?php
                    /*
                    if( $level_id == 1 ){  
                        $sql = "SELECT * FROM meeting_room   ORDER BY room_id DESC ";      //admin   display all
                    }elseif( $level_id == 3 ){         
                        $sql = "SELECT * FROM meeting_room WHERE room_status = 1 OR dep_id = $dep_id ORDER BY room_id DESC ";   // admin depart 
                    }elseif( $level_id == 4 ){
                        $sql = "SELECT * FROM meeting_room WHERE room_status = 1 OR dep_id = $dep_id ORDER BY room_id DESC ";
                    }else{
                        $sql = "SELECT * FROM meeting_room WHERE room_status = 1 OR dep_id = $dep_id ORDER BY room_id DESC ";
                    }
                    */
                    // ให้สำนักงานจังหวัดสามารถจองได้ทุกห้อง  หน่วยอื่นไม่เห็น
                    if ($dep_id==1) {
                        $sql = "SELECT * FROM meeting_room WHERE room_status <> 0   ORDER BY room_id DESC "; 
                    }elseif($dep_id<>1){
                        $sql = "SELECT * FROM meeting_room WHERE room_status = 1   ORDER BY room_id DESC "; 
                    }
					$result = dbQuery($sql);
					while ($row = dbFetchArray($result)) {?>
						<option value="<?php echo $row['room_id'];?>"><?php echo $row['roomname'];?>&nbsp&nbsp[<?php echo  $row['roomplace'];?>]</option>
				<?php }?>
			</select>
            <?php //echo "depid=".$dep_id."sql.".$sql;?>
        </div>
    </div>  
	 <div class="form-group">
        <div class="input-group col-xs-6">
            <span class="input-group-addon"><i class="fas fa-calendar-alt"></i> วันที่ใช้ห้อง</span>
            <input type="date" class="form-control" id="้startdate" name="startdate"  placeholder="วันที่ใช้ห้อง"  required="" onKeyDown="return false">
        </div>
    </div>      
	<div class="form-group">
        <div class="input-group col-xs-6">
            <span class="input-group-addon"><i class="fas fa-clock"></i> เวลาเริ่ม</span>
            <select class="form-control"  id="starttime" name="starttime">
				<?php
					$sql = "SELECT * FROM meeting_starttime ORDER BY time_id ASC ";
					$result = dbQuery($sql);
					while ($row = dbFetchArray($result)) {?>
						<option value="<?php echo $row['time_name'];?>"><?php echo $row['time_name'];?></option>
				<?php }?>
			</select>
			<span class="input-group-addon"><i class="fas fa-clock"></i> เวลาสิ้นสุด</span>
            <select class="form-control"  id="endtime"" name="endtime">
				<?php
					$sql = "SELECT * FROM meeting_endtime ORDER BY time_id ASC ";
					$result = dbQuery($sql);
					while ($row = dbFetchArray($result)) {?>
						<option value="<?php echo $row['time_name'];?>"><?php echo $row['time_name'];?></option>
				<?php }?>
			</select>
    	</div>
    </div>    
	 <div class="form-group">
        <div class="input-group">
		    <label>ระบบสนับสนุน</label>
			<div class="checkbox">
  				<label><input type="checkbox" value="1" checked>ระบบเสียง (Sound)</label>&nbsp
				<label><input type="checkbox" value="2" checked>ระบบแสดงผล (Projector)</label>&nbsp
				<label><input type="checkbox" value="3">ระบบประชุมทางไกล (VCS)</label>
			</div>
        </div>
    </div>     
    <div class="form-group">
        <div class="input-group col-xs-6">
            <span class="input-group-addon"><i class="fas fa-file"></i> แนบคำขออนุมัติ</span>
            <input class="form-control" type="file" name="fileUpload" id="fileUpload" required>
        </div>
    </div>  
	<div class="form-group">
        <div class="input-group col-xs-6">
			<?php
				 $sql = "SELECT u.u_id,u.firstname,u.lastname,u.dep_id,d.dep_name FROM user as u
				         INNER JOIN depart as d  ON u.dep_id = d.dep_id
				         WHERE u_id = $u_id";
				 $result = dbQuery($sql);
				 $row =dbFetchArray($result);
			?>
            <span class="input-group-addon"><i class="fas fa-user"></i> ผู้จอง</span>
            <label><?php echo $row['firstname'];?>&nbsp&nbsp<?php echo $row['lastname'];?></label>
        </div>
    </div>   
	<div class="form-group">
        <div class="input-group col-xs-6">
            <span class="input-group-addon"><i class="fas fa-home"></i></span>
            <label><?php echo $row['dep_name'];?></label>
        </div>
    </div>  
	 <center>
        <button class="btn btn-success btn-lg" type="submit" name="save_reserv">
            <i class="fab fa-twitter"></i> จองเลย...
        </button>
    </center>          
</form>

