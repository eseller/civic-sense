<?php
// Include config file
require_once __DIR__.'/../config.php';

// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login_admin.php");
  exit;
}

$username = $_SESSION['username'];
$username_ente = $nome = $tag = $citta = $provincia = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
  $nome = trim($_POST['nome']);
  $username_ente = trim($_POST['username_ente']);
  $tag = trim($_POST["tag"]);
  $citta = trim($_POST["citta"]);
  $provincia = trim($_POST['provincia']);

    $sql = "INSERT IGNORE INTO tag (nome) VALUES ('$tag')";
      if (mysqli_query($link, $sql)) {    
        $sql = "INSERT INTO ente
        (username, nome, provincia, citta, tag, username_responsabile)
        VALUES
        ('$username_ente', '$nome', $provincia','$citta','$tag','$username')";
        if (mysqli_query($link, $sql)) {
          header("location: view_agency_admin.php?id=".$username_ente);
        } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($link);
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
        <form>
          <div class="form-row">
            <div class="col-sm-12 col-lg-11 mx-auto">
              <div class="form-group">
                <div class="intro">
                  <h2 class="text-center">Nuovo Ente</h2>
                  <p class="text-center">Crea un nuovo ente</p>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row justify-content">
            <label class="col-form-label">Nome</label><input class="form-control" name="nome" type="text" required>
          </div>
          <div class="form-row justify-content-center">
            <div class="col-sm-6 col-lg-5">
              <div class="form-group"><label>Username</label><input class="form-control" name ="username_ente" type="text"></div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="form-group"><label>Tag</label><input class="form-control" type="text" name="tag" required></div>
            </div>
<!--               <div class="select-group"><label>Tag</label>
                <div class="dropdown">
                  <select class="custom-select" name="tag" required>
                    <option value="">Tag</option>
                    <?php
                        $sql = "SELECT nome FROM tag";
                        $result = mysqli_query($link, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                          echo "<option value=\"" .($row['nome']). "\"";
                          if($tag==$row['nome']) echo ' selected="selected" ';
                          echo ">".$row['nome']."</option>";
                        }
                    ?>
                  </select>
                </div>
              </div> -->
          </div>
          <div class="form-row justify-content-center"><br>
            <div class="col-sm-3">
              <div class="form-group"><label>Città</label><input class="form-control"

                  type="text" name="citta" required></div>
            </div>
            <div class="col-sm-3">
              <div class="form-group"><label>Provincia</label><input class="form-control"

                  type="text" nome="provincia" required></div>
            </div>
          </div>
          <br>
          <div class="form-row">
            <div class="col-sm-2">
              <div class="form-group"><label>Label</label><input class="form-control"

                  type="text"></div>
            </div>
            <div class="col-sm-2">
              <div class="form-group"><label>Label</label><input class="form-control"

                  type="text"></div>
            </div>
            <div class="col-sm-2">
              <div class="form-group"><label>Label</label><input class="form-control"

                  type="text"></div>
            </div>
            <div class="col-sm-2">
              <div class="form-group"><label>Label</label><input class="form-control"

                  type="text"></div>
            </div>
            <div class="col-sm-2">
              <div class="form-group"><label>Label</label><input class="form-control"

                  type="text"></div>
            </div>
            <div class="col-sm-2">
              <div class="form-group"><label>Label</label><input class="form-control"

                  type="text"></div>
            </div>
          </div>
          <button class="btn btn-success btn-block" type="submit">Crea
            ente</button><button class="btn btn-danger btn-block" type="submit">Annulla</button>
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
