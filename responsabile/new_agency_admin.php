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

$username = $_SESSION['username'];
$username_ente = $nome = $tag = $citta = $provincia = $ente_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
  $nome = trim($_POST['nome']);
  $username_ente = trim($_POST['username_ente']);
  $tag = trim($_POST["tag"]);
  $citta = trim($_POST["citta"]);
  $provincia = trim($_POST['provincia']);

  $sql = "SELECT nome FROM tag WHERE nome = '$tag'";
  if (mysqli_query($link, $sql)) {
              $result = mysqli_query($link, $sql);
              $valori = mysqli_num_rows($result);
              if ($valori == 0) {
                // Il tag non esiste, quindi può generare l'ente e il tag
                $sql = "INSERT IGNORE INTO tag (nome) VALUES ('$tag')";
                  if (mysqli_query($link, $sql)) {  
                    $sql = "INSERT INTO segnalatore (username) VALUES ('$username_ente')";
                      if (mysqli_query($link, $sql)) {    
                        $sql = "INSERT INTO ente
                        (username, nome, provincia, citta, tag, username_responsabile)
                        VALUES
                        ('$username_ente', '$nome', '$provincia','$citta','$tag','$username')";
                        if (mysqli_query($link, $sql)) {
                          header("location: view_agency_admin.php?id=".$username_ente);
                        } else {
                          echo "Error: " . $sql . "<br>" . mysqli_error($link);
                        }
                      } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($link);
                      }  
                      } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($link);
                  } 
              } else {
                // Controlla se esiste un ente con la stessa combinazione di tag e provincia
                $sql = "SELECT * FROM ente WHERE tag = '$tag' AND provincia = '$provincia'";
                if (mysqli_query($link, $sql)) {
                  $result = mysqli_query($link, $sql);
                  $valori = mysqli_num_rows($result);
                  if ($valori > 0) {
                    //Segnala che l'ente esiste già
                    $ente_err = "Impossibile creare l'ente. Esiste già un ente con la stessa combinazione di provincia e tag.";
                   }
                   else {
                    // Non esiste un ente con la stessa combinazione di tag e provincia, quindi genera l'ente
                    $sql = "INSERT IGNORE INTO tag (nome) VALUES ('$tag')";
                      if (mysqli_query($link, $sql)) {  
                        $sql = "INSERT INTO segnalatore (username) VALUES ('$username_ente')";
                          if (mysqli_query($link, $sql)) {    
                            $sql = "INSERT INTO ente
                            (username, nome, provincia, citta, tag, username_responsabile)
                            VALUES
                            ('$username_ente', '$nome', '$provincia','$citta','$tag','$username')";
                            if (mysqli_query($link, $sql)) {
                              header("location: view_agency_admin.php?id=".$username_ente);
                            } else {
                              echo "Error: " . $sql . "<br>" . mysqli_error($link);
                            }
                          } else {
                            echo "Error: " . $sql . "<br>" . mysqli_error($link);
                          }  
                          } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($link);
                      } 
                  }

                } else {
                  echo "Error: " . $sql . "<br>" . mysqli_error($link);
                }
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
              <div class="form-group"><label>Username</label><input class="form-control" name ="username_ente" type="text" required></div>
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
            <span class="help-block"><?php echo $ente_err; ?></span>
            </div>
          </div>
          <br>
          
          <div class="form-row justify-content-center">
            <div class="col-sm-4 col-lg-3">
              <button class="btn btn-success btn-block" id="creaticket" type="submit">Crea ente</button>
            </div>
            <div class="col-sm-4 col-lg-3">
              <button onclick="location.href='choose_activity_admin.php'" type="button" class="btn btn-danger btn-block">Annulla</button>
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
