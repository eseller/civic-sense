<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$username = $mail = $password = $confirm_password = "";
$username_err = $mail_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Inserire un username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT username FROM segnalatore WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Questo username è già stato preso";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Impossibile accedere al database per validare l'username.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Validate mail

    if(empty(trim($_POST["mail"]))){
        $mail_err = "Inserire una mail.";
    } else{
    	$validating_mail = trim($_POST["mail"]);
    	if(filter_var($validating_mail, FILTER_VALIDATE_EMAIL)){
		// Prepare a select statement
        $sql = "SELECT mail FROM utente WHERE mail = ?";
        
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
                    $mail_err = "Questa mail è già stata presa";
                } else{
                    $mail = trim($_POST["mail"]);
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
    
    // Validate password
    if(empty(trim($_POST['password']))){
        $password_err = "Inserire una password.";     
    } elseif(strlen(trim($_POST['password'])) < 6){
        $password_err = "La password deve essere lunga almeno 6 caratteri";
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = 'Conferma la password.';     
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = 'Le password non corripondono.';
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($mail_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO segnalatore (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){

                // Close statement
                mysqli_stmt_close($stmt);
                // Prepare an insert statement
                $sql = "INSERT INTO utente (username, mail) VALUES (?, ?)";
         
                if($stmt = mysqli_prepare($link, $sql)){
                     // Bind variables to the prepared statement as parameters
                     mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_mail);
            
                     // Set parameters
                    $param_username = $username;
                    $param_mail = $mail;
            
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){              
                        // Redirect to login page
                        header("location: login_user.php");
                     } else{
                        echo "Errore nell'inserimento della mail nel database.";
                     }
               }
            } else{
                echo "Errore nell'inserimento dell'username e della password nel database.";
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
    <title>Civic Sense</title>
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
    <div class="row register-form" style = "background-color:#eef4f7">
        <div class="col-md-8 offset-md-2">
            <form class="custom-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            	<i class="icon ion-android-person-add" style="color:#5547f4;font-size:100px;"></i>
                <div class="form-row form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>"">
                    <div class="col-sm-4 label-column"><label class="col-form-label" for="name-input-field">Username</label></div>
                    <div class="col-sm-6 input-column">
                    	<input class="form-control" type="text" name="username" value="<?php echo $username; ?>">
                    	<span class="help-block"><?php echo $username_err; ?></span>
                    </div>
                </div>
                <div class="form-row form-group <?php echo (!empty($mail_err)) ? 'has-error' : ''; ?>">
                    <div class="col-sm-4 label-column"><label class="col-form-label" for="email-input-field">Email</label></div>
                    <div class="col-sm-6 input-column">
                    	<input class="form-control" type="email" name="mail" value="<?php echo $mail; ?>">
                    	<span class="help-block"><?php echo $mail_err; ?></span>
                    </div>
                </div>
                <div class="form-row form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <div class="col-sm-4 label-column"><label class="col-form-label" for="pawssword-input-field">Password</label></div>
                    <div class="col-sm-6 input-column">
                    	<input class="form-control" type="password" name="password" value="<?php echo $password; ?>">
                    	<span class="help-block"><?php echo $password_err; ?></span>
                    </div>
                </div>
                <div class="form-row form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <div class="col-sm-4 label-column"><label class="col-form-label" for="repeat-pawssword-input-field">Repeat Password</label></div>
                    <div class="col-sm-6 input-column">
                    	<input class="form-control" type="password" name="confirm_password" value="<?php echo $confirm_password; ?>">
                    	<span class="help-block"><?php echo $confirm_password_err; ?></span>
                    </div>
                </div>
                <input class="btn btn-light submit-button" type="submit" style="background-color:#5547f4;" value="Registrati">
                <p>Hai già un account? <a href="login_user.php">Fai il login qui</a>.</p>
            </form>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/Contact-FormModal-Contact-Form-with-Google-Map.js"></script>
    <script src="assets/js/Sidebar-Menu.js"></script>
</body>

</html>