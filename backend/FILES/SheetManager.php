<?php
/**
 * Sheet 
 * Extrait les données d'une fiche école
 */

require '../libs/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SheetManager {

	private $fileContent;
	private $fileURI;
	private $reader;

	function __construct() {
	}

	function load($fileURI) {
		$this->fileURI = $fileURI;
		try {
			$this->reader = IOFactory::createReaderForFile('./EDM/files/'.$this->fileURI);
			$this->reader->setReadDataOnly(true);
			$this->fileContent = $this->reader->load('./EDM/files/'.$this->fileURI);
		} catch(Exception $e) {
			print_r($e);
		}
	}

	function getCellValue($cellName) {
		return $this->fileContent->getActiveSheet()->getCell($cellName)->getValue();
	}
}
?>