<?php
session_start();
error_reporting(0);
mysql_error();

/*
	#issue1: gameend and #issue2
	#issue1.0.1: echo guessed word at leader
	#issue1.1: enter new word
	#issue1.5: update user_word if all letters are guessed right (it is needed and expected from issue 1)
#issue1.9: real stats: winner 2 points, right word 1 point, else 0 points; make new column `lastpoints`
#issue1.9.5: show all gamemembers the stats
	#issue2: join when gend == 1, no join and wait when gend == 0 ... gend at leader	+++not sure, but i guess it works
#issue2.3: if user is opener, leaves and creates a new game, while others are in the old game and the old game has another leader it crashes.
#issue3: registration
#issue4: passwd hashing
#issue4.2: give minimal access to actions in actions.php
#issue4.5: remove ability for sqlinjection
#issue5: picture for hanging man
#issue6: think about the statistics because one can create two accounts and cheat up his account
*/
$gid = $_SESSION['gid']; //Game ID
$uid = $_SESSION['uid']; //User ID
$s = $_GET['s'];	//Site ID
$a = $_GET['a'];

include('../inc/db.php.inc');
include("functions.php");
include("actions.php");
?>
<head> 
	<title>Hangman ITS</title>
    <link href="css/normalize.css" type="text/css" rel="stylesheet">
    <link href="css/style.css" type="text/css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>
<body>
<div class="wrapper">
<?php

//Tabelle: int id, varchar name, varchar pwd, int gid, bool leader, varchar gpwd, bool gend, varchar letters, varchar word, int games, int wins
if($s=='') {
	$query = mysql_query("select `gid`,`name` from `hm` where (`leader` = '1' and `gend` = '1')");	//only where gend=1 at leader
	while($row = mysql_fetch_array($query)) {
		echo "<a href='?s=n&gid=".$row['gid']."'>".$row['name']."</a><br>";
	}
	echo "<a href='?s=n'>New Game</a>";
}
if($s=='n' && $uid!='' && $_GET['gid'] == '')		//Neues Spiel erstellen
{
	echo "<form action='?s=g&a=newg' method='post'>
		Gamepassword: <input type='password' name='gpwd'><br>
		Word: <input type='text' name='wort'><br>	
		<input type='submit' value='ok'></form>";
} else if($s=='n' && $uid!='' && $_GET['gid'] != '') {		//Spiel beitreten
	echo "<form action='?s=g&a=chgid' method='post'><input type='hidden' name='gid' value='".$_GET['gid']."'>
		Gamepassword: <input type='password' name='gpwd'><br>
		<input type='submit' value='ok'></form>";
} else if($s=='g' && $gid!='' && $uid!='' && $gid!='0') {
	$leader=0;
	$query = mysql_query("select `word`,`letters`,`gend`,`name` from `hm` where `gid` = '".$gid."' and (`leader` = '1' or `id` = '".$uid."') order by `leader` desc limit 0,2");
	while($row = mysql_fetch_array($query))
	{
		if($leader==0) {
			$word = $row['word'];
			$gend = $row['gend'];
			$leaderName = $row['name'];
		} else {
			$u_letters = $row['letters'];
			$u_word = $row['word'];
		}
		$leader++;
	}
	$leader = $leader % 2;
	$alphabet = get_alphabet($word);
	if($leader != 1)
	{
		echo $leaderName." ";
		include ("player.php");
	} else { //--------------------------------------------LEADERVIEW
		include("leader.php");
	}
}
else if($uid == '' && $s == '')
{
	echo "<form action='?s=".$s."&a=login' method='post'><input name='name' type='text'><br>
			<input name='pwd' type='password'><input type='submit' value='login'></form>";
}
echo "<br>";
if($uid != '' && ($gid == '' || $gid == '0') && $s != 'g') {
	echo "<br><a href='?'>refresh</a>";
}
if($uid != '' && $gid != '' && $gid != '0' && $s != 'g') {
	echo "<br><a href='?s=g'>back to game</a>";
}
if($uid != '' && $gid != '' && $gid != '0') {
	echo "<br><a href='?a=chgid&leave=1'>leave game</a>";
}
if($uid != '') {
	echo "<br><a href='?a=logout'>logout</a>";
}


?>
</div>
</body>
</html>