<?php
if(isset($_GET['checklogin'])) {
	if($_GET['checklogin'] == 'login') {
		$username = $_POST['username'];
		$password = $_POST['password'];	
		$query = mysql_query("select `id`,`pwd` from `hm` where `name` = '$username'");
		$row = mysql_fetch_array($query);
		if($row['pwd'] == hash('sha512', $password.$username))
		{
			$_SESSION['userId'] = $row['id'];
			$userId = $_SESSION['userId'];
		}else{
			$msg = 'input is wrong';
		}
	} elseif($_GET['checklogin'] == 'logout') {
		if(isset($_SESSION['userId'])){
			$_SESSION = array(); //leert alle Variabeln
			session_destroy(); //zerstört Session
		}
	}
}

ob_start(); //prepaire OUTPUT	
if(!(isset($_SESSION['userId']) && !empty($_SESSION['userId']))){
?>
<div class="loginContainer">
<h2>Login</h2>
<form name="loginForm" method="post" action="index.php?login=on&checklogin=login">
<input type="text" placeholder="username" name="username">
<input type="password" placeholder="password" name="password">
<a href="#" onClick="loginForm.submit()">login</a>
<form>
</div>

<?php
}else{
	$btnLobby = true;
	$btnLogout = true;
?>
<div class="welcomeContainer">
<h2>Weclome</h2>
<p>
hallo <?=$username?>
</p>
</div>
<?php 

}
$content['login'] = ob_get_clean(); //save OUTPUT
?>