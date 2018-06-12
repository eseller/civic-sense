  <?php

// Include config file
require_once __DIR__.'/../config.php';

$nticket_tot_ultimoanno = $nticket_risolti_ultimoanno = $nticket_inattesa_ultimoanno = $nticket_presiincarico_ultimoanno = $nticket_invalidati_ultimoanno = $nticket_irrisolti_ultimoanno = '';

$nticket_tot_questomese = $nticket_risolti_questomese = $nticket_inattesa_questomese = $nticket_presiincarico_questomese = $nticket_invalidati_questomese = $nticket_irrisolti_questomese = '';

$nticket_tot_questasettimana = $nticket_risolti_questasettimana = $nticket_inattesa_questasettimana = $nticket_presiincarico_questasettimana = $nticket_invalidati_questasettimana = $nticket_irrisolti_questasettimana = '';


//Numero ticket totali ultimo anno, questo mese, questa settimana
 $sql = "SELECT * FROM ticket WHERE data >= DATE_SUB(NOW(),INTERVAL 1 YEAR)";
 $result = mysqli_query($link, $sql);
 $nticket_tot_ultimoanno = mysqli_num_rows($result);

 $sql = "SELECT * FROM ticket WHERE  MONTH(data) = MONTH(CURRENT_DATE()) AND YEAR(data) = YEAR(CURRENT_DATE())";
 $result = mysqli_query($link, $sql);
 $nticket_tot_questomese = mysqli_num_rows($result);

 $sql = "SELECT * FROM ticket WHERE  YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1)";
 $result = mysqli_query($link, $sql);
 $nticket_tot_questasettimana = mysqli_num_rows($result);

//Numero ticket risolti ultimo anno, questo mese, questa settimana
 $sql = "SELECT * FROM ticket WHERE data >= DATE_SUB(NOW(),INTERVAL 1 YEAR) AND stato = 'Risolto'";
 $result = mysqli_query($link, $sql);
 $nticket_risolti_ultimoanno = mysqli_num_rows($result);

 $sql = "SELECT * FROM ticket WHERE  MONTH(data) = MONTH(CURRENT_DATE()) AND YEAR(data) = YEAR(CURRENT_DATE()) AND stato = 'Risolto'";
 $result = mysqli_query($link, $sql);
 $nticket_risolti_questomese = mysqli_num_rows($result);

 $sql = "SELECT * FROM ticket WHERE  YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND stato = 'Risolto'";
 $result = mysqli_query($link, $sql);
 $nticket_risolti_questasettimana = mysqli_num_rows($result);

 //Numero ticket in attesa di approvazione ultimo anno, questo mese, questa settimana
  $sql = "SELECT * FROM ticket WHERE data >= DATE_SUB(NOW(),INTERVAL 1 YEAR) AND stato = 'In attesa di approvazione'";
  $result = mysqli_query($link, $sql);
  $nticket_inattesa_ultimoanno = mysqli_num_rows($result);

  $sql = "SELECT * FROM ticket WHERE  MONTH(data) = MONTH(CURRENT_DATE()) AND YEAR(data) = YEAR(CURRENT_DATE()) AND stato = 'In attesa di approvazione'";
  $result = mysqli_query($link, $sql);
  $nticket_inattesa_questomese = mysqli_num_rows($result);

  $sql = "SELECT * FROM ticket WHERE  YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND stato = 'In attesa di approvazione'";
  $result = mysqli_query($link, $sql);
  $nticket_inattesa_questasettimana = mysqli_num_rows($result);

  //Numero ticket presi in carico ultimo anno, questo mese, questa settimana
   $sql = "SELECT * FROM ticket WHERE data >= DATE_SUB(NOW(),INTERVAL 1 YEAR) AND stato = 'Preso in carico'";
   $result = mysqli_query($link, $sql);
   $nticket_presiincarico_ultimoanno = mysqli_num_rows($result);

   $sql = "SELECT * FROM ticket WHERE  MONTH(data) = MONTH(CURRENT_DATE()) AND YEAR(data) = YEAR(CURRENT_DATE()) AND stato = 'Preso in carico'";
   $result = mysqli_query($link, $sql);
   $nticket_presiincarico_questomese = mysqli_num_rows($result);

   $sql = "SELECT * FROM ticket WHERE  YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND stato = 'Preso in carico'";
   $result = mysqli_query($link, $sql);
   $nticket_presiincarico_questasettimana = mysqli_num_rows($result);

   //Numero ticket invalidati ultimo anno, questo mese, questa settimana
    $sql = "SELECT * FROM ticket WHERE data >= DATE_SUB(NOW(),INTERVAL 1 YEAR) AND stato = 'Invalidato'";
    $result = mysqli_query($link, $sql);
    $nticket_invalidati_ultimoanno = mysqli_num_rows($result);

    $sql = "SELECT * FROM ticket WHERE  MONTH(data) = MONTH(CURRENT_DATE()) AND YEAR(data) = YEAR(CURRENT_DATE()) AND stato = 'Invalidato'";
    $result = mysqli_query($link, $sql);
    $nticket_invalidati_questomese = mysqli_num_rows($result);

    $sql = "SELECT * FROM ticket WHERE  YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND stato = 'Invalidato'";
    $result = mysqli_query($link, $sql);
    $nticket_invalidati_questasettimana = mysqli_num_rows($result);

    //Numero ticket invalidati ultimo anno, questo mese, questa settimana
     $sql = "SELECT * FROM ticket WHERE data >= DATE_SUB(NOW(),INTERVAL 1 YEAR) AND stato = 'Irrisolto'";
     $result = mysqli_query($link, $sql);
     $nticket_irrisolti_ultimoanno = mysqli_num_rows($result);

     $sql = "SELECT * FROM ticket WHERE  MONTH(data) = MONTH(CURRENT_DATE()) AND YEAR(data) = YEAR(CURRENT_DATE()) AND stato = 'Irrisolto'";
     $result = mysqli_query($link, $sql);
     $nticket_irrisolti_questomese = mysqli_num_rows($result);

     $sql = "SELECT * FROM ticket WHERE  YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND stato = 'Irrisolto'";
     $result = mysqli_query($link, $sql);
     $nticket_irrisolti_questasettimana = mysqli_num_rows($result);
?>

