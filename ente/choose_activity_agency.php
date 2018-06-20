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

  $username_reale = $_SESSION['username'];

  // $sql2 = "SELECT * FROM ente";
  //
  // $result = mysqli_query($link, $sql2);
  // $row = mysqli_fetch_assoc($result);
  // $numero = mysqli_num_rows($result);
  // echo "Numero righe:  " . $numero;

  // function utente_impostore(){
  //
  //     $sql2 = "SELECT * FROM ente";
  //
  //     $result = mysqli_query($link, $sql2);
  //     $row = mysqli_fetch_assoc($result);
  //     $numero = mysqli_num_rows($result);
  //     echo "Numero righe:  " . $numero;
  //
  //
    // while ($row1 = mysqli_fetch_assoc($result)){
      // echo "entra nel ciclo";
      // echo "da controllare: " . $row1['username'];
      // if($variabile['username']==$_SESSION['username']){
      //   return false;
      // }
    // }
    // echo "non entra nel ciclo";
    // mysqli_close($link);
  //   return true;
  // }

 ?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Civic Sense</title>
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

      <!-- CONTROLLO SE L'UTENTE E' ABILITATO AD ACCEDERE ALLA PAGINA -->

      <div class="col-sm-12 col-lg-11 mx-auto">
        <div class="intro">
          <h2 class="text-center">Civic Sense</h2>
        </div>
      </div>
      <div class="container">
        <div class="row justify-content-center features">
          <div class="col-sm-6 col-md-6 col-lg-4 item">
            <div class="box"><i class="fa fa-wrench icon"></i>
              <h3 class="name">VISUALIZZA TICKET DA RISOLVERE</h3>
              <p class="description">Permette assegnare un gruppo di risoluzione ad un ticket.</p>
              <a href="list_global_ticket.php"></a>
            </div>
          </div>
          <div class="col-sm-6 col-md-6 col-lg-4 item">
            <div class="box"><i class="fa fa-users icon"></i>
              <h3 class="name">GESTISCI GRUPPI RISOLUZIONE</h3>
              <p class="description">Permette di aggiungere, modificare ed eliminare i gruppi di risoluzione.</p>
              <br>
              <a href="list_group_fordetails_agency.php"></a>
            </div>
          </div>
          <div class="col-sm-6 col-md-6 col-lg-4 item">
            <div class="box"><i class="fa fa-id-card-o icon"></i>
              <h3 class="name">GESTISCI DIPENDENTI</h3>
              <p class="description">Permette di aggiungere, modificare o rimuovere i dipendenti.</p>
              <br>
              <a href="list_employee.php"></a>
            </div>
          </div>
          <div class="col-sm-6 col-md-6 col-lg-4 item">
            <div class="box"><i class="fa fa-plus icon"></i>
              <h3 class="name">NUOVO TICKET</h3>
              <p class="description">Permette di inserire una nuova segnalazione di disservizio.</p>
              <br/>
              <a href="new_ticket_agency.php"></a>
            </div>
          </div>
          <div class="col-sm-6 col-md-6 col-lg-4 item">
            <div class="box"><i class="fa fa-gears icon"></i>
              <h3 class="name">GESTISCI TICKET</h3>
              <p class="description">Permette di visualizzare, modificare ed eliminare i ticket.</p>
              <br/>
              <a href="list_ticket_fordetails_agency.php"></a>
            </div>
          </div>
          <div class="col-sm-6 col-md-6 col-lg-4 item">
            <div class="box"><i class="fa fa-bar-chart icon"></i>
              <h3 class="name">VISUALIZZA STATISTICHE</h3>
              <p class="description">Permette di visualizzare delle statistiche sull'efficacia dello strumento.</p>
              <br>
              <a href="view_stats_agency.php"></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script src="<?php __DIR__ ?>/../assets/js/jquery.min.js"></script>
<script src="<?php __DIR__ ?>/../assets/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
  $(".box").click(function(){
  window.location=$(this).find("a").attr("href");
  return false;
  });
</script>
<script src="<?php __DIR__ ?>/../assets/js/Contact-FormModal-Contact-Form-with-Google-Map.js"></script>
<script src="<?php __DIR__ ?>/../assets/js/Sidebar-Menu.js"></script>
</html>
