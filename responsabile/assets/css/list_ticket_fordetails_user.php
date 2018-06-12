<?php
  // Include config file
  require_once 'config.php';

  // Initialize the session
  session_start();

  // If session variable is not set it will redirect to login page
  if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("location: login_user.php");
    exit;
  }

  if($_SERVER["REQUEST_METHOD"] == "POST"){

  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <title>Visualizza Segnalazioni</title>
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
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="intro">
            <h2 class="text-center">Visualizza le tue segnalazioni</h2>
          </div>
          <div class="container">
            <?php

              // preparazione della query che ricava gli id delle segnalazioni dell'utente
              $username = $_SESSION['username'];
              $sql = "SELECT id_ticket, data, gravita, stato FROM ticket WHERE segnalatore LIKE '$username'";
              $result = mysqli_query($link, $sql);
              $valori = mysqli_num_rows($result);

              // se la query produce righe, costruisco la tabella
              if ($valori>0) {

                // stampa la tabella
                echo "<div class=\"table-responsive\">";
                  echo "<table class=\"table table-hover \">";
                    echo "<thead>";
                      echo "<tr>";
                        echo "<th>ID ticket</th>";
                        echo "<th>Data</th>";
                        echo "<th>Gravità</th>";
                        echo "<th>Stato</th>";
                      echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                  while ($row = mysqli_fetch_assoc($result)) {

                    // stampa delle righe della tabella con i risultati della query
                    echo "<tr>";
                      echo "<td>".$row['id_ticket']."</td>";
                      echo "<td>".$row['data']."</td>";
                      echo "<td>".$row['gravita']."</td>";
                      echo "<td>".$row['stato']."</td>";
                      $stato = $row['stato'];
                      $id_ticket = $row['id_ticket'];

                      // se lo stato è 'In attesa di approvazione' rende possibile eliminazione e modifica
                      if ($stato == "In attesa di approvazione") {
                        echo "<td><button type=\"button\" class=\"btn btn-danger btn-sm\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\" onclick=\"prendi_id_da_cancellare(".$id_ticket.")\">Elimina ✖</button></td>";
                        echo "<td><button type=\"button\" class=\"btn btn-warning btn-sm\" onclick=\"location.href='edit_ticket_user.php?id=".$id_ticket."'\">Modifica ✏</button></td>";
                      } else {
                        echo "<td><button type=\"button\" class=\"btn btn-danger btn-sm\" data-toggle=\"modal\" data-target=\"#exampleModalCenter\" disabled>Elimina ✖</button></td>";
                        echo "<td><button type=\"button\" class=\"btn btn-warning btn-sm\" onclick=\"location.href='edit_ticket_user.php?id=".$id_ticket."'\" disabled>Modifica ✏</button></td>";
                      }

                      echo "<td><button type=\"button\" class=\"btn btn-primary btn-sm\" onclick=\"location.href='view_ticket_user.php?id=".$id_ticket."'\">Visualizza ➡</button></td>";
                    echo "</tr>";
                  }
                    echo "</tbody>";
                  echo "</table>";
                echo "</div>";
              } else {
                echo "
                  <p>Spiacenti ma non hai ancora segnalazioni.</p>

                ";
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
                <button class="btn btn-dark btn-block" type="button" onclick="location.href='choose_activity_user.html'">Indietro</button>
              </div>
            </div>
          </form>
          <script src="assets/js/jquery.min.js"></script>
          <script src="assets/bootstrap/js/bootstrap.min.js"></script>
          <script>
            function prendi_id_da_cancellare(id) {
              document.getElementById("modal-body").innerHTML = "Stai eliminando la segnalazione num "+ id +". Cosa vuoi fare?";
              var x = document.getElementById("elimina-definit");
              x.setAttribute("onclick", "cancella_id("+id+")");
            }

            function cancella_id(id){
              document.getElementById("elimina-definit").innerHTML = "hai cancellato l'id " +id;
            }
          </script>
          <script src="assets/js/Contact-FormModal-Contact-Form-with-Google-Map.js"></script>
          <script src="assets/js/Sidebar-Menu.js"></script>
          </div>
        </div>
      </div>
    </body>
  </html>
