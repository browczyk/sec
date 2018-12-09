<?php
  session_start();
  require_once(__DIR__ . "/php/myDB.php");
  $OK = isset($_POST["username"]) && isset($_POST["email"]);
  
  if (!$OK){
    header("location: reset.php");
  }
  
  $username = ($_POST["username"]); 
  $email = ($_POST["email"]);

  $email = check_email($email);
  $username = check_username($username);

  if(!(strlen($username) > 0 && strlen($email) > 0)){
     end_session('reset.php');
  }
 
  $db = new portaldb();

  $sql = $db->prepare("SELECT * from clients WHERE username=? && email=?");
  $sql->bind_param('ss', $username, $email);

  $sql->execute();
  $result = $sql->get_result();
  $c = $result->num_rows;

  if ($c == 1) {
    send_reset_email($email);		 // send email here 
    $_SESSION['user'] = $username;
    header("location: reset_set.php");       //this should not be here - instead email should point there
  } else {
    end_session("reset.php");
  }

  $db->close();
  



  // functions
  function send_reset_email($email){

  }

  function check_username($username){
    $username = trim($username);
    if(strlen($username) < 2 || strlen($username) > 50){
      $username = '';
    }
    return $username;
  }

  function check_email($email){
    $email = trim($email);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email ='';
    }
    if(strlen($email) < 5 || strlen($email) > 50){
      $email = '';
    }
    return $email;
  }

  function end_session($url){
    $_SESSION = [];
    session_destroy();   
    session_unset();
    header("location: {$url}");
  }


?>
