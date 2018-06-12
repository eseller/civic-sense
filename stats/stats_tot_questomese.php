<?php
//setting header to json
header('Content-Type: application/json');

// Include stats_query_tot file
require_once __DIR__.'/stats_query_tot.php';

  $data=array($nticket_tot_questomese, $nticket_risolti_questomese, $nticket_inattesa_questomese, $nticket_presiincarico_questomese, $nticket_invalidati_questomese, $nticket_irrisolti_questomese);

  print json_encode($data);

?>

