<?php
session_start();
session_unset(); 
session_destroy(); 
include 'ntuaris.php';
echo $header;
$user = new User();
echo $user->getNavBar();
$validInput = false;
if (isset($_POST['email']) && !empty($_POST['email'])) {
	if (isset($_POST['remind']) && !empty($_POST['remind'])) {
		$validInput = true;
	}
}

if (!$validInput) {
	$user->showMessage("alert-danger","<strong>Προσοχή!</strong> Δεν έχει δoθεί email για να σταλούν οι οδηγίες");
	if ($_POST['remind']=='username') {
		echo sendEmailForm(0);
	} elseif ($_POST['remind']=='password') {
		echo sendEmailForm(1);
	} else {
		$user->showMessage("alert-danger","<p><strong>Προσοχή!</strong> Δεν έχετε ορίσει τύπο υπενθύμισης. Πατήστε <a href=\"http://".$user->getHost()."index.php\"> εδώ </a> για να επιστρέψετε στην φόρμα σύνδεσης.</p>");
	}
} else {
	
	$user->getUserDataByEmail($_POST['email']);

	if ($user->getId() ==null) {
		$user->showMessage("alert-danger","<strong>Προσοχή!</strong> Το email που δώσατε δεν αντιστοιχεί σε κάποιον χρήστη. Δοκιμάστε με διαφορετικό email");
		if ($_POST['remind']=='username') {
			echo sendEmailForm(0);
		} else {
			echo sendEmailForm(1);
		}
	} else {
		if ($_POST['remind']=='username') {
			$to = $_POST['email'];
			$subject =	"Υπενθύμιση Ονόματος Χρήστη";
			$subject = mb_convert_encoding($subject, "UTF-8","UTF-8, ISO-8859-7");
			$message =	"	<p>Το όνομα χρήστη που χρησιμοποιείται στις Ηλεκτρονικές Υπηρεσίες του Ε.Μ.Π είναι : <strong> ".$user->getUsername()."</strong></p></br>
									<p>Πατήστε <a href=\"http://".$user->getHost()."index.php\"> εδώ </a> για να συνδεθείτε</p>";
			$headers="From:tant@mail.ntua.gr\r\n"."Content-Type: text/html; charset=UTF-8\r\n";
			mail($to, $subject, $message, $headers);
			$user->showMessage("alert-success","<strong>Επιτυχής αποστολή!</strong> Έχουν σταλεί στο email <strong> ".$_POST['email']." </strong> οδηγίες για τη σύνδεση στο σύστημα.");
			echo $user->getLoginForm();
		} else {
			$to = $_POST['email'];
			$subject =	"Επαναφορά Συνθηματικού";
			$subject = mb_convert_encoding($subject, "UTF-8","UTF-8, ISO-8859-7");
			$newPwd = getRandomString(8);
			$message =	"	<p>Ο προσωρινός σας κωδικός είναι ο : <strong> ".$newPwd." </strong> Ο παλιός κωδικός δεν λειτουργεί πλέον.</p>
									<p>Παρακαλώ πατήστε <a href=\"http://".$user->getHost()."index.php\"> εδώ </a> για να συνδεθείτε και να ορίσετε ένεν νέο συνθηματικό το συντομότερο.</p>";
			$headers="From:tant@mail.ntua.gr\r\n"."Content-Type: text/html; charset=UTF-8\r\n";
			mail($to, $subject, $message, $headers);
			if ($user->updatePwd($newPwd)) {
				$user->showMessage("alert-success","<strong>Επιτυχής αποστολή!</strong> Έχουν σταλεί στο email <strong> ".$_POST['email']." </strong>οδηγίες για τη σύνδεση στο σύστημα.");
			} else {
				$user->showMessage("alert-warning","<strong>Σφάλμα!</strong> Προέκυψε σφάλμα κατά την διαδικασία ενημέρωσης της βάσης με το νέο συνθηματικό");
			}
			echo $user->getLoginForm();
		}
	}
}
echo getFooter('gr');
?>
