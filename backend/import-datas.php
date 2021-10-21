<?php
	require_once('GED/SpreadSheetUploader.php');

	$errors = [];

	$fileSources = ['fiche-ecole', 'export-agape', 'export-onde', 'export-gaia'];

	if(!isset($_POST['file-source'])) {
		$errors[] = "La source est inconnue. Veuillez l'indiquer.";
	} else if(!in_array($_POST['file-source'], $fileSources)) {
		$errors[] = "La source du fichier est incorrecte. (".$_POST['file-source'].").";
	} else {
		try {
			$uploader = new SpreadSheetUploader($_FILES['spreadSheet']);
			$uploader->registerFile(true);
		} catch (Exception $exception) {
			$errors[] = $exception->getMessage();
		}
	}

	print('{ "success": "'.(empty($errors)?"true":"false").'", "errors": [');

	for ($errorIndex=0; $errorIndex < count($errors); $errorIndex++) { 
		print('"'.$errors[$errorIndex].'"');
		if($errorIndex !== count($errors)-1) {
			print(', ');
		}
	}
	

	print('] }');
?>