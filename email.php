<?php

require_once('./func/auth.php');
$auth = new auth();
$bs_alert = '';
$error_message = '';

if ( isset( $_POST["sub"] ) ) {

	$error_message = "";
	$mailaddress = h($_POST["mailaddress"]);
	$arr = array(
		'mailaddress' => $mailaddress
	);
	dbg(dbg_type, $arr, basename(__FILE__).__LINE__);
	if ($auth->select_users($arr) == 1) $bs_alert = $auth->reset_mail($mailaddress);
	else $error_message = "メールアドレスに一致するユーザーが存在しません。";
}
$title = get_title(basename(__FILE__, ".php"));
?>
<?php require_once('parts/auth_meta.php'); ?>
<?php require_once('parts/auth_header.php'); ?>
		<?php if ($bs_alert != '') echo $bs_alert; ?>
		<h2 class="font-weight-normal">パスワードの再発行</h2>
		<div class="form_login_area">
			<form class="form-email" id="form-email" name="form-email" method="POST" action="">
				<div class="form-group">
					<p style="color:#CC0003;" class="mb-1 text-left"><?= $error_message ?></p>
					<p class="mb-1 text-left">メールアドレス</p>
					<p style="color:#CC0003;" class="mb-1 text-left error_mailaddress"></p>
					<input id="mailaddress" type="email" class="form-control" name="mailaddress" required>
					<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>"/>
				</div>
				<div class="form-group mb-0">
					<button id="sub" name="sub" class="btn btn-lg btn-success">
						パスワード再設定メールを送信
					</button>
				</div>
			</form>
		</div>
<?php require_once('parts/auth_footer.php'); ?>
