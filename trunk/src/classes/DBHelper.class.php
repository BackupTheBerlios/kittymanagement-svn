<?php

/**
 * Stellt Hilfsfunktionen f&uuml;r die Datenbank bereit
 * 
 * @author tobias
 *
 */
class DBHelper {
	
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
	 * Gibt die letzte Laufende Nummer der &uuml;bergebenen Tabelle zur&uuml;ck
	 * 
	 * @param String $tblName Name der abzufragenden Tabelle
	 * 
	 * @return Integer letzte Laufende Nummer
	 */
	public function getLastLfdNr($tblName) {
		$sql = "SELECT max(lfdnr) FROM $tblName LIMIT 1";
		$result = null;
		if((!$qryResult = mysql_query($sql, $this->DBConn)) || (mysql_num_rows($qryResult) != 1)) {
				$result = '<span class="error">Es ist ein Fehler aufgetreten!</span>';
		} else {
			return mysql_fetch_row($result);					
		}		
	}
}

?>