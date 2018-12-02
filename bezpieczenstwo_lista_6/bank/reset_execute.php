<?php
  session_start();
  require_once(__DIR__ . "/php/myDB.php");
  $OK = isset($_POST["password"]);
  
  if (!$OK){
    header("location: reset.php");
  }
  
  $username = ($_SESSION['user']); 
  $password = ($_POST["password"]);

  $password = check_password($password);

  if(!(strlen($password) > 0)){
     end_session('reset.php');
  }
 
  $password = password_hash($password, PASSWORD_BCRYPT, ["cost" => 12]);
 
  $db = new portaldb();

  $sql = $db->prepare("SELECT * from clients WHERE username=?");
  $sql->bind_param('s', $username);

  $sql->execute();
  $result = $sql->get_result();
  $c = $result->num_rows;

  if ($c == 1) {
    
    $sqli = $db->prepare("UPDATE `clients` SET `password`=? WHERE `username`=?");
    $sqli->bind_param('ss', $password, $username);

    $sqli->execute();

    header("location: login.php");       
  } else {
    end_session("reset.php");
  }

  $db->close();
  

  // functions

    function check_password($password){
    $password = trim($password);
    if(strlen($password) < 8 || strlen($password) > 50){
      $password = '';
    }
    return $password;
  }

  function end_session($url){
    $_SESSION = [];
    session_destroy();   
    session_unset();
    header("location: {$url}");
  }


?>
