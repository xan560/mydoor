<?php
session_start();

function reset_login() {
	//$_SESSION['sess_user_id']='';
	//$_SESSION['sess_username']='';
	session_destroy();
}
function is_session_timeout() {
	if (isset($_SESSION['timeout'])) {	
		return ($_SESSION['timeout'] + (10*60) < time());
	} else {
		return true;
	}
	//return false;
}
function is_user_logged_out() {
	return (!isset($_SESSION['sess_user_id']) || trim($_SESSION['sess_user_id']) == '');	
}
function post_logout() {
	if (isset($_POST['go'])) {
		reset_login();
		session_write_close();
		Header('Location: '.$_SERVER['PHP_SELF']);
	}
}
?>

<?php if( is_session_timeout() ) {
	reset_login();
}?> 
<?php if( is_user_logged_out() ) : ?>
	<!-- no one is logged in! -->
	<li id="login">
		<h2>Login</h2>				
		<form method="post" action=<?php echo $dir."login.php";?>>
			<input type="text" id="username" name="username" placeholder="username" />
			<input type="password" id="password" name="password" placeholder="password" />
			<input type="submit" id="" value="Submit" />
			<br><a href=<?php echo $dir."forgot.html";?>>Forgot Password?</a>
			<br><a href=<?php echo $dir."register.html";?>>Register</a>
		</form>
	</li>
<?php else: ?>
	<!-- welcome them! -->
	<li id="welcome">
		<h2>Welcome, <?php echo $_SESSION["sess_username"] ?></h2>
		<h2>Time elapsed: <?php echo (time()-$_SESSION['timeout']);?></h2>
		<br><h2>My Profile</h2>

		<form method="post" action="<?php post_logout(); ?>">
			<input name="go" type="submit" value="Logout"/>
		</form>
	</li>
<?php endif; ?>