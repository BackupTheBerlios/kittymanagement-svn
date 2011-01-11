<?php

/**
 * 
 * 
 * @author Tobias Beckmerhagen
 *
 */
class Kasse {

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
	 * Liefert alle Buchungen der Kasse.<br />
	 * Die Anzahl der Datens&auml;tze kann &uuml;ber den Parameter gesteuert werden.
	 * 
	 * @param Integer $displayLimit Anzahl anzuzeigender Ausgaben
	 */
	public function getCashBoxPostings($displayLimit = null) {
		
		if ($displayLimit != null && is_int($displayLimit)) {
			$sql = "SELECT 
						  date_format(datum, '%d.%m.%Y') as datum
						, bemerkung
						, betrag 
					FROM "._TBL_KA_KASSE_."
					ORDER BY lfdnr DESC 
					LIMIT ".$displayLimit;
		} else {
			$sql = "SELECT * 
					FROM "._TBL_KA_KASSE_."
					ORDER BY lfdnr DESC";
		}

		if((!$result = mysql_query($sql, $this->DBConn)) || (mysql_num_rows($result) <= 0)) {
			return '<span class="error">Es ist ein Fehler aufgetreten!</span>';
		} else {
			$resultSet = null;
			while($row = mysql_fetch_assoc($result)) {
				$resultSet[] = $row;
			}				
			return $resultSet;
		}
	}
	
	/**
	 * Liefert alle Einzahlungen in die Kasse.<br />
	 * Die Anzahl der Datens&auml;tze kann &uuml;ber den Parameter gesteuert werden.
	 * 
	 * @param Integer $displayLimit Anzahl anzuzeigender Ausgaben
	 */
	public function getPayments($displayLimit = null) {
		
		if ($displayLimit != null && is_int($displayLimit)) {
			$sql = "SELECT 
						  date_format(mkto.datum, '%d.%m.%Y') as datum
						, CONCAT(mst.name, ', ', mst.vorname) as name
						, mkto.bemerkung
						, mkto.betrag 
					FROM 
						  "._TBL_MA_KTO_." mkto
						, "._TBL_MA_." mst
					WHERE 
						mkto.ma_id = mst.id
						AND 
						mkto.art = '+'
					ORDER BY mkto.lfdnr DESC 
					LIMIT ".$displayLimit;
		} else {
			$sql = "SELECT 
						  mkto.*
						, CONCAT(mst.name, ', ', mst.vorname) as name 
					FROM 
						  "._TBL_MA_KTO_." mkto 
						, "._TBL_MA_." mst
					WHERE
						mkto.ma_id = mst.id
						AND 
						mkto.art = '+' 
					ORDER BY mkto.lfdnr DESC";
		}

		if((!$result = mysql_query($sql, $this->DBConn)) || (mysql_num_rows($result) <= 0)) {
			return '<span class="error">Es ist ein Fehler aufgetreten!</span>';
		} else {
			$resultSet = null;
			while($row = mysql_fetch_assoc($result)) {
				$resultSet[] = $row;
			}				
			return $resultSet;
		}
	}
}