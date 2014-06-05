<?php
	if(isset($_GET['checklogin'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
	}
	
?>
<div class="loginContainer">
<h2>Login</h2>
<form name="loginForm" method="post" action="index.php?checklogin=on&<?=$_SERVER['QUERY_STRING']?>">
<input type="text" placeholder="username" name="username">
<input type="password" placeholder="password" name="password">
<a href="#" onClick="loginForm.submit()">login</a>
<form>
</div>

<div class="welcomeContainer">
<h2>Weclome/h2>
<p>
hallo <?=$username?>
</p>
<a href="index.php?lobby=on">join lobby</a>
</div>