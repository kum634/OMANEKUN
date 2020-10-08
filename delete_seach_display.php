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
  <title>依頼内容の削除</title>
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
      <h1>依頼内容の削除</h1>
      <?php
      if(mb_strpos($_SERVER['HTTP_REFERER'], "/delete.php")){
        if($_SESSION["delete"] == 2){
          $message = "データの削除に成功しました。";
          echo "<div class=\"alert alert-success\">{$message}</div>";
          unset($_SESSION["delete"]);
        }
        if($_SESSION["delete"] == 1){
          $message = "データの削除に失敗しました。";
          $error = $_SESSION["delete_error"];
          echo "<div class=\"alert alert-warning\">{$error}<br>{$message}</div>";
          unset($_SESSION["delete"]);
        }
      }
      ?>
      <div class="form_area">
        <form id="form1" name="form1" method="post" action="">
          <table class="input_area" width="90%" border="1">
            <tbody>
              <tr>
                <td>入庫日：</td>
                <td>
                  <select name="nyuko_bi_y" id="nyuko_bi_y">
                    <option value="">-</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                  </select> 年
                  <select name="nyuko_bi_m" id="nyuko_bi_m">
                    <option value="">-</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                  </select> 月
                  <select name="nyuko_bi_d" id="nyuko_bi_d">
                    <option value="">-</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                  </select> 日
                </td>
              </tr>
              <tr>
                <td>納車予定日：</td>
                <td>
                  <select name="nousya_yoteibi_y" id="nousya_yoteibi">
                    <option value="">-</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                  </select> 年
                  <select name="nousya_yoteibi_m" id="nousya_yoteibi">
                    <option value="">-</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                  </select> 月
                  <select name="nousya_yoteibi_d" id="nousya_yoteibi">
                    <option value="">-</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                  </select> 日
                </td>
              </tr>
              <tr>
                <td>お客様氏名：</td>
                <td><input class="text_area" type="text" name="sei" id="sei" placeholder="姓" /><input class="text_area" type="text" name="mei" id="mei" placeholder="名" />　</td>
              </tr>
              <tr>
                <td>電話番号：</td>
                <td><input class="text_area" type="text" name="tel" id="tel" placeholder="" /></td>
              </tr>
              <tr>
                <td>メールアドレス：</td>
                <td><input class="text_area" type="text" name="mail" id="mail" placeholder="" /></td>
              </tr>
              <tr>
                <td>車種名：</td>
                <td><input class="text_area" type="text" name="car_name" id="car_name" placeholder="" />	</td>
              </tr>
              <tr>
                <td>型式：	</td>
                <td><input class="text_area" type="text" name="katasiki" id="katasiki" placeholder="" /></td>
              </tr>
              <tr>
                <td>登録番号：</td>
                <td><input class="text_area" type="text" name="tourokubangou" id="tourokubangou" placeholder="" /></td>
              </tr>
              <tr>
                <td>車検証の有効期限：</td>
                <td>
                  <select name="syakenmanryou_bi_y" id="syakenmanryou_bi_y">
                    <option value="">-</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                  </select> 年
                  <select name="syakenmanryou_bi_m" id="syakenmanryou_bi_m">
                    <option value="">-</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                  </select> 月
                  <select name="syakenmanryou_bi_d" id="syakenmanryou_bi_d">
                    <option value="">-</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                  </select> 日
                </td>
              </tr>
              <tr>
                <td>整備の種類：</td>
                <td>
                  故障修理 <input class="check_area" type="checkbox" name="seibi_syurui[]" id="seibi_syurui"  value="故障修理" />
                  <br />
                  部品(交換・取付・取外し) <input class="check_area" type="checkbox" name="seibi_syurui[]" id="seibi_syurui" value="部品(交換・取付・取外し)" /><br />
                  点検 <input class="check_area" type="checkbox" name="seibi_syurui[]" id="seibi_syurui" value="点検" />
                  <br />
                  車検 <input class="check_area" type="checkbox" name="seibi_syurui[]" id="seibi_syurui" value="車検" />
                  <br />
                  メンテナンス <input class="check_area" type="checkbox" name="seibi_syurui[]" id="seibi_syurui" value="メンテナンス" />
                  <br />
                  板金塗装 <input class="check_area" type="checkbox" name="seibi_syurui[]" id="seibi_syurui" value="板金塗装" />
                  <br />
                  その他 <input class="check_area" type="checkbox" name="seibi_syurui[]" id="seibi_syurui" value="その他" />
                </td>
              </tr>
              <tr>
                <td>整備内容：</td>
                <td><textarea name="seibi_naiyou" rows="10" id="seibi_naiyou"></textarea></td>
              </tr>
              <tr>
                <td>洗車の有無：</td>
                <td>
                  有 <input class="check_area" type="radio" name="sensya" id="sensya" placeholder="" value="有" />
                  <br />
                  無 <input class="check_area" type="radio" name="sensya" id="sensya" placeholder="" value="無" /></td>
              </tr>
              <tr>
                <td>車内清掃の有無：</td>
                <td>
                  有 <input class="check_area" type="radio" name="syanaiseisou" id="syanaiseisou" placeholder="" value="有" />
                  <br />
                  無 <input class="check_area" type="radio" name="syanaiseisou" id="syanaiseisou" placeholder="" value="無" />
                </td>
              </tr>
              <tr>
                <td>特記事項：</td>
                <td>
                  部品破損要注意 <input class="check_area" type="checkbox" name="tokki_zikou[]" id="tokki_zikou"  value="部品破損要注意" />
                  <br />
                  作業傷要注意 <input class="check_area" type="checkbox" name="tokki_zikou[]" id="tokki_zikou"  value="作業傷要注意" />
                  <br />
                  入念洗車 <input class="check_area" type="checkbox" name="tokki_zikou[]" id="tokki_zikou"  value="入念洗車" />
                  <br />
                  洗車機禁止 <input class="check_area" type="checkbox" name="tokki_zikou[]" id="tokki_zikou"  value="洗車機禁止" />
                  <br />
                  窓拭き禁止 <input class="check_area" type="checkbox" name="tokki_zikou[]" id="tokki_zikou"  value="窓拭き禁止" />
                  <br />
                  車内ゴミ撤去禁止 <input class="check_area" type="checkbox" name="tokki_zikou[]" id="tokki_zikou"  value="車内ゴミ撤去禁止" />
                  <br />
                  納車日厳守 <input class="check_area" type="checkbox" name="tokki_zikou[]" id="tokki_zikou"  value="納車日厳守" />
                  <br />
                  取外し部品返却必須 <input class="check_area" type="checkbox" name="tokki_zikou[]" id="tokki_zikou"  value="取外し部品返却必須" />
                  <br />
                  その他 <input class="check_area" type="checkbox" name="tokki_zikou[]" id="tokki_zikou"  value="その他" />
                </td>
              </tr>
              <tr>
                <td>特記事項詳細：</td>
                <td><textarea name="tokki_zikou_syousai" rows="10" id="tokki_zikou_syousai"></textarea></td>
              </tr>
            </tbody>
          </table>
          <input class="small_btn pl-5 pr-5"type="submit" name="submit" id="submit" value="検索" />
        </form>
      </div>
      <div class="result">
        <?php

        if ( isset( $_POST["submit"] ) ) {

          $maintenance_request = new Maintenance_request();
          $maintenance_request->posted_seach_data();
          $identify_ID = $maintenance_request->identify_ID();
          $maintenance_request->seach("COUNT(*)", $identify_ID);
          $count = $maintenance_request->res_count();

          if ( $count == 0 ) {
            echo "<script type='text/javascript'>alert('一致するデータがありませんでした。');</script>";
            echo "<div class='result_title'><h2>一致するデータがありません。</h2></div>";
          } else {
            echo "<script type='text/javascript'>alert('{$count} 件該当しました。');</script>";
            echo "<div class='result_title'><h2>該当件数 {$count} 件</h2></div>";
            $maintenance_request->seach("*", $identify_ID);
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
              <form action="delete.php" method="post" style="display: inline;">
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
              <input class="small_btn pl-4 pr-4" type="submit" name="submit_delete" value="削除" />
              </form>
              </td>
              </tr>\n
              END;
            }
            echo "</table>\n" ;
          }
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
