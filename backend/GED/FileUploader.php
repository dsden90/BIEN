<?php
/**
 * Manage the upload of file
 */

require_once('DB/DBConnection.php');

class FileUploader
{
	public $filesDirectory = "GED/files/";
	public $maxFileSize = 2097152; // 2 Mio

	private $fakeName; // name of the physical file on the serveur if real name is hidden
	private $file;
	
	function __construct($file)
	{
		if($file['size'] > $this->maxFileSize) {
			throw new Exception("La taille du fichier est trop grande. Maximum ".$this->maxFileSize, 0);
		}

		$this->file = $file;
		$this->fakeName = uniqid("GED_", true);
	}

	function registerFile($nameIsHidden) {
		$this->moveTempFileToServer($nameIsHidden);
		$this->recordInDB();
	}

	private function moveTempFileToServer($nameIsHidden) {
		$fileNameOnServeur = ($nameIsHidden)?$this->fakeName:basename($file['name']);
		$hasMovedFile = move_uploaded_file($this->file['tmp_name'], $this->filesDirectory.$fileNameOnServeur);
		if(!$hasMovedFile) {
			throw new Exception("Le fichier n'a pu être écrit sur le serveur. Nom temporaire : ".$this->file['tmp_name']." ; Nom serveur : ".$fileNameOnServeur, 2);
		}
	}

	private function recordInDB() {
		$connection = new DBConnection();
		$connection->connect();

		

		$connection->disconnect();
	}
}
?>