<?php

/**
 * MySql Klasse fuer die Anbindung an eine MySQL Datenbank
 *
 * @author Tobias Beckmerhagen
 * @version 1.0
 */
class DBMySql {

	private $host = null;
	private $user = null;
	private $passwd = null;
	private $database = null;

	public $connection = null;

	/**
	 * Konstruktor<br />
	 * Erzeugt Datenbankverbindung
	 */
	public function __construct() {
		$this->host = _DB_HOST;
		$this->user = _DB_USER;
		$this->passwd = _DB_PASSWD;
		$this->database = _DB_DATABASE;

		if($this->connection === null) {
			$this->connect();
		}
	}

	/**
	 * Stellt Verbindung zum Datenbankserver her<br />
	 * und verbindet mit der Datenbank
	 */
	private function connect() {
		if(!$this->connection = mysql_connect($this->host,$this->user,$this->passwd)) {
			throw new DBMySqlException("Fehler beim verbinden mit dem Datenbankserver # DBMySql.class.php",110);
		}

		if(!mysql_select_db($this->database,$this->connection)) {
			throw new DBMySqlException("Fehler beim auswaehlen der Datenbank # DBMySql.class.php",666);
		}
	}

	/**
	 * Trennt die Verbindung zum Datenbankserver
	 */
	private function disconnect() {
		if(!mysql_close($this->connection)) {
			throw new DBMySqlException("Fehler beim trennen der Datenbankverbindung # DBMySql.class.php",911);
		}
	}

	/**
	 * Destruktor<br />
	 * ruft die Disconnect Methode auf um Verbindung zum Datenbankserver zu beenden
	 */
	public function __destruct() {
		try {
			$this->disconnect();
		} catch (DBMySqlException $dbex) {
			print_r($dbex);
		}
	}

	private function __clone() {}

}

?>