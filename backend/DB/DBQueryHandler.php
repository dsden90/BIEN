<?php
/**
 * DB query handler
 */

require_once('DBConnection.php');

class DBQueryHandler {

	private $dbConnection;

	function __construct() {
		$this->dbConnection = new DBConnection();
		$connectionDebug = $this->dbConnection->connect();
		if($this->dbConnection->getConnectionState() !== 'connected') {
			throw new Exception("Impossible d'établir la connexion avec la base de données : ".$connectionDebug->error, 3);
		}
	}

	function revoke() {
		$this->dbConnection->disconnect();
		unset($this->dbConnection);
	}

	function select($query) {
		$results = [];
		foreach($this->dbConnection->query($query) as $row) {
			array_push($results, $row);
		}
		return $results;
	}

	function delete($query) {
		$returnedObject = new stdClass();
		$returnedObject->success = false;
		$returnedObject->errorMessage = null;
		try {
			$this->dbConnection->query($query);
			$returnedObject->success = true;
		} catch (Exception $e) {
			$returnedObject->success = false;
			$returnedObject->errorMessage = $e->getMessage();
		}
		return $returnedObject;
	}



	function insert($query) {
		$this->dbConnection->query($query);
		return $this->dbConnection->getLastInsertedId();
	}
}
?>