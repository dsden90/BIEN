<?php
/**
 * School Sheet Extractor
 * Extrait les données d'une fiche école
 */

require_once('SheetManager.php');

class SchoolSheetExtractor {

	private $sheetManager;

	function __construct($uri) {
		$sheetManager = new SheetManager();
		$sheetManager->load($uri);
	}

}
?>