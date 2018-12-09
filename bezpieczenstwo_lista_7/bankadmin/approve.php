<?php 
session_start();
session_regenerate_id();
require_once(__DIR__ . "/php/myDB.php");

if(!(isset($_SESSION['user'])&& $_SESSION['user']=="admin" ))     
{
    header("Location: admin_panel.php");
}

if(!(isset($_POST['approve']) || isset($_POST['approve_all'])))    
{
    header("Location: admin_panel.php");
}

  if(isset($_POST['approve'])){
    $id=$_POST['approve'];
    if(strlen($id)<=0){
      header("Location: admin_panel.php");
      return;
    }
    
   $sql = "UPDATE transactions SET approved=1 WHERE id=$id";
  }else{
    $sql = "UPDATE transactions SET approved=1";
  }


  $db = new portaldb();
  $result = $db->query($sql);

  $db->close();
  header("Location: admin_panel.php");
  


?>
