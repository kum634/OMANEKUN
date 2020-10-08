<?php
require("conf.php");
class User_auth {

	private $pdo;
	private $query;
	private $stmt;
	private $error;
	private $row;
	private $mailaddress;
	private $username;
	private $password1;
	private $password2;
	private $password;
	private $autologin;
	private $token;
	private $new_token;
	private $current;
	private $time;
	private $content;
	private $header;
	private $mailto;
	private $subject;

	function __construct() {

		$this->pdo = $pdo;
		$this->query = $query;
		$this->stmt = $stmt;
		$this->error = $error;
		$this->row = $row;
		$this->mailaddress = $mailaddress;
		$this->username = $username;
		$this->password1 = $password1;
		$this->password2 = $password2;
		$this->password = $password;
		$this->autologin = $autologin;
		$this->token = $token;
		$this->new_token = $new_token;
		$this->current = $current;
		$this->time = $time;
		$this->content = $content;
		$this->header = $header;
		$this->mailto = $mailto;
		$this->subject = $subject;

		require('db_connection.php');

	}

	function posted_signup_data() {

		if (!empty($_POST["mailaddress"]) && !empty($_POST["password1"]) && !empty($_POST["password2"]) && !empty($_POST["username"])) {
			$this->mailaddress = htmlspecialchars( $_POST["mailaddress"], ENT_QUOTES );
			$this->username = htmlspecialchars( $_POST["username"], ENT_QUOTES );
			$this->password1 = htmlspecialchars( $_POST["password1"], ENT_QUOTES );
			$this->password2 = htmlspecialchars( $_POST["password2"], ENT_QUOTES );
			return true;
		} else {
			return false;
		}

	}

	function posted_login_data() {

		if (!empty($_POST["username"]) && !empty($_POST["password"])) {
			$this->username = htmlspecialchars( $_POST["username"], ENT_QUOTES );
			$this->password = htmlspecialchars( $_POST["password"], ENT_QUOTES );
			return true;
		} else {
			return false;
		}

	}

	function posted_email_data() {

		if (!empty($_POST["mailaddress"])) {
			$this->mailaddress = htmlspecialchars( $_POST["mailaddress"], ENT_QUOTES );
			return true;
		} else {
			return false;
		}

	}

	function posted_reset_data() {

		if (!empty($_POST["mailaddress"]) && !empty($_POST["password1"]) && !empty($_POST["password2"])) {
			$this->mailaddress = htmlspecialchars( $_POST["mailaddress"], ENT_QUOTES );
			$this->password1 = htmlspecialchars($_POST["password1"], ENT_QUOTES );
			$this->password2 = htmlspecialchars($_POST["password2"], ENT_QUOTES );
			return true;
		} else {
			return false;
		}

	}

	function mailaddress_check() {

		if (preg_match( "/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)+$/", $this->mailaddress)) {
			return true;
		} else {
			return false;
		}

	}

	function password_check() {

		if ($this->password1 == $this->password2) {
			return true;
		} else {
			return false;
		}

	}

	function existence_check() {

		$this->query = " SELECT COUNT(*) FROM omanekun_users WHERE mailaddress = '{$this->mailaddress}' OR username = '{$this->username}' ";
		$this->stmt = $this->pdo->query ( $this->query );

		if ( $this->stmt == false ) {
			$this->error = $this->pdo->errorInfo ( );
			echo "<div class=\"alert alert-warning\">エラーが発生しました。<br />{$this->error[2]}</div>";
			exit();
		}
		return $this->stmt->fetchColumn();

	}

	function register() {

		$this->query = "INSERT INTO omanekun_users VALUES(null, '{$this->mailaddress}', '{$this->username}',  '{$this->password2}')";
		$this->stmt = $this->pdo->query( $this->query );
		return $this->stmt;

	}

	function login_auth() {

		$this->query = " SELECT COUNT(*) FROM omanekun_users WHERE username = '{$this->username}' AND password = '{$this->password}' ";
		$this->stmt = $this->pdo->query ( $this->query );

		if ( $this->stmt == false ) {
			$this->error = $this->pdo->errorInfo ( );
			echo "<div class=\"alert alert-warning\">エラーが発生しました。<br />{$this->error[2]}</div>";
			exit();
		}
		return $this->stmt->fetchColumn();

	}

	function login() {

		$_SESSION["login"] = $this->username;
		$_SESSION["pass"] = $this->password;
		header( "Location: index.php" );

	}

	function autologin_start() {

		$this->autologin = $_POST["autologin"];
		$this->query = "DELETE FROM auto_login WHERE username = '{$this->username}'";
		$this->pdo->query ( $this->query );
		$this->token = $this->username . time( );
		$this->query = "INSERT INTO auto_login VALUES('{$this->username}', '{$this->token}', '{$this->password}')";
		$this->stmt = $this->pdo->query ( $this->query );
		if ( $this->stmt != false ) {
			setcookie ( "token", $this->token, time() + 7 * 60 * 60 * 24 );
		}

	}

	function autologin() {

		$this->query = "SELECT * FROM auto_login WHERE token = '{$_COOKIE["token"]}'";
		$this->stmt = $this->pdo->query ( $this->query );
		if ($this->stmt != false ) {
			$this->row = $this->stmt->fetch ( PDO::FETCH_ASSOC );
			$_SESSION["login"] = $this->row["username"];
			$_SESSION["pass"] = $this->row["password"];

			$this->query = "DELETE FROM auto_login WHERE token = '{$_COOKIE["token"]}'";
			$this->pdo->query ( $this->query );
			$this->new_token = $_SESSION["login"] . time ( );
			$this->query = "INSERT INTO auto_login VALUES('{$_SESSION["login"]}', '{$this->new_token}', '{$_SESSION["pass"]}')";
			$this->stmt = $this->pdo->query ( $this->query );
			if ( $this->stmt != false ) {
				setcookie ( "token", $this->new_token, time() + 7 * 60 * 60 * 24 );
			}
			header( "Location: index.php" );
		}

	}

	function mailaddress_existence_check() {

		$this->query = " SELECT COUNT(*) FROM omanekun_users WHERE mailaddress = '{$this->mailaddress}' ";
		$this->stmt = $this->pdo->query ( $this->query );
		if ( $this->stmt == false ) {
			$this->error = $this->pdo->errorInfo ( );
			echo "<div class=\"alert alert-warning\">エラーが発生しました。<br />{$this->error[2]}</div>";
			exit();
		}
		return $this->stmt->fetchColumn();

	}

	function reset_mail() {

		$this->current = time();
		date_default_timezone_set( "Asia/Tokyo" );
		$this->time = date( "Y年m月d日 H時i分", $this->current );
		$this->content = "<!DOCTYPE html>
		<html lang=\"ja\">
		<style>
		body {
			text-align: center;
		}
		h1 {
			font-size: 16px;
			color: #212529;
			margin-top: 35px;
		}
		#button {
			width: 200px;
			text-align: center;
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
		<body>
		<h1>
		パスワードリセット
		</h1>
		<p>
		以下のボタンを押下し、パスワードリセットの手続きを行ってください。
		</p>
		<p id=\"button\">
		<a href=\"reset.php\">パスワードの変更</a>
		</p>
		</body>
		</html>";

		$this->header = "from: umetarochan823341@outlook.jp";
		$this->header .= "\r\n";
		$this->header .= "Content-type: text/html; charset=UTF-8";
		$this->mailto =$this->mailaddress;
		$this->subject = "パスワードの再設定";
		return mb_send_mail ( $this->mailto , $this->subject , $this->content , $this->header);

	}


	function password_reset() {

		$this->query = " SELECT * FROM omanekun_users WHERE mailaddress = '{$this->mailaddress}' ";
		$this->stmt = $this->pdo->query ( $this->query );
		if ( $this->stmt == false ) {
			$this->error = $this->pdo->errorInfo ( );
			echo "<div class=\"alert alert-warning\">エラーが発生しました。<br />{$this->error[2]}</div>";
			exit();
		}
		$this->row = $this->stmt->fetch ( PDO::FETCH_ASSOC );
		if($this->row["username"] != "guest" && $this->row["password"] != "guest2020"){
			$this->query = "UPDATE omanekun_users SET password = '{$this->password2}' WHERE id = '{$this->row['ID']}'";
			$this->stmt = $this->pdo->query ( $this->query );
			if ( $this->stmt == false ) {
				$this->error = $this->pdo->errorInfo ( );
				return array("message" => "登録に失敗しました。", "error" => $this->error[ 2 ]);
				exit();
			}
			return true;
		} else {
			return "テスト用ユーザー情報は変更できません。";
		}

	}

	function withdrawal($ID) {

		$this->query = "DELETE FROM omanekun_users WHERE ID ='{$ID}' ";
		$this->stmt_withdrawal1 = $this->pdo->query ( $this->query );
		$this->query = "DELETE FROM maintenance_request_table WHERE identify_ID = '{$ID}'";
		$this->stmt_withdrawal2 = $this->pdo->query ( $this->query );
		return array("stmt_withdrawal1" => $stmt_withdrawal1, "stmt_withdrawal2" => $this->stmt_withdrawal2);

	}

	function delete_cookie() {

		$this->query = "DELETE FROM auto_login WHERE token = '{$_COOKIE["token"]}'";
		$this->pdo->query ( $this->query );
		setcookie ( "token", "" );

	}


	function identify_ID() {

		$this->query = " SELECT * FROM omanekun_users WHERE username = '{$_SESSION["login"]}' AND password = '{$_SESSION["pass"]}' ";
		$this->stmt = $this->pdo->query ( $this->query );
		if ( $this->stmt == false ) {
			$this->error2 = $this->pdo->errorInfo();
			echo "<div class=\"alert alert-warning\">エラー<br />{$this->error2[2]}</div>";
			exit();
		}
		$this->row = $this->stmt->fetch ( PDO::FETCH_ASSOC );
		return $this->row["ID"];
	}

}
?>
