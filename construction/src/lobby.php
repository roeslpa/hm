<?php
$content['lobby'] =
"<div class='lobbyContainer'>
    <div class='listOfGames'>";
		$query = mysql_query("select `gid`,`name` from `hm` where (`leader` = '1' and `gend` = '1')");
		while($row = mysql_fetch_array($query))
			$content['lobby'] .= "<a href='?create=on&gameId=".$row['gid']."'>".$row['name']."</a><br>";
    	$content['lobby'] .=
		"<a href='?create=on'>New Game</a>
    </div>
</div>";
$btnLogout = true;
?>