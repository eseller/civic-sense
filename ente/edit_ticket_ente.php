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

  $id_ticket = $_GET['id'];

  $sql = "SELECT * FROM ticket WHERE id_ticket=58";
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

  // function utente_impostore($segnalatore_reale_prova){
  //   $sql1 = "SELECT username FROM ente";
  //   $result1 = mysqli_query($link, $sql1);
  //   $row1 = mysqli_fetch_assoc($result1);
  //
  //   foreach ($variable as $row1) {
  //     if($variabile['username']==$_SESSION['username']){
  //       $trovato = 1;
  //     }
  //   }
  //   if($trovato==1){
  //     return false;
  //   } else {
  //     mysqli_close($link);
  //     return true;
  //   }
  // }

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

    header("location: list_ticket_fordetails_ente.php");
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Ticket</title>
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
    <div class="form-row justify-content-center">
      <!-- <?php
        // if(utente_impostore($segnalatore_reale)==true){
        //   echo "<h1>Accesso vietato</h1>
        //   <h5>Non sembra che abbia le autorizzazioni per accedere a questa pagina</h5>
        //   <h4>Sarai reindirizzato alla pagina di login</h4>";
        //   die();
        // }
      ?> -->
    </div>
    <div class="features-boxed">
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="container">
            <!-- contentitore titolo, sottotitolo e descrizione -->
            <div class="form-row">
              <div class="col-sm-12 col-lg-11 mx-auto">
                <div class="form-group">
                  <div class="intro">
                    <h2 class="text-center">Modifica Ticket</h2>
                    <p class="text-center">Modifica una segnalazione per disservizio</p>
                  </div>
                </div>
                <label class="col-form-label">Descrizione <font color="red">*</font></label>
                <textarea class="form-control" maxlength="400" name="descrizione" id="descrizione" type="text" rows="4" onload="count(this, 400, 'descrizione')" onkeyup="count(this, 400, 'descrizione')"><?php echo $descrizione; ?></textarea>
              </div>
            </div>

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
                <div class="select-group">
                  <label>Tag <font color="red">*</font></label>
                    <div class="dropdown">
                      <select class="custom-select" name="tag" readonly>
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
                <div class="select-group">
                  <label>Gravità <font color="red">*</font></label>
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
                <div class="select-group">
                  <label>Città</label>
                  <input  name="citta"  maxlength="45" class="form-control" type="text" value="<?php echo $citta ?>"></div>
              </div>

              <!-- colonna della provincia -->
              <div class="col-sm-3 col-lg-2">
                <div class="dropdown">
                  <div class="select-group"><label>Provincia <font color="red">*</font></label>
                    <select class="custom-select" name="provincia" readonly>
                      <option value=""><?php echo $provincia;?></option>
                        <?php
                          $filepath = "http://www.mandile.it/wp-content/uploads/province-sigle.csv";
                          $array_csv = csvToArray($filepath);

                          foreach($array_csv as $numero_riga => $valori){
                           $valore_prima_colonna = $valori[0];
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
                <div class="form-group">
                  <label>Latitudine</label>
                  <input disabled="true" class="form-control" readonly="readonly" type="text" id="latitudine" placeholder="<?php echo $latitude ?>"></div>
              </div>

              <!-- colonna longitudine -->
              <div class="col-sm-4 col-lg-2">
                <div class="form-group">
                  <label>Longitudine</label>
                  <input disabled="true" class="form-control" readonly="readonly" type="text" id="longitudine" placeholder="<?php echo $longitude ?>"></div>
              </div>
            </div>

            <!-- contenitore per id_ticket e data -->
            <div class="form-row justify-content-center">
              <div class="col-sm-4 col-lg-2">
                <div class="form-group">
                  <label>ID Ticket</label>
                  <input name="id_ticket" class="form-control" readonly type="text" value="<?php echo $id_ticket; ?>"></div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label>Data</label>
                  <input readonly class="form-control" placeholder="<?php echo $data ?>" readonly></div>
              </div>
            </div>
            <br>

            <div class="form-row justify-content-center">

            </div>

            <div class="form-row justify-content-center">
              <div class="col-sm-4 col-lg-3">
                <button class="btn btn-success btn-block" type="submit">Modifica ticket</button>
              </div>
              <div class="col-sm-4 col-lg-3">
                <button class="btn btn-danger btn-block" type="button" onclick="location.href='list_ticket_fordetails_ente.php'">Annulla</button>
              </div>
            </div>
            <br>
            <br>
        </div>
      </form>
    </div>
    <script src="<?php __DIR__ ?>/../assets/js/jquery.min.js"></script>
    <script src="<?php __DIR__ ?>/../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php __DIR__ ?>/../assets/js/Contact-FormModal-Contact-Form-with-Google-Map.js"></script>
    <script src="<?php __DIR__ ?>/../assets/js/Sidebar-Menu.js"></script>
    <script>
      function count(field,maxlength,id){
        var totalLength = field.value.length;
        document.getElementById("caratteri_desc_rimanenti").innerHTML = maxlength-totalLength + " caratteri rimanenti";
      }
    </script>
  </body>
</html>
