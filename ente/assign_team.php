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

  $sql = "SELECT * FROM ticket WHERE id_ticket = $id_ticket";
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
  $stato = $row['stato'];
  $report = $row['report'];

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

    // Se è una post per la modifica della gravità entra qui <------------------------
    if (!empty($_POST['modifica_gravita'])) {

      // Check if gravità is empty
      if(empty(trim($_POST['gravita']))){
          $gravita_err = 'Inserire la gravita.';
      } else{
        echo trim($_POST['gravita']);
          $gravita = trim($_POST['gravita']);
      }

      $id_ticket = trim($_POST['id_ticket']);

      $sql = "UPDATE ticket SET gravita='$gravita' WHERE id_ticket = $id_ticket";
      $result = mysqli_query($link, $sql);
      header("location:list_global_ticket.php");

    } elseif (!empty($_POST['invalida_ticket'])) {
      // Se è una post per l'invalidazione del ticket entra qui <------------------------

      $id_ticket = trim($_POST['id_ticket']);
      echo "entra nella richiesta di invalidazione";
      echo $id_ticket;
      // Check if gravità is empty
      if(empty(trim($_POST['stato']))){
          $stato_err = 'Inserire lo stato.';
      } else{
          $stato = trim($_POST['stato']);
          echo trim($_POST['stato']);
      }

      // Check if gravità is empty
      if(empty(trim($_POST['report']))){
          $report_err = 'Inserire il report.';
      } else{
          $report = trim($_POST['report']);
      }

      $id_ticket = trim($_POST['id_ticket']);
      $sql = "UPDATE ticket SET report='$report', stato='$stato' WHERE id_ticket = $id_ticket";
      $result = mysqli_query($link, $sql);

      header("location:list_global_ticket.php");
    }
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assegna gruppo di risoluzione</title>
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
    <style>
       /* Set the size of the div element that contains the map */
      #map {
        height: 400px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
        background-color: beige;
       }
    </style>
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
      <div class="container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

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
              <textarea disabled class="form-control" maxlength="400" name="descrizione" id="descrizione" type="text" rows="4" onload="count(this, 400, 'descrizione')" onkeyup="count(this, 400, 'descrizione')"><?php echo $descrizione; ?></textarea>
            </div>
          </div>

          <!-- contenitore per indirizzo, tag e gravità -->
          <div class="form-row justify-content-center">

            <!-- colonna indirizzo -->
            <div class="col-sm-12 col-lg-6">
              <div class="form-group">
                <label>Indirizzo</label>
                <input disabled name="indirizzo" maxlength="45" class="form-control" type="text" value="<?php echo $indirizzo; ?>"></div>
            </div>

            <!-- colonna tag -->
            <div class="col-sm-6 col-lg-2">
              <div class="select-group">
                <label>Tag <font color="red">*</font></label>
                  <div class="dropdown">
                    <select class="custom-select" name="tag" disabled>
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
                    <select class="custom-select" name="gravita" id="gravita">
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
                <input disabled  name="citta"  maxlength="45" class="form-control" type="text" value="<?php echo $citta ?>"></div>
            </div>

            <!-- colonna della provincia -->
            <div class="col-sm-3 col-lg-2">
              <div class="dropdown">
                <div class="select-group"><label>Provincia <font color="red">*</font></label>
                  <select class="custom-select" name="provincia" disabled>
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
                <input disabled="true" class="form-control" readonly="readonly" type="text" id="latitudine" value="<?php echo $latitude ?>"></div>
            </div>

            <!-- colonna longitudine -->
            <div class="col-sm-4 col-lg-2">
              <div class="form-group">
                <label>Longitudine</label>
                <input disabled="true" class="form-control" readonly="readonly" type="text" id="longitudine" value="<?php echo $longitude ?>"></div>
            </div>
          </div>

          <!-- contenitore per id_ticket e data -->
          <div class="form-row justify-content-center">
            <div class="col-sm-4 col-lg-2">
              <div class="form-group">
                <label>ID Ticket</label>
                <input name="id_ticket" id="id_ticket" class="form-control" readonly type="text" value="<?php echo $id_ticket; ?>"></div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label>Data</label>
                <input readonly class="form-control" placeholder="<?php echo $data ?>" readonly></div>
            </div>
          </div>

          <!-- bottoni per conferma o annullamento -->
          <div class="form-row justify-content-center">
            <div class="col-sm-4 col-lg-3">
              <input class="btn btn-success btn-block" name="modifica_gravita" type="submit" value="Modifica ticket">
            </div>
            <div class="col-sm-4 col-lg-3">
              <button class="btn btn-danger btn-block" type="button" onclick="location.href='list_global_ticket.php'">Annulla</button>
            </div>
          </div>
          <br>
          <br>
        </form>

        <!-- contenitore stato, bottone invalidazione, report -->
        <div class="form-row justify-content-center">
          <div class="col-sm-5 col-lg-4">
            <label>Stato</label>
            <input class="form-control" disabled placeholder="<?php echo $stato ?>">
            <br>
            <div class="form-row justify-content-center">
              <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModalCenter">Invalida Ticket</button>
            </div>
          </div>
          <div class="col-sm-7 col-lg-8">
            <label>Report</label>
            <textarea class="form-control" type="text" rows="4" id="report" disabled><?php echo $report; ?></textarea>
          </div>
        </div>
        <br>
        <br>

        <!-- contenitore per agiunta gruppo di risoluzione -->
        <div class="form-row justify-content-center">
          <div class="col-sm-12 col-lg-12">
            <h4 class="text-center">Assegna gruppo di risoluzione</h4>
          </div>
          <div class="col-sm-6 col-lg-6">
            <label>Assegna gruppo esistente</label>
            <input class="form-control" disabled placeholder="<?php echo $stato ?>">
            <br>
            <div class="form-row justify-content-center">
              <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ModalLarge" value="Assegna gruppo">
            </div>
            <div class="form-row justify-content-center">
              <input type="button" class="btn btn-warning" data-toggle="modal" data-target="#ModalLarge" value="Visualizza gruppi">
            </div>
          </div>
        </div>

        <br>
        <br>
        <div id="map" class="embed-responsive embed-responsive-16by9 big-padding">
        </div>

        <br>
          <br>
            <div class="form-row justify-content-center">
              <div class="col-sm-4 col-lg-5">
                <button class="btn btn-dark btn-block" type="button" onclick="location.href='list_global_ticket.php'">Indietro</button>
              </div>
            </div>
          <br>
        <br>

      </div>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="ModalCenterTitle">Vuoi davvero invalidare il ticket?</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="modal-body">
              <strong>L'azione non può essere più annullabile.</strong><br>
              Scrivi una motivazione:
              <div class="input-group">
                <textarea class="form-control" name="report" type="text" rows="4" placeholder="Inserisci una motivazione"></textarea>
              </div>
            </div>
            <input type="text" name="id_ticket" value="<?php echo $id_ticket; ?>" hidden>
            <input type="text" name="stato" value="Invalidato" hidden>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Annulla</button>
              <input type="submit" name="invalida_ticket" class="btn btn-danger" id="invalida-definit" value="Invalida definitivamente">
            </div>
          </div>
        </div>
      </div>
    </form>

    <div class="modal fade bd-example-modal-lg" id="ModalLarge" tabindex="-1" role="dialog" aria-labelledby="ModalCenterLarge" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalCenterTitle">Elenco gruppi di risoluzione</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="modal-body">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Chiudi</button>
          </div>
        </div>
      </div>
    </div>


    <script src="<?php __DIR__ ?>/../assets/js/jquery.min.js"></script>
    <script src="<?php __DIR__ ?>/../assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">

    function estrapola_report() {
      document.getElementById('motivazione').innerHTML = document.getElementById('report').innerHTML;
    }

    </script>
    <script>
    // Initialize and add the map
    function initMap() {

      // var luru = new google.maps.LatLng(
      //     parseFloat(document.getElementById("latitudine").value),
      //     parseFloat(document.getElementById("longitudine").value));

      var lati = parseFloat(document.getElementById("latitudine").value);
      var longi = parseFloat(document.getElementById("longitudine").value);
      // The location of Uluru

      var uluru = {lat: lati, lng: longi};

      // The map, centered at Uluru
      var map = new google.maps.Map(document.getElementById('map'), {zoom: 17, center: uluru});
      // The marker, positioned at Uluru
      var marker = new google.maps.Marker({position: uluru, map: map});

      var infoWindow = new google.maps.InfoWindow;

      var id = document.getElementById("id_ticket").value;

       // Change this depending on the name of your PHP or XML file
       downloadUrl('xml/gen_xml_map_ente.php?id='+id, function(data) {
         var xml = data.responseXML;
         var markers = xml.documentElement.getElementsByTagName('marker');
         Array.prototype.forEach.call(markers, function(markerElem) {
           var descrizione = markerElem.getAttribute('descrizione');
           var data = markerElem.getAttribute('data');
           var gravita = markerElem.getAttribute('gravita');
           var tag = markerElem.getAttribute('tag');
           var point = new google.maps.LatLng(
               parseFloat(markerElem.getAttribute('latitudine')),
               parseFloat(markerElem.getAttribute('longitudine')));

           var infowincontent = document.createElement('div');
           var strong = document.createElement('strong');
           strong.textContent = descrizione
           infowincontent.appendChild(strong);
           infowincontent.appendChild(document.createElement('br'));

           var text = document.createElement('text');
           text.textContent = data
           infowincontent.appendChild(text);
           // var icon = customLabel[type] || {};
           var marker = new google.maps.Marker({
             map: map,
             position: point,
             // label: icon.label
           });
           marker.addListener('click', function() {
             infoWindow.setContent(infowincontent);
             infoWindow.open(map, marker);
           });
         });
       });
     }

    function downloadUrl(url, callback) {
     var request = window.ActiveXObject ?
         new ActiveXObject('Microsoft.XMLHTTP') :
         new XMLHttpRequest;

     request.onreadystatechange = function() {
       if (request.readyState == 4) {
         request.onreadystatechange = doNothing;
         callback(request, request.status);
       }
     };

     request.open('GET', url, true);
     request.send(null);
    }

    function doNothing() {}
    </script>
    <!--Load the API from the specified URL
    * The async attribute allows the browser to render the page while the API loads
    * The key parameter will contain your own API key (which is not needed for this tutorial)
    * The callback parameter executes the initMap() function
    -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2-9hld_I3B-CWHMUKzRmkUDr75_p1VCI&callback=initMap" type="text/javascript"></script>
    <script src="<?php __DIR__ ?>/../assets/js/Contact-FormModal-Contact-Form-with-Google-Map.js"></script>
    <script src="<?php __DIR__ ?>/../assets/js/Sidebar-Menu.js"></script>
  </body>
</html>
