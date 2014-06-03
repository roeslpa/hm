<?php

/*
winner is 1. correct word 2. fewest guesses 3. fewest wrong guesses
no winner is i) wrong word ii) >=10 wrong guesses ?? iii) someone else has fewer guesses and got the right word
if no winner ??=> leader is winner

gameend[player] = 1 if (word != '' or wrong guesses >9)
if gameend[all] == 1 => calculate stats
*/
if($word == '') {
	echo "<form action='?s=g&a=newword' method='post'>
		New word: <input type='text' name='newwordset'> <input type='submit' value='ok'></form>";
} else {
	$players = 0;
	$finished_players = 0;
	$finished_letters = 15;
	$query = mysql_query("select `id`,`letters`,`word`,`name` from `hm` where `gid` = '".$gid."' order by `leader` desc");
	while($row = mysql_fetch_array($query))
	{
		$name[$players] = $row['name'];
		$letters[$players] = $row['letters'];
		$words[$players] = $row['word'];
		$ids[$players] = $row['id'];
		if($ids[$players] != $uid) {
			echo $row['name']." ";
			$wrong_letters[$players] = get_wrong_letters($row['letters'],$alphabet,0);
			if($row['word'] != '') {
				echo " guessed: ".$row['word']."<br>";
			} else {
				echo "<br>";
			}
		} else {
			echo "<b>".$row['word']."</b><br>";
		}
		
		if($words[$players] != '' || $wrong_letters[$players]>9)
		{
			$finished[$players] = 1;
			$finished_players++;
		}
		$players++;
	}
	
	if($gend == 1) {
		echo "<br><a href='?s=g&a=startgame'>start game</a>";
	}
	
	if($finished_players == $players && $players > 1)
	{
		$sorted_player_ids = sort_players($word,$players,$ids,$words,$letters,$wrong_letters);
		if($sorted_player_ids['intwin'] == 1) {
			echo "The winner is: ".$name[$sorted_player_ids['winner_list']];
				//create list of cases how points are spread
			$query = mysql_query("update `hm` set `leader` = case `id` when '".$sorted_player_ids['winner_id']."' then '1' else '0' end, ".
			"`gend` = case `leader` when '1' then '1' else '0' end,`letters` = '', `word` = '' where `gid`='".$gid."'");
		} else if($sorted_player_ids['intwin'] > 1) {
			$query = mysql_query("update `hm` set `gend` = case `leader` when '1' then '1' else '0' end, `letters` = '', `word` = '' where `gid`='".$gid."'");
			echo "there are more than one winner: "."the leader will choose another word.";
		} else {
			$query = mysql_query("update `hm` set `gend` = case `leader` when '1' then '1' else '0' end, `letters` = '', `word` = '' where `gid`='".$gid."'");
			echo "no one is the winner. the leader will choose another word.";
		}
		
		echo "<br><a href='?s=g'>continue</a><br>";
		//??sieger berechnen: wenigste letters, wenigste falsch
		//??falls kein sieger => keinen eintragen => leader wieder
		//??punkte verteilen
		//??gend auf 1
		//??stats anzeigen
		//??refreshbutton
	} else {
		echo "<br><a href='?s=g'>refresh</a>";
	}
}
?>