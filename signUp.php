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
	try {
		$conn = $user->connect();
		$user->existPlayer($_POST['email']);
		$user->insertPlayer($_POST['email'], 0, $_POST['lastname'], $_POST['firstname'], $_POST['phoneNo']); 
		$to = $_POST['email'];
		$subject =	"Paragka - Confirmation of Participation";
		$hash = md5($_POST['email']);
		$message =	"<p>Για να ολοκληρωθεί η δήλωση συμμετοχής σας στο Εσωτερικό Πρωτάθλημα Paragka 2 πατήστε στον παρακάτω σύνδεσμο:</p><br/>
									<a href=\"http://".$host."activate.php?email=".$_POST['email']."&hashCode=".md5($_POST['email'])."\">http://".$host."activate.php?email=".$_POST['email']."&hashCode=".md5($_POST['email'])."</a>";
		$headers="From:t.antonioudakis@gmail.com\r\n"."Content-Type: text/html; charset=UTF-8\r\n";
		mail($to, $subject, $message, $headers);
		$user->showMessage("alert-success","Επιτυχής καταχώριση!","Ο παίκτης με email <strong>".$_POST['email']."</strong> καταχωρήθηκε. <br/>Για να ολοκληρωθεί η διαδικασία δήλωσης συμμετοχής διαβάστε το σχετικό email που σας έχει ήδη σταλεί στο email που υποδείξατε.");
	} catch (Exception $e) {
		$user->showMessage("alert-danger","Σφάλμα!",$e->getMessage());
		$user->showSignUpForm();
	}
} else {
	$user->showSignUpForm();
}
showFooter();
?>
