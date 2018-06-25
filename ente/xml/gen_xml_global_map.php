<?php
  // Include config file
  require_once __DIR__.'/../../config.php';

  // Initialize the session
  session_start();

  if($_SERVER["REQUEST_METHOD"] == "GET"){

    // Start XML file, create parent node
    $dom = new DOMDocument("1.0");
    $node = $dom->createElement("markers");
    $parnode = $dom->appendChild($node);

    $provincia = $_GET['prov'];
    $tag = $_GET['tag'];


    header("Content-type: text/xml");


    $sql = "SELECT * FROM ticket WHERE provincia LIKE '$provincia' AND tag LIKE '$tag'";

    $result = mysqli_query($link, $sql);

    while ($row = mysqli_fetch_assoc($result)) {

      $node = $dom->createElement("marker");
      $newnode = $parnode->appendChild($node);

      $newnode->setAttribute("id", $row['id_ticket']);
      $newnode->setAttribute("descrizione", $row['descrizione']);
      $newnode->setAttribute("data", $row['data']);
      $newnode->setAttribute("latitudine", $row['latitudine']);
      $newnode->setAttribute("longitudine", $row['longitudine']);
      $newnode->setAttribute("provincia", $row['provincia']);
      $newnode->setAttribute("citta", $row['citta']);
      $newnode->setAttribute("indirizzo",$row['indirizzo']);
      $newnode->setAttribute("tag",$row['tag']);
      $newnode->setAttribute("gravita", $row['gravita']);
      $newnode->setAttribute("stato", $row['stato']);
      $newnode->setAttribute("report", $row['report']);

    }

    echo $dom->saveXML();

  }

?>
