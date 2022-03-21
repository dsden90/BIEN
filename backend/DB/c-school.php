{
	"results":[
<?php
	require_once("./DBQueryHandler.php");

	$jsonInput = file_get_contents('php://input');
	$objectInput = json_decode($jsonInput);

	// $request = "SELECT * FROM `schools` ";

	// if(isset($objectInput->UAI) && $objectInput->UAI != "") {
	// 	$request .= " WHERE `UAI` LIKE '".$objectInput->UAI."'";
	// } else if(isset($objectInput->emailAddress) && $objectInput->emailAddress != "") {
	// 	print('"emailAddress": '.$objectInput->emailAddress);
	// } else if(isset($objectInput->name) && $objectInput->name != "") {
	// 	print('"name": '.$objectInput->name);
	// }

	// $dbHandler = new DBQueryHandler();
	// $results = $dbHandler->select($request);
	// $dbHandler->revoke();

	// $nbResults = count($results);
	// for($i = 0; $i < $nbResults; $i++) {
	// 	print('{
	// 		"UAI": "'.$results[$i]["UAI"].'",
	// 		"name": "'.$results[$i]["name"].'",
	// 		"city": "'.$results[$i]["city"].'"
	// 	}');
	// 	if($i < $nbResults-1)
	// 		print(',');
	// }


?>
	]
}