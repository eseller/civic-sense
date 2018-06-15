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
// Username Ente
$username_ente = $_SESSION['username'];
// Selezione ultimo id immesso relativo ai gruppi
$sql = "SELECT MAX(id_gruppo_risoluzione) FROM gruppo_risoluzione";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);
$id_gruppo_risoluzione = $row['MAX(id_gruppo_risoluzione)'];
$id_gruppo_risoluzione++;

$sqldip1="INSERT INTO partecipazione (id_gruppo_risoluzione,username_dipendente) 
VALUES ('$id_gruppo_risoluzione','$dipendente1')";

if($_SERVER["REQUEST_METHOD"] == "POST"){
  if (empty(trim($_POST["dip1"])) &&
      empty(trim($_POST["dip2"])) &&
      empty(trim($_POST["dip3"])) &&
      empty(trim($_POST["dip4"])) &&
      empty(trim($_POST["dip5"])) &&
      empty(trim($_POST["dip6"]))){
    $at_least_err = 'Inserisci almeno un dipendente.';
  }
  // Insert del gruppo risoluzione
  $sql="INSERT INTO gruppo_risoluzione (id_gruppo_risoluzione,username_ente)
  VALUES ('$id_gruppo_risoluzione','$username_ente')";
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
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Forum---Thread-listing1.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Pretty-Registration-Form.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Pretty-Registration-Form-1.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Login-Form-Dark.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Sidebar-Menu.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Sidebar-Menu1.css">
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
                  <h2 class="text-center">Nuovo Gruppo</h2>
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
              <button onclick="location.href='choose_activity_ente.php'" 
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
