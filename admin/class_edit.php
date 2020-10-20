
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->

<?php  
echo "hello";
/*
include("library/database.php");
$cid = $_POST['data'];
echo $cid;


$sql = "SELECT * FROM st_class WHERE cid = $cid";
$result = dbQuery($sql);
$row = dbFetchAssoc($result);
?>
<form  method="POST">
    <div class="form-group">
      <div class="input-group">
            <select class="form-control col-6" name="minis2" id="minis2">
                    <option selected>---เลือกต้นสังกัด---</option>
                <?php
                    $presee_sql="SELECT * FROM  st_group  ORDER BY gnumber";
                    $presee_result=dbQuery($presee_sql);
                    $presee_num=dbNumRows($presee_result);
                    if ($presee_num>0){
                        while($presee_row=dbFetchArray($presee_result)){	
                            $m_id2=$presee_row["m_id"];
                            $m_name2=$presee_row["m_name"];
                        ?>
                            <option value="<?php echo"$m_id2"?>"><? echo"$m_name2"?></option>
                    <?php } //end while
                    }else{?>
                            <option value="0">NoData</option>
                    <?}?>
            </select>
      </div>
      <br>
      <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">ชื่อต้นสังกัด</span>
          </div>
          <input type="text" id="dep_name" name="dep_name" class="form-control col-10" value="<?php print $row['dep_name'];?>">
      </div>
      <br>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">ลำดับที่</span>
        </div>
        <input type="text" id="dep_impo" name="dep_impo" class="form-control col-2" value="<?php print $row['dep_impo'];?>">
      </div>
    </div> <!-- form-group -->
    <br>
    <center>
    <button type="submit" class="btn btn-primary btn-md" name="btnEdit" id="btnEdit"><i class="fas fa-check"></i> ตกลง</button>
    </center>
    <input type="hidden" name="dep_id" id="dep_id" value="<?php echo $dep_id;?>">
</form>


