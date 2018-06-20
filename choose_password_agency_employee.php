<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$isente = 2;
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Inserire un username.";
    } else {
        // Prepare a select statement
        $sql = "SELECT username FROM ente WHERE username = ?";
        
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
                    // Prepare a select statement
                    $sql = "SELECT username, password FROM segnalatore WHERE username = ?";

                    if($stmt = mysqli_prepare($link, $sql)){
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "s", $param_username);
                        
                        // Set parameters
                        $param_username = trim($_POST["username"]);
                        
                        // Attempt to execute the prepared statement
                        if(mysqli_stmt_execute($stmt)){
                            /* store result */
                            mysqli_stmt_store_result($stmt);
                            // Bind result variables
                            mysqli_stmt_bind_result($stmt, $username, $hashed_password);
                            if(mysqli_stmt_fetch($stmt)){
                                if (empty($hashed_password)){
                                    $username = trim($_POST["username"]);
                                    $isente = 1;
                                } else {$username_err = "Questo username ha già una password assegnata.";}
                            }    
                        } else {
                             echo "Impossibile accedere al database per validare l'username.";
                        }
                    } 
                } else{
                    // Prepare a select statement
                    $sql = "SELECT username, password FROM dipendente WHERE username = ?";

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
                                // Bind result variables
                                mysqli_stmt_bind_result($stmt, $username, $hashed_password);
                                if(mysqli_stmt_fetch($stmt)){
                                    if (empty($hashed_password)){
                                        $username = trim($_POST["username"]);
                                        $isente = 0;
                                    } else {$username_err = "Questo username ha già una password assegnata.";}
                                }
                            } else {
                                $username_err = "Questo username non risulta essere valido.";
                            }
                        } else{
                             echo "Impossibile accedere al database per validare l'username.";
                        }
                    } 
                }
            } else {
                echo "Impossibile accedere al database per validare l'username.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
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
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        if ($isente == 1){
            // É un ente
            // Prepare an update statement
            $sql = "UPDATE segnalatore SET password = ? WHERE username = ?";
         
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ss", $param_password, $param_username);
            
                // Set parameters
                $param_username = $username;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Effettua il login come ente e vai alla choose activity agency
                    session_start();
                    $_SESSION['username'] = $username;
                    header("location: ente/choose_activity_agency.php");
                }
            } else{
                echo "Errore nell'inserimento della password nel database.";
            }
        } 
        if ($isente == 0) {
            // É un dipendente
            // Prepare an update statement
            $sql = "UPDATE dipendente SET password = ? WHERE username = ?";
         
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ss", $param_password, $param_username);
            
                // Set parameters
                $param_username = $username;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Effettua il login come dipendente e vai alla scelta della mail
                    session_start();
                    $_SESSION['username'] = $username;
                    header("location: dipendente/choose_mail_employee.php");
                } else{
                    echo "Errore nell'inserimento della password nel database.";
                }
            }
        }
    }
         
    // Close statement
    mysqli_stmt_close($stmt);      

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
                <br>
                <p> Se sei un ente o un dipendente che fa l'accesso per la prima volta, inserisci il tuo username e scegli la tua password.<br>
                </p>
                <br>
                <div class="form-row form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>"">
                    <div class="col-sm-4 label-column"><label class="col-form-label" for="name-input-field">Username</label></div>
                    <div class="col-sm-6 input-column">
                    	<input class="form-control" type="text" name="username" value="<?php echo $username; ?>">
                    	<span class="help-block"><?php echo $username_err; ?></span>
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
                    <div class="col-sm-4 label-column"><label class="col-form-label" for="repeat-pawssword-input-field">Conferma Password</label></div>
                    <div class="col-sm-6 input-column">
                    	<input class="form-control" type="password" name="confirm_password" value="<?php echo $confirm_password; ?>">
                    	<span class="help-block"><?php echo $confirm_password_err; ?></span>
                    </div>
                </div>
                <input class="btn btn-light submit-button" type="submit" style="background-color:#5547f4;" value="Continua">
                <p> Non è la prima volta che fai l'accesso? <a href="login_user.php">Clicca
              qui</a>.</p>
            </form>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/Contact-FormModal-Contact-Form-with-Google-Map.js"></script>
    <script src="assets/js/Sidebar-Menu.js"></script>
</body>

</html>