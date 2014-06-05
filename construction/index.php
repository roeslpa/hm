<?php
	//include_once( '' );
	$include_path = 'src/';
	//URL-Auswerung mit GET
	//->Überprüfung auf Permission
	//->Setzen der Show-Variabeln
	$container_title = array('login', 'lobby', 'create', 'gameplay', 'leader', 'rank');
	$_GET['login'] = 'on'; $_GET['lobby'] = 'on'; $_GET['create'] = 'on'; $_GET['gameplay'] = 'on'; $_GET['leader'] = 'on'; $_GET['rank'] = 'on'; 
	if(isset($_GET['login'])){
		$show_container['login'] = true;
	}
	if(isset($_GET['lobby'])){
		//check permission
		$show_container['lobby'] = true;
	}
	if(isset($_GET['create'])){
		//check permission
		$show_container['create'] = true;
	}
	if(isset($_GET['gameplay'])){
		//check permission
		$show_container['gameplay'] = true;
	}
	if(isset($_GET['leader'])){
		//check permission
		$show_container['leader'] = true;
	}
	if(isset($_GET['rank'])){
		//check permission
		$show_container['rank'] = true;
	}
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
	for($index_container_title = 0; $index_container_title < count($container_title); $index_container_title++) { 
		if(isset($show_container[$container_title[$index_container_title]])) {
			include_once( $include_path.$container_title[$index_container_title].'.php' );
		}
	}
?>
</div>
</body>
</html>