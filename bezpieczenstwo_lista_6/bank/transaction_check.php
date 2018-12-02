<?php 
session_start();
session_regenerate_id();
require_once(__DIR__ . "/php/myDB.php");

if(!(isset($_SESSION['user']) && isset($_POST["destination"]) && isset($_POST["value"])))     
{
    header("Location: transaction.php");
}

  $destination = ($_POST["destination"]); 
  $value = ($_POST["value"]);
  $recipient = ($_POST["recipient"]);
  $address = ($_POST["address"]);
  $comment = ($_POST["comment"]);

  $destination = check_destination($destination); 
  $value = check_value($value);
  $recipient = check_recipient($recipient);
  $address = check_address($address);
  $comment = check_comment($comment);


  if($destination == '' || $value == ''){
    header("Location: transaction.php");
  }else{

    $db = new portaldb();

    $id = get_user_id($_SESSION['user'],$db);

    if($id != NULL){
      $db->close();
      $_SESSION['destination'] = $destination;
      $_SESSION['value'] = $value;
      $_SESSION['recipient'] = $recipient;
      $_SESSION['address'] = $address;
      $_SESSION['comment'] = $comment;
      $_SESSION['user_id'] = $id;
      header("Location: transaction_confirmation.php");
    }else{
      header("Location: transaction.php");
    }


    $db->close();
  }



 //functions

function get_user_id($username,$db){

  $sql = $db->prepare("SELECT * from clients WHERE username=?");
  $sql->bind_param('s', $username); 
  $sql->execute();

  $result = $sql->get_result();
  $c = $result->num_rows;

  if($c == 1){
    $row = $result->fetch_assoc();
    $id = $row['id'];
    return($id);
  }else{
    return NULL;
  }
}

function check_destination($destination){
  $destination = trim($destination);				//trim
  if(strlen($destination) < 8 || strlen($destination) > 20){  //check length
    $destination = '';
    return $destination;
  }
  if(!(ctype_digit(strval($destination)) && (int)$destination > 0)){		//check if int and positive
    $destination = '';
  }
  return $destination;
}

function check_value($value){
  $value = trim($value);
  if(strlen($value) < 1 || $value <= 0){
    $value ='';
  }  
  return $value;
}

function check_recipient($recipient){
  $recipient= trim($recipient);
  if( strlen($recipient) > 120){ 	 //check length
    $recipient = '';
  }
  return $recipient;
}

function check_address($address){
  $address= trim($address);
  if( strlen($address) > 120){ 	 //check length
    $address = '';
  }
  return $address;
}

function check_comment($comment){
  $comment= trim($comment);
  if( strlen($comment) > 120){ 	 //check length
    $comment = '';
  }
  return $comment;
}

?>
