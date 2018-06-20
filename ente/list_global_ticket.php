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

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id_ticket = $_POST['id_ticket'];
    $sql = "DELETE FROM ticket WHERE id_ticket = $id_ticket";
    $result = mysqli_query($link, $sql);

    // header("location: list_ticket_fordetails_user.php");
  }

  $username = $_SESSION['username'];

  $sql = "SELECT provincia, tag FROM ente WHERE username LIKE '$username'";

  $result = mysqli_query($link, $sql);
  $row = mysqli_fetch_assoc($result);
  $provincia = $row['provincia'];
  $tag = $row['tag'];

?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <title>Visualizza Segnalazioni da risolvere</title>
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
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="intro">
            <h2 class="text-center">Visualizza le segnalazioni dei cittadini da dover risolvere</h2>
          </div>
            <?php
              // preparazione della query che ricava gli id delle segnalazioni dell'utente
              $username = $_SESSION['username'];
              $sql = "SELECT id_ticket, data, gravita, stato, id_gruppo_risoluzione FROM ticket WHERE provincia LIKE '$provincia' AND tag LIKE '$tag'";
              $result = mysqli_query($link, $sql);
              $valori = mysqli_num_rows($result);


              // se la query produce righe, costruisco la tabella
              if ($valori>0) {
                // stampa la tabella
                echo "<div class=\"table-responsive\">";
                  echo "<table class=\"table table-hover \">";
                    echo "<thead>";
                      echo "<tr>";
                        echo "<th>ID</th>";
                        echo "<th>Data</th>";
                        echo "<th>Gravità</th>";
                        echo "<th>Stato</th>";
                        echo "<th>Gruppo Risol.</th>";
                      echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                  while ($row = mysqli_fetch_assoc($result)) {
                    // stampa delle righe della tabella con i risultati della query
                    if ($row['stato']=="Invalidato") {
                      echo "<tr>";
                    }elseif($row['gravita']=="Alta"){
                      echo "<tr class=\"table-danger\">";
                    }elseif ($row['gravita']=="Media") {
                      echo "<tr class=\"table-warning\">";
                    }elseif ($row['gravita']=="Bassa") {
                      echo "<tr class=\"table-success\">";
                    }
                      echo "<td>".$row['id_ticket']."</td>";
                      echo "<td>".$row['data']."</td>";
                      echo "<td>".$row['gravita']."</td>";
                      echo "<td>".$row['stato']."</td>";
                      echo "<td>".$row['id_gruppo_risoluzione']."</td>";
                      $stato = trim($row['stato']);
                      $id_ticket = $row['id_ticket'];

                      if ($stato!= "Invalidato") {
                        echo "<td><button type=\"button\" class=\"btn btn-warning btn-sm\" onclick=\"location.href='assign_team.php?id=".$id_ticket."'\">Modifica Gruppo/Visualizza ✏</button></td>";
                      }else {
                        echo "<td><button type=\"button\" class=\"btn btn-primary btn-sm\" onclick=\"location.href='view_ticket_agency.php?id=".$id_ticket."'\">Visualizza ➡</button></td>";
                      }
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
