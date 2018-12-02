<?php 

echo('<p>Hej</p>');
$password = "lol";
$password_hash = password_hash($password, PASSWORD_BCRYPT, ["cost" => 12]);
if (password_verify('super', $password_hash)) {
    echo $password_hash;
} else {
    echo $password_hash;
}
?>
