<?php 
session_start();
session_regenerate_id();
require_once(__DIR__ . "/php/myDB.php");

if(!( isset($_SESSION['user']) && isset($_SESSION['user_id']) && isset($_SESSION['destination']) && isset($_SESSION['value']) && isset($_SESSION['address']) && isset($_SESSION['recipient']) && isset($_SESSION['comment']) ))     
{
    header("Location: transaction.php");
}

$db = new portaldb();

$sqli = $db->prepare("INSERT INTO transactions (client_id, destination, recipient, address, comment, monies) VALUES (?,?,?,?,?,?)");
$sqli->bind_param('iisssd', $_SESSION['user_id'], $_SESSION['destination'], $_SESSION['recipient'], $_SESSION['address'],$_SESSION['comment'],$_SESSION['value']);

$sqli->execute();

$db->close();

header("Location: transaction_done.php");

?>
