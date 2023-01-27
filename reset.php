<?php

require_once('./func/auth.php');
$auth = new auth();
$bs_alert = '';
$error_message = "" ;
$error_mailaddress = "" ;
$error_password = "" ;

if ( isset( $_POST["sub"] ) ) {
	$res = $auth->password_resets($_GET['mailaddress'], $_POST['password2']);
	dbg(dbg_type, $res, basename(__FILE__).__LINE__);
	if ($res == 1) {
		$_SESSION["reset"] = $res;
		dbg(dbg_type, __METHOD__.ok, basename(__FILE__).__LINE__, ex);
		header ("Location:login.php") ;
	} else {
		dbg(dbg_type, __METHOD__.ng, basename(__FILE__).__LINE__);
		$bs_alert = $res;
	}
}
$title = get_title(basename(__FILE__, ".php"));
?>
<?php require_once('parts/auth_meta.php'); ?>
<?php require_once('parts/auth_header.php'); ?>
		<?php if ($bs_alert != '') echo '<div class="alert alert-warning">'.$bs_alert.'</div>'; ?>
		<h2 class="font-weight-normal">パスワードの初期化</h2>
		<div class="form_login_area">
			<form class="form-reset" id="form-reset" name="form-email"  method="POST" action="">
				<div class="form-group">
					<p style="color:#CC0003;" class="mb-1 text-left"></p>
					<p class="mb-1 text-left">新規パスワード</p>
					<p style="color:#CC0003;" class="mb-1 text-left error_password1"></p>
					<input id="password1" type="password" class="form-control" name="password1" required>
				</div>
				<div class="form-group">
					<p class="mb-1 text-left">新規パスワード（確認）</p>
					<p style="color:#CC0003;" class="mb-1 text-left error_password2"></p>
					<input id="password2" type="password" class="form-control" name="password2" required>
				</div>
				<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>"/>
				<div class="form-group">
					<button id="sub" name="sub" class="btn btn-lg btn-success">変更する</button>
				</div>
			</form>
		</div>
<?php require_once('parts/auth_footer.php'); ?>
