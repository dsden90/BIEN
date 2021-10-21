<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Importer des données</title>
</head>
<body>
	<form action="backend/import-datas.php" method="post" enctype="multipart/form-data">
		Indiquer la source : 
		<select name="file-source">
			<option value="fiche-ecole">Fiche école</option>
		</select>
		<input type="file" name="file" id="file-input">
		<input type="submit" name="submit" value="Importer le fichier">
	</form>
</body>
</html>