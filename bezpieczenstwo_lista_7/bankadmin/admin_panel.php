<?php 
session_start();
session_regenerate_id();
require_once(__DIR__ . "/php/myDB.php");

if(!isset($_SESSION['user']) && ($_SESSION['user'] != "admin"))      
{
    header("Location: login.php");
}

function show_history(){

  $username = ($_SESSION['user']);
  
  $db = new portaldb();

  $sqli = $db->prepare("SELECT id, client_id, destination, recipient, address, comment, monies FROM transactions WHERE approved=0 LIMIT 15");
  //$sqli->bind_param();
  $sqli->execute();

  $resulti = $sqli->get_result();
  $ci = $resulti->num_rows;

  if($ci <= 0){
    echo('<p>No transactions made yet.</p>');
  }else{

    $template = "<tr><td>{ID}</td><td>{C_ID}</td><td>{DEST}</td><td>{REC}</td><td>{ADD}</td><td>{COMM}</td><td>{VAL}</td></tr>\n\n";

    echo('<table>');
    echo('<tr><th>ID</th><th>Client ID</th><th>Destination</th><th>Recipient</th><th>Address</th><th>Comment</th><th>Value</th></tr>');

    while (($row = $resulti -> fetch_assoc()) !== null) {
    $tmp = $template;
    $s= str_replace(
      ["{ID}", "{C_ID}", "{DEST}",  "{REC}", "{ADD}", "{COMM}", "{VAL}"],
      [$row['id'],$row['client_id'],htmlspecialchars($row['destination']),htmlspecialchars($row['recipient']),htmlspecialchars($row['address']),$row['comment'],htmlspecialchars($row['monies'])], 
      $tmp);													// no output sanitizing in comment
    echo $s;
    }
  }
  
  $resulti->close();
  $db->close();

}


?>

<html>
<style>

body {font-family: Arial, Helvetica, sans-serif;}
form {
    border: 3px solid #f1f1f1;
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

<h1>Admin panel</h1>

<?php
  $user = htmlspecialchars(($_SESSION['user']));
  echo("<h2>Welcome $user</h2>");
?>
<form action="approve.php" method="post" id="all">
	<input type="submit" size="24" maxlength="10" value="Approve all" name="approve_all">
</form>
<form action="approve.php" method="post" >
	<div class="container">
    	<button type="submit">Approve transaction with id:</button>
	<input type="number" size="24" maxlength="10" placeholder="Enter transaction ID" name="approve">
	<?php
		show_history();
	?>

	</div>
</form>



</body>
</html>


