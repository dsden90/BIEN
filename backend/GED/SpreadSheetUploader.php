<?php
/**
 * Manage the upload of spreadsheet files to import datas
 */

require_once('FileUploader.php');

class SpreadSheetUploader extends FileUploader
{
	const ALLOWEDFILEEXTENSIONS = ['xls','xlsx','ods'];

	private $fileExtension;
	
	function __construct($file)
	{
		parent::__construct($file);

		$this->fileExtension = strtolower(end(explode('.',$file['name'])));

		if(!in_array($this->fileExtension, self::ALLOWEDFILEEXTENSIONS)) {
			throw new Exception("Seuls les fichiers Open Document Spreadsheet (ods) et Excel (xls, xlsx) sont pris en charge.", 1);
		}
	}
}
?>