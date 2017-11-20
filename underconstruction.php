<?php
if (!isset($_SESSION)) { 
	session_start(); 
}
include 'paragka.php';
showHeader();
$user = new User();
$user->showNavBar();
echo "	<div class=\"container text-center\">
			</br>
			<img src=\"./img/underconstruction.png\" class=\"img-thumbnail\" height=\"350\" width=\"350\" alt=\"UnderConstruction\">
		</div>
		<div>
			</br>
			<p align=\"center\">Πατήστε <a href=\"http://".$user->getHost()."index.php\"> εδώ </a> για να επιστρέψετε στη σελίδα επιλογών</p>
		</div>";
showFooter();
?>
