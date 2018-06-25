<?php
// Include config file
require_once __DIR__.'/../config.php';

// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: https://civicsensesst.altervista.org/login_user.php");
  exit;
}

$username = $_SESSION['username'];
$username_dipendente = $tag = $citta = $provincia = $disponibilita = $nome = $cognome = $dipendente_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

$sql = "SELECT tag FROM ente WHERE username = '$username'";
  if (mysqli_query($link, $sql)) {
      $result = mysqli_query($link, $sql);
      $row = mysqli_fetch_assoc($result);
      $tag = $row['tag'];
    
  }else {
          echo "Error: " . $sql . "<br>" . mysqli_error($link);
            }  
  $disponibilita = 1;
  $username_dipendente = trim($_POST['username_dipendente']);
  $nome = trim($_POST['nome']);
  $cognome = trim($_POST['cognome']);
  $citta = trim($_POST["citta"]);
  $provincia = trim($_POST['provincia']);

  $sql = "SELECT username FROM dipendente WHERE username = '$username_dipendente'";
  if (mysqli_query($link, $sql)) {
              $result = mysqli_query($link, $sql);
              $valori = mysqli_num_rows($result);
              if ($valori == 0) {
                // Il dipendente non esiste, quindi può generarlo
                $sql = "INSERT INTO dipendente (username, tag, disponibilita, citta, provincia, nome, cognome) VALUES ('$username_dipendente', '$tag', '$disponibilita', '$citta', '$provincia', '$nome', '$cognome')";
                  if (mysqli_query($link, $sql)) {  
                        header("location: list_employee.php");
                      } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($link);
                  } 
              } else {
                $dipendente_err = "Questo dipendente esiste già.";
              }
            } else {
                  echo "Error: " . $sql . "<br>" . mysqli_error($link);
                }

  mysqli_close($link);

}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
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
                  <h2 class="text-center">Nuovo Dipendente</h2>
                  <p class="text-center">Crea un nuovo dipendente</p>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row justify-content">
            <label class="col-form-label">Username</label><input class="form-control" name="username_dipendente" type="text" required>
            <span class="help-block"><?php echo $dipendente_err; ?></span>
          </div>
          <div class="form-row justify-content-center">
            <div class="col-sm-6 col-lg-5">
              <div class="form-group"><label>Nome</label><input class="form-control" name ="nome" type="text" required></div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="form-group"><label>Cognome</label><input class="form-control" type="text" name="cognome" required></div>
            </div>
          </div>
          <div class="form-row justify-content-center"><br>
            <div class="col-sm-3">
              <div class="form-group"><label>Città</label><input class="form-control"

                  type="text" name="citta" required></div>
            </div>
            <div class="col-sm-3">
              <div class="form-group"><label>Provincia</label>
                <select class="custom-select" name="provincia" required>
                  <option value=""><?php echo "";?></option>
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
               <span style="color:#FF2D00" class="help-block"><?php echo $provincia_err;?></span>
            </div>
            </div>
          </div>
          <br>
          
          <div class="form-row justify-content-center">
            <div class="col-sm-4 col-lg-3">
              <button class="btn btn-success btn-block" id="creaticket" type="submit">Crea dipendente</button>
            </div>
            <div class="col-sm-4 col-lg-3">
              <button onclick="location.href='choose_activity_agency.php'" type="button" class="btn btn-danger btn-block">Annulla</button>
            </div>
          </div>
          <br>
          <br>
        </form>
      </div>
    </div>
    <script src="<?php __DIR__ ?>/../assets/js/jquery.min.js"></script>
    <script src="<?php __DIR__ ?>/../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php __DIR__ ?>/../assets/js/Contact-FormModal-Contact-Form-with-Google-Map.js"></script>
    <script src="<?php __DIR__ ?>/../assets/js/Sidebar-Menu.js"></script>
  </body>
</html>
