<?php
require_once('loading.php');
require_once('db.php');
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
  <title>オーマネ君-整備依頼管理-</title>
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
      <div class="result">
        <?php
        $maintenance_request = new Maintenance_request();
        $date = $maintenance_request->weekly();
        echo "<h1>今週( {$date["startDate"]} - {$date["endDate"]} )の作業予定</h1>";
        $identify_ID = $maintenance_request->identify_ID();
        $maintenance_request->weekly_match("COUNT(*)", $identify_ID);
        $count = $maintenance_request->res_count();

        if ( $count == 0 ) {
          echo "<div class='result_title'><h2>今週の作業予定はありません。</h2></div>";
        } else {
          echo "<div class='result_title'><h2>今週の作業予定 {$count} 件</h2></div>";
          $maintenance_request->weekly_match("*", $identify_ID);
          $stmt = $maintenance_request->res_display();

          echo <<< END
          <table class="seach_result">
            <tr>
              <th style="display:none;">ID</th>
              <th>入庫日</th><th>納車予定日</th>
              <th>お客様氏名</th><th>車種名</th>
              <th>型式</th><th>登録番号</th>
              <th>整備の種類</th>
              <th></th>
            </tr>
          END;

          while ( $row = $stmt->fetch ( PDO::FETCH_ASSOC ) ) {
            echo <<< END
            <tr>
              <td style="display:none;">{$row["ID"]}</td>
              <td>{$row["nyuko_bi"]}</td>
              <td>{$row["nousya_yoteibi"]}</td>
              <td>{$row["sei"]}{$row["mei"]}</td>
              <td>{$row["car_name"]}</td>
              <td>{$row["katasiki"]}</td>
              <td>{$row["tourokubangou"]}</td>
              <td>{$row["seibi_syurui"]}</td>
              <td>
                <form action="details.php" method="POST" name="form{$row["ID"]}" id="form{$row["ID"]}">
                  <input style="display:none;" name="ID" value="{$row["ID"]}"/>
                  <input style="display:none;" name="nyuko_bi" value="{$row["nyuko_bi"]}"/>
                  <input style="display:none;" name="nousya_yoteibi" value="{$row["nousya_yoteibi"]}"/>
                  <input style="display:none;" name="sei" value="{$row["sei"]}"/>
                  <input style="display:none;" name="mei" value="{$row["mei"]}"/>
                  <input style="display:none;" name="tel" value="{$row["tel"]}"/>
                  <input style="display:none;" name="mail" value="{$row["mail"]}"/>
                  <input style="display:none;" name="car_name" value="{$row["car_name"]}"/>
                  <input style="display:none;" name="katasiki" value="{$row["katasiki"]}"/>
                  <input style="display:none;" name="tourokubangou" value="{$row["tourokubangou"]}"/>
                  <input style="display:none;" name="syakenmanryou_bi" value="{$row["syakenmanryou_bi"]}"/>
                  <input style="display:none;" name="seibi_syurui" value="{$row["seibi_syurui"]}"/>
                  <input style="display:none;" name="seibi_naiyou" value="{$row["seibi_naiyou"]}"/>
                  <input style="display:none;" name="sensya" value="{$row["sensya"]}"/>
                  <input style="display:none;" name="syanaiseisou" value="{$row["syanaiseisou"]}"/>
                  <input style="display:none;" name="tokki_zikou" value="{$row["tokki_zikou"]}"/>
                  <input style="display:none;" name="tokki_zikou_syousai" value="{$row["tokki_zikou_syousai"]}"/>
                  <input class="small_btn" type="submit" name="submit_{$row["ID"]}" id="submit_{$row["ID"]}" value="詳細を表示"/>
                </form>
              </td>
            </tr>\n
            END;
          }
          echo "</table>\n" ;
        }
        ?>
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
