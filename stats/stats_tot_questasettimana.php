<?php
//setting header to json
header('Content-Type: application/json');

// Include stats_query_tot file
require_once __DIR__.'/stats_query_tot.php';

  $data=array($nticket_tot_questasettimana, $nticket_risolti_questasettimana, $nticket_inattesa_questasettimana, $nticket_presiincarico_questasettimana, $nticket_invalidati_questasettimana, $nticket_irrisolti_questasettimana);

  print json_encode($data);

?>

