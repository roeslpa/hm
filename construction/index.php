<?php
	include_once( '../../inc/db.php.inc' );
	$include_path = 'src/';
	//URL-Auswerung mit GET
	//->Überprüfung auf Permission
	//->Setzen der Show-Variabeln
	$gameId = $_SESSION['gameId']; //Game ID
	$userId = $_SESSION['userId'];
	
	$container_title = array('login', 'lobby', 'create', 'gameplay', 'leader', 'rank');
	
	$_GET['login'] = 'on';
	/*$_GET['lobby'] = 'on';
	$_GET['create'] = 'on';
	$_GET['gameplay'] = 'on';
	$_GET['leader'] = 'on';
	$_GET['rank'] = 'on'; */
	
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
		if($gid!='' && $uid!='' && $gid!='0') {
			$gameInfo = getGameInfo($userId,$gameId);
			if($leaderInfo['status'] == 0) {
				$show_container['gameplay'] = true;
			} else {
				$show_container['leader'] = true;
			}
		}
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
    <link href="css/normalize.css" type="text/css" rel="stylesheet">
    <link href="css/style.css" type="text/css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
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