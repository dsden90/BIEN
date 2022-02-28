<?php
	$filesDirectory = "EDM/files/";

	$errors = []; // Store errors here

	$allowedFileExtensions = ['xls','xlsx','ods'];

	$fileName 		= $_FILES['file']['name'];
	$fileSize 		= $_FILES['file']['size'];
	$fileTmpName  	= $_FILES['file']['tmp_name'];
	$fileType 		= $_FILES['file']['type'];
	$fileExtension 	= strtolower(end(explode('.',$fileName)));

	$uploadedFilesPath = $filesDirectory.basename($fileName); 

	if(isset($_POST['submit'])) {

		if(!in_array($fileExtension,$allowedFileExtensions)) {
			$errors[] = "Seuls les fichiers Open Document Spreadsheet (ods) et Excel (xls, xlsx) sont pris en charge.";
		}

		if($fileSize > 2097152) {
			$errors[] = "Le fichier est trop volumineux. Taille maximum : 2 Mio.";
		}

		if(empty($errors)) {
			$didUpload = move_uploaded_file($fileTmpName, $uploadedFilesPath);
			if($didUpload) {
				print("Le fichier ".basename($fileName)." a été téléchargé.");
			} else {
				print("Une erreur est survenue.");
			}
		} else {
			foreach($errors as $error) {
				print($error."\n");
			}
		}
	}
?>