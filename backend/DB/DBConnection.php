<?php
/**
 * connection handler
 */
class DBConnection {

	private $dbServer;
	private $dbPort;
	private $dbUser;
	private $dbPassword;
	private $dbLink;
	
	function __construct() {
		$this->dbServer = "127.0.0.1";
		$this->dbPort = "3307";
		$this->dbUser = "bienadmin";
		$this->dbPassword = "l5_fTr0P#Km";
		$this->dbName = "bien";
		$this->dbLink = null;
	}

	function connect() {
		$returnedObject = new stdClass();
		
		try {
			$this->dbLink = new PDO("mysql:host=".$this->dbServer.";port=".$this->dbPort.";dbname=".$this->dbName, $this->dbUser, $this->dbPassword);
			$returnedObject->success = true;
			$returnedObject->link = $this->dbLink;
		} catch (PDOException $e) {
			$returnedObject = new stdClass();
			$returnedObject->success = false;
			$returnedObject->error = "DB Error:" . $e->getMessage() . "<br/>";
		}
		
		return $returnedObject;
	}

	function disconnect() {
		$this->dbLink = null;
	}
}
?>