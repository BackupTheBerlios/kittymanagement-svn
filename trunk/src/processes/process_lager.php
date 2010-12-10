<?php

require_once('../config/Init.php');

if($_POST['artikel_add'] == 1) {
	
	$art_sorte = $_POST['sorte'];
	$art_uom = $_POST['uom'];
	$art_uom_short = $_POST['uom_short'];
	$art_size = $_POST['size'];
	print_r($_POST);
	$add_return = $LA->addArtikel($art_sorte, $art_uom, $art_uom_short, $art_size);
	echo $add_return;
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
				$tbl .= '<td class="betrag">'.$artikel['size'].' '.$artikel['uom_short'].'</td>';
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
		$singlePrice = $_POST['preis_einzel'];
	} else {
		$singlePrice = $_POST['preis_gesamt'] / $size;
	}
	
	echo $LA->checkInStockPosting($artikel_id, $size, $singlePrice, $date);

}

?>