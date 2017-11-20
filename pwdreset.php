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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['email']) && !empty($_POST['email'])) {
		try {
			$response = $user->existUser($_POST['email']);
		} catch (Exception $e) {
			$user->showMessage("alert-danger","Σφάλμα!",$e->getMessage());
			$user->showPwdResetForm();
		}
		if ($response==1){	
			$to = $_POST['email'];
			$subject =	"Paragka : Reset Password";
			//$subject = mb_convert_encoding($subject, "UTF-8","UTF-8, ISO-8859-7");
			$newPwd = getRandomString(8);
			$message =	"	<p>Ο προσωρινός σας κωδικός είναι ο : <strong> ".$newPwd." </strong> Ο παλιός κωδικός δεν ισχύει πλέον.</p>
									<p>Παρακαλώ πατήστε <a href=\"http://".$user->getHost()."index.php\"> εδώ </a> για να συνδεθείτε και να ορίσετε ένα νέο συνθηματικό το συντομότερο.</p>";
			$headers="From:tant@mail.ntua.gr\r\n"."Content-Type: text/html; charset=UTF-8\r\n";
			mail($to, $subject, $message, $headers);
			try {
				$user->updatePwd($_POST['email'], $newPwd);
			} catch (Exception $e) {
				$user->showMessage("alert-warning","Σφάλμα!","Προέκυψε σφάλμα κατά την διαδικασία ενημέρωσης της βάσης με το νέο συνθηματικό");
				$user->showLoginForm();
			}
			$user->showMessage("alert-success","Επιτυχής αποστολή!","Έχουν σταλεί στο email <strong> ".$_POST['email']." </strong>οδηγίες για τη σύνδεση στο σύστημα.");
			$user->showLoginForm();
		} else {
			$user->showMessage("alert-danger","Προσοχή!","Δεν υπάρχει χρήστης με το email που δώσατε.");
			$user->showPwdResetForm();
		} 
	} else {
		$user->showMessage("alert-danger","Προσοχή!","Δεν έχει οριστεί email χρήστη για την επαναφορά του κωδικού σύνδεσης");
		$user->showPwdResetForm();
	}
} else {
	$user->showPwdResetForm();
}
showFooter();
?>