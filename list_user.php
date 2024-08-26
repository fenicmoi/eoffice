<?php
// Display  user registry 
date_default_timezone_set('Asia/Bangkok');
include "header.php"; 
include_once 'admin/function.php';
?>

<div class="row">
    <div class ="col-md-12">
    <br><br><br>
        <table class="table table-bordered table-hover" id="myTable" >
                <thead class="bg-info">
                        <tr>
                        <td colspan="3"><center>รายชื่อเจ้าหน้าที่สารบรรณประจำส่วนราชการ/หน่วยงาน</center></td>
                        </tr>
                        <tr >
                                <td colspan="3">
                                <form class="form-inline" method="post">
                                    <div class="form-group">
                                        <input type="radio" name="number" id="number" value="2" checked>ค้นหาด้วยชื่อหน่วยงาน
                                        <div class="input-group">
                                        <span class="input-group-addon">แถวการแสดงผล:</span>
                                            <select class="form-control" name="perpage">
                                                <option value="20">20</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                        </div>
                                        <input class="form-control" id="search" name="search" type="text" size=80 placeholder="พิมพ์ชื่อส่วนราชการ/หน่วยงาน สั้น ๆ">
                                        <button class="btn btn-success" type="submit" name="save">
                                            <i class="fas fa-search "></i> ตกลง
                                        </button>
                                    </div>
                                    
                                </form>
                                </td>
                            </tr>
                     
                    <tr>
                        <th>ส่วนราชการ</th>
                        <th>เจ้าหน้าที่สารบรรณ</th>
                        <th>วันที่ลงทะเบียน</th>
                    </tr>
                </thead>
                <?php
                //searching
                  @$txt_search=$_POST['search'];      //search for name
                  @$type_search=$_POST['number'];     //search for number
                  if(isset($_POST['perpage'])){       //number of page
                    $perpage = $_POST['perpage'];
                  }else{
                    $perpage = 10;                    //count of page
                  }

                  if (isset($_GET['page'])) {         //check page if start = 1
                    $page = $_GET['page'];
                  } else {
                    $page = 1;
                  }
                  $start = ($page - 1) * $perpage;    // calculate page

                 if(isset($_POST['save'])){           //check button search
                    if($type_search==2){              //static variable  tye; 2
                        // $sql="SELECT t.type_name,d.dep_name,u.dep_id,u.firstname,u.lastname,u.level_id,u.date_create
                        //  FROM depart as d 
                        // INNER JOIN user as u ON d.dep_id = u.dep_id 
                        // INNER JOIN office_type as t ON t.type_id=d.type_id
                        // WHERE u.level_id=3  and d.dep_name LIKE '%$txt_search%'
                        // LIMIT $start , $perpage  ";

                        // $sql = "SELECT depart, fname, lname, date_add 
                        //         FROM register_staf 
                        //         WHERE depart LIKE '%$txt_search%'
                        //         LIMIT $start, $perpage 
                        //         ";

                        $sql = "SELECT * FROM register_staf
                                WHERE depart LIKE '%$txt_search%'
                                LIMIT $start, $perpage";
                         $result = dbQuery($sql);
                    }
                                     
                }else{
                    //  $sql="SELECT t.type_name,d.dep_name,u.dep_id,u.firstname,u.lastname,u.level_id,u.date_create
                    //  FROM depart as d 
                    //  INNER JOIN user as u ON d.dep_id = u.dep_id 
                    //  INNER JOIN office_type as t ON t.type_id=d.type_id WHERE u.level_id=3 ORDER BY d.dep_name
                    //  limit $start , $perpage  ";    
                        // $sql = "SELECT depart, fname, lname, date_add
                        //         FROM register_staf
                        //         LIMIT $start, $perpage";

                        $sql = "SELECT *
                                FROM register_staf
                                LIMIT $start, $perpage";
                         $result = dbQuery($sql);
                }
                //print $sql;
                // print $sql; 
                       
                ?>        
                <tbody>
                    
                        <?php while($row=dbFetchArray($result)){?>
                        <tr>
                            <td><?=$row['depart']?></td>
                            <td><?=$row['fname']?>&nbsp&nbsp<?=$row['lname']?></td>
                            <td><?=$row['date_add']?></td>
                        </tr>
                    <?php } ?>
                        <tr>
                     <?php
                     // Management pagenavigation
                            // $sql = "SELECT t.type_name,d.dep_name,u.dep_id,u.firstname,u.lastname,u.level_id,u.date_create
                            //         FROM depart as d 
                            //         INNER JOIN user as u ON d.dep_id = u.dep_id 
                            //         INNER JOIN office_type as t ON t.type_id=d.type_id WHERE u.level_id=3 ORDER BY d.dep_name";
                            $sql = "SELECT *
                                    FROM  register_staf
                                    LIMIT $start, $perpage";
                            $result=dbQuery($sql);
                            $total_record = dbNumRows($result);
                            $total_page = ceil($total_record / $perpage);

                                        // print $
                                    ?>
                        <td colspan=4>
                                            <center>
                                             <nav>
                                                <ul class="pagination">
                                                    <li>
                                                        <a href="list_user.php?page=1" aria-label="ก่อนหน้า">
                                                        <span aria-hidden="true"><i class="fas fa-arrow-alt-circle-left"></i></span>
                                                        </a>
                                                    </li>
                                                    <?php for($i=1;$i<=$total_page;$i++){ ?>
                                                    <li><a href="list_user.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                                    <?php } ?>
                                                    <li>
                                                    <a href="list_user.php?page=<?php echo $total_page;?>" aria-label="ถัดไป">
                                                    <span aria-hidden="true"><i class="fas fa-arrow-alt-circle-right"></i></span>
                                                    </a>
                                                    </li>
                                                </ul>
                                            </nav>
                                            </center>
                                        </td>
                            </tr>
                </tbody>
            </table>
    </div>
</div>
<?php include "footer.php";