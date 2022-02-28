<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>BIEN Pajitnov</title>
	<link rel="icon" type="image/x-icon" href="./favicon.ico">
	<link rel="stylesheet" type="text/css" href="frontend/styles/common.css" />
	<script type="module">
		import {SpreadSheetUploader} from './frontend/js/SpreadSheetUploader.js';
		import {EDMFileListManager} from './frontend/js/EDMFileListManager.js';

		document.addEventListener('DOMContentLoaded', function() {
			// EDM files list
			let fileListManager = new EDMFileListManager(document.querySelector("#EDMFileList"));
			let sheetImporter = new SpreadSheetUploader(document.querySelector("#sheet-importer"));

			fileListManager.loadDatas();

			sheetImporter.addEventListener(
				SpreadSheetUploader.FILE_IMPORTED_EVENT, 
				fileListManager.loadDatas.bind(fileListManager)
			);
		});
	</script>
</head>
<body>

	<div class="module" id="sheet-importer">
		<h2>Importer un fichier de données</h2>
    	<form action="#" method="post" enctype="multipart/form-data">
    		Indiquer la source : 
    		<select name="file-source">
    			<?php
	    			require_once('backend/DB/DBQueryHandler.php');
					$dbHandler = new DBQueryHandler();
					$EDM_file_types = $dbHandler->select("SELECT * FROM EDM_file_types");
					$dbHandler->revoke();
					for($i = 0; $i < count($EDM_file_types); $i++) {
						print('<option value="'.$EDM_file_types[$i]["EDM_file_type_id"].'">'.$EDM_file_types[$i]["name"].'</option>');
					}
				?>
    		</select>
    		<input type="file" name="spreadSheet" id="file-input">
    		<button name="submit">Importer le fichier</button>
    	</form>
	</div>

	<div class="module" id="files-list">
		<h2>Liste des fichiers envoyés</h2>
		<div id="EDMFileList"></div>
	</div>
</body>
</html>