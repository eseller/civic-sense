<?php
// Include stats_query_tot file
require_once __DIR__.'/../stats/stats_query_tot.php';
// Include stats_query_pv file
require_once __DIR__.'/../stats/stats_query_pv.php';

// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: https://civicsensesst.altervista.org/login_user.php");
  exit;
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Civic Sense</title>
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Article-List.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Contact-FormModal-Contact-Form-with-Google-Map.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/dh-row-text-image-right.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Features-Boxed.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Forum---Thread-listing.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Forum---Thread-listing1.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Pretty-Registration-Form.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Pretty-Registration-Form-1.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Login-Form-Dark.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Sidebar-Menu.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Sidebar-Menu1.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/styles.css">
    <style type="text/css">
      #chart-container {
        width: 640px;
        height: auto;
      }
    </style>
    <script type="text/javascript" src="<?php __DIR__ ?>/../stats/Chart.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>

<body style="background-color:#eef4f7;">
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="row clearmargin clearpadding row-image-txt" style="background-color:#eef4f7;">
        <div class="col-xs-12 col-sm-6 col-md-6 col-sm-pull-6" style="padding:20px;">
          <h1 style="color:#000000;">Stato dei ticket</h1>
          <hr>
          <h3 style="color:#000000;">Nell'ultimo anno</h3>
          <p style="color:#000000;">
          	<?php
          	  echo "Nell'ultimo anno sono stati inseriti $nticket_tot_ultimoanno tickets. Di questi, $nticket_risolti_ultimoanno sono stati risolti, $nticket_inattesa_ultimoanno sono in attesa di approvazione, $nticket_presiincarico_ultimoanno sono attualmente presi in carico da un gruppo di risoluzione, $nticket_invalidati_ultimoanno sono stati invalidati e $nticket_irrisolti_ultimoanno sono irrisolti. <br> <br>";
              ?>
              <div id="chart-container-tot-ultimoanno">
                <canvas id="mycanvas_tot_ultimoanno"></canvas>
                <script type="text/javascript" src="<?php __DIR__ ?>/../stats/tot_ultimoanno.js"></script>
              </div></p>
          <h3 style="color:#000000;">In questo mese</h3>

          <p style="color:#000000;">
            <?php
          	  echo "In questo mese sono stati inseriti $nticket_tot_questomese tickets. Di questi, $nticket_risolti_questomese sono stati risolti, $nticket_inattesa_questomese sono in attesa di approvazione, $nticket_presiincarico_questomese sono attualmente presi in carico da un gruppo di risoluzione, $nticket_invalidati_questomese sono stati invalidati e $nticket_irrisolti_questomese sono irrisolti. <br> <br>";
              ?>
              <div id="chart-container-tot-questomese">
                <canvas id="mycanvas_tot_questomese"></canvas>
                <script type="text/javascript" src="<?php __DIR__ ?>/../stats/tot_questomese.js"></script>
              </div></p>
          <h3 style="color:#000000;">In questa settimana</h3>

          <p style="color:#000000;">
            <?php
          	  echo "In questa settimana sono stati inseriti $nticket_tot_questasettimana tickets. Di questi, $nticket_risolti_questasettimana sono stati risolti, $nticket_inattesa_questasettimana sono in attesa di approvazione, $nticket_presiincarico_questasettimana sono attualmente presi in carico da un gruppo di risoluzione, $nticket_invalidati_questasettimana sono stati invalidati e $nticket_irrisolti_questasettimana sono irrisolti. <br> <br>";
          	?>
            <div id="chart-container-tot-questasettimana">
              <canvas id="mycanvas_tot_questasettimana"></canvas>
              <script type="text/javascript" src="<?php __DIR__ ?>/../stats/tot_questasettimana.js"></script>
            </div>
          </p>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-sm-pull-6" style="padding:20px;">
            <h1 style="color:#000000;">Statistiche per provincia</h1>
            <hr>
				<div class="dropdown">
          <div class="select-group"><label>Provincia</label>
            <select class="custom-select" name="provincia" required>
              <option value=""><?php echo $provincia;?></option>
                <?php
                  $filepath = "http://www.mandile.it/wp-content/uploads/province-sigle.csv";
                  $array_csv = csvToArray($filepath);

                  foreach($array_csv as $numero_riga => $valori){
                   $valore_prima_colonna = $valori[0];
                   $valore_seconda_colonna = $valori[1];

                   echo "<option value=\"".$valore_seconda_colonna."\">".$valore_seconda_colonna."</option>";
                   }
                ?>
            </select>
          </div>
        </div>
        <p style="color:#000000;">
          <?php if($provincia == "") {echo 'Selezionare una provincia.';} else {
          if ($nticket_tot_ultimoanno_pv == 0) {echo 'Nessun dato da mostrare.';}
          else {
          $_SESSION['data'] = array(intval($nticket_tot_ultimoanno_pv), intval($nticket_risolti_ultimoanno_pv), intval($nticket_inattesa_ultimoanno_pv), intval($nticket_presiincarico_ultimoanno_pv), intval($nticket_invalidati_ultimoanno_pv), intval($nticket_irrisolti_ultimoanno_pv));
           echo "<h3 style=\"color:#000000;\">Nell'ultimo anno</h3>";

           echo "Nell'ultimo anno sono stati inseriti $nticket_tot_ultimoanno_pv tickets in provincia di $provincia <br><br>";

           echo '<div id="chart-container-pv-ultimoanno">
                 <canvas id="mycanvas_pv_ultimoanno"></canvas>
                 <script type="text/javascript" src="../stats/pv_ultimoanno.js"></script>
                 </div>';

          $_SESSION['data1'] = array(intval($nticket_tot_questomese_pv), intval($nticket_risolti_questomese_pv), intval($nticket_inattesa_questomese_pv), intval($nticket_presiincarico_questomese_pv), intval($nticket_invalidati_questomese_pv), intval($nticket_irrisolti_questomese_pv));
           echo '<h3 style="color:#000000;">In questo mese</h3>';

           echo "In questo mese sono stati inseriti $nticket_tot_questomese_pv tickets in provincia di $provincia <br><br>";

           echo '<div id="chart-container-pv-questomese">
                 <canvas id="mycanvas_pv_questomese"></canvas>
                 <script type="text/javascript" src="../stats/pv_questomese.js"></script>
                 </div>';

          $_SESSION['data2'] = array(intval($nticket_tot_questasettimana_pv), intval($nticket_risolti_questasettimana_pv), intval($nticket_inattesa_questasettimana_pv), intval($nticket_presiincarico_questasettimana_pv), intval($nticket_invalidati_questasettimana_pv), intval($nticket_irrisolti_questasettimana_pv));
           echo '<h3 style="color:#000000;">In questa settimana</h3>';

           echo "In questa settimana sono stati inseriti $nticket_tot_questasettimana_pv tickets in provincia di $provincia <br><br>";

           echo '<div id="chart-container-pv-questasettimana">
                 <canvas id="mycanvas_pv_questasettimana"></canvas>
                 <script type="text/javascript" src="../stats/pv_questasettimana.js"></script>
                 </div>';

               }
             }?>
         </p>
        <div style="text-align:center"><button class="btn btn-light btn-lg" type="submit" style="background-color:#5547f4;color:#eef4f7;">Mostra</button></div>
      </div>
      </div>
      <div class="form-row justify-content-center">
        <div class="col-sm-4 col-lg-3">
          <button onclick="location.href='choose_activity_agency.php'" type="button" class="btn btn-danger btn-block">Indietro</button>
        </div>
      </div>
      <br>
      <br>
    </div>
    <div style="text-align:center"></div>
    <script src="<?php __DIR__ ?>/../assets/js/jquery.min.js"></script>
    <script src="<?php __DIR__ ?>/../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php __DIR__ ?>/../assets/js/Contact-FormModal-Contact-Form-with-Google-Map.js"></script>
    <script src="<?php __DIR__ ?>/../assets/js/Sidebar-Menu.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php __DIR__ ?>/../stats/Chart.bundle.min.js"></script>
</form>
</body>
</html>
