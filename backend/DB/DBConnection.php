<?php
/**
 * connection handler
 */
class DBConnection {

	private $connectionState;
	private $dbServer;
	private $dbPort;
	private $dbUser;
	private $dbPassword;
	private $dbLink;
	
	function __construct() {
		$this->connectionState = 'disconnected';
		$this->dbServer = "localhost";
		$this->dbPort = "3306";
		$this->dbUser = "pajitnov";
		$this->dbPassword = "pajitnov";
		$this->dbName = "pajitnov";
		$this->dbLink = null;
	}

	function connect() {
		$returnedObject = new stdClass();
		
		try {
			$this->dbLink = new PDO("mysql:host=".$this->dbServer.";port=".$this->dbPort.";dbname=".$this->dbName, $this->dbUser, $this->dbPassword);
			$returnedObject->success = true;
			$returnedObject->link = $this->dbLink;
			$this->connectionState = 'connected';
		} catch (PDOException $e) {
			$returnedObject = new stdClass();
			$returnedObject->success = false;
			$returnedObject->error = "DB Error:" . $e->getMessage() . "<br/>";
		}
		
		return $returnedObject;
	}

	function disconnect() {
		$this->dbLink = null;
		$this->connectionState = 'disconnected';
	}

	function getConnectionState() {
		return $this->connectionState;
	}

	function query($query) {
		return $this->dbLink->query($query);
	}

	function getLastInsertedId() {
		return $this->dbLink->lastInsertId();
	}
}
?>