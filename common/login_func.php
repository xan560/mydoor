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
	//if (isset($_POST['submit'])) {
		return (!isset($_SESSION['sess_user_id']) || trim($_SESSION['sess_user_id']) == '');	
	//} 
}
function post_logout() {
	if (isset($_POST['go'])) {
		reset_login();
		session_write_close();
		Header('Location: '.$_SERVER['PHP_SELF']);
	}
}

?>