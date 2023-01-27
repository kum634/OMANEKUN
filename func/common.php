<?php

session_start();

require("config.php");
require("debug.php");

function get_title($this_file) {
  switch ($this_file){
  case 'login':
    return 'ログイン';
    break;
  case 'signup':
    return 'ユーザー登録';
    break;
  case 'email':
    return 'パスワードの再発行';
    break;
  case 'index':
    return '週間作業予定';
    break;
  case 'reset':
    return 'パスワードの初期化';
    break;
  case 'index':
    return '週間作業予定';
    break;
  case 'history':
    return '依頼履歴';
    break;
  case 'import':
    return 'インポート';
    break;
  case 'export':
    return 'エキスポート';
    break;
  case 'withdrawal':
    return '退会';
    break;
  }
  return 'オーマネ君-整備依頼管理-';
}

/*

XSS対策

*/

function h($str) {
  $str = htmlspecialchars( $str, ENT_QUOTES );
  return $str;
}

/*

bootstrapアラート

*/
function bs_alert($str, $judgment = '', $error_code = '') {

  $html_class = '';
  if ($judgment == true) $html_class = 'alert-success';
  if ($judgment == false) {
    $html_class = 'alert-warning';
    if ($error_code != '') $error_code = '<br>'.$error_code;
  }

  return '<div class="alert '.$html_class.'">'.$str.$error_code.'</div>';

}


class common {

  public $con;

  public function __construct() {

    if (!$this->con) $this->$con = $this->conect();
    $this->create_users_table();
    $this->create_auto_login_table();
    $this->create_password_resets_table();
    $this->create_requests_table();

  }

  /*

  データベース接続

  */
  public function conect() {

    try {
      $this->con = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
      $this->con->query("set character set utf8");
    } catch (Exception $e) {
      echo $e->getMessage();
      exit;
    }
    return true;
  }


  /*

  usersテーブル作成

  */
  public function create_users_table() {

    // テーブルを作成するSQLを作成
    // SQL実行 返り値はtrueかfalse
      $sql = "CREATE TABLE IF NOT EXISTS users (
      	ID bigint(20) not null auto_increment primary key,
        username varchar(50) not null,
        mailaddress varchar(50) not null,
        password varchar(1000) not null
      )";

      try {
        $stmt = $this->con->query($sql);
      } catch (Exception $e) {
        echo $e->getMessage();
        exit;
      }

  }

  /*

  auto_loginテーブル作成

  */
  public function create_auto_login_table() {
    // テーブルを作成するSQLを作成
    // SQL実行 返り値はtrueかfalse
      $sql = "CREATE TABLE IF NOT EXISTS auto_login (
        username varchar(50) not null primary key,
        token varchar(1000) not null
      )";

      try {
        $stmt = $this->con->query($sql);
      } catch (Exception $e) {
        echo $e->getMessage();
        exit;
      }

  }

  /*

  password_resetsテーブル作成

  */
  public function create_password_resets_table() {
    // テーブルを作成するSQLを作成
    // SQL実行 返り値はtrueかfalse
      $sql = "CREATE TABLE IF NOT EXISTS password_resets (
        email varchar(50) not null primary key,
        token varchar(1000) not null
      )";

      try {
        $stmt = $this->con->query($sql);
      } catch (Exception $e) {
        echo $e->getMessage();
        exit;
      }

  }

  /*

  requestsテーブル作成

  */
  public function create_requests_table() {
    // テーブルを作成するSQLを作成
    // SQL実行 返り値はtrueかfalse
      $sql = "CREATE TABLE IF NOT EXISTS requests (
      	ID bigint(20) not null auto_increment primary key,
      	UID bigint(20) not null,
      	visible int(1) not null,
        storage_date date,
        retrieval_date date,
      	last_name varchar(200),
      	first_name varchar(200),
      	tel varchar(50),
        mailaddress varchar(50),
        car_name varchar(20),
        model varchar(20),
        license varchar(20),
        inspection_date date,
        maintenance_type varchar(200),
        maintenance_detail varchar(500),
        wash varchar(10),
        clean varchar(10),
        notices varchar(200),
        notices_detail varchar(500),
      	updated datetime not null default current_timestamp on update current_timestamp,
      	modified datetime not null default current_timestamp
      )";

      try {
        $stmt = $this->con->query($sql);
      } catch (Exception $e) {
        echo $e->getMessage();
        exit;
      }

  }

  /*

  XSS対策

  */
  public function get_chk() {

    // var_dump($_GET);
    if (empty($_GET) || !is_array($_GET)) return;
    foreach ($_GET as $key => $val) $_GET[$key] = htmlspecialchars($val);
    // var_dump($_GET);

  }

  public function arr_chk($arr) {

    // var_dump($arr);
    if (empty($arr) || !is_array($arr)) return;
    foreach ($arr as $key => $val) {
      if (!is_array($val)) $arr[$key] = htmlspecialchars($val);
      else $this->arr_chk($val);
    }
    // var_dump($arr);

  }

  /*

  セッションハイジャック対策

  */
  public function session_expires_chk() {

    if(!isset($_SESSION['expires'])) $_SESSION['expires'] = time();
    if(mt_rand(1, 10) === 1) {
      if ($_SESSION['expires'] + 1 < time()) {
        $_SESSION['expires'] = time();

        // echo '古いセッションID: '.session_id()."\n".basename(__FILE__).__LINE__."\n";
        session_regenerate_id(true);
        // echo '新しいセッションID: '.session_id()."\n".basename(__FILE__).__LINE__."\n";
      }
    }

  }

  /*

  CSRF対策

  */
  public function csrf_set() {

    if (!isset($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = $this->gen_token();

  }

  public function csrf_chk() {
    // if (!empty($_POST)) {
    //   var_dump($_POST);
    //   exit;
    // }
    // var_dump($_SESSION['csrf_token']);
    // var_dump($_POST['csrf_token']);
    if (!empty($_POST)) {
      if (!isset($_SESSION['csrf_token']) || $_POST['csrf_token'] != $_SESSION['csrf_token']) {
        al('認証に失敗しました');
        exit;
      }
    }

  }


    /*

    ユーザー情報の照合

    */
  	public function select_users($arr, $val = false, $error_display = false) {

      dbg(dbg_type, $arr, basename(__FILE__).__LINE__);
      $sql= "SELECT * FROM users WHERE";
      $keys = array_keys($arr);
      dbg(dbg_type, $keys, basename(__FILE__).__LINE__);
      for ($i=0; $i < count($arr); $i++) {
        if ($i > 0) $sql.= " AND";
        $sql.= " ".$keys[$i]." = :".$keys[$i];
      }
      dbg(dbg_type, $sql, basename(__FILE__).__LINE__);
      $stmt = $this->con->prepare($sql);

      for ($i=0; $i < count($arr); $i++) {
        if ($arr[$keys[$i]]) $stmt->bindvalue(':'.$keys[$i], $arr[$keys[$i]]);
      }

      try {
        $stmt->execute();
      } catch (PDOException $e) {
        dbg(dbg_type, __METHOD__.ng, basename(__FILE__).__LINE__);
        $error = $e->getMessage();
        if ($error_display === true) return bs_alert('エラーが発生しました。', false, $error);
      }

      if ($val === false) {
        $obj = $stmt->fetchAll();
        dbg(dbg_type, count($obj), basename(__FILE__).__LINE__);
        return count($obj);
      } elseif ($val === true) {
        $obj = $stmt->fetch ( PDO::FETCH_ASSOC );
        dbg(dbg_type, $obj, basename(__FILE__).__LINE__);
        return $obj;
      }

  	}

  /*

  トークン生成

  */
	public function gen_token() {

    $token = base64_encode(uniqid(time().$_SERVER['HTTP_USER_AGENT']));
    return $token;

  }

  /*

  トークンの削除

  */
	public function del_token($token_name, $tbl, $del_cookie = false) {

    dbg(dbg_type, $token_name, basename(__FILE__).__LINE__);
    dbg(dbg_type, $tbl, basename(__FILE__).__LINE__);
		$sql= "DELETE FROM ".$tbl." WHERE token = :token";
    $stmt = $this->con->prepare($sql);
    $stmt->bindvalue(':token', $_COOKIE[$token_name]);
    $stmt->execute();

		if ($del_cookie === true) setcookie ($token_name, '');
    dbg(dbg_type, $_COOKIE[$token_name], basename(__FILE__).__LINE__);
    dbg(dbg_type, __METHOD__.ok, basename(__FILE__).__LINE__, ex);

	}

  /*

  ログアウト

  */
	public function logout($location = true) {

		session_destroy() ;
		session_start() ;
    dbg(dbg_type, $_SESSION, basename(__FILE__).__LINE__);
    $token_name = 'autologin_token';
    dbg(dbg_type, $_COOKIE[$token_name], basename(__FILE__).__LINE__);
		if (isset( $_COOKIE[$token_name] )) {
      $tbl = 'auto_login';
      $this->del_token($token_name, $tbl, true);
    }
    dbg(dbg_type, $location, basename(__FILE__).__LINE__);
    dbg(dbg_type, __METHOD__.ok, basename(__FILE__).__LINE__, ex);
		if ($location === true) header ( "Location: login.php" ) ;

	}

  /*

  ユーザー情報の抹消

  */
	public function del_user($ID) {

		$sql= "DELETE FROM users WHERE ID ='{$ID}' ";
    $stmt = $this->con->prepare ($sql);
    $stmt->bindvalue(':ID', $ID);
    try {
      $stmt->execute();
    } catch (PDOException $e) {
      dbg(dbg_type, __METHOD__.ng, basename(__FILE__).__LINE__);
      $error = $e->getMessage();
      return $error;
    }
    dbg(dbg_type, __METHOD__.ok, basename(__FILE__).__LINE__);
    return 1;

	}

  /*

  ユーザーの依頼データの抹消

  */
	public function del_all_requests($UID) {

		$sql= "DELETE FROM requests WHERE UID = '{$ID}'";
    $stmt = $this->con->prepare ($sql);
    $stmt->bindvalue(':ID', $UID);
    try {
      $stmt->execute();
    } catch (PDOException $e) {
      dbg(dbg_type, __METHOD__.ng, basename(__FILE__).__LINE__);
      $error = $e->getMessage();
      dbg(dbg_type, $error, basename(__FILE__).__LINE__);
      return $error;
    }
    dbg(dbg_type, __METHOD__.ok, basename(__FILE__).__LINE__);
    return 1;

	}

}
?>
