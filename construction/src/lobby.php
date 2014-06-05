<div class='lobbyContainer'>

    <div class='listOfGames'>
	<?php
		$query = mysql_query("select `gid`,`name` from `hm` where (`leader` = '1' and `gend` = '1')");
		while($row = mysql_fetch_array($query))
			echo "	<a href='?create=on&gameId=".$row['gid']."'>".$row['name']."</a><br>";
	?>
    <a href='?create=on'>New Game</a>
    </div>

</div>
<?php 
	$btnLogout = true;
?>