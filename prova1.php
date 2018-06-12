<?php
// Include config file
require_once 'config.php';
$rowSQL = mysqli_query($con, "SELECT * FROM ticket WHERE id_ticket=(SELECT MAX(id_ticket) FROM ticket)");
$largest = mysqli_fetch_array($rowSQL);
echo "Largest is: " . $largest;
?>