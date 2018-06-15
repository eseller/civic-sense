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

  $id_ticket = $_GET['id'];

  $sql = "SELECT * FROM ticket WHERE id_ticket=$id_ticket";
  $result = mysqli_query($link, $sql);
  $row = mysqli_fetch_assoc($result);

  $descrizione= $row['descrizione'];
  $data = $row['data'];
  $latitude = $row['latitudine'];
  $longitude = $row['longitudine'];
  $provincia = $row['provincia'];
  $citta = $row['citta'];
  $indirizzo = $row['indirizzo'];
  $tag = $row['tag'];
  $gravita = $row['gravita'];
  $segnalatore_reale = $row['segnalatore'];

  function utente_impostore($segnalatore_reale){
    if($_SERVER["REQUEST_METHOD"] == "GET"){

      if ($segnalatore_reale != $_SESSION['username']) {
        // Close connection
        mysqli_close($link);
        return true;
      }else {
        return false;
      }
    }
  }

  if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Define variables and initialize with empty values
    $descrizione = $id_ticket = $tag = $provincia = $gravita = $id_ticket_err = $descrizione_err = $tag_err = $provincia_err = $gravita_err = "";

    $citta = trim($_POST['citta']);
    $indirizzo = trim($_POST['indirizzo']);

    if(empty(trim($_POST['id_ticket']))){
        $id_ticket_err= 'Inserire l\' id.';
    } else{
        $id_ticket = trim($_POST['id_ticket']);
    }

    // Check if username is empty
    if(empty(trim($_POST['tag']))){
        $tag_err = 'Inserire un tag.';
    } else{
        $tag = trim($_POST['tag']);
    }

    // Check if password is empty
    if(empty(trim($_POST['provincia']))){
        $provincia_err = 'Inserire la provincia.';
    } else{
        $provincia = trim($_POST['provincia']);
    }

    // Check if password is empty
    if(empty(trim($_POST['gravita']))){
        $gravita_err = 'Inserire la gravita.';
    } else{
        $gravita = trim($_POST['gravita']);
    }

    if(empty(trim($_POST['descrizione']))){
        $gravita_err = 'Inserire la descrizione.';
    } else{
        $descrizione = trim($_POST['descrizione']);
    }

    if(empty($provincia_err) && empty($provincia_err) && empty($gravita_err) && empty($gravita_err) && empty($id_ticket_err)){
      $sql = "UPDATE ticket SET descrizione='$descrizione', gravita='$gravita', provincia='$provincia', tag='$tag', citta='$citta', indirizzo='$indirizzo' WHERE id_ticket = $id_ticket";
      $result = mysqli_query($link, $sql);
    }

    header("location: list_ticket_fordetails_user.php");
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Ticket</title>
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
<body style = "background-color:#eef4f7">
    <div class="features-boxed">
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="container">

          <!-- CONTROLLO SE L'UTENTE E' ABILITATO AD ACCEDERE ALLA PAGINA -->
          <!-- <?php
            // if(utente_impostore($segnalatore_reale)==true){
            //   echo "
            //     <h1>Non hai formulato una richiesta valida</h1>
            //     </div>
            //     <div class=\"form-row justify-content-center\">
            //       <div class=\"col-sm-4 col-lg-6\">
            //         <button class=\"btn btn-danger btn-block\" type=\"button\" onclick=\"javascript:history.go(-1)\">Torna alla pagina precedente</button>
            //       </div>
            //     </div>";
            //   die();
            // }
          ?> -->
            <!-- contentitore titolo, sottotitolo e descrizione -->
            <div class="form-row">
              <div class="col-sm-12 col-lg-11 mx-auto">
                <div class="form-group">
                  <div class="intro">
                    <h2 class="text-center">Modifica Ticket</h2>
                    <p class="text-center">Modifica una segnalazione per disservizio</p>
                  </div>
                </div>
                <label class="col-form-label">Descrizione <font color="red">*</font></label> <font id="caratteri_desc_rimanenti" color="red"></font>
                <textarea class="form-control" maxlength="400" name="descrizione" id="descrizione" type="text" rows="4" onload="count(this, 400, 'descrizione')" onkeyup="count(this, 400, 'descrizione')" required><?php echo $descrizione; ?></textarea>
              </div>
            </div>
          <!-- </div> -->

            <!-- contenitore per indirizzo, tag e gravità -->
            <div class="form-row justify-content-center">

              <!-- colonna indirizzo -->
              <div class="col-sm-12 col-lg-6">
                <div class="form-group">
                  <label>Indirizzo</label>
                  <input name="indirizzo" maxlength="45" class="form-control" type="text" value="<?php echo $indirizzo; ?>"></div>
              </div>

              <!-- colonna tag -->
              <div class="col-sm-6 col-lg-2">
                <div class="select-group"><label>Tag <font color="red">*</font></label>
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
                </div>
              </div>

              <!-- colonna gravità -->
              <div class="col-sm-6 col-lg-2">
                <div class="select-group"><label>Gravità <font color="red">*</font></label>
                  <div class="dropdown">
                    <select class="custom-select" name="gravita" required>
                      <option value="">Gravità</option>
                      <option value="Bassa"  <?php if($gravita=="Bassa") echo 'selected="selected"'; ?>>Bassa</option>
                      <option value="Media"  <?php if($gravita=="Media") echo 'selected="selected"'; ?>>Media</option>
                      <option value="Alta"  <?php if($gravita=="Alta") echo 'selected="selected"'; ?>>Alta</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

            <!-- contenitore per città, provincia, latitudine, longitudine -->
            <div class="form-row justify-content-center">

              <!-- colonna città -->
              <div class="col-sm-3">
                <div class="select-group"><label>Città</label>
                  <input  name="citta"  maxlength="45" class="form-control" type="text" value="<?php echo $citta ?>"></div>
              </div>

              <!-- colonna della provincia -->
              <div class="col-sm-3 col-lg-2">
                <div class="dropdown">
                  <div class="select-group"><label>Provincia <font color="red">*</font></label>
                    <select class="custom-select" name="provincia" required>
                      <option value=""><?php echo $provincia;?></option>
                        <?php
                          $filepath = "http://www.mandile.it/wp-content/uploads/province-sigle.csv";
                          $array_csv = csvToArray($filepath);

                          foreach($array_csv as $numero_riga => $valori){
                           $valore_seconda_colonna = $valori[1];

                           echo "<option value=\"".$valore_seconda_colonna."\"";
                           if($provincia==$valore_seconda_colonna) echo ' selected="selected" ';
                           echo ">".$valore_seconda_colonna."</option>";
                          }
                        ?>
                    </select>
                  </div>
                </div>
              </div>

              <!-- colonna latitudine -->
              <div class="col-sm-4 col-lg-2">
                <div class="form-group"><label>Latitudine</label>
                  <input disabled="true" class="form-control" readonly="readonly" type="text" id="latitudine" placeholder="<?php echo $latitude ?>"></div>
              </div>

              <!-- colonna longitudine -->
              <div class="col-sm-4 col-lg-2">
                <div class="form-group"><label>Longitudine</label><input disabled="true" class="form-control" readonly="readonly" type="text" id="longitudine" placeholder="<?php echo $longitude ?>"></div>
              </div>
            </div>

            <!-- contenitore per id_ticket e data -->
            <div class="form-row justify-content-center">
              <div class="col-sm-4 col-lg-2">
                <div class="form-group"><label>ID Ticket</label>
                  <input name="id_ticket" class="form-control" readonly type="text" value="<?php echo $id_ticket; ?>"></div>
              </div>
              <div class="col-sm-3">
                <div class="form-group"><label>Data</label><input disabled="true" class="form-control" placeholder="<?php echo $data ?>" readonly></div>
              </div>
            </div>
            <br>

            <div class="form-row justify-content-center">
              <div class="col-sm-4 col-lg-3">
                <button class="btn btn-success btn-block" type="submit">Modifica ticket</button>
              </div>
              <div class="col-sm-4 col-lg-3">
                <button class="btn btn-danger btn-block" type="button" onclick="location.href='list_ticket_fordetails_user.php'">Annulla</button>
              </div>
            </div>
            <br>
            <br>
        </div>
      </form>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/Contact-FormModal-Contact-Form-with-Google-Map.js"></script>
    <script src="assets/js/Sidebar-Menu.js"></script>
    <script>
      var x = document.getElementById("latitudine");
      var y = document.getElementById("longitudine");
      var z = document.getElementById("ottienigeolocalizzazione");
      var zz = document.getElementById("scrittainterna");

      function getLocation() {
          if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(showPosition);
          } else {
              zz.innerHTML = "Geolocalizzazione non supportata";
          }
      }

      function showPosition(position) {
          x.placeholder = position.coords.latitude;
          y.placeholder = position.coords.longitude;
          zz.innerHTML = "Localizzazione registrata";
          z.disabled = true;
      }

      function count(field,maxlength,id){
        var totalLength = field.value.length;
        // if(totalLength >= maxlength) {
        //   field.value = field.value.substring(0, maxlength);
        //   alert("Hai raggiunto il limite massimo di caratteri inseribili.");
        // }
        document.getElementById("caratteri_desc_rimanenti").innerHTML = maxlength-totalLength + " caratteri rimanenti";
      }
    </script>
  </body>
</html>
