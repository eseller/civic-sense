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
// Id gruppo
$id_gruppo_risoluzione = $_GET['id'];
// Select info gruppo
$sql = "SELECT * FROM partecipazione WHERE id_gruppo_risoluzione = $id_gruppo_risoluzione";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_assoc($result);
$dipendente = $row['username_dipendente'];
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gruppo di Risoluzione</title>
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
            <span style="color:red" class="help-block"><?php echo $exist_err ?></span>
            <span style="color:red" class="help-block"><?php echo $available_err ?></span>            
          </div>
          <br>
          <div class="form-row justify-content-center">
            <div class="col-sm-3">
              <div class="form-group"><label>Dipendente #1</label><input class="form-control"
              method="post" name="dip1" value="<?php echo $dipendente; ?>" type="text">
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
