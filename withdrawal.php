<?php

require_once('func/page.php');
$page = new page();
if (isset($_POST['logout'])) $page->logout();
if (!empty($_POST["wit"])) $bs_alert = $page->erasure();
$title = get_title(basename(__FILE__, ".php"));

?>
<?php require_once('parts/meta.php'); ?>
<?php require_once('parts/header.php'); ?>
<h1>退会</h1>
<?php
if (!empty($bs_alert) && $bs_alert != '') {
  echo $bs_alert;
}
?>
<div class="container">
  <form class="form-reauth mt-5" action="" method="post" onsubmit="return confirm('本当に退会しますか？')">
    <dl>
      <dt>パスワードを入力してください。</dt>
      <dd><input type="password" name="password" value=""/></dd>
    </dl>
    <input class="pl-5 pr-5" type="hidden" name="wit" value="wit"/>
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>"/>
    <div class="text-center mt-5">
      <button id="sub" class="btn btn-lg btn-success">退会</button>
    </div>
  </form>
</div>
<?php require_once('parts/footer.php'); ?>
