<?php
if(isset($_GET['action'])){
	
} else {
	$content['create'] = 
	"<div class='createContainer'>
	<div class='getInGame'>";
	if($_GET['gameId'] == '') {
		$content['create'] .= 
		"<form action='?create=on&action=newGame' method='post' name='formNewGame'>
	            Gamepassword: <input type='password' name='gamePassword'><br>
	            Word: <input type='text' name='word'><br>	
	            <a href='#' onClick='formNewGame.submit()'>create</a>
		</form>";
	} else if($_GET['gameId'] != '') {		//Spiel beitreten
		$content['create'] .= 
		"<form action='?create=on&action=changeGameId' method='post' name='formJoin'>
	            <input type='hidden' name='gameId' value='".$_GET['gameId']."'>
	            Gamepassword: <input type='password' name='gamePassword'><br>
	            <a href='#' onClick='formJoin.submit()'>join</a>
		</form>";
	}
	$content['create'] .= 
		"</div>
	</div>";
}


function actionChangeGameId($userId,$gameId,$leave,$gamePassword) {
	if($leave == '1') {
		$changingGameId = '0';
		$result = '';
	} else {
		$changingGameId = $gameId;
	}
	$sql1 = "update `hm` ";
	$sql2 = "set `gid` = '".$changingGameId."', `leader` = '0', `gpwd` = '', `gend` = '0', `letters` = '', `word` = '' ";
	$sql3 = "where `id` = '".$userId."' and ";		//only changes with own id
	$sql4 = " ((  '".$gamePassword."' in (select `gpwd` from (select `gpwd` from `hm` where `id` = '".$changingGameId."') as `temptable`) ) and";	//password correct?		#Issue: pass hash
	$sql4_1 = "(  '1' in (select `gend` from (select `gend` from `hm` where `leader` = '1' and `gid` = '".$changingGameId."') as `temptable2`) ) or ";	//only when gend at leader = 1
	$sql5 = " ('".$gamePassword."' = '' and '".$_GET['leave']."' = '1')) and ";		//leave game
	$sql6 = "`id` != '".$changingGameId."'";		//cannot go into your own game?!
	
	$query = mysql_query($sql1.$sql2.$sql3.$sql4.$sql4_1.$sql5.$sql6);
	
	if(mysql_affected_rows() == 1)			// #Issue: nicht erneut in gleiches spiel um stats zu löschen wenn gend = 0, dann direkt rein, sonst warten
	{											// #Issue: Pwd hashen;
		$result = $changingGameId;
	} else {
		$result = '-1';
	}
	return $result;
}

function actionNewGame($userId,$gameWord,$gamePassword) {
	$query = mysql_query("update `hm` set `gid` = `id`, `leader` = '1', `gpwd` = '".$gamePassword.
	"', `gend` = '1', `letters` = '', `word` = '".strtoupper($gameWord)."' where `id`='".$userId."'");		// #Issue: GPWD hashen
	
	if(mysql_affected_rows() == 1) {
		return $userId;
	} else {
		return '-1';
	}
}

?>
