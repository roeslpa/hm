<?php

if($a!='')
{
	if($a == 'login') {
		$query = mysql_query("select `id`,`pwd` from `hm` where `name` = '".$_POST['name']."'");
		$row = mysql_fetch_array($query);
		if($row['pwd'] == $_POST['pwd'])
		{
			$_SESSION['userId'] = $row['id'];
			$userId = $_SESSION['userId'];
		}
	} else if($a =='logout') {
		$query = mysql_query("update `hm` set `gid` = '0', `leader` = '0', `gpwd` = '0', `gend` = '0', `letters` = '', `word` = '' where `id`='".$userId."'");
		$_SESSION['userId'] = '';
		$userId = '';
		$_SESSION['gameId'] = '';
		$gameId = '';
	} else if($a == 'changeGameId') {
		if($_GET['leave'] == '1') {
			$changing_g_id = '0';
		} else {
			$changing_g_id = $_POST['gameId'];
		}
		$sql1 = "update `hm` ";
		$sql2 = "set `gid` = '".$changing_g_id."', `leader` = '0', `gpwd` = '', `gend` = '0', `letters` = '', `word` = '' ";
		$sql3 = "where `id` = '".$userId."' and ";		//only changes with own id
		$sql4 = " ((  '".$_POST['gpwd']."' in (select `gpwd` from (select `gpwd` from `hm` where `id` = '".$changing_g_id."') as `temptable`) ) and";	//password correct?		#Issue: pass hash
		$sql4_1 = "(  '1' in (select `gend` from (select `gend` from `hm` where `leader` = '1' and `gid` = '".$changing_g_id."') as `temptable2`) ) or ";	//only when gend at leader = 1
		$sql5 = " ('".$_POST['gpwd']."' = '' and '".$_GET['leave']."' = '1')) and ";		//leave game
		$sql6 = "`id` != '".$changing_g_id."'";		//cannot go into your own game?!
		
		$query = mysql_query($sql1.$sql2.$sql3.$sql4.$sql4_1.$sql5.$sql6);
		
		if(mysql_affected_rows() == 1)			// #Issue: nicht erneut in gleiches spiel um stats zu löschen wenn gend = 0, dann direkt rein, sonst warten
		{											// #Issue: Pwd hashen;
			$_SESSION['gameId'] = $changing_g_id;
			$gameId = $_SESSION['gameId'];
		} else {
			echo "either you typed the wrong password or the game started without you. <a href='?'>back to start</a>";
		}
	} else if($a == 'newg') {
		$query = mysql_query("update `hm` set `gid` = `id`, `leader` = '1', `gpwd` = '".$_POST['gpwd'].
		"', `gend` = '1', `letters` = '', `word` = '".strtoupper($_POST['wort'])."' where `id`='".$userId."'");		// #Issue: GPWD hashen
		
		if(mysql_affected_rows() == 1) {
			$_SESSION['gameId'] = $userId;
			$gameId = $_SESSION['gameId'];
			echo "you created a new game!";
		}
	} else if($a == 'newword') {
		$query = mysql_query("update `hm` set `letters` = '', `word` = '".strtoupper($_POST['newWordSet'])."' where `id`='".$userId."' and `leader` = '1'");
	} else if($a == 'startgame') {
		$query = mysql_query("update `hm` set `gend` = '0' where `id`='".$userId."' and `leader` = '1'");
	}
}

?>