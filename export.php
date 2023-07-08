<?php

require_once('func/page.php');
$page = new page();
if (isset($_POST['logout'])) $page->logout();
if (!empty($_POST["csv_mode"])) $bs_alert = $page->csv_use();
$title = get_title(basename(__FILE__, ".php"));

?>
<?php require_once('parts/meta.php'); ?>
<?php require_once('parts/header.php'); ?>
<h1>エキスポート</h1>
<?php
if (!empty($bs_alert) && $bs_alert != '') {
  echo $bs_alert;
}
?>
<div class="container">
  <form class="form-reauth mt-5" action="" method="post">
    <dl>
      <dt>パスワードを入力してください。</dt>
      <dd><input type="password" name="password" value=""/></dd>
    </dl>
    <input type="hidden" name="csv_mode" value="ex"/>
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>"/>
    <div class="text-center mt-5">
      <button id="sub" class="btn btn-lg btn-success">エキスポート</button>
    </div>
  </form>
</div>
<?php require_once('parts/footer.php'); ?>
