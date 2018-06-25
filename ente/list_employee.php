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

  if(!isset($_SESSION['ente'])){
  echo "<br />";
  echo "<br />";
  echo "<center><h1>Non hai formulato una richiesta valida</h1></center>";
  echo "<br />";
  echo "<center><h3>Sarai reindirizzato alla homepage</h3></center>";
  header("refresh:3;url=".home_url());
  die();
  }

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username_dipendente = $_POST['username_dipendente'];
    $sql = "DELETE FROM dipendente WHERE username = '$username_dipendente'";
        if (mysqli_query($link, $sql)) {
          header("location: https://civicsensesst.altervista.org/ente/list_employee.php");
        }
      else {
        echo "Error: " . $sql . "<br>" . mysqli_error($link);
      }
    }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <title>Visualizza Enti</title>
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
<body style = "background-color:#eef4f7">
    <div class="features-boxed">
      <div class="container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="intro">
            <h2 class="text-center">Visualizza i dipendenti</h2>
          </div>
          <div class="container">
            <div class="form-row justify-content-center">
              <div class="col-sm-4 col-lg-5">
                <button class="btn btn-dark btn-block" type="button" onclick="location.href='new_employee_agency.php'">Nuovo dipendente</button>
                <br>
              </div>
            </div>
            <?php

              $username = $_SESSION['username'];
              $sql = "SELECT tag FROM ente WHERE username = '$username'";
              if (mysqli_query($link, $sql)) {
                $result = mysqli_query($link, $sql);
                $row = mysqli_fetch_assoc($result);
                $tag = $row['tag'];
                $sql = "SELECT username, disponibilita, nome, cognome, citta, provincia, mail FROM dipendente WHERE tag = '$tag'";
                if (mysqli_query($link, $sql)) {
                $result = mysqli_query($link, $sql);
                $valori = mysqli_num_rows($result);
                if ($valori>0) {

                  // stampa la tabella
                  echo "<div class=\"table-responsive\">";
                    echo "<table class=\"table table-hover \">";
                      echo "<thead>";
                        echo "<tr>";
                          echo "<th>Username dipendente</th>";
                          echo "<th>Disponibile</th>";
                          echo "<th>Nome</th>";
                          echo "<th>Cognome</th>";
                          echo "<th>Città</th>";
                          echo "<th>Provincia</th>";
                          echo "<th>Mail</th>";
                        echo "</tr>";
                      echo "</thead>";
                      echo "<tbody>";
                    while ($row = mysqli_fetch_assoc($result)) {
                      $username_dipendente = $row['username'];
                      $i=0;
                      if ($row['disponibilita'] == 1){
                        $active = "Disponibile";
                      } else {
                        $active = "Non disponibile";
                      }
                      // stampa delle righe della tabella con i risultati della query
                      echo "<tr>";
                        echo "<td>".$row['username']."</td>";
                        echo "<td>".$active."</td>";
                        echo "<td>".$row['nome']."</td>";
                        echo "<td>".$row['cognome']."</td>";
                        echo "<td>".$row['citta']."</td>";
                        echo "<td>".$row['provincia']."</td>";
                        echo "<td>".$row['mail']."</td>";
                        $username_dipendente = $row['username'];
                        $attivo = $row['disponibilita'];

                        if ($attivo == 0){
                          echo "<td><button type=\"button\" class=\"btn btn-danger btn-sm\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\" disabled>Elimina ✖</button></td>";
                        } else {
                        printf ('<td><button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModalCenter" onclick="prendi_id_da_cancellare(\'%s\')">Elimina ✖</button></td>', $username_dipendente);
                        }

                        // echo "<td><button type=\"button\" class=\"btn btn-primary btn-sm\" onclick=\"location.href='view_ticket_user.php?id=".$username_ente."'\">Visualizza ➡</button></td>";
                      echo "</tr>";
                    }
                      echo "</tbody>";
                    echo "</table>";
                  echo "</div>";
                } else {
                  echo "<p>Spiacenti ma non esistono dipendenti da te creati.</p>";
                }
                }
                  else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($link);
                  }
              }
                else {
                  echo "Error: " . $sql . "<br>" . mysqli_error($link);
                }
              
            ?>

            <!-- Modal di conferma eliminazione -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Vuoi davvero eliminare?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" id="modal-body">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Chiudi</button>
                    <button type="button" class="btn btn-danger" id="elimina-definit">Elimina definitivamente</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-row justify-content-center">
              <div class="col-sm-4 col-lg-5">
                <button class="btn btn-dark btn-block" type="button" onclick="location.href='choose_activity_agency.php'">Indietro</button>
              </div>
            </div>
            <br>
            <br>
          </form>
          <script src="<?php __DIR__ ?>/../assets/js/jquery.min.js"></script>
          <script src="<?php __DIR__ ?>/../assets/bootstrap/js/bootstrap.min.js"></script>
          <script>
            function prendi_id_da_cancellare(id) {
              document.getElementById("modal-body").innerHTML = "Stai eliminando il dipendente "+ id +". Cosa vuoi fare?";
              var x = document.getElementById("elimina-definit");
              x.setAttribute("onclick", "cancella_id('"+id+"')");
            }

            function cancella_id(id){
              invia_dati('https://civicsensesst.altervista.org/ente/list_employee.php', {'username_dipendente': id}, 'post');
            }

            function invia_dati(servURL, params, method) {
              method = method || "post"; // il metodo POST è usato di default
              var form = document.createElement("form");
              form.setAttribute("method", method);
              form.setAttribute("action", servURL);
              for(var key in params) {
                  var hiddenField = document.createElement("input");
                  hiddenField.setAttribute("type", "hidden");
                  hiddenField.setAttribute("name", key);
                  hiddenField.setAttribute("value", params[key]);
                  form.appendChild(hiddenField);
              }
              document.body.appendChild(form);
              form.submit();
            }
          </script>
          <script src="<?php __DIR__ ?>/../assets/js/Contact-FormModal-Contact-Form-with-Google-Map.js"></script>
          <script src="<?php __DIR__ ?>/../assets/js/Sidebar-Menu.js"></script>
          </div>
        </div>
      </div>
    </body>
  </html>
