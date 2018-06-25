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
    <title>Segnalazioni da risolvere</title>
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

                echo "<div id=\"map\" class=\"embed-responsive embed-responsive-16by9 big-padding\"></div>
                <br><br>";

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
                    if ($row['stato']=="Invalidato" || $row['stato']=="Irrisolto" || $row['stato']=="Risolto") {
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

          <!-- script per la mappa -->
          <script>
            // Initialize and add the map
            function initMap() {

              // The location of Uluru
              var uluru = {lat: 10, lng: 10};

              // The map, centered at Uluru
              // var map = new google.maps.Map(document.getElementById('map'), {zoom: 9, center: uluru});
              var map = new google.maps.Map(document.getElementById('map'), {center: uluru});

              var infoWindow = new google.maps.InfoWindow;

              var latiTot = 0;
              var longiTot = 0;
              var i = 0;

              var bounds = new google.maps.LatLngBounds;

               // Change this depending on the name of your PHP or XML file
                downloadUrl('xml/gen_xml_global_map.php?tag=<?php echo $tag; ?>&prov=<?php echo $provincia; ?>', function(data) {

                 var xml = data.responseXML;
                 var markers = xml.documentElement.getElementsByTagName('marker');
                 Array.prototype.forEach.call(markers, function(markerElem) {
                   var descrizione = markerElem.getAttribute('descrizione');
                   var data = markerElem.getAttribute('data');
                   var gravita = markerElem.getAttribute('gravita');
                   var tag = markerElem.getAttribute('tag');
                   var id = markerElem.getAttribute('id');
                   var point = new google.maps.LatLng(
                       parseFloat(markerElem.getAttribute('latitudine')),
                       parseFloat(markerElem.getAttribute('longitudine'))
                    );
                    // latiTot += parseFloat(markerElem.getAttribute('latitudine'));
                    // longiTot += parseFloat(markerElem.getAttribute('longitudine'));
                    // i++;

                   var infowincontent = document.createElement('div');
                   var strong = document.createElement('strong');
                   strong.textContent = descrizione;
                   infowincontent.appendChild(strong);
                   infowincontent.appendChild(document.createElement('br'));

                   var text = document.createElement('text');
                   text.textContent = "Gravità: "+gravita;
                   infowincontent.appendChild(text);
                   infowincontent.appendChild(document.createElement('br'));

                   var text1 = document.createElement('text');
                   text1.textContent = data;
                   infowincontent.appendChild(text1);
                   infowincontent.appendChild(document.createElement('br'));

                   var link = document.createElement('a');
                   var t = document.createTextNode("Apri");
                   link.setAttribute('href', "assign_team.php?id="+id);
                   link.appendChild(t);
                   infowincontent.appendChild(link);
                   // var icon = customLabel[type] || {};
                   var marker = new google.maps.Marker({
                     map: map,
                     position: point,
                     // label: icon.label
                   });

                   bounds.extend(marker.position);

                   marker.addListener('click', function() {
                     infoWindow.setContent(infowincontent);
                     infoWindow.open(map, marker);
                   });
                 });
               });

               map.fitBounds(bounds);

               // map.panToBounds(bounds);

               var listener = google.maps.event.addListener(map, "idle", function () {
                   map.setZoom(7);
                   google.maps.event.removeListener(listener);
               });

              // var latiMedia = latiTot / i;
              // var longiMedia = longiTot / i;
              // var center = new google.maps.LatLng(parseInt(latiMedia), parseInt(longiMedia));

              // map.setCenter(center);
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
          <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2-9hld_I3B-CWHMUKzRmkUDr75_p1VCI&callback=initMap" type="text/javascript"></script>
          <script src="<?php __DIR__ ?>/../assets/js/Contact-FormModal-Contact-Form-with-Google-Map.js"></script>
          <script src="<?php __DIR__ ?>/../assets/js/Sidebar-Menu.js"></script>
          </div>
        </div>
      </div>
    </body>
  </html>
