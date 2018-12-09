<?php
/*.
  require_module 'standard';
  require_module 'mysqli';
.*/

/**
*  konstruktor połączenia z bazą danych
*  @return void
*/

class portaldb extends mysqli {

  public function __construct() {
    parent::__construct('localhost', 'root', 'rootoor', 'bankadmin');
  
    if (mysqli_connect_errno() != 0) {
      die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }
    parent::query("SET NAMES utf8");
    parent::query("SET CHARACTER SET utf8");
    parent::query("SET collation_connection = utf16_polish_ci");
  }
}

?>
