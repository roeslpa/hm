<?php

if($a!='')
{
	if($a == 'login') {
		$query = mysql_query("select `id`,`pwd` from `hm` where `name` = '".$_POST['name']."'");
		$row = mysql_fetch_array($query);
		if($row['pwd'] == $_POST['pwd'])
		{
			$_SESSION['uid'] = $row['id'];
			$uid = $_SESSION['uid'];
		}
	} else if($a =='logout') {
		$query = mysql_query("update `hm` set `gid` = '0', `leader` = '0', `gpwd` = '0', `gend` = '0', `letters` = '', `word` = '' where `id`='".$uid."'");
		$_SESSION['uid'] = '';
		$uid = '';
		$_SESSION['gid'] = '';
		$gid = '';
	} else if($a == 'chgid') {
		if($_GET['leave'] == '1') {
			$changing_g_id = '0';
		} else {
			$changing_g_id = $_POST['gid'];
		}
		$sql1 = "update `hm` ";
		$sql2 = "set `gid` = '".$changing_g_id."', `leader` = '0', `gpwd` = '', `gend` = '0', `letters` = '', `word` = '' ";
		$sql3 = "where `id` = '".$uid."' and ";		//only changes with own id
		$sql4 = " ((  '".$_POST['gpwd']."' in (select `gpwd` from (select `gpwd` from `hm` where `id` = '".$changing_g_id."') as `temptable`) ) and";	//password correct?		#Issue: pass hash
		$sql4_1 = "(  '1' in (select `gend` from (select `gend` from `hm` where `leader` = '1' and `gid` = '".$changing_g_id."') as `temptable2`) ) or ";	//only when gend at leader = 1
		$sql5 = " ('".$_POST['gpwd']."' = '' and '".$_GET['leave']."' = '1')) and ";		//leave game
		$sql6 = "`id` != '".$changing_g_id."'";		//cannot go into your own game?!
		
		$query = mysql_query($sql1.$sql2.$sql3.$sql4.$sql4_1.$sql5.$sql6);
		
		if(mysql_affected_rows() == 1)			// #Issue: nicht erneut in gleiches spiel um stats zu löschen wenn gend = 0, dann direkt rein, sonst warten
		{											// #Issue: Pwd hashen;
			$_SESSION['gid'] = $changing_g_id;
			$gid = $_SESSION['gid'];
		} else {
			echo "either you typed the wrong password or the game started without you. <a href='?'>back to start</a>";
		}
	} else if($a == 'newg') {
		$query = mysql_query("update `hm` set `gid` = `id`, `leader` = '1', `gpwd` = '".$_POST['gpwd'].
		"', `gend` = '1', `letters` = '', `word` = '".strtoupper($_POST['wort'])."' where `id`='".$uid."'");		// #Issue: GPWD hashen
		
		if(mysql_affected_rows() == 1) {
			$_SESSION['gid'] = $uid;
			$gid = $_SESSION['gid'];
			echo "you created a new game!";
		}
	} else if($a == 'newword') {
		$query = mysql_query("update `hm` set `letters` = '', `word` = '".strtoupper($_POST['newwordset'])."' where `id`='".$uid."' and `leader` = '1'");
	} else if($a == 'startgame') {
		$query = mysql_query("update `hm` set `gend` = '0' where `id`='".$uid."' and `leader` = '1'");
	}
}

?>