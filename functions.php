<?php
  function the_title(){
    global $title;

    echo $title;
  }

  define('ABS_URL', 'https://civicsensesst.altervista.org/');

  function home_url(){
    return ABS_URL;
  }

  /**
  * Apre un file .csv e ritorna un array.
  *
  * @param string $filepath Percorso completo del file
  */
  function csvToArray($filepath){
   setlocale(LC_ALL, 'en_US.UTF-8');
   // apertura del file
   if (($handle = fopen($filepath, "r")) !== FALSE) {
    $nn = 0;
    // legge una riga alla volta fino alla fine del file
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
     // numero di elementi presenti nella riga letta
     $num_elementi = count($data);
     // popolamento dell'array
     for ($x=0; $x<$num_elementi; $x++) {
      $csvarray[$nn][$x] = $data[$x];
     }
     $nn++;
    }
    // Chiusura del file
    fclose($handle);
   } else {
    echo "File non trovato";
   }

   return $csvarray;
  }


  /**
  * Crea un file .xml con i valori del database
  */
  function parseToXML($htmlStr){
    $xmlStr=str_replace('<','&lt;',$htmlStr);
    $xmlStr=str_replace('>','&gt;',$xmlStr);
    $xmlStr=str_replace('"','&quot;',$xmlStr);
    $xmlStr=str_replace("'",'&apos;',$xmlStr);
    $xmlStr=str_replace("&",'&amp;',$xmlStr);
    return $xmlStr;
  }

?>
