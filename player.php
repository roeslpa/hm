<?php

//??eintragen vom raten oder lösen !!wichtig auf großschreibung umwandeln

if($_GET['try'] != '') {

	$try = strtoupper($_GET['try']);

	$query = mysql_query("update `hm` set `letters` = CONCAT(`letters`,'".$try."') where `id`=".$uid);

	$u_letters = $u_letters.$try;

} else if($_GET['solve'] != '') {

	$solve = strtoupper($_GET['solve']);

	$u_word = $solve;

	$query = mysql_query("update `hm` set `word` = '".$solve."' where `id`=".$uid);

}

//sel word from where gid=gid and leader=1



$all_letters_guessed = print_word($word,$u_letters);

$wrong_letters = get_wrong_letters($u_letters,$alphabet,1);


if($gend == 1) {

	echo "<br>wait until the leader starts the game..<br><a href='?s=g'>refresh</a>";

} else {

	if($wrong_letters < 10 && $u_word == '' && $all_letters_guessed != 1) {

		echo "<form action='?s=g' method='get' autocomplete='off'><input type='hidden' name='s' value='g' style='display:inline-block; width: 100px;'>

		<input type='text' name='try' size='2' autocomplete='off' autocorrect='off' class='field try-field' style='display:inline-block;'>

		<input type='submit' value='try' style='display:inline-block; width: 70px;'></form>";
		
		if($wrong_letters > '0') {
			echo "<img src='images/".$wrong_letters.".gif' style='display:inline-block;'>";
		}

		echo "<form action='?s=g' method='get'><input type='hidden' name='s' value='g'>

		<input type='text' name='solve' autocomplete='off' autocorrect='off'>

		<input type='submit' value='solve'></form>";

	} else if($wrong_letters > 9) {

		echo "<br>you tried 10 wrong letters, wait until everyone finished the game and the leader submitted the points<br><a href='?s=g'>refresh</a>";
		echo "<img src='images/10.gif' style='display:block;'>";


	} else if($u_word != '') {

		echo "<br>you guessed <u>".$u_word."</u>, wait until everyone finished the game and the leader submitted the points<br><a href='?s=g'>refresh</a>";

	} else if($all_letters_guessed == 1) {

		$query = mysql_query("update `hm` set `word` = '".$word."' where `id`='".$uid."'");

		echo "<br>you guessed all letters right, wait until everyone finished the game and the leader submitted the points<br><a href='?s=g'>refresh</a>";

	}

}

?>