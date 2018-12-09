<?php
  session_start();
  require_once(__DIR__ . "/php/myDB.php");
  $OK = isset($_POST["username"]) && isset($_POST["password"]);
  
  if (!$OK){
    header("location: login.php");
  }
  
  $username = ($_POST["username"]); 
  $password = ($_POST["password"]);

  $password = check_password($password);
  $username = check_username($username);
 
  $db = new portaldb();

  $sql = $db->prepare("SELECT * from clients WHERE username=?");
  $sql->bind_param('s', $username);

  $sql->execute();
  $result = $sql->get_result();
  $c = $result->num_rows;

  if ($c == 1) {
    $row = $result -> fetch_assoc();
    $password_hash = $row['password'];

    if(password_verify($password, $password_hash)){
      $_SESSION['user'] = $username;
      if($username=="admin"){
        header("location: admin_panel.php");
      }else{
        header("location: history.php");
      }
    }else{
      end_session('login.php');
    }

  } else {
    end_session('login.php');
  }

  $db->close();
  

  // functions
  
  function check_username($username){
    return $username;
  }
  
  function check_password($password){
    return $password;
  }
 
  function end_session($url){
    $_SESSION = [];
    session_destroy();   
    session_unset();
    header("location: {$url}");
  }
?>
