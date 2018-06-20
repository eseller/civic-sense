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

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $id_gruppo = $_POST['id_gruppo'];
  $sql = "UPDATE dipendente SET disponibilita = 1 WHERE username IN 
  (SELECT username_dipendente FROM partecipazione WHERE id_gruppo_risoluzione = $id_gruppo)";
  if (mysqli_query($link,$sql)){
  } else{
    echo "Error: " . $sql . "<br>" . mysqli_error($link);
  } 
  $sql1 = "UPDATE gruppo_risoluzione SET attivo = 0 WHERE id_gruppo_risoluzione=$id_gruppo";
  if (mysqli_query($link,$sql1)){
  } else{
    echo "Error: " . $sql . "<br>" . mysqli_error($link);
  }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <title>Visualizza Gruppi</title>
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
<body style = "background-color:#eef4f7">
    <div class="features-boxed">
      <div class="container">
          <div class="intro">
            <h2 class="text-center">Visualizza i Gruppi di Risoluzione</h2>
          </div>
          <div class="form-row justify-content-center">
            <b>Crea Nuovo Gruppo di Risoluzione
            <button class="btn btn-dark btn-block" type="button" onclick="location.href='new_group_agency.php'">Nuovo Gruppo</button></b>
          </div>
          <br><br>
          <div class="container">
            <?php
              // preparazione della query che ricava gli id delle segnalazioni dell'utente
              $username = $_SESSION['username'];
              $sql = "SELECT id_gruppo_risoluzione,attivo FROM gruppo_risoluzione WHERE username_ente LIKE '$username'";
              $result = mysqli_query($link, $sql);
              $valori = mysqli_num_rows($result);
              // se la query produce righe, costruisco la tabella
              if ($valori>0) {

                // stampa la tabella
                echo "<div class=\"table-responsive\">";
                  echo "<table class=\"table table-hover \">";
                    echo "<thead>";
                      echo "<tr>";
                        echo "<th>ID Gruppo</th>";
                        echo "<th>Attivo</th>";
                        echo "<th>Partecipanti</th>";
                      echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                  while ($row = mysqli_fetch_assoc($result)) {
                    $id_gruppo = $row['id_gruppo_risoluzione'];
                    $sqldip = "SELECT username_dipendente FROM partecipazione WHERE id_gruppo_risoluzione = $id_gruppo";
                    $employe = mysqli_query($link,$sqldip);
                    $row2 = mysqli_fetch_assoc($employe);
                    $rowm = mysqli_fetch_row($employe);
                    // stampa delle righe della tabella con i risultati della query
                    if ($row['attivo'] == 1){
                      $active = "Attivo";
                    } else {
                      $active = "Non Attivo";
                    }
                    echo "<tr>";
                      echo "<td>".$row['id_gruppo_risoluzione']."</td>";
                      echo "<td>".$active."</td>";
                      echo "<td>".$row2['username_dipendente']." ..."."</td>";
                      $id_gruppo = $row['id_gruppo_risoluzione'];
                      $attivo = $row['attivo'];
                      // se lo stato è 'In attesa di approvazione' rende possibile eliminazione e modifica
                      if ($attivo == 0){
                        echo "<td><button type=\"button\" class=\"btn btn-danger btn-sm\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\" disabled>Elimina ✖</button></td>";
                        echo "<td><button type=\"button\" class=\"btn btn-warning btn-sm\" disabled>Modifica ✏</button></td>";
                      } else{
                        echo "<td><button type=\"button\" class=\"btn btn-danger btn-sm\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\" onclick=\"prendi_id_da_cancellare(".$id_gruppo.")\">Elimina ✖</button></td>";
                        echo "<td><button type=\"button\" class=\"btn btn-warning btn-sm\" onclick=\"location.href='edit_group_agency.php?id=".$id_gruppo."'\">Modifica ✏</button></td>";
                      }
                      echo "<td><button type=\"button\" class=\"btn btn-primary btn-sm\" onclick=\"location.href='view_group_agency.php?id=".$id_gruppo."'\">Visualizza ➡</button></td>";
                    echo "</tr>";
                  }
                    echo "</tbody>";
                  echo "</table>";
                echo "</div>";
              } else {
                echo "
                  <p>Spiacenti ma non esistono enti da te creati.</p>

                ";
              }
            ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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
                  <input type="text" name="id_gruppo" id="id_gruppo" hidden value="">
                  <div class="modal-body" id="modal-body">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Chiudi</button>
                    <button type="submit" class="btn btn-danger" id="elimina-definit">Elimina definitivamente</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
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
              document.getElementById("modal-body").innerHTML = "Stai eliminando il gruppo "+ id +". Cosa vuoi fare?";
              //var x = document.getElementById("elimina-definit");
              var y = document.getElementById("id_gruppo");
              y.setAttribute("value", id);
              //x.setAttribute("onclick", "cancella_id('"+id+"')");
            }

            function cancella_id(id){
              invia_dati('https://civicsensesst.altervista.org/ente/list_group_fordetails_agency.php', {'id_gruppo_risoluzione': id}, 'post');
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
