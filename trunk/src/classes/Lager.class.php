<?php

/**
 * Stellt alle Aktionen im Lagerumfeld zur Ver&uuml;gung
 * 
 * @author Tobias Beckmerhagen
 * 
 */
class Lager {
	
	private $DBConn = null;
	
	/**
	 * Klassenkonstruktor.<br />
	 * Erwartet eine MySQL Connection Ressource
	 * 
	 * @param MySQL_Connection $iDBConn
	 * @version 1.0
	 * 
	 */
	public function __construct($iDBConn) {
		$this->DBConn = $iDBConn;
	}
	
	/**
	 * F&uuml;gt eine Kaffeesorte / einen Artikel zur Lagerartikelliste hinzu
	 * 
	 * @param String $sorte Beschreibung
	 * @param String $uom Unit of Measure (Mengeneinheit)
	 * @param String $uom_short Unit of Measure Abk&uuml;rzung
	 * @param Decimal $size Verpackungs&ouml;&szlig;e
	 * 
	 * @return Integer Success/Error Code
	 */
	public function addArtikel($sorte, $uom, $uom_short, $size) {
		$size = str_replace(',','.',$size);
		
		$cSql = "SELECT * FROM "._TBL_LA_ARTIKEL_." WHERE sorte = '".$sorte."' AND uom = '".$uom."' AND size = '".$size."'";
		if((!$result = mysql_query($cSql,$this->DBConn)) || (mysql_num_rows($result) == 0)) {
			$sql = "INSERT INTO "._TBL_LA_ARTIKEL_." (sorte, uom, uom_short, size) VALUES ('".$sorte."', '".$uom."', '".$uom_short."', '".$size."')";
			if((!$result = mysql_query($sql,$this->DBConn)) || (mysql_affected_rows($this->DBConn) != 1)) {
				return -1;
			} else {
				return 1;
			}
		} else {
			return -2;
		}
				
	}
	
	/**
	 * Selektiert alle vorhandenen Artikel und gibt sie als Assoziatives Array zur&uuml;ck
	 * 
	 * @return Ambigous <string, multitype:, NULL>
	 */
	public function getArtikelListe() {		
		$sql = "SELECT id, sorte, uom, uom_short, size FROM "._TBL_LA_ARTIKEL_." ORDER BY sorte ASC";
		$result = null;
		if((!$qryResult = mysql_query($sql, $this->DBConn)) || (mysql_num_rows($qryResult) <= 0)) {
				$result = '<span class="error">Es ist ein Fehler aufgetreten!</span>';
		} else {
			while($row = mysql_fetch_assoc($qryResult)) {
				$result[] = $row;
			}							
		}
		return $result;
	}
	
	/**
	 * Selektiert alle Lagereing&auml;nge welche noch nicht vollst&auml;ndig ausgebucht wurden.<br />
	 * Gibt ebenfalls den aktuellen Lagerbestand und die Artikelbeschreibung mit Ma&szlig;einheit und Menge aus.
	 * 
	 * @return Ambigous <string, multitype:, NULL>
	 */
	public function getBookableStockPostings() {
		$sql =	"
					SELECT
							 le.lfdnr AS ekId
							,le.art_id AS artId
							,le.anzahl AS ekAnz
							,le.datum AS ekDatum
							,ifnull(la.anz, 0) AS laAus
							,(le.anzahl - ifnull(la.anz, 0)) AS lagerBestand
							,art.sorte AS artSorte
							,art.size AS artSize
							,art.uom_short AS artUOMshort
					FROM "._TBL_LA_EINGANG." le
					LEFT JOIN
						(
							SELECT SUM(anzahl) AS anz, eid
							FROM "._TBL_LA_AUSGANG."
							GROUP BY eid
						) 	AS la
							ON la.eid = le.lfdnr
							AND la.anz <= le.anzahl
					JOIN
						(
							SELECT id, sorte, size, uom_short
							FROM "._TBL_LA_ARTIKEL_."
						)	AS art
							ON le.art_id = art.id
					WHERE (le.anzahl - ifnull(la.anz, 0)) > 0
					ORDER BY ekDatum
				";

		$result = null;
		if((!$qryResult = mysql_query($sql, $this->DBConn)) || (mysql_num_rows($qryResult) <= 0)) {
				$result = '<span class="error">Es ist ein Fehler aufgetreten!</span>';
		} else {
			while($row = mysql_fetch_assoc($qryResult)) {
				$result[] = $row;
			}
		}
		return $result;
	}
	
	/**
	 * Selektiert die letzten Lagereing&auml;nge.<br />
	 * Die Anzahl ist &uuml;ber den Parameter "$displayLimit" geregelt.
	 * 
	 * @return Ambigous <string, multitype:, NULL>
	 */
	public function getLastStockPostings($displayLimit = null) {
		if ($displayLimit != null && is_int($displayLimit)) {
			$sql =	"SELECT
						 date_format(le.datum, '%d.%m.%Y') as datum
						,le.anzahl
						,round(le.preis_pro_stueck,3) AS pps
						,la.sorte
						,la.uom_short AS uoms
						,la.size
					FROM
						 "._TBL_LA_EINGANG." le
						,"._TBL_LA_ARTIKEL_." la
					WHERE
						le.art_id = la.id
					ORDER BY
						 le.datum desc
						,le.art_id asc
					LIMIT ".$displayLimit;
		} else {
			$sql =	"SELECT
						 date_format(le.datum, '%d.%m.%Y') as datum
						,le.anzahl
						,round(le.preis_pro_stueck,3) AS pps
						,la.sorte
						,la.uom_short AS uoms
						,la.size
					FROM
						 "._TBL_LA_EINGANG." le
						,"._TBL_LA_ARTIKEL_." la
					WHERE
						le.art_id = la.id
					ORDER BY
						 le.datum desc
						,le.art_id asc";
		}
		
		$result = null;
		if((!$qryResult = mysql_query($sql, $this->DBConn)) || (mysql_num_rows($qryResult) <= 0)) {
				$result = '<span class="error">Es ist ein Fehler aufgetreten!</span>';
		} else {
			while($row = mysql_fetch_assoc($qryResult)) {
				$result[] = $row;
			}
		}
		return $result;
	}
	
/**
	 * Selektiert die letzten Lagerausg&auml;nge.<br />
	 * Die Anzahl ist &uuml;ber den Parameter "$displayLimit" geregelt.
	 * 
	 * @return Ambigous <string, multitype:, NULL>
	 */
	public function getLastStockWithdrawals($displayLimit = null) {
		if ($displayLimit != null && is_int($displayLimit)) {
			$sql =	"SELECT
						 aus.eid AS ekID
						,aus.anzahl AS anzahl
						,date_format(aus.datum, '%d.%m.%Y') AS datum
						,art.sorte AS sorte
						,art.uom_short AS uoms
						,art.size AS size
					FROM
						 "._TBL_LA_AUSGANG." aus
						,"._TBL_LA_EINGANG." ein
						,"._TBL_LA_ARTIKEL_." art
					WHERE
						aus.eid = ein.lfdnr
						AND
						art.id = ein.art_id
					ORDER BY
						 aus.datum DESC
						,aus.lfdnr DESC
					LIMIT ".$displayLimit;
		} else {
			$sql =	"SELECT
						 aus.eid AS ekID
						,aus.anzahl AS anzahl
						,date_format(aus.datum, '%d.%m.%Y') AS datum
						,art.sorte AS sorte
						,art.uom_short AS uoms
						,art.size AS size
					FROM
						 "._TBL_LA_AUSGANG." aus
						,"._TBL_LA_EINGANG." ein
						,"._TBL_LA_ARTIKEL_." art
					WHERE
						aus.eid = ein.lfdnr
						AND
						art.id = ein.art_id
					ORDER BY
						 aus.datum DESC
						,aus.lfdnr DESC";
		}
		
		$result = null;
		if((!$qryResult = mysql_query($sql, $this->DBConn)) || (mysql_num_rows($qryResult) <= 0)) {
				$result = '<span class="error">Es ist ein Fehler aufgetreten!</span>';
		} else {
			while($row = mysql_fetch_assoc($qryResult)) {
				$result[] = $row;
			}
		}
		return $result;
	}
	
	/**
	 * F&uuml;gt einen Einkauf in die entsprechende Lagertabelle ein.
	 * 
	 * @param Integer $artId Artikel ID aus der Artikel Tabelle
	 * @param Integer $size Einkaufsmenge
	 * @param Integer $singlePrice Preis pro Einheit
	 * @param Date $datum Datum des Einkaufs
	 * 
	 * @return Integer Success/Error Code
	 */
	public function checkInStockPosting($artId, $size, $singlePrice, $datum) {
		$singlePrice = str_replace(',','.',$singlePrice);
		$size = str_replace(',','.',$size);
		$sql = "INSERT INTO "._TBL_LA_EINGANG." (art_id, anzahl, preis_pro_stueck, datum) 
												VALUES (".$artId.", ".$size.", ".$singlePrice.", '".$datum."')";
		if((!$result = mysql_query($sql,$this->DBConn)) || (mysql_affected_rows($this->DBConn) != 1)) {
			return -1;
		} else {			
			return 1;
		}
	}
	
	/**
	 * F&uuml;gt einen Verbrauch in die entsprechende Lagertabelle ein.<br />
	 * Schreibt zus&auml;tzlich den aktuellen Tassenz&auml;hlerstand in die Datenbank, <br />
	 * wenn die Entnahme eine Kaffeeentnahme ist.
	 * 
	 * @param Date $datum
	 * @param Integer $ekId
	 * @param Integer $size
	 * @param Integer $cupCount
	 * 
	 * @return Integer Success/Error Code
	 */
	public function checkOutStockPosting($datum, $ekId, $size, $cupCount) {
		$size = str_replace(',','.',$size);
		$vbSql = "INSERT INTO "._TBL_LA_AUSGANG." (eid, anzahl, datum) VALUES (".$ekId.", ".$size.", '".$datum."')";
		if((!$vbResult = mysql_query($vbSql,$this->DBConn)) || (mysql_affected_rows($this->DBConn) != 1)) {
			return -1;
		} else {
			if($cupCount != -1) {
				$cupSql = "INSERT INTO "._TBL_GER_ZAEHLER_." (zaehlerstand, datum) VALUES (".$cupCount.", '".$datum."')";
				if((!$cupResult = mysql_query($cupSql,$this->DBConn)) || (mysql_affected_rows($this->DBConn) != 1)) {
					return -2;
				} else {
					return 2;
				}
			} else {
				return 1;
			}
		}
	}
	
}

?>