<?php
  session_start();
  require_once(__DIR__ . "/php/myDB.php");
  $OK = isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["password_check"]) && isset($_POST["email"]);
  
  if (!$OK){
    header("location: signup.php");
  }
  
  $username = ($_POST["username"]); 
  $password = ($_POST["password"]);
  $password_check = ($_POST["password_check"]);
  $email = ($_POST["email"]);

  $username = check_username($username);
  $password = check_password($password);
  $password_check = check_password($password_check);
  $email = check_email($email);

  if(!(strlen($username) > 0 && strlen($email) > 0 && strlen($password) > 0 && $password == $password_check)){
    end_session('signup.php');
  }
 
  $password = password_hash($password, PASSWORD_BCRYPT, ["cost" => 12]); //hash password
  
  $db = new portaldb();

  $sql = $db->prepare("SELECT * from clients WHERE username=?");
  $sql->bind_param('s', $username);

  $sql->execute();
  $result = $sql->get_result();
  $c = $result->num_rows;

  if ($c == 0) {
    
    $sqli = $db->prepare("INSERT INTO clients (username, password, email) VALUES (?,?,?)");
    $sqli->bind_param('sss', $username, $password, $email);

    $sqli->execute();

    $_SESSION['user'] = $username;
    header("location: history.php");

  } else {
    end_session('signup.php');
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
