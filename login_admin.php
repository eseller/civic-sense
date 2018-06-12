<?php
  // Include config file
  require_once 'config.php';

  // Define variables and initialize with empty values
  $username = $password = "";
  $username_err = $password_err = "";

  // Processing form data when form is submitted
  if($_SERVER["REQUEST_METHOD"] == "POST"){

      // Check if username is empty
      if(empty(trim($_POST["username"]))){
          $username_err = 'Inserire un username.';
      } else{
          $username = trim($_POST["username"]);
      }

      // Check if password is empty
      if(empty(trim($_POST['password']))){
          $password_err = 'Inserire la password.';
      } else{
          $password = trim($_POST['password']);
      }

      // Validate credentials
      if(empty($username_err) && empty($password_err)){
          // Prepare a select statement
          $sql = "SELECT username, password FROM responsabile WHERE username = ?";

          if($stmt = mysqli_prepare($link, $sql)){
              // Bind variables to the prepared statement as parameters
              mysqli_stmt_bind_param($stmt, "s", $param_username);

              // Set parameters
              $param_username = $username;

              // Attempt to execute the prepared statement
              if(mysqli_stmt_execute($stmt)){
                  // Store result
                  mysqli_stmt_store_result($stmt);

                  // Check if username exists, if yes then verify password
                  if(mysqli_stmt_num_rows($stmt) == 1){
                      // Bind result variables
                      mysqli_stmt_bind_result($stmt, $username, $hashed_password);
                      if(mysqli_stmt_fetch($stmt)){
                      	  if(empty($hashed_password))
                      	  {
                      	  	// Close statement
                      	  	mysqli_stmt_close($stmt);
                      	  	 // Prepare an insert statement
                      	  	 $sql = "UPDATE responsabile SET password = ? WHERE username = ?";
                      	  	
                      	  	 if($stmt = mysqli_prepare($link, $sql)){
                      	  	      // Bind variables to the prepared statement as parameters
                      	  	      mysqli_stmt_bind_param($stmt, "ss", $param_password, $param_username);
                      	  	
                      	  	      // Set parameters
                      	  	     $param_username = $username;
                      	  	     $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                      	  	
                      	  	     // Attempt to execute the prepared statement
                      	  	     if(mysqli_stmt_execute($stmt)){              
                      	  	         // Redirect to login page
                      	  	         header("location: responsabile/choose_activity_admin.html");
                      	  	      } else{
                      	  	         echo "Errore nell'inserimento della password nel database.";
                      	  	      }
                      	  	}
                      	  	// Close statement
                      	  	mysqli_stmt_close($stmt);
                      	  } else {
                          	if(password_verify($password, $hashed_password)){
                            	/* Password is correct, so start a new session and
                              	save the username to the session */
                              	session_start();
                              	$_SESSION['username'] = $username;
                              	header("location: responsabile/choose_activity_admin.html");
                          		} else{
                              	// Display an error message if password is not valid
                              	$password_err = 'La password inserita non è valida.';
                          }
                          }
                      }
                  } else{
                      // Display an error message if username doesn't exist
                      $username_err = 'Nessun account trovato con questo username.';
                  }
              } else{
                  echo "Errore nella validazione delle credenziali.";
              }
          }

          // Close statement
          mysqli_stmt_close($stmt);
      }

      // Close connection
      mysqli_close($link);
  }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Civic Sense Log-in</title>
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
</head>

<body style = "background-color:#eef4f7">
    <div class="login-clean">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration"><i class="icon ion-android-person" style="color:#5547f4;"></i></div>
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <input class="form-control" type="username" name="username" placeholder="Username" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input class="form-control" type="password" name="password" placeholder="Password">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit" style="background-color:#5547f4;">Accedi</button></div><p align="justify">Se è la tua prima visita, la password inserita verrà associata al tuo account da questo accesso in avanti. <br> <br> Altrimenti, inserisci la password inserita durante la tua prima visita.</p>
        </form>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/Contact-FormModal-Contact-Form-with-Google-Map.js"></script>
    <script src="assets/js/Sidebar-Menu.js"></script>
</body>

</html>
