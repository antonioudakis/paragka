<?php
if (!isset($_SESSION)) { 
	session_start();
}
if (session_status()==PHP_SESSION_ACTIVE) {
	session_unset(); 
} 
include 'paragka.php';
showHeader();
$user = new User();
$user->showNavBar();
if (isset($_GET['email']) && !empty($_GET['email'])) {
	if (isset($_GET['hashCode']) && !empty($_GET['hashCode'])) {
		try {
			$user->activatePlayer($_GET["email"], $_GET["hashCode"]);
			$user->showMessage("alert-success","Ολοκλήρωση Δήλωσης Συμμετοχής!","Καταχωρήθηκε η δήλωση συμμετοχής του παίκτη με email <strong>".$_GET['email']."</strong>. <br/><br/>Σας ευχαριστούμε για τη συμμετοχή !!!<br/> <br/>Πατήστε <a href=\"http://users.ntua.gr/tant/paragka/\"> εδώ </a> για να μεταβείτε στην αρχική σελίδα της παράγκας");
		} catch (Exception $e) {
			$user->showMessage("alert-danger","Προσοχή!",$e->getMessage());
		}
	} else {
		$user->showMessage("alert-warning","Σφάλμα!","Παρουσιάστηκε σφάλμα κατά την διαδικασία ολοκλήρωσης δήλωσης συμμετοχής του παίκτη με email ".$_GET['email']);
	}
} else {
	$user->showMessage("alert-warning","Σφάλμα!","Παρουσιάστηκε σφάλμα κατά την διαδικασία ολοκλήρωσης δήλωσης συμμετοχής του παίκτη με email ".$_GET['email']);
}
showFooter();
?>
