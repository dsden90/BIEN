{

<?php
	$success = "true";
	$error = "";

	// Check user existance and give related classrooms
	if(isset($_GET['username']) && isset($_GET['merge']) && $_GET['merge'] === 'classroom') {
		// Link to DB
		require_once('DBConnection.php');
		$linker = new DBConnection();
		$link = $linker->link();

		if($link->success === true) {
			$request = "SELECT classrooms.id, classrooms.name 
			FROM users, users_classrooms, classrooms
			WHERE users.name = '".$_GET['username']."'
			AND users.id = users_classrooms.id_user 
			AND users_classrooms.id_classroom = classrooms.id";

			$JSONData = '';

			$JSONData .= '	"classrooms": [';
			$resultCount = 0;

			foreach ($linker->query($request) as $line => $classroom) {
				$JSONData .= '{"id": "'.$classroom["id"].'", "name": "'.$classroom["name"].'"},';
				$resultCount++;
			}

			if($resultCount > 0)
				$JSONData = substr($JSONData, 0, strlen($JSONData)-1);
			$JSONData .= '],';

			print($JSONData);
		} else {
			$success = "false";
			$error .= "Error: unable to connect to data base.";
		}
	}
?>

	"error": "<?php print($error); ?>",
	"success": "<?php print($success); ?>"
}