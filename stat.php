<?php
session_start();
include 'ntuaris.php';
echo $header;
$user = new User();
echo $user->getNavBar();
if (!$user->isConnected()) {
	$user->showMessage("alert-danger","<strong>Προσοχή!</strong> Δεν υπάρχει σύνδεση. Πατήστε <a href=\"http://".$user->getHost()."index.php\"> εδώ </a> για να συνδεθείτε");
	echo getFooter('gr');
	die();
} 

function isActive($query) {
	if (!isset($_POST['query'])) {
		if ($query=='prop') {
			return true;
		} else {
			return false;
		}
	} else {
		if ($_POST['query']==$query) {
			return true;
		} else {
			return false;
		}
	}
}

function checkSelected($param, $value) {
	if ($param == 'school') {
		if (!isset($_POST[$param])) {
			if ($value==0) {
				return " selected ";
			} else {
				return null;
			}
		} else {
			if ($_POST[$param] == $value) {
				return " selected ";
			} else { 
				return null;
			}
		} 
	} elseif ($param == 'ak') {
		if (!isset($_POST[$param])) {
			if($value==date("Y")+1) {
				return " selected ";
			} else {
				return null;
			}
		} else {
			if ($_POST[$param] == $value) {
				return " selected ";
			} else {
				return null;
			}
		}
	} else {
		return null;
	}
}

function isValidInput() {
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST['school'])&&!empty($_POST['school'])&&($_POST['school']!=0)&&isset($_POST['ak'])&&!empty($_POST['ak'])) {
			return true;
		} else {
			return false;
		}
	} else {
		return true;  
	}
}

function showMessage($alertType, $alertMessage) {
	echo  "	<div class=\"alert ".$alertType." alert-dismissable fade in\">
					<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
					<p id=\"msgtext\">".$alertMessage."</p>
				</div>";
}

function createInputForm($query){
	echo "	<div class=\"container\">
					<h4>Κριτήρια Αναζήτησης</h4>
					<form  class=\"form-inline\"  action=\"".htmlspecialchars($_SERVER["PHP_SELF"])."\" method=\"post\">
						<div class=\"form-group\">
							<input type=\"hidden\" class=\"form-control\" name=\"query\" value=\"".$query."\">
						</div>
						<div class=\"form-group\">
							<label for=\"school\">Σχολή:</label>
							<select class=\"form-control\" id=\"school\" placeholder=\"Σχολή ...\" name=\"school\">
								<option value=\"0\"".checkSelected("school",0).">Επιλογή Σχολής ...</option>
								<option value=\"1\"".checkSelected("school",1).">Σχολή Πολιτικών Μηχανικών</option>
								<option value=\"2\"".checkSelected("school",2).">Σχολή Μηχανολόγων Μηχανικών</option>
								<option value=\"3\"".checkSelected("school",3).">Σχολή Ηλεκτρολόγων Μηχανικών και Μηχανικών Υπολογιστών</option>
								<option value=\"4\"".checkSelected("school",4).">Σχολή Αρχιτεκτόνων Μηχανικών</option>
								<option value=\"5\"".checkSelected("school",5).">Σχολή Χημικών Μηχανικών</option>
								<option value=\"6\"".checkSelected("school",6).">Σχολή Αγρονόμων και Τοπογράφων Μηχανικών</option>
								<option value=\"7\"".checkSelected("school",7).">Σχολή Μηχανικών Μεταλλείων Μεταλλουργών</option>
								<option value=\"8\"".checkSelected("school",8).">Σχολή Ναυπηγών Μηχανολόγων Μηχανικών</option>
								<option value=\"9\"".checkSelected("school",9).">Σχολή Εφαρμοσμένων Μαθηματικών και Φυσικών Επιστημών</option>
							</select>
						</div>
						<div class=\"form-group\">
							<label for=\"ak\">Ακαδημαϊκό Έτος:</label>
							<select class=\"form-control\" id=\"school\" placeholder=\"Ακαδημαϊκό Έτος\" name=\"ak\" style = \"text-align:center\">
								<option value=\"".(date("Y")+1)."\"".checkSelected("ak",date("Y")+1).">".(date("Y")+1)."</option>
								<option value=\"".date("Y")."\"".checkSelected("ak",date("Y")).">".date("Y")."</option>
								<option value=\"".(date("Y")-1)."\"".checkSelected("ak",date("Y")-1).">".(date("Y")-1)."</option>
								<option value=\"".(date("Y")-2)."\"".checkSelected("ak",date("Y")-2).">".(date("Y")-2)."</option>
								<option value=\"".(date("Y")-3)."\"".checkSelected("ak",date("Y")-3).">".(date("Y")-3)."</option>
								<option value=\"".(date("Y")-4)."\"".checkSelected("ak",date("Y")-4).">".(date("Y")-4)."</option>
								<option value=\"".(date("Y")-5)."\"".checkSelected("ak",date("Y")-5).">".(date("Y")-5)."</option>
								<option value=\"".(date("Y")-6)."\"".checkSelected("ak",date("Y")-6).">".(date("Y")-6)."</option>
								<option value=\"".(date("Y")-7)."\"".checkSelected("ak",date("Y")-7).">".(date("Y")-7)."</option>
								<option value=\"".(date("Y")-8)."\"".checkSelected("ak",date("Y")-8).">".(date("Y")-8)."</option>
								<option value=\"".(date("Y")-9)."\"".checkSelected("ak",date("Y")-9).">".(date("Y")-9)."</option>
								<option value=\"".(date("Y")-10)."\"".checkSelected("ak",date("Y")-10).">".(date("Y")-10)."</option>
								<option value=\"".(date("Y")-11)."\"".checkSelected("ak",date("Y")-11).">".(date("Y")-11)."</option>
								<option value=\"".(date("Y")-12)."\"".checkSelected("ak",date("Y")-12).">".(date("Y")-12)."</option>
								<option value=\"".(date("Y")-13)."\"".checkSelected("ak",date("Y")-13).">".(date("Y")-13)."</option>
								<option value=\"".(date("Y")-14)."\"".checkSelected("ak",date("Y")-14).">".(date("Y")-14)."</option>
								<option value=\"".(date("Y")-15)."\"".checkSelected("ak",date("Y")-15).">".(date("Y")-15)."</option>
							</select>
							<button type=\"submit\" class=\"btn btn-primary\">Αναζήτηση</button>
						</div>
					</form>
				</div>";
}



function find($query) {
	global $user,$dbhost,$dbname,$dbuser,$dbpwd;
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isValidInput()) {
			/*USING ODBC
			if ($_POST['school'] == 4) {
				$db = "met04odbc";
			} else {
				$db = "base0".$_POST['school']."odbc";
			}
			if  (($_POST['school'] == 2)||($_POST['school'] == 8)) {
				$pwd = "m16e@gle";
			} else {
				$pwd = "sysadm";
			}
			$connect = odbc_connect($db, "sysadm", $pwd);*/
			$connect = mysqli_connect($dbhost, $dbuser, $dbpwd, $dbname);
			if ($connect) {
				$validQuery = false;
				if (($query == "met_active")&&($_POST['query']==$query)) {
					$validQuery = true;
					/*USING ODBC
					$strSQL = "	select metprogram.progcode as progcode, metprogram.titlos AS titlos,@if(1-sex,'ΘΗΛΕΙΣ',@if(2-sex,'ΑΡΡΕΝΕΣ',sex)) as sex,@year(birthdate) as year_birth,count(*) as synolo 
										from metstuprog, met,metprogram 
										where metstuprog.mitroo = met.mitroo and metstuprog.progcode = metprogram.progcode
													and metstuprog.ak <=".$_POST['ak']."  and (met.erasmus is null or met.erasmus ='2') and (metstuprog.dateanag is null or metstuprog.dateanag >= '01-SEP-".$_POST['ak']."') 
													and metstuprog.mitroo not in (select mitroo from metdiakop where metdiakop.progcode = metstuprog.progcode and dateapo < '01-SEP-".$_POST['ak']."' and dateeos is null) group by 1,2,3,4 order by 1,2,3,4 desc";  */
				    $strSQL = "	select metstuprog.progcode as progcode, metprogram.titlos AS titlos,if(sex = '1','ΑΡΡΕΝΕΣ',if(sex='2','ΘΗΛΕΙΣ',sex)) as sex,year(birthdate) as year_birth,count(*) as synolo 
										from (metstuprog inner join met on metstuprog.mitroo=met.mitroo and metstuprog.tmimacode=met.tmimacode) inner join metprogram on metstuprog.tmimacode = metprogram.tmimacode and metstuprog.progcode = metprogram.progcode 
										where metstuprog.tmimacode = ".$_POST['school']." and metstuprog.ak <= ".$_POST['ak']." and (met.erasmus is null or met.erasmus ='2') and (metstuprog.dateanag is null or metstuprog.dateanag >= '".$_POST['ak']."-09-01') 
												and metstuprog.mitroo not in (select mitroo from metdiakop where metdiakop.progcode = metstuprog.progcode and dateapo < '".$_POST['ak']."-09-01' and dateeos is null) group by 1,2,3,4 order by 1,2,3,4 desc";
				} elseif (($query == "met_new")&&($_POST['query']==$query)) {
					$validQuery = true;
					/*USING ODBC
					$strSQL = "	select metstuprog.progcode as progcode,metprogram.titlos as titlos,@if(1-sex,'ΘΗΛΕΙΣ',@if(2-sex,'ΑΡΡΕΝΕΣ',sex)) as sex,@year(birthdate) as year_birth,count(*) as synolo 
										from metstuprog,met,metprogram
										where metstuprog.mitroo = met.mitroo and metstuprog.progcode = metprogram.progcode
												and metstuprog.ak =".$_POST['ak']." and (met.erasmus is null or met.erasmus ='2')  group by 1,2,3,4 order by 1,2,3,4 desc";	*/
					$strSQL = "	select metstuprog.progcode as progcode, metprogram.titlos AS titlos,if(sex = '1','ΑΡΡΕΝΕΣ',if(sex='2','ΘΗΛΕΙΣ',sex)) as sex,year(birthdate) as year_birth,count(*) as synolo 
										from (metstuprog inner join met on metstuprog.mitroo=met.mitroo and metstuprog.tmimacode=met.tmimacode) inner join metprogram on metstuprog.tmimacode = metprogram.tmimacode and metstuprog.progcode = metprogram.progcode 
										where metstuprog.tmimacode = ".$_POST['school']." and metstuprog.ak = ".$_POST['ak']." and (met.erasmus is null or met.erasmus ='2') group by 1,2,3,4 order by 1,2,3,4 desc";
				} elseif (($query =="met_dipl")&&($_POST['query']==$query)) {
					$validQuery = true;
					/*USING ODBC
					$strSQL = "	select metstuprog.progcode as metprogram, metprogram.titlos as titlos,@if(1-sex,'ΘΗΛΕΙΣ',@if(2-sex,'ΑΡΡΕΝΕΣ',sex)) as sex,@year(birthdate) as year_birth,count(*) as synolo
										from metstuprog,met,metprogram
										where metstuprog.mitroo = met.mitroo and metstuprog.progcode = metprogram.progcode
											and metstuprog.ak <=".$_POST['ak']."  and (met.erasmus is null or met.erasmus ='2')  and (metstuprog.dateanag between '01-SEP-".($_POST['ak']-1)."' and '31-AUG-".$_POST['ak']."') group by 1,2,3,4 order by 1,2,3,4 desc";*/
					$strSQL = "	select metstuprog.progcode as progcode, metprogram.titlos AS titlos,if(sex = '1','ΑΡΡΕΝΕΣ',if(sex='2','ΘΗΛΕΙΣ',sex)) as sex,year(birthdate) as year_birth,count(*) as synolo 
										from (metstuprog inner join met on metstuprog.mitroo=met.mitroo and metstuprog.tmimacode=met.tmimacode) inner join metprogram on metstuprog.tmimacode = metprogram.tmimacode and metstuprog.progcode = metprogram.progcode 
										where metstuprog.tmimacode = ".$_POST['school']." and metstuprog.ak <= ".$_POST['ak']." and (met.erasmus is null or met.erasmus ='2') and (metstuprog.dateanag between '".($_POST['ak']-1)."-09-01' and '".$_POST['ak']."-08-31' group by 1,2,3,4 order by 1,2,3,4 desc";
				}
				if ($validQuery) {
					echo "	<div align =\"center\">
									<a href=\"http://".$user->getHost()."export.php?file=txt&query=".$query."&school=".$_POST['school']."&ak=".$_POST['ak']."\"><button type=\"button\" class=\"btn btn-success\"><span class=\"glyphicon glyphicon-file\"></span> Εξαγωγή σε αρχείο csv</span></button></a>
								</div>";
					/*USING ODBC
					$result = odbc_exec($connect, $strSQL);*/
					$result = mysqli_query($connect, $strSQL);
					$programOld=null;
					$maleSum=0;
					$femaleSum=0;
					$totalSum=0;
					/*USING ODBC 
					while (odbc_fetch_row($result)) { */
					while ($row = mysqli_fetch_assoc($result)) {
						/*USING ODBC 
						$program = odbc_result($result, 2);*/
						$program = $row["titlos"];
						$test = $program;
						echo "Πρόγραμμα πριν το utf :".$test;
						$program = mb_convert_encoding($program, "UTF-8","UTF-8, ISO-8859-7");
						$test = mb_convert_encoding($test, "ISO-8859-7","UTF-8, ISO-8859-7");
						echo "Πρόγραμμα μετά το utf :".$test;
						if ($programOld != $program) {
							if ($programOld!=null) {
								echo "		</tbody>
											</table>
										</div>";
								echo "<p style=\"text-align:center\"><i>ΑΡΡΕΝΕΣ <strong> ".$maleSum." </strong> ΘΗΛΕΙΣ <strong> ".$femaleSum." </strong> Σύνολο <strong> ".$totalSum," </strong></i>";if($totalSum>($maleSum+$femaleSum)) echo "</br><p style=\"color:red;text-align:center\"><i> * Φοιτητές χωρίς καταχωρισμένο φύλο ".($totalSum-$maleSum-$femaleSum)."</i></p>";echo "</p></br></br>";
								$maleSum=0;
								$femaleSum=0;
								$totalSum=0;
							}
							echo "	<div class=\"container\">    
									<h4 style=\"align:center;color:blue\">".$program."</h4>
									<table class=\"table table-striped table-bordered\">
										<thead>
											<tr>
												<th>Φύλο</th>
												<th style =\"text-align:right\">Έτος Γέννησης</th>
												<th style =\"text-align:right\">Σύνολο</th>
											</tr>
										</thead>
										<tbody>";
							$programOld = $program;
						}
						/*USING ODBC 
						$sex = odbc_result($result, 3); */
						$sex = $row['sex'];
						$sex = mb_convert_encoding($sex, "UTF-8","UTF-8, ISO-8859-7");
						/*USING ODBC 
						$year = odbc_result($result, 4); */
						$year = $row['year_birth'];
						/*USING ODBC 
						if ($year != null) {
							$year += 1900;
						}
						$sum = odbc_result($result, 5);*/
						$sum = $row['synolo'];
						if ($sex=="ΑΡΡΕΝΕΣ") {
							$maleSum+=$sum;
						} elseif ($sex=="ΘΗΛΕΙΣ") {
							$femaleSum+=$sum;
						}
						$totalSum+=$sum;
						echo "	<tr>
										<td>".$sex."</td>
										<td style =\"text-align:right\">".$year."</td>
										<td style =\"text-align:right\">".$sum."</td>
									</tr>";
					}
					/*USING ODBC
					if (odbc_num_rows($result) >0) { */
					if (mysqli_num_rows($result) > 0) {
						echo "		</tbody>
									</table>
								</div>";
						echo "<p style=\"text-align:center\"><i>ΑΡΡΕΝΕΣ <strong> ".$maleSum." </strong> ΘΗΛΕΙΣ <strong> ".$femaleSum." </strong> Σύνολο <strong> ".$totalSum," </strong></i>";if($totalSum>($maleSum+$femaleSum)) echo "</br><p style=\"color:red;text-align:center\"><i> * Φοιτητές χωρίς καταχωρισμένο φύλο ".($totalSum-$maleSum-$femaleSum)."</i></p>";echo "</p></br></br>";
					}
				} else {
					return null;
				}
				/*USING ODBC
				odbc_close($connect); */
				mysqli_close($connect);
			} else {
				showMessage("alert-danger","<p><strong>Σφάλμα!</strong> Αδυναμία σύνδεσης στην βάση</p>");
			}
		} else {
			showMessage("alert-danger","<p><strong>Προσοχή!</strong> Δεν έχετε αρίσει τα κριτήρια αναζήτησης</p>");	
		}
	} else {
		return null;
	}
}
?>
<div class="container-fluid text-center">    
	<div class="row content">
		<div class="col-sm-2 sidenav">
			<ul class="nav nav-pills nav-stacked">
				<li<?php if (isActive('prop')) echo " class=\"active\" "; ?>><a data-toggle="pill" href="#prop">Προπτυχιακό</a></li>
				<li class="dropdown <?php if ((isActive('met_active'))||(isActive('met_new'))||(isActive('met_dipl'))) echo "active"; else echo null; ?>">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Μεταπτυχιακό<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li<?php if (isActive('met_active')) echo " class=\"active\" "; ?>><a data-toggle="pill" href="#met_active">Ενεργοί ανά φύλο και έτος γέννησης</a></li>
						<li<?php if (isActive('met_new')) echo " class=\"active\" "; ?>><a data-toggle="pill" href="#met_new">Νεοεισαχθέντες ανά φύλο και έτος γέννησης</a></li>
						<li<?php if (isActive('met_dipl')) echo " class=\"active\" "; ?>><a data-toggle="pill" href="#met_dipl">Αναγορευμένοι ανά φύλο και έτος γέννησης</a></li>
					</ul>
				</li>
				<li><a href="http://<?php echo $user->getHost()?>">Επιστροφή</a></li>
			</ul>
		</div>
		<div class="col-sm-10 text-left"> 
			<div class="tab-content">
				<div id="prop" class="tab-pane fade <?php if (isActive('prop')) echo " in active "; ?>">
					<div class="container text-center">
						</br>
						<img src="./img/underconstruction.png" class="img-thumbnail" height="350" width="350" alt="UnderConstruction">
					</div>
					<div>
						</br>
						<p align="center">Πατήστε <a href="http://<?php echo $user->getHost()?>index.php"> εδώ </a> για να επιστρέψετε στη σελίδα επιλογών</p>
					</div>
				</div>
				<div id="met_active" class="tab-pane fade <?php if (isActive('met_active')) echo " in active "; ?>">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 style="text-align:center">Ενεργοί Μεταπτυχιακοί Φοιτητές Ανά Φύλο και Έτος Γέννησης</h4>
							<?php createInputForm("met_active"); ?>
						</div>
						<div class="panel-body" style="width:100%">
							<?php find("met_active")?>
						</div>
					</div>
				</div>
				<div id="met_new" class="tab-pane fade <?php if (isActive('met_new')) echo " in active "; ?>">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 style="text-align:center">Νεοεισαχθέντες Μεταπτυχιακοί Φοιτητές Ανά Φύλο και Έτος Γέννησης</h4>
							<?php createInputForm("met_new")?>
						</div>
						<div class="panel-body" style="width:100%">
							<?php find("met_new")?>
						</div>
					</div>
				</div>
				<div id="met_dipl" class="tab-pane fade <?php if (isActive('met_dipl')) echo " in active "; ?>">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 style="text-align:center">Αναγορευμένοι Μεταπτυχιακοί Φοιτητές Ανά Φύλο και Έτος Γέννησης</h4>
							<?php createInputForm("met_dipl") ?>
						</div>
						<div class="panel-body" style="width:100%">
							<?php find("met_dipl")?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
echo getFooter('gr');
?>