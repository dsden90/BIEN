{

<?php
	$success = "true";
	$error = "";


	if(isset($_GET['classname'])) {

		// Link to DB
		require_once('DBConnection.php');
		$linker = new DBConnection();
		$link = $linker->link();

		if($link->success == true) {
			$request = "SELECT id, name FROM classrooms WHERE name = '".$_GET['classname']."'";

			$resultCount = 0;

			foreach($link->link->query($request) as $row) {
				$resultCount++;
			}

			if($resultCount > 0) {
				// classroom found
				print('
	"class": {
		"name": "'.$_GET['classname'].'",
		"id": "'.$row[0].'"
	},');

			} else {
				// classroom not found
				$success = "false";
				$error .= "Error: classroom not found.";
			}

			$linker->unlink();
		} else {
			$success = "false";
			$error .= "Error: unable to connect to data base.";
		}

	} else {
		$success = "false";
		$error .= "Error: no class requested.";
	}
?>

	"error": "<?php print($error); ?>",
	"success": "<?php print($success); ?>"
}