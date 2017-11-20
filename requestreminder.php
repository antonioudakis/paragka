<?php
session_start();
session_unset(); 
session_destroy(); 
include 'ntuaris.php';
echo $header;
$user = new User();
echo $user->getNavBar();
if (isset($_GET['type']) && !empty($_GET['type'])) {
	if ($_GET['type'] == "username")  {
		echo sendEmailForm(0);
	} elseif ($_GET['type'] == "password") {
		echo sendEmailForm(1);
	} else {
		$user->showMessage("alert-danger","<p><strong>Προσοχή!</strong> Δεν έχετε ορίσει σωστό τύπο υπενθύμισης. Πατήστε <a href=\"http://".$user->getHost()."index.php\"> εδώ </a> για να επιστρέψετε στην φόρμα σύνδεσης.</p>");
	}
} else {
	$user->showMessage("alert-danger","<p><strong>Προσοχή!</strong> Δεν έχετε ορίσει τύπο υπενθύμισης. Πατήστε <a href=\"http://".$user->getHost()."index.php\"> εδώ </a> για να επιστρέψετε στην φόρμα σύνδεσης.</p>");
}
echo getFooter('gr');
?>
