<?php
	include_once( '' );
	$include_path = 'src/';
	//URL-Auswerung mit GET
	//->Überprüfung auf Permission
	//->Setzen der Show-Variabeln
	/*	
		$container_title[] = {'login', 'lobby', 'create', 'gameplay', 'leader', 'rank'}
		$show_container['login'] = true;
		$show_container['lobby'] = true;
		$show_container['create'] = true;
		$show_container['gameplay'] = true;
		$show_container['leader'] = true;
		$show_container['rank'] = true;
	*/
	
?>	
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Hangman ITS</title>
</head>
<body>
<div class="wrapper">
<?php
	for($index_container_title = 0; $index_container_title < count($index_container_title); $index_container_title++) {
		if(isset($show_container[$show_container[$index_container_title]])) {
			include_once( $include_path.$show_container[$show_container[$index_container_title]] );
		}
	}
?>
</div>
</body>
</html>