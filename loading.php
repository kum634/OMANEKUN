<?php
session_start() ;

if ( !isset ( $_SESSION["login"] ) ) {
  header ( "Location:login.php" ) ;
}else{
  $user = $_SESSION["login"];
  $logout_btn = '<a href="logout.php">ログアウト</a>';
}
?>
