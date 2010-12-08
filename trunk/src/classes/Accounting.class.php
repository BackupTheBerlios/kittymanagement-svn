<?php

/**
 * Stellt alle Methoden zum Buchen von Ein- und Auszahlungen zur Verf&uuml;gung.
 * 
 * @author Tobias Beckmerhagen
 *
 */
class Accounting {

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
	 * Bucht eine Einzahlung
	 * 
	 * @param Integer $ma_id
	 * @param Date $datum
	 * @param Decimal $betrag
	 * @param String $bemerkung
	 * 
	 * @return Integer Success/Error Code 
	 */
	public function postIncomingPayment($ma_id, $datum, $betrag, $bemerkung) {
		$betrag = str_replace(',','.',$betrag);
		
		// kaffee_kasse buchen
		$kk_sql = "INSERT INTO "._TBL_KA_KASSE_." (datum, betrag, art, bemerkung) 
					VALUES ('".$datum."', ".($betrag*-1).", '-', '".$bemerkung."')";
		
		if((!$kk_result = mysql_query($kk_sql,$this->DBConn)) || (mysql_affected_rows($this->DBConn) != 1)) {
			return -1;
		} else {
			// mitglieder_konto buchen, WENN kaffee_kasse Buchung erfolgreich
			$ma_sql = "INSERT INTO "._TBL_MA_KTO_." (kk_lfdnr, ma_id, datum, betrag, art, bemerkung) 
					VALUES (LAST_INSERT_ID(), ".$ma_id.", '".$datum."', ".$betrag.", '+', '".$bemerkung."')";
			
			if((!$ma_result = mysql_query($ma_sql,$this->DBConn)) || (mysql_affected_rows($this->DBConn) != 1)) {
				return -2;
			} else {
				return 1;
			}
		}
	}
	
	/**
	 * Bucht direkte Ausgaben aus der Kasse
	 * 
	 * @param Date $datum
	 * @param Decimal $betrag
	 * @param String $bemerkung
	 *
	 * @return Integer Success/Error Code
	 */
	public function postSpendings($datum, $betrag, $bemerkung) {
		$betrag = str_replace(',','.',$betrag);
		
		$aus_sql = "INSERT INTO "._TBL_KA_KASSE_." (datum, betrag, art, bemerkung) 
					VALUES ('".$datum."', ".$betrag.", '+', '".$bemerkung."')";
				
		if((!$result = mysql_query($aus_sql,$this->DBConn)) || (mysql_affected_rows($this->DBConn) != 1)) {
			return -1;
		} else {
			return 1;
		}
	}
	
	/**
	 * Bucht turnusm&auml;ssige Beitr&auml;ge
	 * 
	 * @param Integer $ma_id
	 * @param Date $datum
	 * @param Decimal $betrag
	 * @param String $bemerkung
	 * 
	 * @return Integer Success/Error Code 
	 */
	public function postContributions($ma_id, $datum, $betrag, $bemerkung) {
		$betrag = str_replace(',','.',$betrag);
		
		$checkSql = "SELECT * FROM "._TBL_MA_KTO_." WHERE ma_id = ".$ma_id." AND art = '-' and bemerkung LIKE ('%".$bemerkung."%')";
		if((!$result = mysql_query($checkSql,$this->DBConn)) || (mysql_affected_rows($this->DBConn) != 1)) {
			return -2;
		} else {
			$sql = "INSERT INTO "._TBL_MA_KTO_." (ma_id, datum, betrag, art, bemerkung) 
				VALUES (".$ma_id.", '".$datum."', ".($betrag*-1).", '-', '".$bemerkung."')";
			if((!$result = mysql_query($sql,$this->DBConn)) || (mysql_affected_rows($this->DBConn) != 1)) {
				return -1;
			} else {
				return 1;
			}
		}
	}
	
}

?>