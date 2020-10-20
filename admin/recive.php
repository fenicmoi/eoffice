<?php
include 'header.php';
//include 'function.php';
//include '../library/database.php';

$pid=$_GET['pid'];
$sec_id=$_GET['sec_id'];
$dep_id=$_GET['dep_id'];
$dateRecive=date('Y-m-d H:m:s');

$sql="SELECT  p.pid,p.insite,p.outsite FROM paper p
      INNER JOIN  paperuser u ON u.pid=p.pid
      WHERE u.pid=$pid AND u.dep_id=$dep_id";
$result=dbQuery($sql);
if(!$result){
  echo "<script>
  swal({
      title:'มีบางอย่างผิดพลาด !',
      type:'error',
      showConfirmButton:true
      },
      function(isConfirm){
          if(isConfirm){
              window.location.href='paper.php';
          }
      }); 
  </script>"; 
}else{
  $numrow=dbNumRows($result);
  if($numrow<>0){
    $row=dbFetchArray($result);
    if($row['insite']==1){
     // echo "นี่เป็นหนังสื่อส่งภายใน";
      $sql="UPDATE paperuser SET confirm=1,confirmdate='$dateRecive' WHERE pid=$pid AND sec_id=$sec_id AND u_id=$u_id";
      $result=dbQuery($sql);
      if(!$result){
        echo "<script>
        swal({
            title:'มีบางอย่างผิดพลาด !',
            type:'error',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='paper.php';
                }
            }); 
        </script>"; 
      }else{
        echo "<script>
        swal({
            title:'ยืนยันรับทราบเรียบร้อยแล้ว',
            type:'success',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='paper.php';
                }
            }); 
        </script>"; 
      }
    }elseif($row['outsite']==1){
      //echo "นี่เป็นหนังสื่อส่งภายนอก";
      $sql="UPDATE paperuser SET u_id=$u_id,confirm=1,confirmdate='$dateRecive' WHERE pid=$pid AND dep_id=$dep_id";
      //print $sqlRecive;
      $result=dbQuery($sql);
      if(!$result){
        echo "<script>
        swal({
            title:'มีบางอย่างผิดพลาด !',
            type:'error',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='paper.php';
                }
            }); 
        </script>"; 
      }else{
        echo "<script>
        swal({
            title:'ยืนยันรับทราบเรียบร้อยแล้ว !',
            type:'success',
            showConfirmButton:true
            },
            function(isConfirm){
                if(isConfirm){
                    window.location.href='paper.php';
                }
            }); 
        </script>"; 
      }
    }
  }
}

?>