<?php   
session_start();
if(isset($_SESSION['UserID'])){
 include("header.php");
 
}else{
    echo "<script>window.location.href='index.php'</script>";
}

?>
<div class="container-fluid">
    <div class="col-md-12">
    <div class="panel panel-primary">
                <div class="panel-heading"><i class="fas fa-feather fa-2x"></i>  <strong>Group Number (Admin Deskboard)</strong> 
                     <a href="" class="btn btn-default  pull-right" data-toggle="modal" data-target="#modalAdd">
                     <i class="fa fa-plus" aria-hidden="true"></i> เพิ่ม Group
                    </a></div>  
                <div class="panel-content">
                <table class="table table-bordered table-hover" id="tbGroup">
                        <thead>
                            <th>ลำดับที่</th>
                            <th>ชื่อกลุ่ม (GROUP)</th>
                            <th>หมายเลขกลุ่ม</th>
                            <th>แก้ไข</th>
                        </thead>
                        <tbody>
                        <?php   
                            $sql ="SELECT * FROM st_group ORDER BY gid DESC";
                            $result = dbQuery($sql);
                            while ($row = dbFetchArray($result)) {
                                echo "<tr>
                                         <td>".$row['gid']."</td>
                                         <td>".$row['gname']."</td>
                                         <td>".$row['gnumber']."</td>
                                         <td>".$row['gstatus']."</td>
                                     </tr>";
                            }
                        ?>
                        </tbody>
                   </table>

                </div>
				<div class="panel-footer"></div>
            </div> 
    </div>
</div>
<?php  include("footer.php");  ?>    