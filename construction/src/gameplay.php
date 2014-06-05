<div class='gameplay'>
<?php

if($_GET['triedLetter'] != '') {
	$triedLetters = strtoupper($_GET['triedLetter']);
	$mysqlQuery = mysql_query("update `hm` set `letters` = CONCAT(`letters`,'".$triedLetter."') where `id`=".$userId);
	$gameInfo['userLetters'] = $gameInfo['userLetters'].$triedLetters;
} else if($_GET['solvedWord'] != '') {
	$solvedWord = strtoupper($_GET['solvedWord']);
	$gameInfo['userWord'] = $solvedWord;
	$mysqlQuery = mysql_query("update `hm` set `word` = '".$solvedWord."' where `id`=".$userId." and `word` = ''");
}
//sel word from where gid=gid and leader=1

?>
<div class='playerStatusContent'><?=$gameInfo['leaderName']?><br>
<?php
$guessedWordByLetters = print_word($gameInfo['leaderWord'],$gameInfo['userLetters']);
$numberOfWrongLetters = get_wrong_letters($gameInfo['leaderLetters'],$gameInfo['alphabet'],1);
?>
</div>
<?php

if($gameInfo['gameEnd'] == 1) {	//TODO: echo the stats
	?>
    <div class='playerGameEndMessage'>
		<br>wait until the leader starts the game..<br>
		<a href='?gameplay=on'>refresh</a>
	</div>
    <?php
} else {
	?><div class='playerVariableContent'><?php
	if($numberOfWrongLetters < 10 && $gameInfo['userWord'] == '' && $guessedWordByLetters != 1) {
		?>
        <div class='playerTryForm'>
            <form action='?gameplay=on' method='get' autocomplete='off' name="formTry">
                <input type='text' name='triedLetter' size='2' autocomplete='off' autocorrect='off' class='field try-field' style='display:inline-block;'>
                <a href="#" onClick="formTry.submit()">try</a>
            </form>
		</div>
       	<?php
	
		if($numberOfWrongLetters > '0') {
			echo "<div class='playerHangmanImage'><img src='images/".$wrongLetters.".gif' style='display:inline-block;'></div>";
		}
		?>
        <div class='playerSolveForm'>
            <form action='?gameplay=on' method='get'>
                <input type='text' name='solvedWord' autocomplete='off' autocorrect='off'>
                <input type='submit' value='solve'>
            </form>
		</div>
        <?php
	} else if($numberOfWrongLetters > 9) {
		?>
        <div class='playerGameEndMessage'>
            <br>you tried 10 wrong letters, wait until everyone finished the game and the leader submitted the points<br>
            <a href='?gameplay=on'>refresh</a>
            <img src='images/10.gif' style='display:block;'>
        </div>
        <?php
	} else if($gameInfo['userWord'] != '') {
		?>
        <div class='playerGameEndMessage'>
            <br>you guessed <u><?=$gameInfo['userWord']?></u>, wait until everyone finished the game and the leader submitted the points<br>
            <a href='?gameplay=on'>refresh</a>
        </div>
		<?php
	} else if($guessedWordByLetters == 1) {
		$query = mysql_query("update `hm` set `word` = '".$gameInfo['leaderWord']."' where `id`='".$userId."'");
		?>
        <div class='playerGameEndMessage'>
            <br>you guessed all letters right, wait until everyone finished the game and the leader submitted the points<br>
            <a href='?gameplay=on'>refresh</a>
        </div>
        <?php
	}
	?></div><?php
}
?>
</div>