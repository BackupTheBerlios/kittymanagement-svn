<?php

require_once('../config/Init.php');

if($_POST['artikel_add'] == 1) {
	
	$art_sorte = $_POST['sorte'];
	$art_uom = $_POST['uom'];
	$art_uom_short = $_POST['uom_short'];
	$art_size = $_POST['size'];
	
	$add_return = $LA->addArtikel($art_sorte, $art_uom, $art_uom_short, $art_size);
	
	if($add_return == -1) {
		echo "Fehler beim Anlegen des Artikels";
	} elseif($add_return == -2) {
		echo "Artikel bereits vorhanden";
	} elseif($add_return == 1) {
		echo "Artikel erfolgreich hinzugef&uuml;gt";
	} else {
		echo -666;
	}
}

if($_GET['zeigeArtikel'] == 1) {
	$artikelListe = $LA->getArtikelListe();
	
	if(is_array($artikelListe)) {
		$tbl = '<table>
				<tr>
					<th>Sorte</th>
					<th>Verpackungsgr&ouml;&szlig;e</th>
				</tr>';
		foreach($artikelListe as $artikel) {
			$tbl .= "<tr>";
				$tbl .= "<td>".$artikel['sorte']."</td>";
				$tbl .= '<td class="betrag">'.number_format($artikel['size'], 2, ",", ".").' '.$artikel['uom_short'].'</td>';
			$tbl .= "</tr>";
		}
		$tbl .= "</table>";
		
		echo $tbl;
	} else {
		echo $artikelListe;
	}
}

if($_POST['lager_eingang'] == 1) {
	
	$datum = $_POST['datum'];
	$dtmp = explode(".", $datum); // dd mm yyyy
	$date = $dtmp[2].'-'.$dtmp[1].'-'.$dtmp[0]; // yyyy mm dd
	
	$artikel_id = $_POST['artikel'];
	$size = $_POST['size'];

	$singlePrice = 0;
	if($_POST['preis_einzel']) {
		$price = str_replace(',','.',$_POST['preis_einzel']);
		$singlePrice = $price;
	} else {
		$price = str_replace(',','.',$_POST['preis_gesamt']);
		$singlePrice = $price / $size;
	}
	
	echo $LA->checkInStockPosting($artikel_id, $size, $singlePrice, $date);

}

if($_GET['zeigeEingaenge'] == 1) {
	$eingangsListe = $LA->getLastStockPostings(_STORAGE_ENTRY_DISPLAY_COUNT);
	
	if(is_array($eingangsListe)) {
		$tbl = '<table>
				<tr>
					<th>Datum</th>
					<th>Anzahl</th>
					<th>Preis pro Stck.</th>
					<th>Sorte</th>
				</tr>';
		foreach($eingangsListe as $eingang) {
			$tbl .= "<tr>";
				$tbl .= "<td>".$eingang['datum']."</td>";
				$tbl .= '<td class="betrag">'.$eingang['anzahl'].'</td>';
				$tbl .= '<td class="betrag">'.number_format($eingang['pps'], 2, ",", ".").' &euro;</td>';
				$tbl .= '<td>'.htmlentities($eingang['sorte']).' ('.number_format($eingang['size'], 2, ",", ".").' '.$eingang['uoms'].')</td>';
			$tbl .= "</tr>";
		}
		$tbl .= "</table>";
		
		echo $tbl;
	} else {
		echo $eingangsListe;
	}
	
}

if($_POST['lager_ausgang'] == 1) {
	
	$datum = $_POST['datum'];
	$ekId = $_POST['ekId'];
	$size = $_POST['size'];
	$cupCount = $_POST['cupCount'];
	
	$dtmp = explode(".", $datum); // dd mm yyyy
	$datum = $dtmp[2].'-'.$dtmp[1].'-'.$dtmp[0]; // yyyy mm dd
	
	$add_return = $LA->checkOutStockPosting($datum, $ekId, $size, $cupCount);
	
	if($add_return == -1) {
		echo "Der Lagerausgang konnte nicht gebucht werden!";
	} elseif($add_return == -2) {
		echo "Der angegebene Z&auml;hlerstand konnte nicht gebucht werden!";
	} elseif($add_return == 1) {
		echo "Lagerentnahme erfolgreich gebucht, kein Z&auml;hlerstand eingetragen!";
	} elseif($add_return == 2) {
		echo "Lagerentnahme erfolgreich gebucht, Z&auml;hlerstand eingetragen!";
	} else {
		echo -666;
	}
	
}

if($_GET['zeigeAusgaenge'] == 1) {
	$ausgangsListe = $LA->getLastStockWithdrawals(_STORAGE_OUTGOINGS_DISPLAY_COUNT);
	
	if(is_array($ausgangsListe)) {
		$tbl = '<table>
				<tr>
					<th>Datum</th>
					<th>Anzahl</th>
					<th>Sorte</th>
				</tr>';
		foreach($ausgangsListe as $ausgang) {
			$tbl .= "<tr>";
				$tbl .= "<td>".$ausgang['datum']."</td>";
				$tbl .= '<td class="betrag">'.$ausgang['anzahl'].'</td>';
				$tbl .= '<td>'.htmlentities($ausgang['sorte']).' ('.number_format($ausgang['size'], 2, ",", ".").' '.$ausgang['uoms'].')</td>';
			$tbl .= "</tr>";
		}
		$tbl .= "</table>";
		
		echo $tbl;
	} else {
		echo $ausgangsListe;
	}
	
}
?>