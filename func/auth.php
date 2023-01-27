<?php
require('common.php');

class auth extends common {

	/*

	データベースへの接続確認

	*/

	public function __construct() {

    if (!$this->con) $this->$con = $this->conect();

    $this->csrf_set();
    $this->csrf_chk();
		$this->get_chk();
		$this->arr_chk($_POST);

  }


	public function insert_users($arr) {

    $sql = "INSERT INTO users";
    $sql.= " VALUES(null, ";
    $sql.= " :username,";
		$sql.= " :mailaddress,";
    $sql.= " :password";
    $sql.= ")";
		dbg(dbg_type, $sql, basename(__FILE__).__LINE__);
    $stmt = $this->con->prepare($sql);
    $stmt->bindvalue ( ':mailaddress', $arr['mailaddress'] );
    $stmt->bindvalue ( ':username', $arr['username'] );
    $stmt->bindvalue ( ':password', $arr['password'] );

    try {
      $stmt->execute();
    } catch (PDOException $e) {
      $error = $e->getMessage();
      return bs_alert('エラーが発生しました。', false, $error);
    }

  }

  /*

  ユーザー登録

  */
	public function register() {

		$username = $_POST["username"];
		$password = $_POST["password2"];
		$mailaddress = $_POST["mailaddress"];

    $arr = array(
      'username' => $username,
      'mailaddress' => $mailaddress
    );
		$both_ence = $this->select_users($arr);

    $arr = array(
      'username' => $username
    );
		$username_ence = $this->select_users($arr);

    $arr = array(
      'mailaddress' => $mailaddress
    );
		$mailaddress_ence = $this->select_users($arr);

		$key = array();
		if ($both_ence > 0) {
			$key[] = 'both';
			return $key;
		} elseif ($username_ence > 0 || $mailaddress_ence > 0) {
			if ($username_ence > 0) $key[] = 'username';
			if ($mailaddress_ence > 0) $key[] = 'mailaddress';
			return $key;
		}

		$password = password_hash($password, PASSWORD_BCRYPT);

    $arr = array(
      'mailaddress' => $mailaddress,
      'username' => $username,
      'password' => $password
    );
    $res = $this->insert_users($arr);
    if (is_string($res)) return $res;

		return 1;

	}


  /*

  ログイン

  */
	public function login($username, $password, $autologin = '') {

		$username = h($username);
		$password = h($password);
    dbg(dbg_type, $username, basename(__FILE__).__LINE__);
  	dbg(dbg_type, $password, basename(__FILE__).__LINE__);
		if ($username == 'guest' && $password == 'guest2020') {

      $arr = array(
        'username' => $username
      );
      dbg(dbg_type, $arr, basename(__FILE__).__LINE__);
      $res = $this->select_users($arr, false, true);
      dbg(dbg_type, $res, basename(__FILE__).__LINE__);
      if (is_string($res)) return $res;
      if ($res != 1) return $res;

      $row = $this->select_users($arr, true);
      dbg(dbg_type, $row, basename(__FILE__).__LINE__);

			// echo '古いセッションID: '.session_id()."\n".basename(__FILE__).__LINE__."\n";
			session_regenerate_id(true);
			// echo '新しいセッションID: '.session_id()."\n".basename(__FILE__).__LINE__."\n";

      $_SESSION["UID"] = $row["ID"];
      $_SESSION["user"] = $row["username"];
      $_SESSION["pass"] = $row["password"];

		} else {

      $arr = array(
        'username' => $username
      );
      dbg(dbg_type, $arr, basename(__FILE__).__LINE__);
      $res = $this->select_users($arr, true, true);
      dbg(dbg_type, $res, basename(__FILE__).__LINE__);
      if (is_string($res)) return $res;
			if (!password_verify($password, $res["password"])) return 0;
      dbg(dbg_type, $res, basename(__FILE__).__LINE__);

			// echo '古いセッションID: '.session_id()."\n".basename(__FILE__).__LINE__."\n";
			session_regenerate_id(true);
			// echo '新しいセッションID: '.session_id()."\n".basename(__FILE__).__LINE__."\n";

      $_SESSION["UID"] = $res["ID"];
      $_SESSION["user"] = $res["username"];
      $_SESSION["pass"] = $res["password"];

		}
    dbg(dbg_type, $autologin, basename(__FILE__).__LINE__);
		if ($autologin != '') $this->autologin_start($username, $password);
    $this->csrf_set();
    dbg(dbg_type, __METHOD__.ok, basename(__FILE__).__LINE__, ex);
		header( "Location: index.php" );
	}

	public function insert_autologin($arr) {

    $sql = "INSERT INTO auto_login";
    $sql.= " VALUES(";
    $sql.= " :username,";
    $sql.= " :token";
    // $sql.= " :password";
    $sql.= ")";
		dbg(dbg_type, $sql, basename(__FILE__).__LINE__);
    $stmt = $this->con->prepare($sql);
    $stmt->bindvalue ( ':username', $arr['username'] );
    $stmt->bindvalue ( ':token', $arr['token'] );
    try {
      $stmt->execute();
    } catch (PDOException $e) {
      dbg(dbg_type, __METHOD__.ng, basename(__FILE__).__LINE__);
      $error = $e->getMessage();
      al('自動ログインに失敗しました。\n'.$error);
    }

  }


  /*

  自動ログインの開始

  */
	public function autologin_start($username, $password) {

    dbg(dbg_type, $username, basename(__FILE__).__LINE__);
    dbg(dbg_type, $password, basename(__FILE__).__LINE__);
		$sql= "DELETE FROM auto_login WHERE username = :username";
    dbg(dbg_type, $sql, basename(__FILE__).__LINE__);
    $stmt = $this->con->prepare($sql);
    $stmt->bindvalue(':username', $username);
    $stmt->execute();
		$autologin_token = $this->gen_token();
    dbg(dbg_type, $autologin_token, basename(__FILE__).__LINE__);
    $arr = array(
      'username' => $username,
      'token' => $autologin_token
    );
    dbg(dbg_type, $arr, basename(__FILE__).__LINE__);
    $this->insert_autologin($arr);
    setcookie ("autologin_token", $autologin_token, time() + autologin_time);

	}

  /*

  自動ログイン

  */
	public function autologin() {

    dbg(dbg_type, $_COOKIE["autologin_token"], basename(__FILE__).__LINE__);
		if (!$_COOKIE["autologin_token"]) {
			echo "<script type='text/javascript'>alert('自動ログインに失敗しました。');</script>";
			return;
		}
		$sql= "SELECT * FROM auto_login WHERE token = :token";
    dbg(dbg_type, $sql, basename(__FILE__).__LINE__);
    $stmt = $this->con->prepare($sql);
    $stmt->bindvalue (':token', $_COOKIE['autologin_token']);
    $stmt->execute();

		$row = $stmt->fetch ( PDO::FETCH_ASSOC );
    dbg(dbg_type, $row, basename(__FILE__).__LINE__);

    if (count($row) != 1) {
			echo "<script type='text/javascript'>alert('自動ログインに失敗しました。');</script>";
			return;
		}

		// echo '古いセッションID: '.session_id()."\n".basename(__FILE__).__LINE__."\n";
		session_regenerate_id(true);
		// echo '新しいセッションID: '.session_id()."\n".basename(__FILE__).__LINE__."\n";

		$_SESSION['user'] = $row[0]['username'];
		$_SESSION['pass'] = $row[0]['password'];
		$_SESSION['UID'] = $row[0]['id'];

    $token_name = 'autologin_token';
    $tbl = 'auto_login';
    $this->del_token($token_name, $tbl);
		$autologin_token = $this->gen_token();
    dbg(dbg_type, $autologin_token, basename(__FILE__).__LINE__);

    $arr = array(
      'username' => $_SESSION['user'],
      'token' => $autologin_token,
      'password' => $_SESSION['pass']
    );
    dbg(dbg_type, $arr, basename(__FILE__).__LINE__);
    $this->insert_autologin($arr);
    setcookie ( 'autologin_token', $autologin_token, time() + autologin_time );

    $this->csrf_set();
    dbg(dbg_type, __METHOD__.ok, basename(__FILE__).__LINE__, ex);
		header( 'Location: index.php' );

	}


  /*

  メール作成

  */
	public function create_mail($mailaddress, $content, $subject, $html_mail = false) {

      dbg(dbg_type, $mailaddress, basename(__FILE__).__LINE__);

  		$current = time();
      dbg(dbg_type, $current, basename(__FILE__).__LINE__);
  		$time = date( 'Y年m月d日 H時i分', $current );
      dbg(dbg_type, $time, basename(__FILE__).__LINE__);

      $header = "from: ".from;
      dbg(dbg_type, $header, basename(__FILE__).__LINE__);
      if ($html_mail) $header .= "\r\n"."Content-Type: text/html;charset=ISO-2022-JP\nX-Mailer: PHP/".phpversion();
      dbg(dbg_type, $header, basename(__FILE__).__LINE__);
      $mailto = $mailaddress;
      dbg(dbg_type, $mailto, basename(__FILE__).__LINE__);
      dbg(dbg_type, $subject, basename(__FILE__).__LINE__);
      dbg(dbg_type, $content, basename(__FILE__).__LINE__);
			if (mb_send_mail($mailto, $subject, $content, $header)) return bs_alert('入力したメールアドレス宛にメールを送信しました。', true);
      else return bs_alert('メールの送信に失敗しました。', false);
  }


  /*

  パスワードリセットトークンの保存

  */
  public function insert_reset($arr) {

    dbg(dbg_type, $arr, basename(__FILE__).__LINE__);
    $sql = "INSERT INTO password_resets";
    $sql.= " VALUES(";
    $sql.= " :email,";
    $sql.= " :token";
    $sql.= ")";
    dbg(dbg_type, $sql, basename(__FILE__).__LINE__);
    $stmt = $this->con->prepare($sql);
    $stmt->bindvalue ( ':email', $arr['mailaddress'] );
    $stmt->bindvalue ( ':token', $arr['token'] );
    try {
      $stmt->execute();
    } catch (PDOException $e) {
      dbg(dbg_type, __METHOD__.ng, basename(__FILE__).__LINE__);
      $error = $e->getMessage();
      return bs_alert('メールの送信に失敗しました。', false, $error);
    }
    dbg(dbg_type, __METHOD__.ok, basename(__FILE__).__LINE__);
    return 1;
  }

  /*

  パスワードリセットメール送信

  */
	public function reset_mail($mailaddress) {

    dbg(dbg_type, $mailaddress, basename(__FILE__).__LINE__);
		$sql= "DELETE FROM password_resets WHERE email = :email";
    dbg(dbg_type, $sql, basename(__FILE__).__LINE__);
    $stmt = $this->con->prepare($sql);
    $stmt->bindvalue(':email', $mailaddress);
    $stmt->execute();
		$reset_token = $this->gen_token();
    dbg(dbg_type, $reset_token, basename(__FILE__).__LINE__);

    $arr = array(
      'mailaddress' => $mailaddress,
      'token' => $reset_token
    );
    dbg(dbg_type, $arr, basename(__FILE__).__LINE__);
    $res = $this->insert_reset($arr);
    dbg(dbg_type, $res, basename(__FILE__).__LINE__);
    if (is_string($res)) return $res;

		setcookie ('reset_token', $reset_token, time() + reset_time);

		$content = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
		<html lang="ja">
		<head>
		<meta name="viewport" content="target-densitydpi=device-dpi,width=device-width,maximum-scale=1.0,user-scalable=yes">
		<meta http-equiv="Content-Language" content="ja">
		<meta charset="shift_jis">
		<title>タイトル</title>
			<style>
			h1 {
				margin-top: 35px;
				text-align: center;
				font-size: 16px;
				color: #212529;
			}
			p {
				text-align: center;
			}
			#button {
				width: 200px;
				border-radius :0.3rem;
				margin: 35px auto;
			}
			#button a {
				padding: 10px 20px;
				display: block;
				border: 1px solid #28a745;
				background-color: #28a745;
				color: #fff;
				text-decoration: none;
				box-shadow: 2px 2px 3px #f5deb3;
				border-radius :0.3rem;
			}
			#button a:hover {
				background-color: #218838;
				color: #1e7e34;
			}
			</style>
	  </head>
		<body>
		<h1>
		パスワードリセット
		</h1>
		<p>
		以下のボタンを押下し、パスワードリセットの手続きを行ってください。
		</p>
		<p id="button">
		<a href="'.url.'reset.php?mailaddress='.$mailaddress.'">パスワードの変更</a>
		</p>
		</body>
		</html>';
    dbg(dbg_type, $content, basename(__FILE__).__LINE__);

    $subject = 'パスワードの再設定';
    return $this->create_mail($mailaddress, $content, $subject, true);

	}


  /*

  パスワードの書き換え

  */
	public function password_resets($mailaddress, $password) {

    dbg(dbg_type, $mailaddress, basename(__FILE__).__LINE__);
    dbg(dbg_type, $password, basename(__FILE__).__LINE__);
    dbg(dbg_type, $_COOKIE['reset_token'], basename(__FILE__).__LINE__);
		if (!$_COOKIE['reset_token']) return bs_alert('メールの有効期限が切れています。<br>最初からやり直して下さい。', false);

		$sql = "SELECT * FROM password_resets";
		$sql.= " LEFT JOIN users";
		$sql.= " ON password_resets.email = users.mailaddress";
		$sql.= " WHERE users.mailaddress = :mailaddress";
    dbg(dbg_type, $sql, basename(__FILE__).__LINE__);
    $stmt = $this->con->prepare($sql);
    $stmt->bindvalue ( ':mailaddress', $mailaddress );
    try {
      $stmt->execute();
    } catch (PDOException $e) {
      dbg(dbg_type, __METHOD__.ng, basename(__FILE__).__LINE__);
      $error = $e->getMessage();
      return bs_alert('登録に失敗しました。', false, $error);
    }

		$row = $stmt->fetch ( PDO::FETCH_ASSOC );
    dbg(dbg_type, $row, basename(__FILE__).__LINE__);
		if (!$row) return bs_alert('ユーザーが存在しません。', false);
		if ($row['username'] != 'guest' && $row['password'] != 'guest2020') {

			$password = password_hash($password, PASSWORD_BCRYPT);
      dbg(dbg_type, $password, basename(__FILE__).__LINE__);
			$sql= "UPDATE users SET password = :password WHERE ID = :ID";
      dbg(dbg_type, $sql, basename(__FILE__).__LINE__);
      $stmt = $this->con->prepare($sql);
      $stmt->bindvalue (':password', $password);
      $stmt->bindvalue (':ID', $row['ID']);
      try {
        $stmt->execute();
      } catch (PDOException $e) {
        dbg(dbg_type, __METHOD__.ng, basename(__FILE__).__LINE__);
        $error = $e->getMessage();
        return bs_alert('登録に失敗しました。', false, $error);
      }
			$token_name = 'reset_token';
			$tbl = 'password_resets';

      dbg(dbg_type, $_COOKIE[$token_name], basename(__FILE__).__LINE__);
			if (isset( $_COOKIE[$token_name] )) $this->del_token($token_name, $tbl, true);

      dbg(dbg_type, __METHOD__.ok, basename(__FILE__).__LINE__);
      return 1;

		} else {
      dbg(dbg_type, 'テスト用ユーザー情報は変更できません。', basename(__FILE__).__LINE__);
			return bs_alert('テスト用ユーザー情報は変更できません。', false);
		}

	}





}

?>
