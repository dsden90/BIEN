<?php
	$jsonInput = file_get_contents('php://input');
	$objectInput = json_decode($jsonInput);

	if(substr($objectInput->phoneNumber, 0, 1) == "3") {
		$objectInput->phoneNumber = "0".$objectInput->phoneNumber;
	}

	print("
		<form action='#' method='POST'>
			UAI : <input name='UAI' type='text' value='".$objectInput->UAI."' />
			Nom : <input name='name' type='text' value='".$objectInput->name."' />
			Adresse : <input name='address' type='text' value='".$objectInput->address."' />
			Téléphone : <input name='phoneNumber' type='text' value='".$objectInput->phoneNumber."' />
			Courriel : <input name='emailAddress' type='text' value='".$objectInput->emailAddress."' />
			Collège de rattachement : <input name='midSchool' type='text' value='".$objectInput->midSchool."' />
			Bibliothèque : <input name='library' type='text' value='".$objectInput->library."' />
			<button id='validate'>Ajouter</button>
		</form>
		");
?>