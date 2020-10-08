<?php
session_start() ;
require_once('auth.php');

session_destroy() ;
if ( isset( $_COOKIE["token"] ) ) {
	$user_auth = new User_auth();
	$user_auth->delete_cookie();
}

header ( "Location: login.php" ) ;
?>
