<?php
//setting header to json
header('Content-Type: application/json');

// Include stats_query_tot file
require_once __DIR__.'/stats_query_tot.php';

  $data=array($nticket_tot_ultimoanno, $nticket_risolti_ultimoanno, $nticket_inattesa_ultimoanno, $nticket_presiincarico_ultimoanno, $nticket_invalidati_ultimoanno, $nticket_irrisolti_ultimoanno);

  print json_encode($data);

?>