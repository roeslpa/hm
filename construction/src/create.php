<div class='createContainer'>

<div class='getInGame'><?php
	if($_GET['gameId'] == '') {
		?>
        <form action='?gameplay=on&a=newGame' method='post' name='formNewGame'>
            Gamepassword: <input type='password' name='gamePassword'><br>
            Word: <input type='text' name='word'><br>	
            <a href='#' onClick='formNewGame.submit()'>create</a>
		</form>
		<?php
	} else if($_GET['gameId'] != '') {		//Spiel beitreten
		?>
        <form action='?gameplay=on&a=changeGameId' method='post' name='formJoin'>
            <input type='hidden' name='gameId' value='<?=$_GET['gameId']?>'>
            Gamepassword: <input type='password' name='gamePassword'><br>
            <a href="#" onClick="formJoin.submit()">join</a>
		</form>
		<?php
	}
	?>
	</div>
</div>
