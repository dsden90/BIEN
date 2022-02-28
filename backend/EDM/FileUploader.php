<?php
/**
 * Manage the upload of file
 */

// require_once('DB/DBConnection.php');
require_once('DB/DBQueryHandler.php');

class FileUploader
{
	public $filesDirectory = "EDM/files/";
	public $maxFileSize = 2097152; // 2 Mio

	private $fakeName; // name of the physical file on the serveur if real name is hidden
	private $chosenName; // depends on choice between fake or original name
	private $file;
	
	function __construct($file)
	{
		if($file['size'] > $this->maxFileSize) {
			throw new Exception("La taille du fichier est trop grande. Maximum ".$this->maxFileSize, 0);
		}

		$this->file = $file;
		$this->fakeName = uniqid("EDM_", true);
	}

	function registerFile($nameIsHidden, $fileTypeId) {
		$this->moveTempFileToServer($nameIsHidden);
		$this->recordInDB($fileTypeId);
	}

	private function moveTempFileToServer($nameIsHidden) {
		$this->chosenName = ($nameIsHidden)?$this->fakeName:basename($this->file['name']);
		$hasMovedFile = move_uploaded_file($this->file['tmp_name'], $this->filesDirectory.$this->chosenName);
		if(!$hasMovedFile) {
			throw new Exception("Le fichier n'a pu être écrit sur le serveur.", 2);
			// throw new Exception("Le fichier n'a pu être écrit sur le serveur. Nom temporaire : ".$this->file['tmp_name']." ; Nom serveur : ".$fileNameOnServeur, 2);
		}
	}

	private function recordInDB($fileTypeId) {
		$registerFileQuery = "INSERT INTO EDM_files (
				original_name, 
				uri, 
				fk_user_id,
				fk_EDM_file_type_id) 
			VALUES (
				'".basename($this->file['name'])."', 
				'".$this->chosenName."', 
				'1',
				'".$fileTypeId."')";


		$dbHandler = new DBQueryHandler();
		$fileDBId = $dbHandler->insert($registerFileQuery);


		if($fileDBId == 0) {
			throw new Exception("Le fichier n'a pas pu être inscrit en BDD.");
		}

		$fileStatusQuery = "INSERT INTO EDM_files_have_states (
				fk_user_id, 
				fk_EDM_file_id,
				fk_EDM_file_state_id,
				setting_date) 
			VALUES (
				'1',
				'".$fileDBId."',
				'1',
				'".date("Y-m-d H:i:s")."')";

		try {
			$dbHandler->insert($fileStatusQuery);
		} catch (Exception $e) {
			throw new Exception("Le statut du fichier n'a pas pu être inscrit en BDD. ".$e->getMessage());
		}

		$dbHandler->revoke();
	}
}
?>