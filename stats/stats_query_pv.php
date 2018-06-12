<?php
// Include config file
require_once __DIR__.'/../config.php';

  if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['provincia'] != ""){
        $provincia = trim($_POST['provincia']);
}

 $nticket_tot_ultimoanno_pv =  $nticket_risolti_ultimoanno_pv =  $nticket_inattesa_ultimoanno_pv =  $nticket_presiincarico_ultimoanno_pv =  $nticket_invalidati_ultimoanno_pv =  $nticket_irrisolti_ultimoanno_pv = '';

 $sql = "SELECT * FROM ticket WHERE data >= DATE_SUB(NOW(),INTERVAL 1 YEAR) AND provincia LIKE '$provincia'";
 $result = mysqli_query($link, $sql);
 $nticket_tot_ultimoanno_pv = mysqli_num_rows($result);

 $sql = "SELECT * FROM ticket WHERE  MONTH(data) = MONTH(CURRENT_DATE()) AND YEAR(data) = YEAR(CURRENT_DATE()) AND provincia = '$provincia'";
 $result = mysqli_query($link, $sql);
 $nticket_tot_questomese_pv = mysqli_num_rows($result);

 $sql = "SELECT * FROM ticket WHERE  YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND provincia = '$provincia'";
 $result = mysqli_query($link, $sql);
 $nticket_tot_questasettimana_pv = mysqli_num_rows($result);

//Numero ticket risolti ultimo anno, questo mese, questa settimana
 $sql = "SELECT * FROM ticket WHERE data >= DATE_SUB(NOW(),INTERVAL 1 YEAR) AND stato = 'Risolto' AND provincia = '$provincia'";
 $result = mysqli_query($link, $sql);
 $nticket_risolti_ultimoanno_pv = mysqli_num_rows($result);

 $sql = "SELECT * FROM ticket WHERE  MONTH(data) = MONTH(CURRENT_DATE()) AND YEAR(data) = YEAR(CURRENT_DATE()) AND stato = 'Risolto' AND provincia = '$provincia'";
 $result = mysqli_query($link, $sql);
 $nticket_risolti_questomese_pv = mysqli_num_rows($result);

 $sql = "SELECT * FROM ticket WHERE  YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND stato = 'Risolto' AND provincia = '$provincia'";
 $result = mysqli_query($link, $sql);
 $nticket_risolti_questasettimana_pv = mysqli_num_rows($result);

 //Numero ticket in attesa di approvazione ultimo anno, questo mese, questa settimana
  $sql = "SELECT * FROM ticket WHERE data >= DATE_SUB(NOW(),INTERVAL 1 YEAR) AND stato = 'In attesa di approvazione' AND provincia = '$provincia'";
  $result = mysqli_query($link, $sql);
  $nticket_inattesa_ultimoanno_pv = mysqli_num_rows($result);

  $sql = "SELECT * FROM ticket WHERE  MONTH(data) = MONTH(CURRENT_DATE()) AND YEAR(data) = YEAR(CURRENT_DATE()) AND stato = 'In attesa di approvazione' AND provincia = '$provincia'";
  $result = mysqli_query($link, $sql);
  $nticket_inattesa_questomese_pv = mysqli_num_rows($result);

  $sql = "SELECT * FROM ticket WHERE  YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND stato = 'In attesa di approvazione' AND provincia = '$provincia'";
  $result = mysqli_query($link, $sql);
  $nticket_inattesa_questasettimana_pv = mysqli_num_rows($result);

  //Numero ticket presi in carico ultimo anno, questo mese, questa settimana
   $sql = "SELECT * FROM ticket WHERE data >= DATE_SUB(NOW(),INTERVAL 1 YEAR) AND stato = 'Preso in carico' AND provincia = '$provincia'";
   $result = mysqli_query($link, $sql);
   $nticket_presiincarico_ultimoanno_pv = mysqli_num_rows($result);

   $sql = "SELECT * FROM ticket WHERE  MONTH(data) = MONTH(CURRENT_DATE()) AND YEAR(data) = YEAR(CURRENT_DATE()) AND stato = 'Preso in carico' AND provincia = '$provincia'";
   $result = mysqli_query($link, $sql);
   $nticket_presiincarico_questomese_pv = mysqli_num_rows($result);

   $sql = "SELECT * FROM ticket WHERE  YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND stato = 'Preso in carico' AND provincia = '$provincia'";
   $result = mysqli_query($link, $sql);
   $nticket_presiincarico_questasettimana_pv = mysqli_num_rows($result);

   //Numero ticket invalidati ultimo anno, questo mese, questa settimana
    $sql = "SELECT * FROM ticket WHERE data >= DATE_SUB(NOW(),INTERVAL 1 YEAR) AND stato = 'Invalidato' AND provincia = '$provincia'";
    $result = mysqli_query($link, $sql);
    $nticket_invalidati_ultimoanno_pv = mysqli_num_rows($result);

    $sql = "SELECT * FROM ticket WHERE  MONTH(data) = MONTH(CURRENT_DATE()) AND YEAR(data) = YEAR(CURRENT_DATE()) AND stato = 'Invalidato' AND provincia = '$provincia'";
    $result = mysqli_query($link, $sql);
    $nticket_invalidati_questomese_pv = mysqli_num_rows($result);

    $sql = "SELECT * FROM ticket WHERE  YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND stato = 'Invalidato' AND provincia = '$provincia'";
    $result = mysqli_query($link, $sql);
    $nticket_invalidati_questasettimana_pv = mysqli_num_rows($result);

    //Numero ticket invalidati ultimo anno, questo mese, questa settimana
     $sql = "SELECT * FROM ticket WHERE data >= DATE_SUB(NOW(),INTERVAL 1 YEAR) AND stato = 'Irrisolto' AND provincia = '$provincia'";
     $result = mysqli_query($link, $sql);
     $nticket_irrisolti_ultimoanno_pv = mysqli_num_rows($result);

     $sql = "SELECT * FROM ticket WHERE  MONTH(data) = MONTH(CURRENT_DATE()) AND YEAR(data) = YEAR(CURRENT_DATE()) AND stato = 'Irrisolto' AND provincia = '$provincia'";
     $result = mysqli_query($link, $sql);
     $nticket_irrisolti_questomese_pv = mysqli_num_rows($result);

     $sql = "SELECT * FROM ticket WHERE  YEARWEEK(data, 1) = YEARWEEK(CURDATE(), 1) AND stato = 'Irrisolto' AND provincia = '$provincia'";
     $result = mysqli_query($link, $sql);
     $nticket_irrisolti_questasettimana_pv = mysqli_num_rows($result);

     ?>