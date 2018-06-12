<?php
//setting header to json
header('Content-Type: application/json');

session_start();

// Include stats_query_pv file
require_once __DIR__.'/stats_query_pv.php';

  $data = $_SESSION['data1'];

  print json_encode($data);

?>