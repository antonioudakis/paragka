<?php
$host = "147.102.213.13/paragka/";
$dbhost = "localhost";
$port = "3302";
$dbname = "paragka";
$dbuser = "root";
$dbpwd = "ker@me$4";
//ini_set('log_errors','On');
ini_set('display_errors','Off');
//ini_set('error_reporting', E_ALL );
//define('WP_DEBUG', false);
//define('WP_DEBUG_LOG', true);
//define('WP_DEBUG_DISPLAY', false);
						
$pwdModal = "	<!-- Modal -->
							<div class=\"modal fade\" id=\"pwdModal\" role=\"dialog\">
								<div class=\"modal-dialog\">
    
									<!-- Modal content-->
									<div class=\"modal-content\">
										<div class=\"modal-header\">
											<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
											<h4 class=\"modal-title\">Αλλαγή Συνθηματικού</h4>
										</div>
										<div class=\"modal-body\">
											<div id=\"msg\" class=\"alert alert-danger alert-dismissable fade in\" style=\"display:none\">
												<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
												<p id=\"msgtext\"></p>
											</div>
											<form action=\"http://".$host."changepwd.php\" method=\"post\">
												<div class=\"form-group\">
													<label for=\"oldpwd\">Παλιό Συνθηματικό:</label>
													<input type=\"password\" class=\"form-control\" id=\"oldpwd\" placeholder=\"Εισαγωγή παλιού συνθηματικού\" name = \"oldpwd\" required>
												</div>
												<div class=\"form-group\">
													<label for=\"pwd\">Νέο Συνθηματικό:</label>
													<input type=\"password\" class=\"form-control\" id=\"pwd\" placeholder=\"Εισαγωγή νέου συνθηματικού\" size = \"25\" name = \"pwd\" required>
												</div>
												<div class=\"form-group\">
													<label for=\"pwdconfirm\">Επιβεβαίωση Συνθηματικού:</label>
													<input type=\"password\" class=\"form-control\" id=\"pwdconfirm\" placeholder=\"Επιβεβαίωση συνθηματικού\" size = \"25\" name = \"pwdconfirm\" onchange=\"pwdConfirmation() \" required>
												</div>
												<div align=\"right\">
													<button type=\"button\" class=\"btn btn-info\" data-dismiss=\"modal\">Άκυρο</button>
													<button type=\"submit\" class=\"btn btn-info\">Ενημέρωση</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>";
							
function showHeader(){
	$header = "<!DOCTYPE html>
					<html lang=\"el\">
						<head>
							<title>paragka</title>
							<meta charset=\"utf-8\">
							<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
							<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\">
							<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js\"></script>
							<script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>
							<script src=\"paragka.js\"></script>
							<style>
   
							/* Set black background color, white text and some padding */
	
							body {
								margin-bottom:50px;
								color:white;
							}
	
							    
							footer {
								position:fixed;
								width:100%;;
								height:20px;
								bottom:0px;
								margin-auto;
								background-color: #555;
								color: white;
								padding:2px;
								font-size:0.8em;
							}
							
							form {
								border-style: solid;
								border-width: 1px;
								border-color: gray;
								padding: 10px;
								background-color: #f5f5ef;
								color:black;
							}
							
							.error {
								color: #FF0000;
							}
							
							h4 {
								color:#33ff33;
								text-shadow: 2px 2px 4px black;
								font-style: italic;
								letter-spacing: 3px;
								width:100%;
								margin-left:auto;
								margin-right:auto;
							}
							
							
							</style>				
							
						</head>
						<body background=\"./img/court.jpg\">";
	echo $header;
}
							
function showFooter() {
	$footer =	" 	<footer class=\"container-fluid text-center\">
							<p style=\"text-align:center\"><i><span class=\"glyphicon glyphicon-copyright-mark\"></span> Θοδωρής Αντωνιουδάκης</i></p>
						</footer>
					</body>
				</html>";
	echo $footer;
}

function getCookie($cookie_name){
	if (!isset($_COOKIE[$cookie_name])) {
		return null;
	} else {
		return $_COOKIE[$cookie_name];
	}
}

function setChecked($cookie_name){
	if (!isset($_COOKIE[$cookie_name])) {
		return null;
	} else {
		return " checked ";
	}
}

function getRandomString($chars) {
	$str = "";
	$char;
	for ($i=0;$i<$chars;$i++) {
		$char=rand(0,61);
		if ($char<10) {
			$char += 48;
		} elseif ($char<36) {
			$char += 55;
		} else {
			$char += 61;
		}
		$str .= chr($char);
	}
	return $str;
}


	
function downloadFile($fname,$type,$txt){
	// $type == 0 pdf else csv
	global $host;
	if ($type == 0) {
		require('C:/PHP/tcpdf/tcpdf.php');
		$pdf = new TCPDF();
		//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage('P','A4');
		$pdf->SetFont('DejaVuSans', '', 12);
		$pdf->WriteHTML($txt);
		$pdf->Output($fname,'D');
	} else {
		$file = fopen($fname, "w") or die("Unable to open file!");
		fwrite($file, $txt);
		fclose($file);
		$file_url="http://".$host.$fname;

		header('Content-Encoding: UTF-8');
		header('Content-type: text/csv; charset=UTF-8');
		header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
		
		readfile($file_url);
	}
}

class User {
	private $host;
	private $dbhost;
	private $port;
	private $dbname;
	private $dbuser;
	private $dbpwd;
	private $id;
	private $email;
	private $pwd;
	private $hashCode;
	private $active;
	private $lastname;
	private $firstname;
	private $role;
	private $phoneNo;
	
	function __construct(){
		global $host, $dbhost, $port, $dbname, $dbuser, $dbpwd;
		$this->host = $host;
		$this->dbhost = $dbhost;
		$this->port = $port;
		$this->dbname = $dbname;
		$this->dbuser = $dbuser;
		$this->dbpwd = $dbpwd;
		//$this->login(null,null);
	}	
	
	function getHost(){
		return $this->host;
	}
	
	function getId() {
		return $this->id;
	}
	
	function getEmail() {
		return $this->email;
	}
	
	function getLastname() {
		return $this->lastname;
	}
	
	function getFirstname() {
		return $this->firstname;
	}
	
	function getPhoneNo() {
		return $this->phoneNo;
	}
	
	function getPwd() {
		return $this->pwd;
	}
	
	function connect() {
		// Check connection
		if ($conn = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpwd, $this->dbname)) {
			mysqli_set_charset($conn,"utf8");
			return $conn;
		} else {
			throw new Exception('Αδυναμία σύνδεσης με τη βάση');
		}
	} 
	
	function disconnect($conn) {
		mysqli_close($conn);
	}
	
	function login($email, $pwd){
		try {
			$conn = $this->connect(); }
		catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
		if ((isset($_SESSION['userID']))||($email!=null)) {
			if (isset($_SESSION['userID'])) {
				$strSQL = "select * from users where id = ".$_SESSION['userID'];
			} else {
				$strSQL = "select * from users where email = '".$email."' and pwd = '".md5($pwd)."'";
			}
			if ($result = mysqli_query($conn, $strSQL)) {
				if (mysqli_num_rows($result) > 0) {
					$row = mysqli_fetch_assoc($result);
					$this->id = $row['id'];
					$this->email = $row['email'];
					$this->pwd = $row['pwd'];
					$this->hashCode = $row['hashCode'];
					$this->active = $row['active'];
					$this->lastname = $row['lastname'];
					$this->firstname = $row['firstname'];
					$this->role = $row['role'];
					$this->phoneNo = $row['phoneNo'];
			
					if ($this->isActive()) {
						$_SESSION['userID'] = $this->id;
						$this->disconnect($conn);
					} else {
						$this->disconnect($conn);
						throw new Exception('Δεν έχετε ενεργοποιήσει τον λογαριασμό. Ενεργοποιήστε τον λογαριασμό μέσω του συνδέσμου που σας έχει σταλεί στο ηλεκτρονικό σας ταχυδρομείο με διεύθυνση '.$email);
					}
				} else {
					$this->disconnect($conn);
					throw new Exception('Το email χρήστη ή ο κωδικός είναι λάθος');
				}
			} else {
				throw new Exception('Σφάλμα κατά την εκτέλεση της SQL εντολής : '.$strSQL);
			}
		}			
	}
	
	function existUser($email){
		try {
			$conn = $this->connect();
		} catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
		$strSQL = "select id from users where email = '".$email."'";
		if ($result = mysqli_query($conn, $strSQL)) {
			if (mysqli_num_rows($result) > 0) {
				$this->disconnect($conn);
				return 1;
			} else {
				$this->disconnect($conn);
				return 0;
			}	
		} else {
			throw new Exception('Σφάλμα κατά την εκτέλεση της SQL εντολής : '.$strSQL);;
		}
	}
	
	function existPlayer($email){
		try {
			$conn = $this->connect();
		} catch (Exception $e) {
			throw new Exception ($e->getMessage());
		}
		$strSQL = "select id from players where email = '".$email."'";
		if ($result = mysqli_query($conn, $strSQL)) {
			if (mysqli_num_rows($result) > 0) {
				$this->disconnect($conn);
				throw new Exception('Υπάρχει ήδη παίκτης με το email που δώσατε. Χρησιμοποιήστε διαφορετικό email');
			} else {
				$this->disconnect($conn);
			}	
		} else {
			throw new Exception('Σφάλμα κατά την εκτέλεση της SQL εντολής : '.$strSQL);;
		}

	}
	
	function isConnected() {
		if (isset($_SESSION['userID'])) {
			return true;
		} else {
			return false;
		}
	}
	
	function getConnectedUserName(){
		return $this->lastname.' '.$this->firstname;
	}
	
	function isActive() {
		if ($this->active==1) {
			return true;
		} else {
			return false;
		}
	}
	
		
	function isAdministrator() {
		if ($this->role==1) {
			return false;
		} else {
			return true;
		}
	}
	
	function updatePwd($email, $pwd){
		try {
			$conn = $this->connect();
		} catch (Exception $e) {
			throw Exception($e->getMessage());
		}
		$strSQL = "update users set pwd = '".md5($pwd)."' where email = '".$email."'";
		if (mysqli_query($conn, $strSQL)) {
			$this->disconnect($conn);
		} else {
			$this->disconnect($conn);
			throw new Exception('Σφάλμα κατά την εκτέλεση της SQL εντολής : '.$strSQL);
		}
	}
	
	function insertUser($email, $pwd, $active, $lastname, $firstname, $role, $phoneNo) {
		try {
			$conn = $this->connect();
		} catch (Exception $e) {
			throw Exception($e->getMessage());
		}
		$strSQL = "insert into users(email,pwd,hashCode,active,lastname,firstname,role, phoneNo) values ('".$email."','".md5($pwd)."','".md5($email)."',".$active.",'".$lastname."','".$firstname."',".$role.",'".$phoneNo."');";
		if (mysqli_query($conn, $strSQL)) {
			$this->disconnect($conn);
		} else {
			$this->disconnect($conn);
			throw new Exception('Σφάλμα κατά την εκτέλεση της SQL εντολής : '.$strSQL);
		}
	}
	
	function insertPlayer($email, $active, $lastname, $firstname, $phoneNo) {
		try {
			$conn = $this->connect();
		} catch (Exception $e) {
			throw Exception($e->getMessage());
		}
		$strSQL = "insert into players(email,hashCode,active,lastname,firstname,phoneNo) values ('".$email."','".md5($email)."',".$active.",'".$lastname."','".$firstname."','".$phoneNo."');";
		if (mysqli_query($conn, $strSQL)) {
			$this->disconnect($conn);
		} else {
			$this->disconnect($conn);
			throw new Exception('Σφάλμα κατά την προσπάθεια εισαγωγής του παίκτη');
		}
	}
	
	function updateUser($email, $lastname, $firstname, $phoneNo) {
		try {
			$conn = $this->connect();
		} catch (Exception $e) {
			throw Exception($e->getMessage());
		}
		if ($this->isConnected()) {
			$strSQL = "update users set email = '".$email."',lastname = '".$lastname."',firstname ='".$firstname."', hashCode = '".md5($email)."', phoneNo ='".$phoneNo."' where id = ".$_SESSION['userID'];
			if (mysqli_query($conn, $strSQL)) {
				$this->email = $email;
				$this->lastname = $lastname;
				$this->firstname = $firstname;
				$this->phoneNo = $phoneNo;
				$this->disconnect($conn);
			} else {
				$this->disconnect($conn);
				throw new Exception("Σφάλμα κατά την διαδικασία ενημέρωσης των στοιχείων του χρήστη");
			}
		} else {
			throw new Exception("Δεν μπορείτε να ενημερώσετε το στοιχεία κάποιου χρήστη εάν δεν έχετε κάνει πρώτα σύνδεση. Πατήστε <a href=\"http://".$user->getHost()."index.php\"> εδώ </a> για να συνδεθείτε");
		}
	}
	
	function activateUser($email, $hashCode) {
		try {
			$conn = $this->connect();
		} catch (Exception $e) {
			throw new Exception($e>-getMessage());
		}
		$strSQL = "select email,hashCode from users where email = '".$email."' and hashCode ='".$hashCode."'";
		if 	($result = mysqli_query($conn, $strSQL)) {
			if (mysqli_num_rows($result) > 0) {
				$strSQL = "select email,hashCode,active from users where email = '".$email."' and hashCode ='".$hashCode."' and active = 1";
				if 	($result = mysqli_query($conn, $strSQL)) {
					if (mysqli_num_rows($result) > 0)  {
						throw new Exception('Ο χρήστης με email '.$email.' έχει ήδη ενεργοποιηθεί');
					} else {
						$strSQL = "update users set active = 1 where email = '".$email."' and hashCode='".$hashCode."'";
						if (!mysqli_query($conn, $strSQL)) {
							throw new Exception('Σφάλμα κατά την εκτέλεση της SQL εντολής : '.$strSQL);
						}
					}
				} else {
					throw new Exception('Σφάλμα κατά την εκτέλεση της SQL εντολής : '.$strSQL);
				}
			} else {
				throw new Exception('Δεν υπάρχει χρήστης με τα στοιχεία που δώσατε');
			}
		} else {
			throw new Exception('Σφάλμα κατά την εκτέλεση της SQL εντολής : '.$strSQL);
		}
	}
	
	function activatePlayer($email, $hashCode) {
		try {
			$conn = $this->connect();
		} catch (Exception $e) {
			throw new Exception($e>-getMessage());
		}
		$strSQL = "select email,hashCode from players where email = '".$email."' and hashCode ='".$hashCode."'";
		if 	($result = mysqli_query($conn, $strSQL)) {
			if (mysqli_num_rows($result) > 0) {
				$strSQL = "select email,hashCode,active from players where email = '".$email."' and hashCode ='".$hashCode."' and active = 1";
				if 	($result = mysqli_query($conn, $strSQL)) {
					if (mysqli_num_rows($result) > 0)  {
						throw new Exception('Ο παίκτης με email '.$email.' έχει ήδη ολοκληρώσει την διαδικασία δήλωσης συμμετοχής στο Εσωτερικό Πρωτάθλημα Paragka 2.');
					} else {
						$strSQL = "update players set active = 1 where email = '".$email."' and hashCode='".$hashCode."'";
						if (!mysqli_query($conn, $strSQL)) {
							throw new Exception('Σφάλμα κατά την εκτέλεση της SQL εντολής : '.$strSQL);
						}
					}
				} else {
					throw new Exception('Σφάλμα κατά την εκτέλεση της SQL εντολής : '.$strSQL);
				}
			} else {
				throw new Exception('Δεν υπάρχει χρήστης με τα στοιχεία που δώσατε');
			}
		} else {
			throw new Exception('Σφάλμα κατά την εκτέλεση της SQL εντολής : '.$strSQL);
		}
	}
	
	function showNavBar() {
		$navbar = "	<nav class=\"navbar navbar-inverse\">
						<div class=\"container-fluid\">
							<div class=\"navbar-header\">
								<button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#myNavbar\">
									<span class=\"icon-bar\"></span>
									<span class=\"icon-bar\"></span>
									<span class=\"icon-bar\"></span>                        
								</button>
								<a class=\"navbar-brand\" href=\"http://".$this->getHost()."\">paragka</a>
							</div>
							<div class=\"collapse navbar-collapse\" id=\"myNavbar\">
								<ul class=\"nav navbar-nav navbar-right\">";
		if (!$this->isConnected()) {
			$navbar = $navbar."		<li><a href=\"http://".$this->getHost()."SignIn.php\"><span class=\"glyphicon glyphicon-log-in\"></span> Σύνδεση </a></li>
									<li><a href=\"http://".$this->getHost()."signUp.php\"><span class=\"glyphicon glyphicon-file\"></span> Εγγραφή </a></li>
									<li><a href=\"http://".$this->getHost()."underconstruction.php\"><span class=\"glyphicon glyphicon-signal\"></span> Βαθμολογία </a></li>
								</ul>
							</div>
						</div>
					</nav>";
		} else {
			global $pwdModal;

			$navbar = $navbar."		<li><a href=\"http://".$this->getHost()."underconstruction.php\"><span class=\"glyphicon glyphicon-signal\"></span> Βαθμολογία </a></li>
									<li><a href=\"http://".$this->getHost()."underconstruction.php\"><span class=\"glyphicon glyphicon-pencil\"></span> Καταχώριση Αποτελέσματος </a></li>
									<li><a href=\"http://".$this->getHost()."underconstruction.php\"><span class=\"glyphicon glyphicon-envelope\"></span> Μηνύματα </a></li>
									<li class = \"dropdown\"><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\"><span class=\"glyphicon glyphicon-user\"></span> " .$this->getConnectedUserName()." <span class=\"caret\"></span></a>
										<ul class=\"dropdown-menu\">
											<li><a href=\"http://".$this->getHost()."updateUser.php\"><span class=\"glyphicon glyphicon-pencil\"> Επεξεργασία </span></a></li>
											<li><a href=\"#\" data-toggle=\"modal\" data-target=\"#pwdModal\"><span class=\"glyphicon glyphicon-pawn\"> Αλλαγή Συνθηματικού </span></a></li>
											<li><a href=\"http://".$this->getHost()."logout.php\"><span class=\"glyphicon glyphicon-log-out\"> Αποσύνδεση </span></a></li>
										</ul>
									</li>
								</ul>
							</div>
						</div>
					</nav>";
			$navbar = $navbar.$pwdModal;
		}
		echo $navbar;
	}
	
	function showLoginForm() {
		global $host;
		$loginForm = "	<div class=\"container text-center\">
									<div class=\"col-xs-4 text-right\">
										<img src=\"./img/ball.png\" class=\"img-circle\" alt=\"pyrforos\" width=\"45\" height=\"45\">
									</div>
									<div class=\"col-xs-8 text-left\">
										<h4>Εσωτερικό Πρωτάθλημα Ηλιούπολης - Παράγκα</h4>
									</div>
								</div>

								<div class=\"row\">
									<div class=\"col-xs-2\"></div>
									<div class=\"col-xs-8\">
										<h4>Σύνδεση Χρήστη</h4></br>
										<form action=\"".htmlspecialchars($_SERVER["PHP_SELF"])."\" method=\"post\">
											<div class=\"form-group\">
												<label for=\"email\"><span class=\"glyphicon glyphicon-user\"></span> Email Χρήστη:</label>
												<input type=\"email\" class=\"form-control\" id=\"username\" placeholder=\"Εισαγωγή Email Χρήστη\" size = \"35\" name = \"email\" value = \"".getCookie('email')."\" autocomplete=\"on\" required>
											</div>
											<div class=\"form-group\">
												<label for=\"pwd\"><span class=\"glyphicon glyphicon-lock\"></span> Συνθηματικό:</label>
												<input type=\"password\" class=\"form-control\" id=\"pwd\" placeholder=\"Εισαγωγή συνθηματικού\" size = \"25\" name = \"pwd\" value = \"".getCookie('pwd')."\" required>
											</div>
											<div>
												<a href=\"http://".$this->getHost()."pwdreset.php\">Επαναφορά Συνθηματικού</a>
											</div>
											<div align=\"right\">
												</br>
												<button type=\"button\" class=\"btn btn-info\" name=\"cancel\" value =\"cancel\" onClick=\"window.location='http://".$host."index.php';\">Άκυρο</button>
												<button type=\"submit\" class=\"btn btn-info\">Σύνδεση</button>
											</div>
										</form>
									</div>
									<div class=\"col-xs-2\"></div>
								</div>";
								/*<div class=\"checkbox\">
									<label><input type=\"checkbox\" name =\"remember\" ".setChecked('email')."> Να με θυμάσαι</label>
								</div>*/
		echo $loginForm;	
	}
	
	function showSignUpForm(){
		global $host;
		$signUpForm= "	<div id=\"msg\" class=\"alert alert-danger alert-dismissable fade in\" style=\"display:none\">
								<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
								<p id=\"msgtext\"></p>
							</div>
							<div class=\"container\">
								<div>
									<div><h4><p>Εγγραφή στο Εσωτερικό Πρωτάθλημα Παράγκα 2</p></h4></div>
									<div class=\"well\">
										<form action=\"".htmlspecialchars($_SERVER["PHP_SELF"])."\" method=\"post\">
											<div class=\"form-group\">
												<label for=\"email\">Email: <span style=\"color:red\">*</span></label>
												<input type=\"email\" class=\"form-control\" id=\"email\" placeholder=\"Εισαγωγή Email\" name = \"email\"";
		if (isset($_POST['email'])) {
			$signUpForm .= " value = \"".$_POST['email']."\"";
		}
		$signUpForm.= " autocomplete=\"on\" required>
											</div>";
											/*<div class=\"form-group\">
												<label for=\"pwd\">Συνθηματικό:</label>
												<input type=\"password\" class=\"form-control\" id=\"pwd\" placeholder=\"Εισαγωγή συνθηματικού\" size = \"25\" name = \"pwd\" required>
											</div>
											<div class=\"form-group\">
												<label for=\"pwdconfirm\">Επιβεβαίωση Συνθηματικού:</label>
												<input type=\"password\" class=\"form-control\" id=\"pwdconfirm\" placeholder=\"Επιβεβαίωση συνθηματικού\" size = \"25\" name = \"pwdconfirm\" onchange=\"pwdConfirmation() \" required>
											</div>*/
		$signUpForm.= "
											<div class=\"form-group\">
												<label for=\"lastname\">Επώνυμο: <span style=\"color:red\">*</span></label>";
											//	<input type=\"text\" class=\"form-control\" id=\"lastname\" placeholder=\"Εισαγωγή Επωνύμου\" name = \"lastname\" onkeyup=\"upperCase('lastname')\"";
		$signUpForm.= "							<input type=\"text\" class=\"form-control\" id=\"lastname\" placeholder=\"Εισαγωγή Επωνύμου\" name = \"lastname\"";
		if (isset($_POST['lastname'])) {
			$signUpForm .= " value = \"".$_POST['lastname']."\"";
		}
		$signUpForm.= "required>			
											</div>
											<div class=\"form-group\">
												<label for=\"firstname\">Όνομα: <span style=\"color:red\">*</span></label>";
											//	<input type=\"text\" class=\"form-control\" id=\"firstname\" placeholder=\"Εισαγωγή Ονόματος\" name = \"firstname\" onkeyup=\"upperCase('firstname')\"";
		$signUpForm.= "							<input type=\"text\" class=\"form-control\" id=\"firstname\" placeholder=\"Εισαγωγή Ονόματος\" name = \"firstname\"";
		if (isset($_POST['firstname'])) {
			$signUpForm .= " value = \"".$_POST['firstname']."\"";
		}
		$signUpForm.= "required>		
											</div>
											<div class=\"form-group\">
												<label for=\"phoneNo\">Τηλέφωνο:</label>
												<input type=\"text\" class=\"form-control\" id=\"phoneNo\" placeholder=\"Εισαγωγή Τηλεφώνου\" name = \"phoneNo\"";
		if (isset($_POST['phoneNo'])) {
			$signUpForm .= " value = \"".$_POST['phoneNo']."\"";
		}
		$signUpForm.= " maxlength=\"10\">
											</div>
											<p class=\"error\">* Υποχρεωτικά πεδία</p>
											<div align=\"right\">
												<button type=\"button\" class=\"btn btn-info\" name=\"cancel\" value =\"cancel\" onClick=\"window.location='http://users.ntua.gr/tant/paragka';\">Άκυρο</button>
												<button type=\"submit\" class=\"btn btn-info\">Εγγραφή</button>
											</div>
										</form>
									</div>
								</div>
							</div>";
		echo $signUpForm;
	}
	
	function showPwdResetForm() {
		$emailForm = "	<div id=\"msg\" class=\"alert alert-danger alert-dismissable fade in\" style=\"display:none\">
									<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
									<p id=\"msgtext\"></p>
								</div>
								<div class=\"container\">
									<h4>Επαναφορά Συνθηματικού</h4>
									<form action=\"".htmlspecialchars($_SERVER["PHP_SELF"])."\" method=\"post\">
										<div class=\"form-group\">
											<p>Θα λάβετε έναν προσωρινό κωδικό στο email που δηλώσετε</p>
											<label for=\"email\"><span class=\"glyphicon glyphicon-envelope\"></span> Email χρήστη:</label>
											<input type=\"email\" class=\"form-control\" id=\"email\" placeholder=\"Εισαγωγή Email\" name = \"email\" autocomplete=\"on\">
										</div>
										<div align=\"right\">
											<button type=\"button\" class=\"btn btn-info\" name=\"cancel\" value =\"cancel\" onClick=\"window.location='http://".$this->getHost()."index.php';\">Άκυρο</button>
											<button type=\"submit\" class=\"btn btn-info\">Αποστολή</button>
										</div>
									</form>
								</div>";
		echo $emailForm;
	}
	
	function showUpdateUserForm(){
		$updateUserForm= "	<div id=\"msg\" class=\"alert alert-danger alert-dismissable fade in\" style=\"display:none\">
								<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
								<p id=\"msgtext\"></p>
							</div>
							<div class=\"container\">
								<div>
									<div><h4><p>Ενημέρωση Στοιχείων Χρήστη</p></h4></div>
									<div class=\"well\">
										<form action=\"".htmlspecialchars($_SERVER["PHP_SELF"])."\" method=\"post\">
											<div class=\"form-group\">
												<label for=\"email\">Email:</label>
												<input type=\"email\" class=\"form-control\" id=\"email\" placeholder=\"Εισαγωγή Email\" name = \"email\" value = \"".$this->email."\" readonly autocomplete=\"on\">
											</div>
											<div class=\"form-group\">
												<label for=\"lastname\">Επώνυμο:</label>
												<input type=\"text\" class=\"form-control\" id=\"lastname\" placeholder=\"Εισαγωγή Επωνύμου\" name = \"lastname\" onkeyup=\"upperCase('lastname')\" value = \"".$this->lastname."\">
											</div>
											<div class=\"form-group\">
												<label for=\"firstname\">Όνομα:</label>
												<input type=\"text\" class=\"form-control\" id=\"firstname\" placeholder=\"Εισαγωγή Ονόματος\" name = \"firstname\" onkeyup=\"upperCase('firstname')\" value = \"".$this->firstname."\">
											</div>
											<div class=\"form-group\">
												<label for=\"phoneNo\">Τηλέφωνο:</label>
												<input type=\"text\" class=\"form-control\" id=\"phoneNo\" placeholder=\"Εισαγωγή Τηλεφώνου\" name = \"phoneNo\" value = \"".$this->phoneNo."\" maxlength=\"10\">
											</div>
											<div align=\"right\">
												<button type=\"button\" class=\"btn btn-info\" name=\"cancel\" value =\"cancel\" onClick=\"window.location='http://".$this->getHost()."index.php';\">Άκυρο</button>
												<button type=\"submit\" class=\"btn btn-info\">Ενημέρωση</button>
											<div align=\"right\">
										</form>
									</div>
								</div>
							</div>";
		echo $updateUserForm;
	}
	
	function showMenu() {
		global $host;
		$menu = "	<div class=\"container-fluid text-center\">
						<div class=\"col-xs-4 text-right\">
							<img src=\"./img/ball.png\" class=\"img-circle\" alt=\"pyrforos\" width=\"45\" height=\"45\">
						</div>
						<div class=\"col-xs-8 text-left\">
							<h4>Εσωτερικό Πρωτάθλημα Ηλιούπολης - Παράγκα</h4></br></br><br>
						</div>
					</div>";
		if (!$this->isConnected()) {	
			$menu = $menu."	<div class=\"container-fluid text-center\">
								<div class=\"col-xs-5 text-right\">
									<a href=\"http://".$host."SignIn.php\"><img src=\"./img/signIn.jpg\" class=\"img-thumbnail\" height=\"65\" width=\"65\" alt=\"Σύνδεση\"></a>
								</div>
								<div class=\"col-xs-7 text-left\">
									<h4><a href=\"http://".$host."signIn.php\">Σύνδεση</a></h4>
									</br>
								</div>
							</div>";
							
			$menu = $menu."	<div class=\"container-fluid text-center\">
								<div class=\"col-xs-5 text-right\">
									<a href=\"http://".$host."signUp.php\"><img src=\"./img/signUp.jpg\" class=\"img-thumbnail\" height=\"65\" width=\"65\" alt=\"Εγγραφή\"></a>
								</div>
								<div class=\"col-xs-7 text-left\">
									<h4><a href=\"http://".$host."signUp.php\">Εγγραφή</a></h4>
									</br>
								</div>
							</div>";

			$menu = $menu."	<div class=\"container-fluid text-center\">
								<div class=\"col-xs-5 text-right\">
									<a href=\"http://".$host."underconstruction.php\"><img src=\"./img/ranking.jpg\" class=\"img-thumbnail\" height=\"65\" width=\"65\" alt=\"Βαθμολογία\"></a>
								</div>
								<div class=\"col-xs-7 text-left\">
									<h4><a href=\"http://".$host."underconstruction.php\">Βαθμολογία</a></h4>
									</br>
								</div>
							</div>";
		} else {
			$menu = $menu."	<div class=\"container-fluid text-center\">
								<div class=\"col-xs-5 text-right\">
									<a href=\"http://".$host."underconstruction.php\"><img src=\"./img/ranking.jpg\" class=\"img-thumbnail\"  width=\"65\" alt=\"Βαθμολογία\"></a>
								</div>
								<div class=\"col-xs-7 text-left\">
									<h4><a href=\"http://".$host."underconstruction.php\">Βαθμολογία</a></h4>
									</br>
								</div>
							</div>";
			
			$menu = $menu."	<div class=\"container-fluid text-center\">
								<div class=\"col-xs-5 text-right\">
									<a href=\"http://".$host."underconstruction.php\"><img src=\"./img/results.jpg\" class=\"img-thumbnail\" width=\"65\" alt=\"Καταχώριση Αποτελέσματος\"></a>
								</div>
								<div class=\"col-xs-7 text-left\">
									<h4><a href=\"http://".$host."underconstruction.php\">Καταχώριση Αποτελέσματος</a></h4>
									</br>
								</div>
							</div>";
							
			$menu = $menu."	<div class=\"container-fluid text-center\">
								<div class=\"col-xs-5 text-right\">
									<a href=\"http://".$host."underconstruction.php\"><img src=\"./img/messages.jpg\" class=\"img-thumbnail\" width=\"65\" alt=\"Μηνύματα\"></a>
								</div>
								<div class=\"col-xs-7 text-left\">
									<h4><a href=\"http://".$host."underconstruction.php\">Μηνύματα</a></h4>
									</br>
								</div>
							</div>";
			
			$menu = $menu."	<div class=\"container-fluid text-center\">
								<div class=\"col-xs-5 text-right\">
									<a href=\"http://".$host."logout.php\"><img src=\"./img/logout.png\" class=\"img-thumbnail\"  width=\"65\" alt=\"Έξοδος\"></a>
								</div>
								<div class=\"col-xs-7 text-left\">
									<h4><a href=\"http://".$host."logout.php\">Αποσύνδεση</a></h4>
									</br>
								</div>
							</div>";

		}
		echo $menu;
	}

	
	function showMessage($alertType, $alertMessage, $alertExplanation) {
		echo  "<div class=\"container-fluid\">
					<div class=\"alert ".$alertType." alert-dismissable fade in\">
						<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
						<p id=\"msgtext\"><strong> ".$alertMessage." </strong> ".$alertExplanation." </p>
					</div>
				</div>";
	}
	
	function createMessage($alertType, $alertMessage) {
			return  "	<div class=\"alert ".$alertType." alert-dismissable fade in\">
								<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
								<p id=\"msgtext\">".$alertMessage."</p>
							</div>";
	}
	
}
?>