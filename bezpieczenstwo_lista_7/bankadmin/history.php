<?php 
session_start();
session_regenerate_id();
require_once(__DIR__ . "/php/myDB.php");

if(!isset($_SESSION['user']))      
{
    header("Location: login.php");
}

function show_history(){

  $username = ($_SESSION['user']);
  
  $db = new portaldb();
 
  $result = $db->query("SELECT * from clients WHERE username='{$username}'");
  
  if($result->num_rows == 1){
    $row = $result->fetch_assoc();
    $id = $row["id"];
  }else{
    echo('<p>Error fetching data for this user</p>');
    return;
  }

  $result->close();
  
  //sql injection  ='666666666 OR recipient="John Doe" ';
  if(isset($_POST['filter'])){
    $filter = $_POST['filter'];
    if($filter==''){
      $resulti = $db->query("SELECT destination, recipient, address, comment, monies, approved FROM transactions WHERE client_id=$id LIMIT 15");
    }else{
      $resulti = $db->query("SELECT destination, recipient, address, comment, monies, approved FROM transactions WHERE client_id=$id AND destination=$filter LIMIT 15");
    }
  }else{
    $resulti = $db->query("SELECT destination, recipient, address, comment, monies, approved FROM transactions WHERE client_id=$id LIMIT 15");
  }  
  

  if(!$resulti){
    echo('<p>You have made no transactions yet.</p>');
  }else{

    $template = "<tr><td>{DEST}</td><td>{REC}</td><td>{ADD}</td><td>{COMM}</td><td>{VAL}</td><td>{APP}</td></tr>\n\n";

    echo('<table>');
    echo('<tr><th>Destination</th><th>Recipient</th><th>Address</th><th>Comment</th><th>Value</th><th>Approved</th></tr>');

    while (($row = $resulti -> fetch_assoc()) !== null) {
    $tmp = $template;
    $s= str_replace(
      ["{DEST}",  "{REC}", "{ADD}", "{COMM}", "{VAL}","{APP}"],
      [htmlspecialchars($row['destination']),htmlspecialchars($row['recipient']),htmlspecialchars($row['address']),htmlspecialchars( $row['comment']),htmlspecialchars($row['monies']),htmlspecialchars($row['approved'])], 
      $tmp);
    echo $s;
     
    }
    $resulti->close();
  }
  
  $db->close();

}


?>

<html>
<style>

body {font-family: Arial, Helvetica, sans-serif;}
form {
    border: 3px solid #f1f1f1;
    max-width:900px;
}

input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

button:hover {
    opacity: 0.8;
}

.container {
    padding: 16px;
    max-width: 900px;
}

span.psw {
    float: right;
    padding-top: 16px;
}


table {
    border-collapse: collapse;

}

table, td, th {
    border: 2px solid #4CAF50 ;
}
td, th{
  padding: .5em 1em;
}

</style>
<head><title>MyBank</title></head>
<body>

<h1>History</h1>

<?php
  $user = htmlspecialchars(($_SESSION['user']));
  echo("<h2>Welcome $user</h2>");
?>
<div><a href="logout.php">Log out</a></div>

<form action="transaction.php">
	<div class="container">
    	<button type="submit">Make a transaction</button>
	<?php
		show_history();
	?>

	</div>
</form>
<form action="history.php" method="post">
	<button type="submit">Use to filter destination:</button>
	<input type="text" size="24" maxlength="120" placeholder="Enter destination" name="filter" >
</form>

</body>
</html>


