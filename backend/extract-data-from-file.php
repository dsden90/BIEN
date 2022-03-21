{
<?php

	$jsonInput = file_get_contents('php://input');
	$objectInput = json_decode($jsonInput);

	function getFileInfos($fileId) {
		require_once('DB/DBQueryHandler.php');
		$dbHandler = new DBQueryHandler();
		$getFileURIQuery = "SELECT original_name, uri, fk_EDM_file_type_id as type
			FROM EDM_files
			WHERE EDM_file_id = ".$fileId;
		$results = $dbHandler->select($getFileURIQuery);
		return $results[0];
	}

	if(!isset($objectInput->fileId)) {
		print('"success": "false",
			"error": "file id is missing"');
	} else {
		$fileInfos = getFileInfos((int)$objectInput->fileId);

		if($fileInfos['type'] == 1) {
			require_once('FILES/SchoolSheetExtractor.php');
			$extractor = new SchoolSheetExtractor($fileInfos['uri']);
			$infos = $extractor->extractAll();
			print('"success": "true", "type": "fiche école",');
			print('"data": ');
			print(json_encode($infos));
			// print(',"debug": '.json_encode($extractor->getWorkers(20)));
		} else if($fileInfos['type'] == 2) {
			print('"success": "false",
			"error": "Les export Agape ne sont pas encore pris en charge"');
		} else if($fileInfos['type'] == 3) {
			print('"success": "false",
			"error": "Les export ONDE ne sont pas encore pris en charge"');
		} else if($fileInfos['type'] == 4) {
			print('"success": "false",
			"error": "Les export Gaïa ne sont pas encore pris en charge"');
		}



		$fileURI = $fileInfos['uri'];
		
	}
?>


}