<?php

/**
 *
 *
 * @author Tobias Beckmerhagen
 *
 */
class Textbausteine {

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
	 * Selektiert alle Textbausteintitel und gibt diese als Array zur&uuml;ck
	 * 
	 * @return Array $resultSet Textbaustein Titel 
	 */
	public function getAllTitel() {
		$sql = "SELECT titel FROM "._TBL_TXT_BAUSTEINE_;
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
?>