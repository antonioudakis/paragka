<?php
if (!isset($_SESSION)) { 
	session_start();
}
if (session_status()==PHP_SESSION_ACTIVE) {
	session_unset(); 
} 
include 'paragka.php';
header("Location: http://".$host);
?>
