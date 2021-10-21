<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Nove</title>
	<link rel="stylesheet" type="text/css" href="frontend/styles/common.css" />
	<script type="module">
		import {SpreadSheetUploader} from './frontend/js/SpreadSheetUploader.js';

		document.addEventListener('DOMContentLoaded', function() {
			var sheetUploaderDOMElement = document.querySelector("#sheet-importer");
			var sheetImporter = new SpreadSheetUploader(sheetUploaderDOMElement);
		});
	</script>
</head>
<body>

	<div class="module" id="sheet-importer">
		<h2>Importer un fichier de données</h2>
    	<form action="backend/import-datas.php" method="post" enctype="multipart/form-data">
    		Indiquer la source : 
    		<select name="file-source">
    			<option value="fiche-ecole">Fiche école</option>
    			<!-- <option value="export-agape">Export Agape</option> -->
    			<!-- <option value="export-onde">Export Onde</option> -->
    			<!-- <option value="export-gaia">Export Gaïa</option> -->
    		</select>
    		<input type="file" name="spreadSheet" id="file-input">
    		<button name="submit">Importer le fichier</button>
    	</form>
	</div>

	<div class="module" id="files-list">
		<h2>Liste des fichiers envoyés</h2>
		<?php
	    	$filesDirectory = "backend/GED/files/";

	    	foreach (new DirectoryIterator($filesDirectory) as $fileInfo) {
	    		if($fileInfo->isFile()) {
	    			print($fileInfo->getFilename()."<br />\n");
	    		}
	    	}
	    ?>
	</div>
</body>
</html>