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

  if(!isset($_SESSION['utente'])){
    echo "<br />";
    echo "<br />";
    echo "<center><h1>Non hai formulato una richiesta valida</h1></center>";
    echo "<br />";
    echo "<center><h3>Sarai reindirizzato alla homepage</h3></center>";
    header("refresh:3;url=".home_url());
    die();
  }

 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Civic Sense</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/Contact-FormModal-Contact-Form-with-Google-Map.css">
    <link rel="stylesheet" href="assets/css/dh-row-text-image-right.css">
    <link rel="stylesheet" href="assets/css/Features-Boxed.css">
    <link rel="stylesheet" href="assets/css/styles.css">
  </head>
<body style = "background-color:#eef4f7">
    <div class="features-boxed">
      <div class="container">
        <div class="intro">
          <h2 class="text-center">Civic Sense</h2>
          <p class="text-center">Civic Sense è un sistema al servizio del
            cittadino per la segnalazione di problemi, malfunzionamenti e
            guasti.</p>
        </div>
        <div class="container">
          <div class="row justify-content-center features">
            <div class="col-sm-6 col-md-5 col-lg-4 item">
              <div class="box" ><em class="fa fa-plus icon"></em>
                <h3 class="name">NUOVO TICKET</h3>
                <p class="description">Permette di inserire una nuova
                  segnalazione di disservizio</p>
                  <br>
                <a href="new_ticket_user.php"></a>
              </div>
            </div>
            <div class="col-sm-6 col-md-5 col-lg-4 item">
              <div class="box"><em class="fa fa-gears icon"></em>
                <h3 class="name">GESTISCI TICKET</h3>
                <p class="description">Permette di visualizzare, modificare ed
                  eliminare un ticket precedentemente inserito</p>
                <a href="list_ticket_fordetails_user.php"></a>
              </div>
            </div>
            <div class="col-sm-6 col-md-5 col-lg-4 item">
              <div class="box"><em class="fa fa-bar-chart icon"></em>
                <h3 class="name">VISUALIZZA STATISTICHE</h3>
                <p class="description">Permette di visualizzare delle
                  statistiche sull'efficacia dello strumento e dei vari enti</p>
                <a href="view_stats_user.php"></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
      $(".box").click(function(){
      window.location=$(this).find("a").attr("href");
      return false;
      });
    </script>
    <script src="assets/js/Contact-FormModal-Contact-Form-with-Google-Map.js"></script>
    <script src="assets/js/Sidebar-Menu.js"></script>
  </body>
</html>
