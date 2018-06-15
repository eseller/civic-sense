<?php
// Include config file
require_once __DIR__.'/../config.php';

// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: https://civicsensesst.altervista.org/login_admin.php");
  exit;
}

$username_ente = $_GET['id'];

$sql = "SELECT * FROM ente WHERE username = '$username_ente'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);

$username_ente = $row['username'];
$oldusername_ente = $row['username'];
$nome = $row['nome'];
$tag = $row['tag'];
$oldtag = $row['tag'];
$citta = $row['citta'];
$provincia = $row['provincia'];
$responsabile_reale = $row['username_responsabile'];

  function utente_impostore($responsabile_reale){
    if($_SERVER["REQUEST_METHOD"] == "GET"){

      if ($responsabile_reale != $_SESSION['username']) {
        // Close connection
        mysqli_close($link);
        return true;
      }else {
        return false;
      }
    }
  }

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Civic Sense</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/Article-List.css">
    <link rel="stylesheet" href="assets/css/Contact-FormModal-Contact-Form-with-Google-Map.css">
    <link rel="stylesheet" href="assets/css/dh-row-text-image-right.css">
    <link rel="stylesheet" href="assets/css/Features-Boxed.css">
    <link rel="stylesheet" href="assets/css/Forum---Thread-listing.css">
    <link rel="stylesheet" href="assets/css/Forum---Thread-listing1.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/Pretty-Registration-Form.css">
    <link rel="stylesheet" href="assets/css/Pretty-Registration-Form-1.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Dark.css">
    <link rel="stylesheet" href="assets/css/Sidebar-Menu.css">
    <link rel="stylesheet" href="assets/css/Sidebar-Menu1.css">
    <link rel="stylesheet" href="assets/css/styles.css">
  </head>
  <body>
    <div class="features-boxed">
      <div class="container">
          <!-- CONTROLLO SE L'UTENTE E' ABILITATO AD ACCEDERE ALLA PAGINA -->
          <?php
            if(utente_impostore($responsabile_reale)==true){
              echo "
                <h1>Non hai formulato una richiesta valida</h1>
                </div>
                <div class=\"form-row justify-content-center\">
                  <div class=\"col-sm-4 col-lg-6\">
                    <button class=\"btn btn-danger btn-block\" type=\"button\" onclick=\"javascript:history.go(-1)\">Torna alla pagina precedente</button>
                  </div>
                </div>";
              die();
            }
          ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="form-row">
            <div class="col-sm-12 col-lg-11 mx-auto">
              <div class="form-group">
                <div class="intro">
                  <h2 class="text-center">Visualizza Ente</h2>
                  <p class="text-center">Visualizza le informazioni dell'ente</p>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row justify-content">
            <label class="col-form-label">Nome</label><input class="form-control" name="nome" type="text" value="<?php echo $nome ?>" required readonly>
          </div>
          <div class="form-row justify-content-center">
            <div class="col-sm-6 col-lg-5">
              <div class="form-group"><label>Username</label><input class="form-control" name ="username_ente" type="text" value="<?php echo $username_ente ?>" required readonly></div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="form-group"><label>Tag</label><input class="form-control" type="text" name="tag" value="<?php echo $tag ?>" required readonly></div>
            </div>
          </div>
          <div class="form-row justify-content-center"><br>
            <div class="col-sm-3">
              <div class="form-group"><label>Città</label><input class="form-control"

                  type="text" name="citta" value="<?php echo $citta ?>" required readonly></div>
            </div>
            <div class="col-sm-3">
                <div class="dropdown">
                <div class="select-group">
                  <label>Provincia</label>
                  <input readonly  name="provincia" class="form-control" type="text" value="<?php echo $provincia; ?>">
                </div>
                </div>
            </div>
          </div>
          <br>
          
          <div class="form-row justify-content-center">
            <div class="col-sm-4 col-lg-3">
              <button onclick="location.href='list_agency_fordetails_admin.php'" type="button" class="btn btn-danger btn-block">Indietro</button>
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
