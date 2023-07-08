<?php

require_once('./func/auth.php');
$auth = new auth();
$error_message = '';
$bs_alert = '';
$display_block = "display:none !important;";

if ( isset( $_POST["sub"] ) ) {

  $res = $auth->register();
  dbg(dbg_type, $res, basename(__FILE__).__LINE__);
  if (is_array($res)) {
    dbg(dbg_type, __METHOD__.ng, basename(__FILE__).__LINE__);
    foreach ($res as $key) $error_message .='<p style="color:#CC0003;" class="mb-1 text-left">'.$register_error[$key].'</p>'."\n";
  } elseif (is_string($res)) {
    dbg(dbg_type, __METHOD__.ng, basename(__FILE__).__LINE__);
    $bs_alert = $res;
  } else {
    dbg(dbg_type, __METHOD__.ok, basename(__FILE__).__LINE__);
    $display_none = "display:none  !important;";
    $display_block = "display:block !imortant;";
  }

}
$title = get_title(basename(__FILE__, ".php"));
?>
<?php require_once('parts/auth_meta.php'); ?>
<?php require_once('parts/auth_header.php'); ?>
    <?php
    if(!empty($_SESSION["withdrawal"]) && $_SESSION["withdrawal"] == 1){
      dbg(dbg_type, $_SESSION, basename(__FILE__).__LINE__);
      echo bs_alert('ご利用ありがとうございました。', true);
      unset($_SESSION["withdrawal"]);
    }
    if (!empty($bs_alert) && $bs_alert != '') echo $bs_alert;
    ?>
    <h2 class="font-weight-normal">ユーザー登録</h2>
    <div class="form_login_area">
      <form class="form-signup" style="<?= $display_none ?>" action="" id="form-signup" name="form-signup" method="post">
        <?= $error_message ?>
        <p class="mb-1 text-left">メールアドレス</p>
        <p style="color:#CC0003;" class="mb-1 text-left error_mailaddress"></p>
        <input type="email" id="mailaddress" class="form-control" name="mailaddress" autofocus required>
        <p class="mb-1 text-left">ユーザー名</p>
        <p style="color:#CC0003;" class="mb-1 text-left error_username"></p>
        <input type="text" id="username" class="form-control" name="username" required>
        <p class="mb-1 text-left">パスワード</p>
        <p style="color:#CC0003;" class="mb-1 text-left error_password1"></p>
        <input type="password" id="password1" class="form-control" name="password1" required>
        <p class="mb-1 text-left">パスワード(確認)</p>
        <p style="color:#CC0003;" class="mb-1 text-left error_password2"></p>
        <input type="password" id="password2" class="form-control" name="password2" required>
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>"/>
        <button class="btn btn-lg btn-success" id="sub" name="sub">登録</button>
        <div class="login_info mb-3 mt-3">
          <p>ユーザー登録済みの方またはゲスト様は<a href="login.php">コチラ</a></p>
        </div>
      </form>
      <div class="complete" style="<?= $display_block ?>">
        <p>ユーザー登録が完了しました。</p>
        <p class="mb-0"><a href="login.php">ログイン</a></p>
      </div>
    </div>
<?php require_once('parts/auth_footer.php'); ?>
