{
	"results":[
<?php
	$jsonInput = file_get_contents('php://input');
	$objectInput = json_decode($jsonInput);

	function getFileURIFromId($id, $dbHandler) {
		$getFileInfoQuery = "SELECT uri FROM `EDM_files` WHERE EDM_files.EDM_file_id = ".$id;
		$URI = $dbHandler->select($getFileInfoQuery);
		return $URI;
	}

	function deleteFileFromServer($id, $dbHandler) {
		$files = getFileURIFromId($id, $dbHandler);
		if(count($files) > 0) {
			$fileURI = $files[0]["uri"];
			unlink('../EDM/files/'.$fileURI);
		}
	}

	function removeFileState($id, $dbHandler) {
		$fileStateQuery = "DELETE FROM `EDM_files_have_states`
			WHERE `fk_EDM_file_id` = ".$id;
		$dbHandler->delete($fileStateQuery);
	}

	function removeFileRegistration($id, $dbHandler) {
		$fileQuery = "DELETE FROM `EDM_files` 
			WHERE `EDM_files`.`EDM_file_id` = 
			".$id;
		$dbHandler->delete($fileQuery);
	}

	if(isset($objectInput->file_id)) {
		if(gettype($objectInput->file_id) === 'integer') {

			$errors = [];

			require_once("./DBQueryHandler.php");
			$dbHandler = new DBQueryHandler();
			
			try {
				deleteFileFromServer($objectInput->file_id, $dbHandler);
			} catch (Exception $e) {
				array_push($errors, $e->getMessage);
			}

			removeFileState($objectInput->file_id, $dbHandler);
			removeFileRegistration($objectInput->file_id, $dbHandler);
			
			$dbHandler->revoke();

			print('{"success": "true",
			"error": "');
			foreach($errors as $error) {
				print(' ['.$error.']');
			}
			print('"}');

		} else {
			print('{"success": "false",
			"error": "bad file id type"}');
		}
	} else {
		print('{"success": "false",
			"error": "unknown file id"}');
	}
?>
	]
}