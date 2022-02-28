<?php
/**
 * Manage the upload of spreadsheet files to import datas
 */

require_once('FileUploader.php');

class SpreadSheetUploader extends FileUploader
{
	const ALLOWED_FILE_EXTENSIONS = ['xls','xlsx','ods'];
	const ALLOWED_MIME_TYPES = ['application/vnd.ms-excel', 'application/vnd.oasis.opendocument.spreadsheet', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
	
	function __construct($file)
	{
		if($this->isMimeTypeAllowed($file) && $this->isFileExtensionAllowed($file)) {
			parent::__construct($file);
		}
	}

	function isFileExtensionAllowed($file) {
		$fileExtension = strtolower(end(explode('.',$file['name'])));
		if(!in_array($fileExtension, self::ALLOWED_FILE_EXTENSIONS)) {
			throw new Exception("Seuls les fichiers Open Document Spreadsheet (ods) et Excel (xls, xlsx) sont pris en charge.", 1);
		} else {
			return true;
		}
	}

	function isMimeTypeAllowed($file) {
		$fileMimeInfo = new finfo(FILEINFO_MIME_TYPE);
		$fileMimeType = $fileMimeInfo->file($file['tmp_name']);
		if(!in_array($fileMimeType, self::ALLOWED_MIME_TYPES)) {
			throw new Exception("Le fichier n'est pas valide", 1);
		} else {
			return true;
		}
	}
}
?>