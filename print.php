<?php
require_once('loading.php');
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8" content="telephone=no,noindex,nofollow,noarchive">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>印刷ページ</title>
  <link href="css/print.css" rel="stylesheet" type="text/css">
</head>
<body>
  <?php
  $nyuko_bi = $_POST[ "nyuko_bi" ];
  $nyuko_bi = explode( '-', $nyuko_bi );
  $nyuko_bi_y = $nyuko_bi[0];
  $nyuko_bi_m = $nyuko_bi[1];
  $nyuko_bi_d = $nyuko_bi[2];
  $nousya_yoteibi = $_POST[ "nousya_yoteibi" ];
  $nousya_yoteibi = explode( '-', $nousya_yoteibi );
  $nousya_yoteibi_y = $nousya_yoteibi[0];
  $nousya_yoteibi_m = $nousya_yoteibi[1];
  $nousya_yoteibi_d = $nousya_yoteibi[2];
  $sei = $_POST[ "sei" ];
  $mei = $_POST[ "mei" ];
  $tel = $_POST[ "tel" ];
  $mail = $_POST[ "mail" ];
  $car_name = $_POST[ "car_name" ];
  $katasiki = $_POST[ "katasiki" ];
  $tourokubangou = $_POST[ "tourokubangou" ];
  $syakenmanryou_bi = $_POST[ "syakenmanryou_bi" ];
  $syakenmanryou_bi = explode( '-', $syakenmanryou_bi );
  $syakenmanryou_bi_y = $syakenmanryou_bi[0];
  $syakenmanryou_bi_m = $syakenmanryou_bi[1];
  $syakenmanryou_bi_d = $syakenmanryou_bi[2];
  $seibi_syurui = $_POST[ "seibi_syurui" ];
  $seibi_naiyou = $_POST[ "seibi_naiyou" ];
  $sensya = $_POST[ "sensya" ];
  $syanaiseisou = $_POST[ "syanaiseisou" ];
  $tokki_zikou = $_POST[ "tokki_zikou" ];
  $tokki_zikou_syousai = $_POST[ "tokki_zikou_syousai" ];
  ?>
  <section class="sheet">
    <h1>作業指示書</h1>
    <table class="date" width="100%">
      <tbody>
        <tr>
          <th><p>入庫日</p></th>
          <th><p>納車予定日</p></th>
        </tr>
        <tr>
          <td><p><?= $nyuko_bi_y ?><span style="margin:0 2mm;">年</span><?= $nyuko_bi_m ?><span style="margin:0 2mm;">月</span><?= $nyuko_bi_d ?><span style="margin-left:2mm;">日</span></p></td>
          <td><p><?= $nousya_yoteibi_y ?><span style="margin:0 2mm;">年</span><?= $nousya_yoteibi_m ?><span style="margin:0 2mm;">月</span><?= $nousya_yoteibi_d ?><span style="margin-left:2mm;">日</span></p></td>
        </tr>
      </tbody>
    </table>
    <table class="guest" width="100%">
      <tbody>
        <tr>
          <th><p>お客様名</p></th>
          <th><p>電話番号</p></th>
          <th><p>メールアドレス</p></th>
        </tr>
        <tr>
          <td><p><?= $sei ?><?= $mei ?><span style="margin-left:2mm;">様</span></p></td>
          <td><p><?= $tel ?></p></td>
          <td><p><?= $mail ?></p></td>
        </tr>
      </tbody>
    </table>
    <table class="car" width="100%">
      <tbody>
        <tr>
          <th><p>車種</p></th>
          <th><p>型式</p></th>
        </tr>
        <tr>
          <td><p><?= $car_name ?></p></td>
          <td><p><?= $katasiki ?></p></td>
        </tr>
        <tr>
          <th><p>登録番号</p></th>
          <th><p>車検満了日</p></th>
        </tr>
        <tr>
          <td><p><?= $tourokubangou ?></p></td>
          <td><p><?= $syakenmanryou_bi_y ?><span style="margin:0 2mm;">年</span><?= $syakenmanryou_bi_m ?><span style="margin:0 2mm;">月</span><?= $syakenmanryou_bi_d ?><span style="margin-left:2mm;">日</span></p></td>
        </tr>
      </tbody>
    </table>
    <table class="clean" width="100%">
      <tbody>
        <tr>
          <th><p>洗車</p></th><th><p>車内清掃</p></th>
        </tr>
        <tr>
          <td><p><?= $sensya ?></p></td><td><p><?= $syanaiseisou ?></p></td>
        </tr>
      </tbody>
    </table>
    <table class="maintenance" width="100%">
      <tbody>
        <tr>
          <th colspan="2"><p>整備の種類</p></th>
        </tr>
        <tr>
          <td colspan="2" class="short_string"><p><?= $seibi_syurui ?></p></td>
        </tr>
        <tr>
          <th colspan="2"><p>整備内容</p></th>
        </tr>
        <tr>
          <td colspan="2" class="long_string"><p><?= $seibi_naiyou ?></p></td>
        </tr>
        <tr>
          <th colspan="2"><p>特記事項</p></th>
        </tr>
        <tr>
          <td colspan="2" class="short_string"><p><?= $tokki_zikou ?></p></td>
        </tr>
        <tr>
          <th colspan="2"><p>特記事項詳細</p></th>
        </tr>
        <tr>
          <td colspan="2" class="long_string"><p><?= $tokki_zikou_syousai ?></p></td>
        </tr>
      </tbody>
    </table>
  </section>
  <script>
  document.body.onload = function() { window.print() };
  </script>
</body>
</html>
