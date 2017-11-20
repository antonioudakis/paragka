<?php
if (!isset($_SESSION)) { 
	session_start(); 
}

include 'paragka.php';
showHeader();
$user = new User();
$user->showNavBar();
if (!$user->isConnected()) {
	$user->showMessage("alert-warning","Σφάλμα!","Δεν μπορείτε να ενημερώσετε το στοιχεία κάποιου χρήστη εάν δεν έχετε κάνει πρώτα σύνδεση. Πατήστε <a href=\"http://".$user->getHost()."index.php\"> εδώ </a> για να συνδεθείτε");
} else {
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$validInput = false;
		if (isset($_POST['email']) && !empty($_POST['email'])) {
			if (isset($_POST['lastname']) && !empty($_POST['lastname'])) {
				if (isset($_POST['firstname']) && !empty($_POST['firstname'])) {
					$validInput = true;
				}
			}
		}
		if (!$validInput) {
			$user->showMessage("alert-warning","Προσοχή!","Πρέπει να συμπληρωθούν τα απαιτούμενα στοιχεία");
			$user->showUpdateUserForm();
		} else {
			try {
				$user->updateUser($_POST['email'], $_POST['lastname'], $_POST['firstname'], $_POST['phoneNo']);
				$user->showMessage("alert-success","Επιτυχής καταχώριση!","Τα στοιχεία του χρήστη με email <strong>".$_POST['email']."</strong> ενημερώθηκαν.");
				$user->showMenu();
			} catch (Exception $e) {
				$user->showMessage("alert-warning","Σφάλμα!","Παρουσιάστηκε σφάλμα κατά την ενημέρωση των στοιχείων του χρήστη με email <strong>".$_POST['email']."</strong>. ".$e->getMessage());
				$user->showMenu();
			}
		}
	} else {
		$user->showUpdateUserForm();
	}
}
showFooter();
?>
