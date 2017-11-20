<?php
if (!isset($_SESSION)) { 
	session_start(); 
}

include 'paragka.php';
showHeader();
$user = new User();
$user->showNavBar();
$user->showMenu();
showFooter();
?>
