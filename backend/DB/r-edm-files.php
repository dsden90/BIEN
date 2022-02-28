{
	"results":[
<?php
	require_once("./DBQueryHandler.php");

	$dbHandler = new DBQueryHandler();
	$results = $dbHandler->select("
		SELECT 
			EDM_files.EDM_file_id, EDM_files.original_name,
			EDM_file_types.name AS file_type_name,
			users.login,
			EDM_file_states.name AS state_name
		FROM `EDM_files`
		LEFT JOIN `EDM_file_types` ON 
			EDM_files.fk_EDM_file_type_id = EDM_file_types.EDM_file_type_id
		LEFT JOIN `users` ON EDM_files.fk_user_id = users.user_id 
		LEFT JOIN `EDM_files_have_states` ON EDM_files_have_states.fk_EDM_file_id = EDM_files.EDM_file_id 
		LEFT JOIN `EDM_file_states` ON EDM_files_have_states.fk_EDM_file_state_id = EDM_file_states.EDM_file_state_id
	");

	$dbHandler->revoke();

	$nbResults = count($results);
	for($i = 0; $i < $nbResults; $i++) {
		print('{ 
			"id": "'.$results[$i]["EDM_file_id"].'",
			"name": "'.$results[$i]["original_name"].'",
			"file_type": "'.$results[$i]["file_type_name"].'",
			"owner": "'.$results[$i]["login"].'",
			"state": "'.$results[$i]["state_name"].'"
		}');
		if($i < $nbResults-1)
			print(',');
	}

?>
	]
}