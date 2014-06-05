<div class='createContainer'>
<?php
if($s=='n' && $uid!='' && $_GET['gid'] == '')		//Neues Spiel erstellen
{
	?><div class='getInGame'><?php
	if($_GET['gid'] == '') {
		?>
        <form action='?s=g&a=newg' method='post' name='formNewGame'>
            Gamepassword: <input type='password' name='gpwd'><br>
            Word: <input type='text' name='wort'><br>	
            <a href='#' onClick='formNewGame.submit()'>create</a>
		</form>
		<?php
	} else if($_GET['gid'] != '') {		//Spiel beitreten
		?>
        <form action='?s=g&a=chgid' method='post' name='formJoin'>
            <input type='hidden' name='gid' value='<?=$_GET['gid']?>'>
            Gamepassword: <input type='password' name='gpwd'><br>
            <a href="#" onClick="formJoin.submit()">join</a>
		</form>
		<?php
	}
	echo "	</div>";
}
?>
</div>
