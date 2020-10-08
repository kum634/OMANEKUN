<?php
session_start() ;
require_once('auth.php');
$display_block = "display:none !important;";
$error_message = '';

if ( isset( $_POST["submit_signup"] ) ) {
  $user_auth = new User_auth();
  if ($user_auth->posted_signup_data()) {
    if ($user_auth->mailaddress_check()) {
      if ($user_auth->password_check()) {
        if ($user_auth->existence_check() == 0) {
          if ($user_auth->register() == false) {
            $error = $pdo->errorInfo ( ) ;
            echo "<div class=\"alert alert-warning\">エラーが発生しました。<br />{$error[2]}</div>";
            exit() ;
          } else {
            $display_none = "display:none  !important;";
            $display_block = "display:block !imortant;";
          }
        } else {
          $error_message = "同名ユーザーもしくはメールアドレスが既に存在しています。";
        }
      } else {
        $error_message = "パスワードが一致しません。";
      }
    } else {
      $error_message = "正しいメールアドレスを入力してください。";
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
  <title>ユーザー登録</title>
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
  if(mb_strpos($_SERVER['HTTP_REFERER'], "/withdrawal.php") && $_SESSION["withdrawal"] == 1){
    $message = "ご利用ありがとうございました。";
    echo "<div class=\"alert alert-success\">{$message}</div>";
    unset($_SESSION["withdrawal"]);
  }
  ?>
  <main>
    <div class="form_signup_area">
      <form class="form-signin" style="<?= $display_none ?>" action="" id="form-signin" name="form-signin" method="post">
        <h2 class="font-weight-normal">ユーザー登録</h2>
        <p style="color:#CC0003;" class="mb-1 text-left"><?= $error_message ?></p>
        <p class="mb-1 text-left">メールアドレス</p>
        <input type="mail" id="Mailaddress" class="form-control" name="mailaddress" autofocus required>
        <p class="mb-1 text-left">ユーザー名</p>
        <input type="text" id="inputUsername" class="form-control" name="username" required>
        <p class="mb-1 text-left">パスワード</p>
        <input type="password" id="inputPassword" class="form-control" name="password1" required>
        <p class="mb-1 text-left">パスワード(確認)</p>
        <input type="password" id="inputPassword" class="form-control" name="password2" required>
        <button class="btn btn-lg btn-success" name="submit_signup" type="submit">登録</button>
        <div class="login_info mb-3 mt-3">
          <p>ユーザー登録済みの方またはゲスト様は<a href="login.php">コチラ</a></p>
        </div>
      </form>
      <div class="complete" style="<?= $display_block ?>">
        <p>ユーザー登録が完了しました。</p>
        <p class="mb-0"><a href="login.php">ログイン</a></p>
      </div>
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
