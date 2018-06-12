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

  // Start XML file, create parent node
  $dom = new DOMDocument("1.0");
  $node = $dom->createElement("markers");
  $parnode = $dom->appendChild($node);

  $id_ticket = $_GET['id'];

  $sql = "SELECT * FROM ticket WHERE id_ticket=$id_ticket";
  $result = mysqli_query($link, $sql);
  $row = mysqli_fetch_assoc($result);

  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);

  $descrizione= $row['descrizione'];
  $data = $row['data'];
  $latitudine = $row['latitudine'];
  $longitudine = $row['longitudine'];
  $provincia = $row['provincia'];
  $citta = $row['citta'];
  $indirizzo = $row['indirizzo'];
  $tag = $row['tag'];
  $gravita = $row['gravita'];
  $stato = $row['stato'];
  $report = $row['report'];

  echo $dom->saveXML();

?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizza Ticket</title>
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
    <link rel="stylesheet" href="css/responsive.css">
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
    <div class="features-boxed">
        <div class="container">
            <!-- contentitore titolo, sottotitolo e descrizione -->
            <div class="form-row">
              <div class="col-sm-12 col-lg-11 mx-auto">
                <div class="form-group">
                  <div class="intro">
                    <h2 class="text-center">Visualizza Ticket</h2>
                    <p class="text-center">Visualizza i dettagli di una segnalazione per disservizio</p>
                  </div>
                </div>
                <label class="col-form-label">Descrizione</label>
                <textarea readonly class="form-control" name="descrizione" type="text" rows="4" required><?php echo $descrizione; ?></textarea>
              </div>
            </div>

            <!-- contenitore per indirizzo, tag e gravità -->
            <div class="form-row justify-content-center">

              <!-- colonna indirizzo -->
              <div class="col-sm-12 col-lg-6">
                <div class="form-group"><label>Indirizzo</label>
                  <input readonly name="indirizzo" class="form-control" type="text" value="<?php echo $indirizzo; ?>"></div>
              </div>

              <!-- colonna tag -->
              <div class="col-sm-6 col-lg-2">
                <div class="select-group"><label>Tag</label>
                  <input readonly  name="tag" class="form-control" type="text" value="<?php echo $tag; ?>">
                </div>
              </div>

              <!-- colonna gravità -->
              <div class="col-sm-6 col-lg-2">
                <div class="select-group"><label>Gravità</label>
                  <input readonly  name="gravita" class="form-control" type="text" value="<?php echo $gravita; ?>">
                </div>
              </div>
            </div>

            <!-- contenitore per città, provincia, latitudine, longitudine -->
            <div class="form-row justify-content-center">

              <!-- colonna città -->
              <div class="col-sm-3 col-lg-2">
                <div class="select-group">
                  <label>Città</label>
                  <input readonly  name="citta" class="form-control" type="text" value="<?php echo $citta; ?>">
                </div>
              </div>

              <!-- colonna della provincia -->
              <div class="col-sm-3 col-lg-1">
                <div class="select-group">
                  <label>Provincia</label>
                  <input readonly  name="provincia" class="form-control" type="text" value="<?php echo $provincia; ?>">
                </div>
              </div>

              <!-- colonna latitudine -->
              <div class="col-sm-4 col-lg-2">
                <div class="form-group">
                  <label>Latitudine</label>
                  <input class="form-control" readonly="readonly" type="text" id="latitudine" value="<?php echo $latitudine ?>">
                </div>
              </div>

              <!-- colonna longitudine -->
              <div class="col-sm-4 col-lg-2">
                <div class="form-group">
                  <label>Longitudine</label>
                  <input class="form-control" readonly="readonly" type="text" id="longitudine" value="<?php echo $longitudine ?>">
                </div>
              </div>
            </div>

            <!-- contenitore per id_ticket e data -->
            <div class="form-row justify-content-center">
              <div class="col-sm-4 col-lg-2">
                <div class="form-group">
                  <label>ID Ticket</label>
                  <input name="id_ticket" id="id_ticket" class="form-control" readonly type="text" value="<?php echo $id_ticket; ?>">
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label>Data</label>
                  <input disabled="true" class="form-control" placeholder="<?php echo $data ?>" readonly>
                </div>
              </div>
            </div>

            <div class="form-row justify-content-center">
              <div class="col-sm-4 col-lg-4">
                <label>Stato</label>
                <input disabled="true" class="form-control" placeholder="<?php echo $stato ?>" readonly>
              </div>
              <div class="col-sm-4 col-lg-8" id="report">
                <label>Report</label>
                <textarea readonly class="form-control" type="text" rows="4"><?php echo $report; ?></textarea>
              </div>
            </div>

            <br>
            <div id="map" class="embed-responsive embed-responsive-16by9 big-padding">
          </div>

            <br>
            <br>
              <button class="btn btn-danger btn-block" type="button" onclick="location.href='list_ticket_fordetails_user.php'">Indietro</button>
            <br>
            <br>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
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
      var map = new google.maps.Map(document.getElementById('map'), {zoom: 15, center: uluru});
      // The marker, positioned at Uluru
      var marker = new google.maps.Marker({position: uluru, map: map});

      var infoWindow = new google.maps.InfoWindow;

      var id = document.getElementById("id_ticket").value;

       // Change this depending on the name of your PHP or XML file
       downloadUrl('gen_xml_map_user.php?id='+id, function(data) {
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
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2-9hld_I3B-CWHMUKzRmkUDr75_p1VCI&callback=initMap" type="text/javascript">
    </script>
    <script src="assets/js/Contact-FormModal-Contact-Form-with-Google-Map.js"></script>
    <script src="assets/js/Sidebar-Menu.js"></script>

  </body>
</html>
