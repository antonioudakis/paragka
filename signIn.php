<?php
if (!isset($_SESSION)) { 
	session_start(); 
}

include 'paragka.php';
showHeader();
$user = new User();
if (!$user->isConnected()) {
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		try {
			$user->login($_POST["email"], $_POST["pwd"]);
			//if (isset($_POST['remember']) && !empty($_POST['remember'])) {
				setcookie("email", $_POST['email'], time() + (10*365*24*60*60), "/"); 
				setcookie("pwd", $_POST['pwd'], time() + (10*365*24*60*60), "/"); 
			/*} else {
				if (isset($_COOKIE['email'])) {
					if ($_COOKIE['email'] == $_POST['email']) {
						setcookie("email", "", time() - 3600, "/"); 
						setcookie("pwd", "", time() - 3600, "/"); 
					}
				}
			}*/
			$user->showNavBar();
			$user->showMenu();
		} catch (Exception $e) {			
		    $user->showNavBar();
			$user->showMessage("alert-danger","Προσοχή!",$e->getMessage());
			$user->showMenu();
		}
	} else {
		$user->showNavBar();
		$user->showLoginForm();
	} 
} else {
	$user->showNavBar();
	$user->showMessage("alert-warning","Προσοχή!","Ο χρήστης με email ".$user->getEmail()." είναι ήδη συνδεδεμένος");
	$user->showMenu();
}
showFooter();
?>