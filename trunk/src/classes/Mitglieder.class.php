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
	
	/**
	 * Aktualisiert die Daten eines Mitgliedes.
	 * 
	 * @param Integer $id Mitglieds ID
	 * @param Integer $email E-Mail Adresse
	 * @param Integer $faktor Berechungsfaktor des Mitgliedes (ma|hiwi)
	 * @param Integer $status Status ob das Mitglied aktiv oder inaktiv ist (1|0)
	 * 
	 * @return Array $updateResult Assoziatives Array mit Integer Werten f&uuml;r die einzelnen Update Vorg&auml;nge
	 */
	public function updateMitglied($id, $email, $faktor, $status) {
		$updateResult;
		$mitgliedData = $this->getMitglied(false, $id);
		if($mitgliedData[6] != $status) {
			$updateStatusSql = "UPDATE "._TBL_MA_STAT_." SET status = '".$status."', datum = CURDATE() WHERE maid = ".$id." LIMIT 1";
			if((!$statusResult = mysql_query($updateStatusSql, $this->DBConn)) || (mysql_affected_rows($this->DBConn) != 1)) {
				$updateResult['status'] = -1;
			} else {
				$updateResult['status'] = 1;
			}
		}
		
		if(($mitgliedData[3] != $email) || ($mitgliedData[5] != $faktor)) {
			$updateStammDaten = "UPDATE "._TBL_MA_." SET email = '".$email."', faktor = '".$faktor."' WHERE id = ".$id." LIMIT 1";
			if((!$stammResult = mysql_query($updateStammDaten, $this->DBConn)) || (mysql_affected_rows($this->DBConn) != 1)) {
				$updateResult['stammDaten'] = -1;
			} else {
				$updateResult['stammDaten'] = 1;
			}
		}
		return $updateResult;
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
			$sql = "SELECT ma.*, ms.status FROM "._TBL_MA_." ma, "._TBL_MA_STAT_." ms WHERE ma.id = ".$ma_id." AND ma.id = ms.maid LIMIT 1";
			if((!$result = mysql_query($sql, $this->DBConn)) || (mysql_num_rows($result) != 1)) {
				return '<span class="error">Die Abfrage lieferte kein Ergebniss!</span>';
			} else {
				return mysql_fetch_row($result);
			}
		} else if(($all == true) && ($ma_id == null)) {
			$sql = "SELECT ma.*, ms.status FROM "._TBL_MA_." ma, "._TBL_MA_STAT_." ms WHERE ms.maid = ma.id ORDER BY name ASC";
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
	 * Gibt die interne ID eines bestimmten Benutzers aus
	 * 
	 * @param String $ma_name Nachname des Benutzers 
	 * @param Integer $ma_email Email Adresse des Benutzers
	 * 
	 * @return Array $resultSet Assoziatives Array mit der Ergebnismenge der Abfrage
	 */
	public function getMitgliedID($ma_name = null, $ma_email = null) {
		if(($ma_name != null) && ($ma_email == null)) {
			$sql = "SELECT id FROM "._TBL_MA_." WHERE name = LOWER('".strtolower($ma_name)."') LIMIT 1";
			if((!$result = mysql_query($sql, $this->DBConn)) || (mysql_num_rows($result) != 1)) {
				return '<span class="error">Die Abfrage lieferte kein Ergebniss!</span>';
			} else {
				$id_result = mysql_fetch_row($result);
				return $id_result[0];
			}
		} else if(($ma_name == null) && ($ma_email != null)) {
			$sql = "SELECT id FROM "._TBL_MA_." WHERE email = LOWER('".strtolower($ma_email)."') LIMIT 1";
			if((!$result = mysql_query($sql, $this->DBConn)) || (mysql_num_rows($result) != 1)) {
				return '<span class="error">Die Abfrage lieferte kein Ergebniss!</span>';
			} else {
				$id_result = mysql_fetch_row($result);
				return $id_result[0];
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
	
	/**
	 * Liefert den Kontostand des Benutzers mit der uebergebenen ID
	 * 
	 * @param Integer $userId
	 * 
	 * @return Integer User Account balance
	 */
	public function getAccountBalance($userId) {
		$sql = "SELECT sum(betrag) as ktostand FROM "._TBL_MA_KTO_." WHERE ma_id = ".$userId." LIMIT 1";
		if((!$result = mysql_query($sql, $this->DBConn)) || (mysql_num_rows($result) != 1)) {
			return '<span class="error">Die Abfrage lieferte kein Ergebniss!</span>';
		} else {
			$resArr = mysql_fetch_row($result);
			return $resArr[0];
		}
	}
	
}

?>