<?php
session_start() ;
require_once('auth.php');
$user_auth = new User_auth();
$error_message = '';

if ( isset( $_POST["submit_login"] ) ) {
	if ($user_auth->posted_login_data()) {
		if ($user_auth->login_auth() == 1) {
			$user_auth->login();
		} else {
			$error_message = "ユーザー名かパスワードが正しくありません。" ;
		}
	}
	if ( isset ( $_POST["autologin"]) ) {
		$user_auth->autologin_start();
	}
}
if ( isset( $_COOKIE["token"] ) ) {
	$user_auth->autologin();
}
?>
<!DOCTYPE html>
<html lang="en"><!-- InstanceBegin template="/Templates/temp2.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="google" content="notranslate">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="format-detection" content="telephone=no,noindex,nofollow,noarchive">
	<!-- InstanceBeginEditable name="doctitle" -->
	<title>ログイン</title>
	<!-- InstanceEndEditable -->
	<!-- Bootstrap -->
	<link href="css/bootstrap-4.3.1.css" rel="stylesheet">
	<link href="css/sign.css" rel="stylesheet" type="text/css">
	<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Kosugi&display=swap" rel="stylesheet">
	<!-- InstanceBeginEditable name="head" -->
	<!-- InstanceEndEditable -->
</head>
<body class="text-center">
	<header class="bg-success">
		<nav class=" navbar navbar-expand-lg navbar-dark custom-hamburger">
			<h1 class="top_logo"><span class="logo">オーマネ君</span><span class="hyphen_left">-</span><span class="catch_copy">整備依頼管理</span><span class="hyphen_right">-</span></h1>
		</nav>
	</header>
	<!-- InstanceBeginEditable name="body" -->
	<main>
		<?php
		if(mb_strpos($_SERVER['HTTP_REFERER'], "/reset.php") && $_SESSION["reset"] == 1) {
			echo "<div class=\"alert alert-success\">パスワードを変更しました。</div>";
			unset($_SESSION["reset"]);
		}
		?>
		<div class="form_login_area">
			<form class="form-signin" action="" id="form-signin" name="form-signin" method="post">
				<h2 class="font-weight-normal">ログイン</h2>
				<p style="color:#CC0003;" class="mb-1 text-left"><?= $error_message ?></p>
				<p class="mb-1 text-left">ユーザー名（テスト用ユーザー名 : guest）</p>
				<input type="text" id="inputUsername" class="form-control" name="username"  value="guest" autofocus required>
				<p class="mb-1 text-left">パスワード（テスト用パスワード : guest2020）</p>
				<input type="password" id="inputPassword" class="form-control" name="password"  value="guest2020" required>
				<div class="checkbox">
					<label class="mb-0">
						<input type="checkbox" name="autologin" value="remember-me"> 自動ログイン
					</label>
				</div>
				<button class="btn btn-lg btn-success" name="submit_login" type="submit">ログイン</button>
				<div class="login_info mb-3 mt-3"></div>
				<p class="mb-0">パスワードを忘れた方は<a href="email.php">コチラ</a></p>
				<p class="mb-0">ユーザー登録を御希望の方は<a href="signup.php">コチラ</a></p>
			</form>
		</div>
	</main>
	<!-- InstanceEndEditable -->
	<footer class="text-center">
		<div>
			<p>Copyright &copy; 2020 &middot; All Rights Reserved &middot; オーマネ君-整備依頼管理-</p>
		</div>
	</footer>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="js/jquery-3.3.1.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap-4.3.1.js"></script>
</body>
<!-- InstanceEnd --></html>
