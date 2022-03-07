<?php
/**
 * Sheet 
 * Extrait les données d'une fiche école
 */

class SheetManager {

	private $fileURI;

	function __construct() {
	}

	function load($fileURI) {
		$this->fileURI = $fileURI;
	}
}
?>