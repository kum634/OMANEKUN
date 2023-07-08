<?php

require_once('func/page.php');
$page = new page();
if (isset($_POST['logout'])) $page->logout();
if (!empty($_POST["csv_mode"])) $bs_alert = $page->csv_use();
$title = get_title(basename(__FILE__, ".php"));

?>
<?php require_once('parts/meta.php'); ?>
<?php require_once('parts/header.php'); ?>
<h1>インポート</h1>
<?php
if (!empty($bs_alert) && $bs_alert != '') {
  echo $bs_alert;
}
?>
<div class="container">
  <form class="form-reauth mt-5" action="" method="post" enctype="multipart/form-data">
    <dl>
      <dt>ファイル（.csv）</dt>
      <dd>
        <label class="submit_file" for="csvfile">
          ＋ファイルを選択<input type="file" name="csvfile" style="display:none;" id="csvfile"  onchange="file_select(this);"/>
        </label>
        <p id="name"></p>
      </dd>
    </dl>
    <dl>
      <dt>パスワードを入力してください。</dt>
      <dd><input type="password" name="password" value=""/></dd>
    </dl>
    <input type="hidden" name="csv_mode" value="im"/>
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>"/>
    <div class="text-center mt-5">
      <button id="sub" class="btn btn-lg btn-success">インポート</button>
    </div>
  </form>
</div>
<script type="text/javascript">
function file_select() {
	var input = document.querySelector('#csvfile').files[0];
	document.querySelector('#name').innerHTML = input.name;
}
</script>
<?php require_once('parts/footer.php'); ?>
