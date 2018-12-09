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

<h2>Login Form</h2>

<form action="login_check.php" method="post">

  	<div class="container">
    		<label for="username"><b>Username</b></label>
    		<input type="text" size="24" maxlength="50" placeholder="Enter Username" name="username" required>

    		<label for="password"><b>Password</b></label>
    		<input type="password" size="24" maxlength="50" placeholder="Enter Password" name="password" required>

    		<button type="submit">Login</button>
  	</div>

  	<div class="container" style="background-color:#f1f1f1">
   		<span >Forgot <a href="reset.php">password?</a></span>
  	</div>
</form> 	


</body>
</html>


