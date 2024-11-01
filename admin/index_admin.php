<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
    if(!isset($_SESSION['ses_u_id'])){
      header("location:../index.php");
    }
} 

include 'header.php';

$menu = checkMenu($level_id);
include $menu;

@$imenu = $_GET['imenu'];

if(isset($imenu)){
    if($imenu == 'deskboard'){
      include("deskboard.php");
    }elseif($imenu == 'newpaper'){
      include("paper.php");
    }
}else{
  $imenu == 'deskboard.php';
  include("deskboard.php");
}

include 'footer.php';
?>
