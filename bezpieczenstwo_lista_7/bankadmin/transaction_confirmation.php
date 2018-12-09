<?php 
session_start();
session_regenerate_id();

if(!( isset($_SESSION['user']) && isset($_SESSION['user_id']) && isset($_SESSION['destination']) && isset($_SESSION['value']) && isset($_SESSION['address']) && isset($_SESSION['recipient']) && isset($_SESSION['comment']) ))     
{
    header("Location: transaction.php");
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
</head>
<body>

<h2>Confirm data</h2>
<?php

    $table = <<<EOT
 <table style="width:100%">
  <tr>
    <th>Destination</th>
    <th>Recipient</th>
    <th>Address</th>
    <th>Comment</th>
    <th>Value</th>
  </tr>
  <tr>
    <td id="ok">{DEST}</td>
    <td>{REC}</td>
    <td>{ADD}</td>
    <td>{COMM}</td>
    <td>{VAL}</td>
  </tr>
</table>
EOT;

$table= str_replace(
      ["{DEST}",  "{REC}", "{ADD}", "{COMM}", "{VAL}"],
      [htmlspecialchars($_SESSION['destination']),htmlspecialchars($_SESSION['recipient']),htmlspecialchars($_SESSION['address']), htmlspecialchars($_SESSION['comment']),htmlspecialchars($_SESSION['value'])], 
      $table);

echo $table;

?>
<form action="transaction_execute.php" method="post">
  	<div class="container">
    		<button type="submit">Everything's fine - make transaction</button>
  	</div>
</form> 

<!--<script>
//document.getElementsByTagName("table")[0].rows[1].cells[0].innerHTML = localStorage.getItem("account"); 
//localStorage.removeItem("account");
</script>-->

</body>
</html>


