<?php
/**
 * DB query handler
 */

require_once('DBConnection.php');

class DBQueryHandler {

	private $dbConnection;

	function __construct() {
		$this->dbConnection = new DBConnection();
		if(!$this->dbConnection->success) {
			throw new Exception("Impossible d'établir la connexion avec la base de données.", 3);
		}
	}

	function insert($query) {
		$this->dbConnection->query()
	}
}
?>