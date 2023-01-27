<?php


/*

デバッグ

*/
function al($msg = 'ここまで正常やで！') {

  if ($msg == ex) {
    echo "<script type='text/javascript'>alert('ここまで正常やで！');</script>";
    exit;
  } else {
    echo "<script type='text/javascript'>alert('".$msg."');</script>";
  }

}

function dmp($arr) {

  var_dump($arr);
  exit;

}

function position($position) {

  if (HIDE == true) echo "<!-- ";
  echo "<p>".$position."</p>\n";
  echo "<p>↓</p>\n";
  if (HIDE == true) echo " -->\n";

}

function dbg($type, $value, $position = false, $ext = false) {

  if (DEBUG == false) return;

  if ($type == 'log') {

    $msg = '['.date("Y/m/d H:i:s").']';
    if ($position !== false) $msg.= $position."\n";
    $msg.= print_r($value, true)."\n";

    error_log($msg, 3, './log/'.date("YmdHis").'_debug.txt');
    return;
  }

  echo "<br>\n";
  if (is_string($position)) position($position);

  if (($type == 'al' or $type == 'AL') && is_string($value) && $value === true) {

    //デバッグ(アラート表示)
    echo "<script type='text/javascript'>alert('".$value."');</script>";

  } elseif ($type == 'dm' or $type == 'DM') {

    //デバッグ(var_dump表示)

    if (HIDE == true) echo "<!– ";
    echo "<pre>\n";
    var_dump($value);
    echo "</pre>\n";
    if (HIDE == true) echo " –>\n";

  } elseif (($type == 'tb' or $type == 'TB') && is_array($value)) {

    //配列デバッグ(テーブル表示)

    if (HIDE == true) echo "<!– ";
    echo "<table>\n";
    foreach($value as $k => $v) {
      echo "<tr>\n<td>".$k."</td>\n<td>";
      if(is_array($v)) {
        debug($k, $v);
      } else {
        echo $v;
      }
      echo "</td>\n</tr>\n";
    }
    echo "</table>\n";
    if (HIDE == true) echo " –>\n";

  } else {

    if (!empty($type) && (empty($value) || $value === true) &&  $ext === false && $position === false) {

      //簡易デバッグ
      if (is_array($type)  || is_string($type) || is_int($type)) {
        if (HIDE == true) echo "<!– ";
        echo "<pre>\n";
        var_dump($type);
        echo "</pre>\n";
        if (HIDE == true) echo " –>\n";
      } else {
        echo "デバッグ処理に不具合が発生しました。";
      }

    }
    if ($value === true && exit_control === true) exit;
  }
  if ($ext == ex && exit_control === true) exit;
}

?>
