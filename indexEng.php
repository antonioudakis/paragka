<?php
session_start();
include 'ntuaris.php';
echo $header;
$user = new User();
$user->setLang('eng');
if (!$user->isConnected()) {
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$validInput = false;
		if (isset($_POST['username']) && !empty($_POST['username'])) {
			if (isset($_POST['pwd']) && !empty($_POST['pwd'])) {
				$validInput = true;
			}
		}
		if (!$validInput) {
			echo $user->getNavBar();
			$user->showMessage("alert-danger","<strong>Προσοχή!</strong> Πρέπει να συμπληρωθούν τα απαιτούμενα στοιχεία");
			echo $user->getLoginForm();
		} else {
			$user->login($_POST["username"], $_POST["pwd"]);
		
			if ($user->getId() == null) {
				echo $user->getNavBar();
				$user->showMessage("alert-danger","<strong>Προσοχή!</strong> Το όνομα χρήστη ή ο κωδικός είναι λάθος");
				echo $user->getLoginForm();
			} else {
				if (!$user->isActive()){
					echo $user->getNavBar();
					$user->showMessage("alert-danger","<strong>Προσοχή!</strong> Δεν έχετε ενεργοποιήσει τον λογαριασμό. Ενεργοποιήστε τον λογαριασμό μέσω του συνδέσμου που σας έχει σταλεί στο ηλεκτρονικό σας ταχυδρομείο με διεύθυνση ".$user->getEmail());
					echo $user->getLoginForm();
				} else {
					if (isset($_POST['remember']) && !empty($_POST['remember'])) {
						setcookie("ntuarisUser", $_POST['username'], time() + (10*365*24*60*60), "/"); 
						setcookie("ntuarisPwd", $_POST['pwd'], time() + (10*365*24*60*60), "/"); 
					}	else {
						if (isset($_COOKIE['ntuarisUser'])) {
							if ($_COOKIE['ntuarisUser'] == $_POST['username']) {
								setcookie("ntuarisUser", "", time() - 3600, "/"); 
								setcookie("ntuarisPwd", "", time() - 3600, "/"); 
							}
						}
					}
					echo $user->getNavBar();
					echo $user->getMenu();
				}
			}
		}
	} else {
		echo $user->getNavBar();
		echo $user->getLoginForm();
	}
} else {
	echo $user->getNavBar();
	echo $user->getMenu();
}
echo getFooter('gr');
?>
