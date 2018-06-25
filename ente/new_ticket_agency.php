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

  if(!isset($_SESSION['ente'])){
    echo "<br />";
    echo "<br />";
    echo "<center><h1>Non hai formulato una richiesta valida</h1></center>";
    echo "<br />";
    echo "<center><h3>Sarai reindirizzato alla homepage</h3></center>";
    header("refresh:3;url=".home_url());
    die();
  }

  $username_reale = $_SESSION['username'];
  $descrizione = $indirizzo = $tag = $gravitabox = $data = $citta = $provincia = $latitudine = $longitudine = "";
  $descrizione_err = $latitudine_err = "";

  $sqlente = "SELECT tag FROM ente WHERE username LIKE '$username_reale'";
  $resultente = mysqli_query($link,$sqlente);
  $row = mysqli_fetch_assoc($resultente);
  $tagente = $row['tag'];

  // ID Ticket
  $sql = "SELECT MAX(id_ticket) FROM ticket";
  $result = mysqli_query($link, $sql);
  $row = mysqli_fetch_assoc($result);
  $id_ticket = $row['MAX(id_ticket)'];


  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id_ticket++;
    // Check if descrizione is empty
    if(empty(trim($_POST["descrizione"]))){
        $descrizione_err = 'Inserire una descrizione.';
    } else{
        $descrizione = trim($_POST["descrizione"]);
    }
    $indirizzo = trim($_POST['indirizzo']);
    $gravitabox = trim($_POST["gravitabox"]);
    $data = date('Y-m-d');
    $citta = trim($_POST["citta"]);
    $provincia = trim($_POST['provincia']);
    $latitudine = floatval($_POST['latitudine']);
    $longitudine = floatval($_POST['longitudine']);
      $sql = "INSERT INTO ticket
      (descrizione,provincia,data,latitudine,longitudine,citta,
      indirizzo,tag,gravita,segnalatore,stato)
      VALUES
      ('$descrizione','$provincia','$data','$latitudine','$longitudine','$citta','$indirizzo','$tagente','$gravitabox',
      '$username_reale','In attesa di approvazione')";
      if (mysqli_query($link, $sql)) {
      header("location: view_ticket_agency.php?id=".$id_ticket);
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($link);
    }
    mysqli_close($link);
  }

  function utente_impostore($segnalatore_reale_prova){
    $sql1 = "SELECT username FROM ente";
    $result1 = mysqli_query($link, $sql1);
    $row1 = mysqli_fetch_assoc($result1);

    foreach ($variable as $row1) {
      if($variabile['username']==$_SESSION['username']){

        $sql2 = "SELECT tag FROM ente WHERE username = $username";
        $result2 = mysqli_query($link, $sql1);
        $row2 = mysqli_fetch_assoc($result1);
        return false;
      }

      $sql2 = "SELECT tag FROM ente WHERE username = $username";
      $result2 = mysqli_query($link, $sql1);
      $row2 = mysqli_fetch_assoc($result1);
      return true;
    }
    // if($trovato==1){
    //   $sql2 = "SELECT tag FROM ente WHERE username = $username";
    //   $result2 = mysqli_query($link, $sql1);
    //   $row2 = mysqli_fetch_assoc($result1);
    //   return false;
    // } else {
    //
    //     $sql2 = "SELECT tag FROM ente WHERE username = $username";
    //     $result2 = mysqli_query($link, $sql1);
    //     $row2 = mysqli_fetch_assoc($result1);
    //     return false;
    // }
  }


?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuovo Ticket</title>
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
  <body onload="showdate()" style = "background-color:#eef4f7">
    <div class="features-boxed">
      <div class="container">
        <?php
          if(utente_impostore($username_reale)==true){
            echo "<h1>Accesso vietato</h1>
            <h5>Non sembra che abbia le autorizzazioni per accedere a questa pagina</h5>
            <h4>Sarai reindirizzato alla pagina di login</h4>";
            die();
          }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="form-row">
            <div class="col-sm-12 col-lg-11 mx-auto">
              <div class="form-group <?php echo (!empty($descrizione_err)) ? 'has-error' : ''; ?>">
                <div class="intro">
                  <h2 class="text-center">Nuovo Ticket</h2>
                  <p class="text-center">Crea una nuova segnalazione per un
                    disservizio</p>
                </div>
              </div>
              <label class="col-form-label">Descrizione <font color="red">*</font></label>
               <textarea class="form-control" name="descrizione" type="text" rows="4" placeholder="Descrizione necessaria" required></textarea>
              <span style="color:#FF2D00" class="help-block"><?php echo $descrizione_err;?></span>
            </div>
          </div>
          <div class="form-row justify-content-center">
            <div class="col-sm-12 col-lg-5">
              <div class="form-group"><label>Indirizzo</label>
                <input class="form-control"  maxlength="45" name="indirizzo" placeholder="Indirizzo relativo alla segnalazione"  type="text"></div>
            </div>
            <div class="col-sm-2">
              <div class="form-group"><label>Città</label>
                <input name="citta"  maxlength="45" class="form-control" type="text"></div>
            </div>
            <div class="col-sm-2">
              <div class="form-group"><label>Provincia <font color="red">*</font></label>
                <select class="custom-select" name="provincia" required>
                  <option value=""><?php echo $provincia;?></option>
                    <?php
                      $filepath = "http://www.mandile.it/wp-content/uploads/province-sigle.csv";
                      $array_csv = csvToArray($filepath);
                      foreach($array_csv as $numero_riga => $valori){
                       $valore_prima_colonna = $valori[0];
                       $valore_seconda_colonna = $valori[1];
                       echo "<option value=\"".$valore_seconda_colonna."\">".$valore_seconda_colonna."</option>";
                       if($gravita==$valore_seconda_colonna) echo 'selected="selected"';
                      }
                    ?>
                </select>
               <span style="color:#FF2D00" class="help-block"><?php echo $provincia_err;?></span>
            </div>

          </div>
            <div class="form-row justify-content-center">
            <div class="col-sm-3 col-lg-2">
              <div class="form-group"><label>ID Ticket</label><input disabled="true" class="form-control"
                  readonly="readonly" name="id_ticket" placeholder="<?php echo $id_ticket+1; ?>" type="text"></div>
            </div>

            <div class="col-sm-3  col-lg-2">
              <div class="form-group"><label>Data</label><input name="data" class="form-control"
                  readonly="readonly" id="date"></div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="select-group"><label>Tag <font color="red">*</font></label>
                  <input disabled="true" class="form-control" readonly="readonly" id="tag" 
                  placeholder="<?php echo $tagente; ?>">
              <!--   <div class="dropdown">
                    <select class="custom-select" name="tag" required disabled>
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
                  </div> -->
                </div>
              </div>
            <div class="col-sm-6 col-lg-3">
              <div class="select-group"><label>Gravità <font color="red">*</font></label>
                <div class="dropdown">
                    <div>
                      <select name="gravitabox" required class="custom-select">
                        <option value="">Gravità</option>
                        <option name="bassa" value="Bassa">Bassa</option>
                        <option name="media" value="Media">Media</option>
                        <option name="alta" value="Alta">Alta</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <br>
          <div class="form-row">
            <label style="visibility:hidden">Label</label>
          </div>
          <div class="form-row justify-content-center">
              <div class="col-sm-2 col-lg-3">
                <label style="visibility:hidden">Label</label>
                <button class="btn btn-secondary btn-block"
                  type='button' onclick="getLocation(),AttivaSubmit()" id="ottienigeolocalizzazione">
                  <a id="scrittainterna">Ottieni Posizione</a>
                </button>
              </div>
            <div class="col-sm-2 col-lg-2">
              <div class="form-group">
                <label>Latitudine</label>
                <input name="latitudine" class="form-control" type="text" id="latitudine" readonly>
              </div>
            </div>
            <div class="col-sm-2 col-lg-2">
              <div class="form-group">
                <label>Longitudine</label>
                <input name="longitudine" class="form-control" type="text" id="longitudine" readonly>
              </div>
            </div>
          </div>

          <br>
          <div class="form-row justify-content-center">
            <div class="col-sm-4 col-lg-3">
              <button class="btn btn-success btn-block" id="creaticket" disabled="true" type="submit">Crea ticket</button>
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
    <script>
      function AttivaSubmit(){
        document.getElementById('creaticket').removeAttribute('disabled');
      }
    </script>
    <script>
    var x = document.getElementById("latitudine");
    var y = document.getElementById("longitudine");
    var z = document.getElementById("ottienigeolocalizzazione");
    var zz = document.getElementById("scrittainterna");

    function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        zz.innerHTML = "Geolocation is not supported by this browser.";
    }
    }
    function showPosition(position) {
        latitudine.value = position.coords.latitude;
        longitudine.value = position.coords.longitude;
        zz.innerHTML = "Posizione registrata";
        z.disabled = true;
        x.readonly = true;
        y.readonly = true;
    }
    </script>
    <script>
      function showdate(){
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1;
        var yyyy = today.getFullYear();
        if(dd<10) {
          dd = '0'+dd
        }
        if(mm<10) {
          mm = '0'+mm
        }
        today = yyyy + '-' + mm + '-' + dd;
        date.placeholder = today;
      }
    </script>
  </body>
</html>
