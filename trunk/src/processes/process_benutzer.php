<?php

require_once('../config/Init.php');

if($_POST['user_add'] == 1) {
	
	$ma_name = $_POST['nname'];
	$ma_vname = $_POST['vname'];
	$ma_email = $_POST['email'];
	$ma_kategorie = $_POST['kategorie'];
	$ma_buchen = $_POST['buchen'];
	
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
			// @TODO Link anpassen, um Maske zum editieren aufzurufen - !!! Auch in benutzer_verwalten.tpl.php !!!
			$tbl .= '<td><a href=""><img src="images/ppl_view.png" alt="edit" title="Benutzer anzeigen / editieren" /></a></td>';
			$tbl .= "</tr>";
		}
		$tbl .= "</table>";
		
		echo $tbl;
	} else {
		echo $benutzerListe;
	}
}
?>