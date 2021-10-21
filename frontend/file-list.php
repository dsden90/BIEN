<?php
	$filesDirectory = "backend/GED/files/";

	foreach (new DirectoryIterator($filesDirectory) as $fileInfo) {
		if($fileInfo->isFile()) {
			print($fileInfo->getFilename()."<br />\n");
		}
	}
?>