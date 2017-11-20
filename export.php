<?php
session_start();
include 'ntuaris.php';
$user = new User();
if (isset($_GET['file']) && !empty($_GET['file'])) {
	if ($_GET['school'] == 4) {
				$db = "met04odbc";
			} else {
				$db = "base0".$_GET['school']."odbc";
			}
			if  (($_GET['school'] == 2)||($_GET['school'] == 8)) {
				$pwd = "m16e@gle";
			} else {
				$pwd = "sysadm";
			}
			$connect = odbc_connect($db, "sysadm", $pwd);
			if ($connect) {
				if ($_GET['query'] == "met_active") {
					$txt = "ΕΝΕΡΓΟΙ ΜΕΤΑΠΤΥΧΙΑΚΟΙ ΦΟΙΤΗΤΕΣ ΑΝΑ ΦΥΛΟ ΚΑΙ ΕΤΟΣ ΓΕΝΝΗΣΗΣ ( ΑΚ ".$_GET['ak']." );
";
					$strSQL = "	select metprogram.progcode as progcode, metprogram.titlos AS titlos,@if(1-sex,'ΘΗΛΕΙΣ',@if(2-sex,'ΑΡΡΕΝΕΣ',sex)) as sex,@year(birthdate) as year_birth,count(*) as synolo 
										from metstuprog, met,metprogram 
										where metstuprog.mitroo = met.mitroo and metstuprog.progcode = metprogram.progcode
													and metstuprog.ak <=".$_GET['ak']."  and (met.erasmus is null or met.erasmus ='2') and (metstuprog.dateanag is null or metstuprog.dateanag >= '01-SEP-".$_GET['ak']."') 
													and metstuprog.mitroo not in (select mitroo from metdiakop where metdiakop.progcode = metstuprog.progcode and dateapo < '01-SEP-".$_GET['ak']."' and dateeos is null) group by 1,2,3,4 order by 1,2,3,4 desc"; 
				} elseif ($_GET['query'] == "met_new") {
					$txt = "ΝΕΟΕΙΣΑΧΘΕΝΤΕΣ ΜΕΤΑΠΤΥΧΙΑΚΟΙ ΦΟΙΤΗΤΕΣ ΑΝΑ ΦΥΛΟ ΚΑΙ ΕΤΟΣ ΓΕΝΝΗΣΗΣ ( ΑΚ ".$_GET['ak']." );
";
					$strSQL = "	select metstuprog.progcode as progcode,metprogram.titlos as titlos,@if(1-sex,'ΘΗΛΕΙΣ',@if(2-sex,'ΑΡΡΕΝΕΣ',sex)) as sex,@year(birthdate) as year_birth,count(*) as synolo 
										from metstuprog,met,metprogram
										where metstuprog.mitroo = met.mitroo and metstuprog.progcode = metprogram.progcode
												and metstuprog.ak =".$_GET['ak']." and (met.erasmus is null or met.erasmus ='2')  group by 1,2,3,4 order by 1,2,3,4 desc";	
				} elseif ($_GET['query'] =="met_dipl") {
					$txt = "ΑΝΑΓΟΡΕΥΜΕΝΟΙ ΜΕΤΑΠΤΥΧΙΑΚΟΙ ΦΟΙΤΗΤΕΣ ΑΝΑ ΦΥΛΟ ΚΑΙ ΕΤΟΣ ΓΕΝΝΗΣΗΣ ( ΑΚ ".$_GET['ak']." );
";
					$strSQL = "	select metstuprog.progcode as metprogram, metprogram.titlos as titlos,@if(1-sex,'ΘΗΛΕΙΣ',@if(2-sex,'ΑΡΡΕΝΕΣ',sex)) as sex,@year(birthdate) as year_birth,count(*) as synolo
										from metstuprog,met,metprogram
										where metstuprog.mitroo = met.mitroo and metstuprog.progcode = metprogram.progcode
											and metstuprog.ak <=".$_GET['ak']."  and (met.erasmus is null or met.erasmus ='2')  and (metstuprog.dateanag between '01-SEP-".($_GET['ak']-1)."' and '31-AUG-".$_GET['ak']."') group by 1,2,3,4 order by 1,2,3,4 desc";
				}
				$txt .= "ΠΡΟΓΡΑΜΜΑ;ΦΥΛΟ;ΕΤΟΣ ΓΕΝΝΗΣΗΣ;ΣΥΝΟΛΟ;
";				
				$txt = mb_convert_encoding($txt, "ISO-8859-7","UTF-8, ISO-8859-7");
				$result = odbc_exec($connect, $strSQL);
				while (odbc_fetch_row($result)) {
					$program = odbc_result($result, 2);
					$program = mb_convert_encoding($program, "ISO-8859-7","UTF-8, ISO-8859-7");
					$sex = odbc_result($result, 3);
					$sex = mb_convert_encoding($sex, "ISO-8859-7","UTF-8, ISO-8859-7");
					$year = odbc_result($result, 4);
					if ($year != null) {
						$year += 1900;
					}
					$sum = odbc_result($result, 5);
					$txt .= $program.";".$sex.";".$year.";".$sum.";
";
				}
				if ($_GET['file'] == 'txt') {
					downloadFile('output.csv',1,$txt);
				}
			}
		} else {
	echo $header;
	echo $user->getNavBar();
	$user->showMessage("alert-danger","<p><strong>Προσοχή!</strong> Δεν έχετε ορίσει τύπο υπενθύμισης. Πατήστε <a href=\"http://".$user->getHost()."stat.php\"> εδώ </a> για να επιστρέψετε στα στατιστικά φοιτητολογίου.</p>");
	echo getFooter('gr');
}
?>
