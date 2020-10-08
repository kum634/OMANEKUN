<?php
require_once('loading.php');
?>
<!DOCTYPE html>
<html lang="en"><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="google" content="notranslate">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="format-detection" content="telephone=no,noindex,nofollow,noarchive">
  <!-- InstanceBeginEditable name="doctitle" -->
  <title>依頼内容の詳細</title>
  <!-- InstanceEndEditable -->
  <!-- Bootstrap -->
  <link href="css/bootstrap-4.3.1.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Kosugi&display=swap" rel="stylesheet">
  <!-- InstanceBeginEditable name="head" -->
  <!-- InstanceEndEditable -->
</head>
<body>
  <header class="fixed-top bg-success">
    <nav class=" navbar navbar-expand-lg navbar-dark custom-hamburger"><a class="navbar-brand top_logo" href="index.php"><span class="logo">オーマネ君</span><span class="hyphen_left">-</span><span class="catch_copy">整備依頼管理</span><span class="hyphen_right">-</span></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span><span class="navbar-toggler-icon"></span><span class="navbar-toggler-icon"></span> </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-calendar"></i>週間作業予定</a> </li>
          <li class="nav-item"><a class="nav-link" href="input.php"><i class="fas fa-edit"></i>依頼内容の登録</a></li>
          <li class="nav-item"><a class="nav-link" href="seach_display.php"><i class="fas fa-search"></i>依頼内容の検索</a></li>
          <li class="nav-item"><a class="nav-link" href="delete_seach_display.php"><i class="fas fa-trash-alt"></i>依頼内容の削除</a></li>
          <li class="nav-item"><a class="nav-link" href="import.php"><i class="fas fa-upload"></i>インポート</a></li>
          <li class="nav-item"><a class="nav-link" href="export.php"><i class="fas fa-download"></i>エキスポート</a></li>
          <li class="nav-item"><a class="nav-link" href="withdrawal.php"><i class="fas fa-door-open"></i>退会</a></li>
        </ul>
      </div>
    </nav>
  </header>
  <main>
    <aside id="side_menu">
      <nav>
        <ul class="large_screen navbar-nav mr-auto">
          <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-calendar"></i>週間作業予定</a> </li>
          <li class="nav-item"><a class="nav-link" href="input.php"><i class="fas fa-edit"></i>依頼内容の登録</a></li>
          <li class="nav-item"><a class="nav-link" href="seach_display.php"><i class="fas fa-search"></i>依頼内容の検索</a></li>
          <li class="nav-item"><a class="nav-link" href="delete_seach_display.php"><i class="fas fa-trash-alt"></i>依頼内容の削除</a></li>
          <li class="nav-item"><a class="nav-link" href="import.php"><i class="fas fa-upload"></i>インポート</a></li>
          <li class="nav-item"><a class="nav-link" href="export.php"><i class="fas fa-download"></i>エキスポート</a></li>
          <li class="nav-item"><a class="nav-link" href="withdrawal.php"><i class="fas fa-door-open"></i>退会</a></li>
        </ul>
        <ul class="middle_screen navbar-nav mr-auto">
          <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-calendar"></i></a> </li>
          <li class="nav-item"><a class="nav-link" href="input.php"><i class="fas fa-edit"></i></a></li>
          <li class="nav-item"><a class="nav-link" href="seach_display.php"><i class="fas fa-search"></i></a></li>
          <li class="nav-item"><a class="nav-link" href="delete_seach_display.php"><i class="fas fa-trash-alt"></i></a></li>
          <li class="nav-item"><a class="nav-link" href="import.php"><i class="fas fa-upload"></i></a></li>
          <li class="nav-item"><a class="nav-link" href="export.php"><i class="fas fa-download"></i></a></li>
          <li class="nav-item"><a class="nav-link" href="withdrawal.php"><i class="fas fa-door-open"></i></a></li>
        </ul>
      </nav>
    </aside>
    <article class="jumbotron jumbotron-fluid text-center mb-0" style="width:100%;">
      <div class="login_info text-right">
        <p class="user text-center"><?php echo $user;?></p>
        <p class="logout_btn text-center"><?php echo $logout_btn ;?></p>
      </div>
      <!-- InstanceBeginEditable name="メインコンテンツ" -->
      <?php
      $id =  $_POST[ "ID" ];
      $nyuko_bi = $_POST[ "nyuko_bi" ];
      $nousya_yoteibi = $_POST[ "nousya_yoteibi" ];
      $sei = $_POST[ "sei" ];
      $mei = $_POST[ "mei" ];
      $tel = $_POST[ "tel" ];
      $mail = $_POST[ "mail" ];
      $car_name = $_POST[ "car_name" ];
      $katasiki = $_POST[ "katasiki" ];
      $tourokubangou = $_POST[ "tourokubangou" ];
      $syakenmanryou_bi = $_POST[ "syakenmanryou_bi" ];
      $seibi_syurui = $_POST[ "seibi_syurui" ];
      $seibi_naiyou = $_POST[ "seibi_naiyou" ];
      $sensya = $_POST[ "sensya" ];
      $syanaiseisou = $_POST[ "syanaiseisou" ];
      $tokki_zikou = $_POST[ "tokki_zikou" ];
      $tokki_zikou_syousai = $_POST[ "tokki_zikou_syousai" ];
      ?>
      <h1>依頼内容の詳細</h1>
      <div class="result">
        <table class="input_area" style="margin-bottom:16px;"  border="1" width="90%">
          <tr style="display:none;">
            <th>ID</th><th><?= $id ?></th>
          </tr>
          <tr>
            <td>入庫日</td><td><?= $nyuko_bi ?></td>
          </tr>
          <tr>
            <td>返却予定日</td><td><?= $nousya_yoteibi ?></td>
          </tr>
          <tr>
            <td>お客様氏名</td><td><?= $sei ?><?= $mei ?></td>
          </tr>
          <tr>
            <td>電話番号</td><td><?= $tel ?></td>
          </tr>
          <tr>
            <td>メールアドレス</td><td><?= $mail ?></td>
          </tr>
          <tr>
            <td>車種名</td><td><?= $car_name ?></td>
          </tr>
          <tr>
            <td>型式</td><td><?= $katasiki ?></td>
          </tr>
          <tr>
            <td>登録番号</td><td><?= $tourokubangou ?></td>
          </tr>
          <tr>
            <td>車検証の有効期限</td><td><?= $syakenmanryou_bi ?></td>
          </tr>
          <tr>
            <td>整備の種類</td><td><?= $seibi_syurui ?></td>
          </tr>
          <tr>
            <td>整備内容</td><td><?= $seibi_naiyou ?></td>
          </tr>
          <tr>
            <td>洗車の有無</td><td><?= $sensya ?></td>
          </tr>
          <tr>
            <td>車内清掃の有無</td><td><?= $syanaiseisou ?></td>
          </tr>
          <tr>
            <td>特記事項</td><td><?= $tokki_zikou ?></td>
          </tr>
          <tr>
            <td>特記事項詳細</td><td><?= $tokki_zikou_syousai ?></td>
          </tr>
        </table>
        <div class="btn_area">
          <form id="form<?= $id ?>" name="form<?= $id ?>" action="print.php"  target="_blank" method="POST">
            <input style="display:none;" name="nyuko_bi" value="<?= $nyuko_bi ?>"/>
            <input style="display:none;" name="nousya_yoteibi" value="<?= $nousya_yoteibi ?>"/>
            <input style="display:none;" name="sei" value="<?= $sei ?>"/>
            <input style="display:none;" name="mei" value="<?= $mei ?>"/>
            <input style="display:none;" name="tel" value="<?= $tel ?>"/>
            <input style="display:none;" name="mail" value="<?= $mail ?>"/>
            <input style="display:none;" name="car_name" value="<?= $car_name ?>"/>
            <input style="display:none;" name="katasiki" value="<?= $katasiki ?>"/>
            <input style="display:none;" name="tourokubangou" value="<?= $tourokubangou ?>"/>
            <input style="display:none;" name="syakenmanryou_bi" value="<?= $syakenmanryou_bi ?>"/><input style="display:none;" name="seibi_syurui" value="<?= $seibi_syurui ?>"/>
            <input style="display:none;" name="seibi_naiyou" value="<?= $seibi_naiyou ?>"/>
            <input style="display:none;" name="sensya" value="<?= $sensya ?>"/>
            <input style="display:none;" name="syanaiseisou" value="<?= $syanaiseisou ?>"/>
            <input style="display:none;" name="tokki_zikou" value="<?= $tokki_zikou ?>"/>
            <input style="display:none;" name="tokki_zikou_syousai" value="<?= $tokki_zikou_syousai ?>"/>
            <input class="small_btn" type="submit" name="submit_<?= $id ?>" id="submit_<?= $id ?>" value="作業指示書を印刷" />
          </form>
        </div>
      </div>
      <!-- InstanceEndEditable -->
      <footer class="text-center">
        <div>
          <p class="mt-5 mb-2" style="font-size: 0.8rem;">※当サイトを正常に動作させるために、最新のGoogle ChromeもしくはSafari等でご覧ください。</p>
          <p>Copyright &copy; 2020 &middot; All Rights Reserved &middot; オーマネ君-整備依頼管理-</p>
        </div>
      </footer>
    </article>
  </main>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="js/jquery-3.3.1.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap-4.3.1.js"></script>
</body>
<!-- InstanceEnd --></html>
