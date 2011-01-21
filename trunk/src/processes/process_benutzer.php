<?php

require_once('../config/Init.php');

if($_POST['user_add'] == 1) {
	
	$ma_name = $_POST['nname'];
	$ma_vname = $_POST['vname'];
	$ma_email = $_POST['email'];
	$ma_kategorie = $_POST['kategorie'];
	$ma_buchen = $_POST['buchen'];
	$send_mail = $_POST['mail'];
	
	$addReturn = $MA->addMitglied($ma_name, $ma_vname, $ma_email, $ma_kategorie);
	
	switch ($addReturn) {
		case 1:
			if($ma_buchen == 1) {
				$beitrag_ma = 0;
				$beitrag_hiwi = 0;
				$betrag = 0;
				if(_BEITRAG_FIX == 1) {
					$beitrag_ma = _BEITRAG_SATZ * _BEITRAG_FAKTOR_MA;
					$beitrag_hiwi = _BEITRAG_SATZ * _BEITRAG_FAKTOR_HIWI;
				}
				
				$ma_id = $MA->getMitgliedID($ma_name);
				echo 'ma_id = '.$ma_id;
				if($ma_kategorie == "ma") {
					$betrag = $beitrag_ma;
				}
				if($ma_kategorie == "hiwi") {
					$betrag = $beitrag_hiwi;
				}
				
				$monthOfPosting = strftime("%B")." ".strftime("%Y");
				
				$success = $ACC->postContributions($ma_id, date("Y-m-d"), $betrag, "Monatsbeitrag - ".$monthOfPosting);
			
				if($success == -2) {
					$successComment = "Buchung vorhanden";
				}
				if($success == -1) {
					$successComment = "Fehler!";
				}
			
				echo '<i>'.$ma_name.', '.$ma_vname.'</i> erfolgreich hinzugef&uuml;gt und Buchung f&uuml;r den Eintrittsmonat erzeugt!';
			} else {
				echo '<i>'.$ma_name.', '.$ma_vname.'</i> erfolgreich hinzugef&uuml;gt!';
			}
			if($send_mail == 1) {
				echo $MAILER->sendWelcomeMail($ma_email, htmlspecialchars($ma_name), htmlspecialchars($ma_vname));
			}
		break;
		
		case -1:
			echo "Es muss eine g&uuml;ltige Email Adresse angegeben werden!";
		break;
		
		case -2:
			echo "Es ist ein Fehler beim Anlegen des Benutzers aufgetreten!";
		break;
		
		case -3:
			echo "Es ist ein Fehler beim Update der Statustabelle aufgetreten!";
		break;
		
		case -4:
			echo "Der angegebene Name oder die Email Adresse ist bereits in Verwendung!";
		break;
		
		default:
			echo -666;
		break;
	}

}

if($_GET['zeigeBenutzer'] == 1) {
	$benutzerListe = $MA->getMitglied(true);
	
	if(is_array($benutzerListe)) {
		$tbl = '<table>
				<tr>
					<th>Name</th>
					<th>Nachname</th>
					<th>Email</th>
					<th></th>
				</tr>';
		foreach($benutzerListe as $benutzer) {
			if($benutzer['status'] == 1) {
				$tbl .= "<tr>";
				foreach($benutzer as $key => $value) {				
					if($key == "name") {
						$tbl .= "<td>".htmlentities($value)."</td>";
					}
					if($key == "vorname") {
						$tbl .= "<td>".htmlentities($value)."</td>";
					}
					if($key == "email") {
						$tbl .= "<td>".htmlentities($value)."</td>";
					}			
				}

				$tbl .= '<td><a href="" name="userDetails" id="'.$benutzer['id'].'"><img src="images/ppl_view.png" alt="edit" title="Benutzer anzeigen / editieren" /></a></td>';
				$tbl .= "</tr>";
			}
		}
		$tbl .= "</table>";
		
		echo $tbl;
	} else {
		echo $benutzerListe;
	}
}

if($_GET['showUsrDetails'] == 1) {
	$usrId = $_GET['usrId'];
	$response = "";
	if(!$usrId || !is_int(intval($usrId))) {
		$response = '<div class="error">Es wurde kein Benutzer angegeben oder der Benutzer existiert nicht! [usrId: '.$usrId.']</div>';
	} else {
		$benutzer = $MA->getMitglied(false, $usrId);
		$checked = 'checked="checked"';
		
		$response = '
			<div class="widget_content">
				<div class="item">
					<fieldset>
				    	<form name="user_edit" id="user_edit" action="" method="post">
				        	<div>
				        		<label for="vname">Vorname: </label>
				        		<input name="vname" type="text" id="vname" class="styled no_edit" readonly="readonly" value="'.htmlentities($benutzer[1]).'" />
				        	</div>
				        	<div>
				        		<label for="nname">Nachname: </label>
				        		<input name="nname" type="text" id="nname" class="styled no_edit" readonly="readonly" value="'.htmlentities($benutzer[2]).'" />
				        	</div>
				        	<div>
				        		<label for="email">eMail Adresse: </label>
				        		<input name="email" type="text" id="email" class="styled" size="30" value="'.htmlentities($benutzer[3]).'" />
				        	</div>
							<div>
								<label for="kategorie">Kategorie:</label>
								<input type="radio" name="kategorie" value="ma" id="kategorie" '.($benutzer[5] == 'ma' ? $checked : '').' /> Mitarbeiter&nbsp;&nbsp;
								<input type="radio" name="kategorie" value="hiwi" id="kategorie" '.($benutzer[5] == 'hiwi' ? $checked : '').' /> HiWi<br />
							</div>
							<div>
								<label for="status">Status:</label>
								<input type="radio" name="status" value="1" id="status" '.($benutzer[6] == 1 ? $checked : '').' /> Aktiv&nbsp;&nbsp;
								<input type="radio" name="status" value="0" id="status" '.($benutzer[6] == 0 ? $checked : '').' /> Inaktiv<br />
								<input type="hidden" name="usrId" value="'.$usrId.'" />
							</div>
						</form>
					</fieldset>
				</div>
				<div class="item" id="retDiv">
					<span id="stammUpd"></span><br />
					<span id="statusUpd"></span>
				</div>
			</div>
		';
	}
	
	echo $response;
}

if($_GET['updateUserData'] == 1) {
	$updReturn = $MA->updateMitglied($_POST['usrId'], $_POST['email'], $_POST['kategorie'], $_POST['status']);
	
	if((isset($updReturn['status'])) && ($updReturn['status'] == 1)) $statusSuccess = "Benutzerstatus erfolgreich ge&auml;ndert!";
	if((isset($updReturn['status'])) && ($updReturn['status'] == -1)) $statusSuccess = "FEHLER!! Benutzerstatus nicht ge&auml;ndert!";
	
	if((isset($updReturn['stammDaten'])) && ($updReturn['stammDaten'] == 1)) $stammSuccess = "Benutzerdaten erfolgreich ge&auml;ndert!";
	if((isset($updReturn['stammDaten'])) && ($updReturn['stammDaten'] == -1)) $stammSuccess = "FEHLER!! Benutzerdaten nicht ge&auml;ndert!";
	
	$returnValues = array('stammDaten' => $stammSuccess, 'status' => $statusSuccess);
	
	echo json_encode($returnValues);
}
?>