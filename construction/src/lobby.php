<div class='lobbyContainer'>
<?php
if($s=='') {
	?>
    <div class='listOfGames'>
	<?php
		$query = mysql_query("select `gid`,`name` from `hm` where (`leader` = '1' and `gend` = '1')");
		while($row = mysql_fetch_array($query))
			echo "	<a href='?s=n&gid=".$row['gid']."'>".$row['name']."</a><br>";
	?>
    <a href='?s=n'>New Game</a>
    </div>
	<?php
}
?>
</div>