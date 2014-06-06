<?php
	session_start();
	include_once( '../../inc/db.php.inc' );
	include_once( 'src/functions.php' );
	
	$include_path = 'src/';
	//URL-Auswerung mit GET
	//->Überprüfung auf Permission
	//->Setzen der Show-Variabeln
	if(isset($_SESSION['gameId'])) {
		$gameId = $_SESSION['gameId']; //Game ID
	} else {
		$gameId = '';
	}
	if(isset($_SESSION['userId'])) {
		$userId = $_SESSION['userId'];
	} else {
		$userId = '';
	}
	echo $userId." ".$gameId;
	
	$show_container = array();
	$container_title = array('login', 'lobby', 'create', 'gameplay', 'leader', 'rank');
	
	/*$_GET['lobby'] = 'on';
	$_GET['create'] = 'on';
	$_GET['gameplay'] = 'on';
	$_GET['leader'] = 'on';
	$_GET['rank'] = 'on'; */
	
	if(isset($_GET['login'])){
		$show_container['login'] = true;
	}
	if(isset($_GET['lobby'])){
		if($userId!='') {
			$show_container['lobby'] = true;
		}
	}
	if(isset($_GET['create'])){
		if($userId!='') {
			$show_container['create'] = true;
		}
	}
	if(isset($_GET['gameplay'])){
		if($uid!='' && $gid!='' && $gid!='0') {
			$gameInfo = getGameInfo($userId,$gameId);
			if($gameInfo['status'] == 0) {
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
	
	if(count($show_container)<1)
		$show_container['login']= true;

	for($index_container_title = 0; $index_container_title < count($container_title); $index_container_title++) { 
		if(isset($show_container[$container_title[$index_container_title]])) {
			include_once( $include_path.$container_title[$index_container_title].'.php' );
		}
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
<header>
<?php include_once( $include_path.'header.php' )?>
</header>
<?php
for($index_container_title = 0; $index_container_title < count($container_title); $index_container_title++) { 
		if(isset($show_container[$container_title[$index_container_title]])) {
			echo $content['login'];
		}
	}
?>
<nav>
<?php include_once( $include_path.'nav.php' )?>
</nav>
</div>
</body>
</html>

<?php 
if(isset($_GET['hashpassword']))
	echo hash_pw($_GET['hashpassword']);
?>