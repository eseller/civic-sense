<?php
//setting header to json
header('Content-Type: application/json');

session_start();

// Include stats_query_pv file
require_once __DIR__.'/stats_query_pv.php';

 // $data=array(intval($nticket_tot_ultimoanno_pv), intval($nticket_risolti_ultimoanno_pv), intval($nticket_inattesa_ultimoanno_pv), intval($nticket_presiincarico_ultimoanno_pv), intval($nticket_invalidati_ultimoanno_pv), intval($nticket_irrisolti_ultimoanno_pv));
  $data = $_SESSION['data'];

  print json_encode($data);

?>