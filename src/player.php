<?php

if($_GET['try'] != '') {
	$try = strtoupper($_GET['try']);
	$query = mysql_query("update `hm` set `letters` = CONCAT(`letters`,'".$try."') where `id`=".$uid);
	$u_letters = $u_letters.$try;
} else if($_GET['solve'] != '') {
	$solve = strtoupper($_GET['solve']);
	$u_word = $solve;
	$query = mysql_query("update `hm` set `word` = '".$solve."' where `id`=".$uid." and `word` = ''");
}
//sel word from where gid=gid and leader=1

echo "	<div class='playerStatusContent'>".$leaderName."<br>";
$guessedAllLetters = print_word($word,$u_letters);
$wrongLetters = get_wrong_letters($u_letters,$alphabet,1);
echo "	</div>";

if($gend == 1) {	//TODO: echo the stats
	echo "	<div class='playerGameEndMessage'>
				<br>wait until the leader starts the game..<br>
				<a href='?s=g'>refresh</a>
			</div>";
} else {
	echo "<div class='playerVariableContent'>";
	if($wrongLetters < 10 && $u_word == '' && $guessedAllLetters != 1) {
		echo "	<div class='playerTryForm'>
					<form action='?s=g' method='get' autocomplete='off'>
						<input type='hidden' name='s' value='g' style='display:inline-block; width: 100px;'>
						<input type='text' name='try' size='2' autocomplete='off' autocorrect='off' class='field try-field' style='display:inline-block;'>
						<input type='submit' value='try' style='display:inline-block; width: 70px;'>
					</form>
				</div>";
	
		if($wrongLetters > '0') {
			echo "<div class='playerHangmanImage'><img src='../images/".$wrongLetters.".gif' style='display:inline-block;'></div>";
		}
		echo "	<div class='playerSolveForm'>
					<form action='?s=g' method='get'>
						<input type='hidden' name='s' value='g'>
						<input type='text' name='solve' autocomplete='off' autocorrect='off'>
						<input type='submit' value='solve'>
					</form>
				</div>";
	} else if($wrongLetters > 9) {
		echo "	<div class='playerGameEndMessage'>
					<br>you tried 10 wrong letters, wait until everyone finished the game and the leader submitted the points<br>
					<a href='?s=g'>refresh</a>
					<img src='../images/10.gif' style='display:block;'>
				</div>";
	} else if($u_word != '') {
		echo "	<div class='playerGameEndMessage'>
					<br>you guessed <u>".$u_word."</u>, wait until everyone finished the game and the leader submitted the points<br>
					<a href='?s=g'>refresh</a>
				</div>";
	} else if($guessedAllLetters == 1) {
		$query = mysql_query("update `hm` set `word` = '".$word."' where `id`='".$uid."'");
		echo "	<div class='playerGameEndMessage'>
					<br>you guessed all letters right, wait until everyone finished the game and the leader submitted the points<br>
					<a href='?s=g'>refresh</a>
				</div>";
	}
	echo "</div>";
}

?>