<?php
session_start();
require_once("./functions/db.php");

// Redirect to a failure or retry page
header("Location: check_out.php?error=payment_failed");
?>
