<?php
session_start() ;
require_once('auth.php');
$user_auth = new User_auth();
$message = "" ;
$error_message = "" ;
$mail_error_message = "" ;
$pass_error_message = "" ;

if ( isset( $_POST["submit"] ) ) {
	if ($user_auth->posted_reset_data()) {
		if ($user_auth->mailaddress_check()) {
			if ($user_auth->password_check()) {
				if ($user_auth->mailaddress_existence_check() == 1) {
					if ($user_auth->password_reset() == true) {
						$message = "登録に成功しました。" ;
						$_SESSION["reset"] = 1;
						header ( "Location:login.php" ) ;
					} else {
						$message = $user_auth->password_reset();
					}
				} else {
					$mail_error_message = "入力したメールアドレスが間違っています。。";
				}
			} else {
				$pass_error_message = "パスワードが一致しません。";
			}
		} else {
			$mail_error_message = "正しいメールアドレスを入力してください。";
		}
	}
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
	<title>パスワードの変更</title>
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
	<?php
	if($message == "登録に成功しました。"){
		echo "<div class=\"alert alert-success\">{$message}</div>";
	}
	if($message["message"] == "登録に失敗しました。"){
		echo "<div class=\"alert alert-warning\">{$message["message"]}<br>{$message["error"]}</div>";
	}
	if($message == "テスト用ユーザー情報は変更できません。"){
		echo "<div class=\"alert alert-warning\">{$message}</div>";
	}
	?>
	<main>
		<div class="form_login_area">
			<form class="form-signin" method="POST" action="">
				<h2 class="font-weight-normal">パスワードの変更</h2>
				<div class="form-group">
					<p style="color:#CC0003;" class="mb-1 text-left"><?= $mail_error_message ?></p>
					<p class="mb-1 text-left">メールアドレス</p>
					<input id="mailaddress" type="email" class="form-control" name="mailaddress" required autofocus>
				</div>
				<div class="form-group">
					<p style="color:#CC0003;" class="mb-1 text-left"><?= $pass_error_message ?></p>
					<p class="mb-1 text-left">新規パスワード</p>
					<input id="password" type="password" class="form-control" name="password1" required>
				</div>
				<div class="form-group">
					<p class="mb-1 text-left">新規パスワード（確認）</p>
					<input id="password-confirm" type="password" class="form-control" name="password2" required>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-lg btn-success" name="submit">変更する</button>
				</div>
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
