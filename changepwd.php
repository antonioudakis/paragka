<?php
if (!isset($_SESSION)) { 
	session_start(); 
}

include 'paragka.php';
showHeader();
$user = new User();
$user->showNavBar();
if (!$user->isConnected()) {
	$user->showMessage("alert-warning","Σφάλμα!","Δεν μπορείτε να αλλάξετε το συνθηματικό κάποιου χρήστη εάν δεν έχετε κάνει πρώτα σύνδεση. Πατήστε <a href=\"http://".$user->getHost()."index.php\"> εδώ </a> για να συνδεθείτε");
} else {
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST['oldpwd']) && !empty($_POST['oldpwd'])) {
			if (isset($_POST['pwd']) && !empty($_POST['pwd'])) {
				if (isset($_POST['pwdconfirm']) && !empty($_POST['pwdconfirm'])) {
					if  ($_POST['pwd']!=$_POST['pwdconfirm']) {
						$user->showMessage("alert-danger","Προσοχή!","Το νέο συνθηματικό είναι διαφορετικό από την επιβεβαίωση του νέου συνθηματικού πρόσβασης");
						$user->showMenu();
				}	 else {
						try {
							$conn = $user->connect(); }
						catch (Exception $e) {
							$user->showMessage("alert-danger","Αποτυχία Αλλαγής Συνθηματικού!",$e->getMessage());
							$user->showMenu();
						}
						$strSQL = "select email from users where id = ".$_SESSION['userID']. " and pwd = '".md5($_POST['oldpwd'])."'";
						if ($result = mysqli_query($conn, $strSQL)) {
							if (mysqli_num_rows($result) > 0) {
								$row = mysqli_fetch_assoc($result);
								$email = $row['email'];
								$oldPwd = $row['pwd'];
								try {
									$user->updatePwd($email, $_POST['pwd']);
									$user->showMessage("alert-success","Επιτυχής καταχώριση!","Έγινε επιτυχής αλλαγή του συνθηματικού πρόσβασης");
								} catch (Exception $e) {
									$user->showMessage("alert-danger","Αποτυχία Αλλαγής Συνθηματικού!",$e->getMessage());
									$user->showMenu();
								}
							} else {
								$user->showMenu();
								$user->showMessage("alert-danger","Αποτυχία Αλλαγής Συνθηματικού!","Το συνθηματικό πρόσβασης είναι διαφορετικό από τον παλιό συνθηματικό που δηλώσατε στη φόρμα αλλαγής συνθηματικού");
							}
							$user->disconnect($conn);
						} else {
							$user->showMenu();
							$user->showMessage("alert-danger","Αποτυχία Αλλαγής Συνθηματικού!","Σφάλμα κατά την εκτέλεση της SQL εντολής : ".$strSQL);
						}
					}
				} else {
					$user->showMenu();
					$user->showMessage("alert-danger","Αποτυχία Αλλαγής Συνθηματικού!","Δεν καταχωρίσατε επιβεβαίωση συνθηματικού");
				} 
			} else {
				$user->showMenu();
				$user->showMessage("alert-danger","Αποτυχία Αλλαγής Συνθηματικού!","Δεν καταχωρίσατε νέο συνθηματικό");
			}
		} else {
			$user->showMenu();
			$user->showMessage("alert-danger","Αποτυχία Αλλαγής Συνθηματικού!","Δεν καταχωρίσατε το παλιό συνθηματικό");
		}
	} else {
		$user->showMenu();
	}		
}
showFooter();
?>
