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
  <section class="sheet">
    <h1>作業指示書</h1>
    <table class="date" width="100%">
      <tbody>
        <tr>
          <th><p>入庫日</p></th>
          <th><p>納車予定日</p></th>
        </tr>
        <tr>
          <td><p><?= $_GET["storage_date_y"] ?><span style="margin:0 2mm;">年</span><?= $_GET["storage_date_m"] ?><span style="margin:0 2mm;">月</span><?= $_GET["storage_date_d"] ?><span style="margin-left:2mm;">日</span></p></td>
          <td><p><?= $_GET["retrieval_date_y"] ?><span style="margin:0 2mm;">年</span><?= $_GET["retrieval_date_m"] ?><span style="margin:0 2mm;">月</span><?= $_GET["retrieval_date_d"] ?><span style="margin-left:2mm;">日</span></p></td>
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
          <td><p><?= $_GET["last_name"] ?><?= $_GET["first_name"] ?><span style="margin-left:2mm;">様</span></p></td>
          <td><p><?= $_GET["tel"] ?></p></td>
          <td><p><?= $_GET["mailaddress"] ?></p></td>
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
          <td><p><?= $_GET["car_name"] ?></p></td>
          <td><p><?= $_GET["model"] ?></p></td>
        </tr>
        <tr>
          <th><p>登録番号</p></th>
          <th><p>車検満了日</p></th>
        </tr>
        <tr>
          <td><p><?= $_GET["license"] ?></p></td>
          <td><p><?= $_GET["inspection_date_y"] ?><span style="margin:0 2mm;">年</span><?= $_GET["inspection_date_m"] ?><span style="margin:0 2mm;">月</span><?= $_GET["inspection_date_d"] ?><span style="margin-left:2mm;">日</span></p></td>
        </tr>
      </tbody>
    </table>
    <table class="clean" width="100%">
      <tbody>
        <tr>
          <th><p>洗車</p></th><th><p>車内清掃</p></th>
        </tr>
        <tr>
          <td><p><?= $_GET["wash"] ?></p></td><td><p><?= $_GET["clean"] ?></p></td>
        </tr>
      </tbody>
    </table>
    <table class="maintenance" width="100%">
      <tbody>
        <tr>
          <th colspan="2"><p>整備の種類</p></th>
        </tr>
        <tr>
          <td colspan="2" class="short_string"><p><?= $_GET["maintenance_type"] ?></p></td>
        </tr>
        <tr>
          <th colspan="2"><p>整備内容</p></th>
        </tr>
        <tr>
          <td colspan="2" class="long_string"><p><?= $_GET["maintenance_detail"] ?></p></td>
        </tr>
        <tr>
          <th colspan="2"><p>特記事項</p></th>
        </tr>
        <tr>
          <td colspan="2" class="short_string"><p><?= $_GET["notices"] ?></p></td>
        </tr>
        <tr>
          <th colspan="2"><p>特記事項詳細</p></th>
        </tr>
        <tr>
          <td colspan="2" class="long_string"><p><?= $_GET["notices_detail"] ?></p></td>
        </tr>
      </tbody>
    </table>
  </section>
  <script>
  document.body.onload = function() { window.print() };
  </script>
</body>
</html>
