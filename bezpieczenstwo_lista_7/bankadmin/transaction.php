<?php 
session_start();
session_regenerate_id();
require_once(__DIR__ . "/php/myDB.php");

if(!isset($_SESSION['user']))      
{
    header("Location: login.php");
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

</style>

</head>
<body>

<h2>Fill up details:</h2>

<form action="transaction_check.php" method="post" id="my_form">

  	<div class="container">
    		<label for="destination"><b>Destination (account number)</b></label>
    		<input type="text" size="24" maxlength="50" placeholder="Enter destination" name="destination" required>

		<label for="recipient"><b>Recipient</b></label>
    		<input type="text" size="24" maxlength="60" placeholder="Enter recipient" name="recipient" >

    		<label for="address"><b>Address</b></label>
    		<input type="text" size="24" maxlength="120" placeholder="Enter address" name="address" >
		
		<label for="comment"><b>Comment</b></label>
    		<input type="text" size="24" maxlength="120" placeholder="Enter comment" name="comment">
		
		<label for="value"><b>Value ($$$)</b></label>
    		<input type="number" step="any" size="24" maxlength="50" placeholder="Enter value" name="value" required>

    		<button type="submit">Make transaction</button>
  	</div>

</form> 	

<!--<script>
//document.getElementById("my_form").reset(); 
//document.getElementById("my_form").onsubmit = function() {
//   localStorage.setItem("account", document.getElementById("my_form").elements.destination.value );
//   document.getElementById("my_form").elements.destination.value = '666666666';
//}; 
</script>-->
</body>
</html>


