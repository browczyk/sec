<?php
  session_start();
  
  if (isset($_SESSION["user"])){
    header("location: history.php");
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

<h2>Password reset</h2>
<h3>to reset your password, enter your username and email</h3>

<form action="reset_check.php" method="post">

  	<div class="container">
    		<label for="username"><b>Username</b></label>
    		<input type="text" size="24" maxlength="50" placeholder="Enter username" name="username" required>

    		<label for="email"><b>Email</b></label>
    		<input type="text" size="24" maxlength="50" placeholder="Enter Email" name="email" required>

    		<button type="submit">Reset</button>
  	</div>
</form> 	


</body>
</html>


