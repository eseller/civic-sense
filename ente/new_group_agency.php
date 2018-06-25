<?php
// Include config file
require_once __DIR__.'/../config.php';

// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: ".home_url()."login_user.php");
  exit;
}

if(!isset($_SESSION['ente'])){
  echo "<br />";
  echo "<br />";
  echo "<center><h1>Non hai formulato una richiesta valida</h1></center>";
  echo "<br />";
  echo "<center><h3>Sarai reindirizzato alla homepage</h3></center>";
  header("refresh:3;url=".home_url());
  die();
}

// Username Ente
$username_agency = $_SESSION['username'];
// Selezione ultimo id immesso relativo ai gruppi
function maxidgruppo(){
  include __DIR__.'/../config.php';
  $sql = "SELECT MAX(id_gruppo_risoluzione) FROM gruppo_risoluzione";
  $result = mysqli_query($link, $sql);
  $row = mysqli_fetch_assoc($result);
  $id_gruppo_risoluzione = $row['MAX(id_gruppo_risoluzione)'];
  return $id_gruppo_risoluzione;
}
$id_gruppo_risoluzione=maxidgruppo()+1;
// Check Empty
if($_SERVER["REQUEST_METHOD"] == "POST"){
  if (empty(trim($_POST["dip1"])) &&
      empty(trim($_POST["dip2"])) &&
      empty(trim($_POST["dip3"])) &&
      empty(trim($_POST["dip4"])) &&
      empty(trim($_POST["dip5"])) &&
      empty(trim($_POST["dip6"]))){
    $at_least_err = 'Inserisci almeno un dipendente.';
  } else{
    // Funzione di controllo esistenza e disponibilità del dipendente
    function checkaddeddip($dipendente){
      include __DIR__.'/../config.php';
      $sqld = "SELECT username FROM dipendente WHERE username = '$dipendente'";
      if (mysqli_query($link,$sqld)){
        $result = mysqli_query($link,$sqld);
        $valori = mysqli_num_rows($result);
        if ($valori>0){
          $sqlavailable = "SELECT disponibilita FROM dipendente WHERE username = '$dipendente'";
          if (mysqli_query($link,$sqlavailable)){
            $resulta = mysqli_query($link,$sqlavailable);
            $row = mysqli_fetch_assoc($resulta);
            $dipabailable = $row['disponibilita'];
            if ($dipabailable == 1){
              return 1;
            } else{
              return 0;
            }
          } else{
            echo "Error: ".$sqlavailable."<br>".mysqli_error($link);
          }
        } else{
          return 2;
        }
      } else{
        echo "Error: ".$sqld."<br>".mysqli_error($link);
      }
    }
    // Controllo esistenza e disponibilità per dipendente 1
    if (!empty(trim($_POST["dip1"]))){
      $dipendente1 = $_POST["dip1"];
      $dip1ready = checkaddeddip($dipendente1);
      if ($dip1ready == 1){
        $dip1r = 1;
      } else{
        $dip1r = 0;
        if ($dip1ready == 2){
         $exist_err = 'Sono stati insertiti uno o più dipendenti non presenti sulla piattaforma.';
        }
        if ($dip1ready == 0){
          $available_err = 'Sono stati inseriti uno o più dipendenti non disponibili';
        }
      }
    } else{
      $dip1r = 1;
    }
    // Controllo esistenza e disponibilità per dipendente 2
    if (!empty(trim($_POST["dip2"]))){
      $dipendente2 = $_POST["dip2"];
      $dip2ready = checkaddeddip($dipendente2);
      if ($dip2ready == 1){
        $dip2r = 1;
      } else{
        $dip2r = 0;
        if ($dip2ready == 2){
         $exist_err = 'Sono stati insertiti uno o più dipendenti non presenti sulla piattaforma.';
        }
        if ($dip2ready == 0){
          $available_err = 'Sono stati inseriti uno o più dipendenti non disponibili';
        }
      }
    } else{
      $dip2r = 1;
    }
    // Controllo esistenza e disponibilità per dipendente 3
    if (!empty(trim($_POST["dip3"]))){
      $dipendente3 = $_POST["dip3"];
      $dip3ready = checkaddeddip($dipendente3);
      if ($dip3ready == 1){
        $dip3r = 1;
      } else{
        $dip3r = 0;
        if ($dip3ready == 2){
         $exist_err = 'Sono stati insertiti uno o più dipendenti non presenti sulla piattaforma.';
        }
        if ($dip3ready == 0){
          $available_err = 'Sono stati inseriti uno o più dipendenti non disponibili';
        }
      }
    } else{
      $dip3r = 1;
    }
    // Controllo esistenza e disponibilità per dipendente 4
    if (!empty(trim($_POST["dip4"]))){
      $dipendente4 = $_POST["dip4"];
      $dip4ready = checkaddeddip($dipendente4);
      if ($dip4ready == 1){
        $dip4r = 1;
      } else{
        $dip4r = 0;
        if ($dip4ready == 2){
         $exist_err = 'Sono stati insertiti uno o più dipendenti non presenti sulla piattaforma.';
        }
        if ($dip4ready == 0){
          $available_err = 'Sono stati inseriti uno o più dipendenti non disponibili';
        }
      }
    } else{
      $dip4r = 1;
    }
    // Controllo esistenza e disponibilità per dipendente 5
    if (!empty(trim($_POST["dip5"]))){
      $dipendente5 = $_POST["dip5"];
      $dip5ready = checkaddeddip($dipendente5);
      if ($dip5ready == 1){
        $dip5r = 1;
      } else{
        $dip5r = 0;
        if ($dip5ready == 2){
         $exist_err = 'Sono stati insertiti uno o più dipendenti non presenti sulla piattaforma.';
        }
        if ($dip5ready == 0){
          $available_err = 'Sono stati inseriti uno o più dipendenti non disponibili';
        }
      }
    } else{
      $dip5r = 1;
    }
    // Controllo esistenza e disponibilità per dipendente 6
    if (!empty(trim($_POST["dip6"]))){
      $dipendente6 = $_POST["dip6"];
      $dip6ready = checkaddeddip($dipendente6);
      if ($dip6ready == 1){
        $dip6r = 1;
      } else{
        $dip6r = 0;
        if ($dip6ready == 2){
         $exist_err = 'Sono stati insertiti uno o più dipendenti non presenti sulla piattaforma.';
        }
        if ($dip6ready == 0){
          $available_err = 'Sono stati inseriti uno o più dipendenti non disponibili';
        }
      }
    } else{
      $dip6r = 1;
    }
    // Controllo pre inserimento nel database
    if ($dip1r == 1 &&  $dip2r == 1 &&  $dip3r == 1 &&  
        $dip4r == 1 &&  $dip5r == 1 &&  $dip6r == 1){
      include __DIR__.'/../config.php';
      $id_gruppo_risoluzione = maxidgruppo()+1;
      // Creazione gruppo
      $sql="INSERT INTO gruppo_risoluzione (id_gruppo_risoluzione,username_ente)
      VALUES ('$id_gruppo_risoluzione','$username_agency')";
      if(mysqli_query($link,$sql)){
      } else{
        echo "Error: ".$sql."<br>".mysqli_error($link);
      }
      // Funzione di link fra gruppo e dipendenti e relativo update di disponibilità per dipendenti
      function insertdipendente($dip,$dipready){
        include __DIR__.'/../config.php';
        $id_gruppo_risoluzione = maxidgruppo();
        if ($dipready==1){
          $sql="INSERT INTO partecipazione (id_gruppo_risoluzione,username_dipendente)
          VALUES ('$id_gruppo_risoluzione','$dip')";
          // Aggiornameno disponibilità
          $sqlactive="UPDATE dipendente SET disponibilita=0 WHERE username='$dip'";
          if(mysqli_query($link,$sql)){
          } else{
            echo "Error: ".$sql."<br>".mysqli_error($link);
          }
          if(mysqli_query($link,$sqlactive)){
          } else{
            echo "Error: ".$sqlactive."<br>".mysqli_error($link);
          }
        }
      }
      // Inserimento dipendenti disponibili e controllati
      insertdipendente($dipendente1,$dip1ready);
      insertdipendente($dipendente2,$dip2ready);
      insertdipendente($dipendente3,$dip3ready);
      insertdipendente($dipendente4,$dip4ready);
      insertdipendente($dipendente5,$dip5ready);
      insertdipendente($dipendente6,$dip6ready);
      header("location: view_group_agency.php?id=".$id_gruppo_risoluzione);
    }
  }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuovo Gruppo</title>
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Article-List.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Contact-FormModal-Contact-Form-with-Google-Map.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/dh-row-text-image-right.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Features-Boxed.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Forum---Thread-listing.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Pretty-Registration-Form.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Login-Form-Dark.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Sidebar-Menu.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/styles.css">
  </head>
  <body>
    <div class="features-boxed">
      <div class="container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="form-row">
            <div class="col-sm-12 col-lg-11 mx-auto">
              <div class="form-group">
                <div class="intro">
                  <h2 class="text-center">Nuovo Gruppo di Risoluzione</h2>
                  <p class="text-center">Registra un nuovo gruppo di risoluzione</p>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row justify-content-center">
            <div class="form-group"><label>ID Gruppo Risoluzione</label>
              <input disabled="true" class="form-control" readonly="readonly" name="id_gruppo_risoluzione"
              placeholder="<?php echo $id_gruppo_risoluzione; ?>" type="text"></div>
          </div>
          <br>
          <br>
          <div class="form-row justify-content-center">
            <div class="form-row">
              <label><h5><b>Inserisci i partecipanti al gruppo</b></h5></label>
            </div>
          </div>
          <div class="form-row justify-content-center">
            <span style="color:red" class="help-block"><?php echo $at_least_err ?></span>
          </div>
          <div class="form-row justify-content-center">
            <span style="color:red" class="help-block"><?php echo $exist_err ?></span>
          </div>
          <div class="form-row justify-content-center">
            <span style="color:red" class="help-block"><?php echo $available_err ?></span>
          </div>
          <br>
          <div class="form-row justify-content-center">
            <div class="col-sm-3">
              <div class="form-group"><label>Dipendente #1</label><input class="form-control"
              method="post" name="dip1" type="text">
            </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group"><label>Dipendente #2</label><input class="form-control"
              method="post" name="dip2" type="text"></div>
            </div>
            <div class="col-sm-3">
              <div class="form-group"><label>Dipendente #3</label><input class="form-control"
              method="post" name="dip3" type="text"></div>
            </div>
          </div>
          <div class="form-row justify-content-center">
            <div class="col-sm-3">
              <div class="form-group"><label>Dipendente #4</label><input class="form-control"
              method="post" name="dip4" type="text"></div>
            </div><div class="col-sm-3">
              <div class="form-group"><label>Dipendente #5</label><input class="form-control"
              method="post" name="dip5" type="text"></div>
            </div><div class="col-sm-3">
              <div class="form-group"><label>Dipendente #6</label><input class="form-control"
              method="post" name="dip6" type="text"></div>
            </div>
          </div>
          <br>
          <div class="form-row justify-content-center">
            <div class="col-sm-4 col-lg-3">
              <button class="btn btn-success btn-block" id="creagruppo" type="submit">Crea Gruppo</button>
            </div>
            <div class="col-sm-4 col-lg-3">
              <button onclick="location.href='choose_activity_agency.php'"
              type="button" class="btn btn-danger btn-block">Annulla</button>
            </div>
          </div>
          <br>
          <br>
        </form>
      </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/Contact-FormModal-Contact-Form-with-Google-Map.js"></script>
    <script src="assets/js/Sidebar-Menu.js"></script>
  </body>
</html>
