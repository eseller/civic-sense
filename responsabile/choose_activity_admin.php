<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Civic Sense</title>
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Contact-FormModal-Contact-Form-with-Google-Map.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/dh-row-text-image-right.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/Features-Boxed.css">
    <link rel="stylesheet" href="<?php __DIR__ ?>/../assets/css/styles.css">
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
              <div class="box" ><i class="fa fa-plus icon"></i>
                <h3 class="name">CREAZIONE ENTE</h3>
                <p class="description">Permette di inserire <br> un nuovo ente</p>
                <br>
                <a href="new_agency_admin.php"></a>
              </div>
            </div>
            <div class="col-sm-6 col-md-5 col-lg-4 item">
              <div class="box"><i class="fa fa-gears icon"></i>
                <h3 class="name">GESTIONE ENTI</h3>
                <p class="description">Permette di visualizzare, modificare ed
                  eliminare un ente precedentemente inserito</p>
                <a href="list_agency_fordetails_admin.php"></a>
              </div>
            </div>
<!--             <div class="col-sm-6 col-md-5 col-lg-4 item">
              <div class="box"><i class="fa fa-bar-chart icon"></i>
                <h3 class="name">Funzionalità</h3>
                <p class="description">Descrizione funzionalità</p>
                <a href="view_stats_user.php" class="learn-more">Link funzionalità</a></div>
            </div> -->
          </div>
        </div>
      </div>
    </div>
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
  </body>
</html>
