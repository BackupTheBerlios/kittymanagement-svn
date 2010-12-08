<?php

/**
 * Stellt alle Methoden f&uuml;r die Ver- und Bearbeitung von Mitarbeitern zur Verf&uuml;gung.
 * 
 * @author Tobias Beckmerhagen
 *
 */
class Mitglieder {

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
	 * F&uuml;gt ein Mitglied in die Datenbank ein und setzt den Status auf "aktiv"
	 * 
	 * @param String $name
	 * @param String $vorname
	 * @param Varchar $email
	 * @param String $faktor
	 * 
	 * @return Integer Success/Error Code
	 */
	public function addMitglied($name, $vorname, $email, $faktor) {
		if(!checkMail($email)) {
			return -1;
		} else {
			$cSql = "SELECT * FROM "._TBL_MA_." WHERE name = LOWER('".$name."') OR email = LOWER('".$email."')";
			if((!$result = mysql_query($cSql,$this->DBConn)) || (mysql_num_rows($result) == 0)) {
				$sql = "INSERT INTO "._TBL_MA_." (name, vorname, email, eintritt, faktor) 
														VALUES ('".$name."', '".$vorname."', '".$email."', CURDATE(), '".$faktor."')";
				
				if((!$result = mysql_query($sql,$this->DBConn)) || (mysql_affected_rows($this->DBConn) != 1)) {
					return -2;
				} else {
					$sSql = "INSERT INTO "._TBL_MA_STAT_." (maId, status, datum) VALUES (LAST_INSERT_ID(), 1, CURDATE())";
					if((!$result = mysql_query($sSql,$this->DBConn)) || (mysql_affected_rows($this->DBConn) != 1)) {
						return -3;
					} else {
						return 1;
					}
				}
			} else {
					return -4;
			}
		}
	}
	
	public function editMitglied() {
		//$id, $name, $vorname, $email, $faktor, $aktiv, $inaktiv_von, $inaktiv_bis
	}
	
	/**
	 * Sucht die Daten von Mitgliedern aus der Datenbank. <br />
	 * Gibt entweder die Daten eines Mitglieds aus ($all = false + $ma_id = x) <br />
	 * oder eine Liste mit allen vorhandenen Mitgliedern ($all = true + $ma_id = null)
	 * 
	 * @param Boolean $all true|false f&uuml;r komplette Liste oder einzelnen Eintrag 
	 * @param Integer $ma_id ID des zu selektierenden Eintrags, wenn $all == false
	 * 
	 * @return Array $resultSet Assoziatives Array mit der Ergebnismenge der Abfrage
	 */
	public function getMitglied($all = true, $ma_id = null) {
		if(($all == false) && $ma_id != null) {
			$sql = "SELECT * FROM "._TBL_MA_." WHERE id = ".$ma_id." LIMIT 1";
			if((!$result = mysql_query($sql, $this->DBConn)) || (mysql_num_rows($result) != 1)) {
				return '<span class="error">Die Abfrage lieferte kein Ergebniss!</span>';
			} else {
				return mysql_fetch_row($result);
			}
		} else if(($all == true) && ($ma_id == null)) {
			$sql = "SELECT * FROM "._TBL_MA_." ORDER BY name ASC";
			if((!$result = mysql_query($sql, $this->DBConn)) || (mysql_num_rows($result) <= 0)) {
				return '<span class="error">Es ist ein Fehler aufgetreten!</span>';
			} else {
				$resultSet = null;
				while($row = mysql_fetch_assoc($result)) {
					$resultSet[] = $row;
				}				
				return $resultSet;
			}			
		} else {
			return '<span class="error">Fehlerhafte Parameter&uuml;bergabe!</span>';
		}
	}
	
	/**
	 * Z&auml;hlt jeweils die Anzahl der eingetragenen Mitarbeiter und HiWi's und die Gesamtanzahl
	 * 
	 * @return Array $count Assoziatives Array 
	 */
	public function getMitgliederCount() {
		$gesSql = "SELECT count(id) as gesamt FROM "._TBL_MA_;
		$maSql = "SELECT count(id) as ma FROM "._TBL_MA_." WHERE faktor = 'ma'";
		$hiwiSql = "SELECT count(id) as hiwi FROM "._TBL_MA_." WHERE faktor = 'hiwi'";
		
		$gesCount = mysql_fetch_row(mysql_query($gesSql,$this->DBConn));
		$maCount = mysql_fetch_row(mysql_query($maSql,$this->DBConn));
		$hiwiCount = mysql_fetch_row(mysql_query($hiwiSql,$this->DBConn));
		
		$count = array('gesamt' => $gesCount[0], 'ma' => $maCount[0], 'hiwi' => $hiwiCount[0]);
		
		return $count;
	}
	
}

?>