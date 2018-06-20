<?php
// Include config file
require_once __DIR__.'/../config.php';

// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: https://civicsensesst.altervista.org/login_user.php");
  exit;
}

$mail = $mail_err = "";
$username = $_SESSION['username'];

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

      // Validate mail

      if(empty(trim($_POST["mail"]))){
          $mail_err = "Inserire una mail.";
      } else{
        $validating_mail = trim($_POST["mail"]);
        if(filter_var($validating_mail, FILTER_VALIDATE_EMAIL)){
      // Prepare a select statement
          $sql = "SELECT mail FROM dipendente WHERE mail = ?";
          
          if($stmt = mysqli_prepare($link, $sql)){
              // Bind variables to the prepared statement as parameters
              mysqli_stmt_bind_param($stmt, "s", $param_mail);
              
              // Set parameters
              $param_mail = trim($_POST["mail"]);
              
              // Attempt to execute the prepared statement
              if(mysqli_stmt_execute($stmt)){
                  /* store result */
                  mysqli_stmt_store_result($stmt);
                  
                  if(mysqli_stmt_num_rows($stmt) == 1){
                      $mail_err = "Questa mail è già stata presa.";
                  } else{
                      $mail = trim($_POST["mail"]);
                      $mail_err = "";
                  }
              } else{
                  echo "Impossibile accedere al database per validare la mail.";
              }
          }
           
          // Close statement
          mysqli_stmt_close($stmt);
        } else {
          $mail_err = "Mail non valida.";
        }
          
      }

      // Check input errors before inserting in database
      if(empty($mail_err)){
         // Prepare an insert statement
         $sql = "UPDATE dipendente SET mail = ? WHERE username = ?";
         
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ss", $param_mail, $param_username);
                   
              // Set parameters
             $param_username = $username;
             $param_mail = $mail;
        
             // Attempt to execute the prepared statement
             if(mysqli_stmt_execute($stmt)){              
                 // Redirect to login page
                 header("location: list_ticket_fordetails_employee.php");
              } else{
                 echo "Errore nell'inserimento della mail nel database.";
              }
        }
      }



}


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
  <body>
    <div class="row register-form">
      <div class="col-md-8 offset-md-2">
        <form class="custom-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <i class="icon ion-android-person-add" style="color:#5547f4;font-size:100px;"></i><br>
          <p> Benvenuto dipendente! Inserisci la tua mail:<br>
          </p>
          <br>
          <div class="form-row form-group <?php echo (!empty($mail_err)) ? 'has-error' : ''; ?>">
              <div class="col-sm-4 label-column"><label class="col-form-label" for="email-input-field">Email</label></div>
              <div class="col-sm-6 input-column">
                <input class="form-control" type="email" name="mail" value="<?php echo $mail; ?>">
                <span class="help-block"><?php echo $mail_err; ?></span>
              </div>
          </div>
          <button class="btn btn-light submit-button" type="button" style="background-color:#5547f4;">Conferma</button>
        </form>
      </div>
    </div>
    <script src="<?php __DIR__ ?>/../assets/js/jquery.min.js"></script>
    <script src="<?php __DIR__ ?>/../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php __DIR__ ?>/../assets/js/Contact-FormModal-Contact-Form-with-Google-Map.js"></script>
    <script src="<?php __DIR__ ?>/../assets/js/Sidebar-Menu.js"></script>
  </body>
</html>
