<?php
  /* Database credentials. Assuming you are running MySQL
  server with default setting (user 'root' with no password) */
  define('DB_SERVER', 'localhost');
  define('DB_USERNAME', 'civicsensesst');
  define('DB_PASSWORD', '');
  define('DB_CHARSET', 'utf8');
  define('DB_NAME', 'my_civicsensesst');

  /* Attempt to connect to MySQL database */
  $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
  $charset = mysqli_set_charset($link, DB_CHARSET);

  // Check connection
  if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
  }

  require_once 'functions.php';
?>
