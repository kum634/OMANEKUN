<?php

require_once('./func/auth.php');
$auth = new auth();
$bs_alert = '';
$error_message = '';

if (isset( $_POST["sub"])) {

	$username = (!empty($_POST["username"])) ? $_POST["username"] : '';
	$password = (!empty($_POST["password"])) ? $_POST["password"] : '';
	$autologin = (!empty( $_POST["autologin"])) ? $_POST["autologin"] : '';

	$res = $auth->login($username, $password, $autologin);
	if ($res == 0) $error_message = 'ユーザー名かパスワードが正しくありません。';
	else $bs_alert = $res;
}
if (isset( $_COOKIE["autologin_token"]))	$auth->autologin();
$title = get_title(basename(__FILE__, ".php"));
?>
<?php require_once('parts/auth_meta.php'); ?>
<?php require_once('parts/auth_header.php'); ?>
		<?php
		if(mb_strpos($_SERVER['HTTP_REFERER'], "/reset.php") && $_SESSION["reset"] == 1) {
			echo bs_alert('パスワードを変更しました。', true);
			unset($_SESSION["reset"]);
		}
		if (!empty($bs_alert) && $bs_alert != '') echo $bs_alert;
		?>
		<h2 class="font-weight-normal">ログイン</h2>
		<div class="form_login_area">
			<form class="form-login" action="" id="form-login" name="form-login" method="post">
				<p style="color:#CC0003;" class="mb-1 text-left error_message"><?= $error_message ?></p>
				<p class="mb-1 text-left">ユーザー名（テスト用ユーザー名 : guest）</p>
				<p style="color:#CC0003;" class="mb-1 text-left error_username"></p>
				<input type="text" id="username" class="form-control" name="username"  value="guest" autofocus required>
				<p class="mb-1 text-left">パスワード（テスト用パスワー ド : guest2020）</p>
				<p style="color:#CC0003;" class="mb-1 text-left error_password"></p>
				<input type="password" id="password" class="form-control" name="password"  value="guest2020" required>
				<div class="checkbox">
					<label class="mb-0">
						<input type="checkbox" name="autologin" value="remember-me"> 自動ログイン
					</label>
				</div>
				<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>"/>
				<button class="btn btn-lg btn-success" id="sub" name="sub">ログイン</button>
				<div class="login_info mb-3 mt-3"></div>
				<p class="mb-0">パスワードを忘れた方は<a href="email.php">コチラ</a></p>
				<p class="mb-0">ユーザー登録を御希望の方は<a href="signup.php">コチラ</a></p>
			</form>
		</div>
<?php require_once('parts/auth_footer.php'); ?>
