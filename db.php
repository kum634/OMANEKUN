<?php
require("conf.php");
class Maintenance_request {

	private $pdo;
	private $query;
	private $stmt;
	private $error;
	private $row;
	private $nyuko_bi_y;
	private $nyuko_bi_m;
	private $nyuko_bi_d;
	private $nyuko_bi;
	private $nousya_yoteibi_y;
	private $nousya_yoteibi_m;
	private $nousya_yoteibi_d;
	private $nousya_yoteibi;
	private $sei;
	private $mei;
	private $tel;
	private $mail;
	private $car_name;
	private $katasiki;
	private $tourokubangou;
	private $syakenmanryou_bi_y;
	private $syakenmanryou_bi_m;
	private $syakenmanryou_bi_d;
	private $syakenmanryou_bi;
	private $seibi_syurui;
	private $seibi_naiyou;
	private $sensya;
	private $syanaiseisou;
	private $tokki_zikou;
	private $tokki_zikou_syousai;
	private $stmt_withdrawal1;
	private $stmt_withdrawal2;
	private $weekNo;
	private $daysLeft;
	private $startDate;
	private $endDate;

	function __construct() {

		$this->pdo = $pdo;
		$this->query = $query;
		$this->stmt = $stmt;
		$this->error = $error;
		$this->row = $row;
		$this->nyuko_bi_y = $nyuko_bi_y;
		$this->nyuko_bi_m = $nyuko_bi_m;
		$this->nyuko_bi_d = $nyuko_bi_d;
		$this->nyuko_bi = $nyuko_bi;
		$this->nousya_yoteibi_y = $nousya_yoteibi_y;
		$this->nousya_yoteibi_m = $nousya_yoteibi_m;
		$this->nousya_yoteibi_d = $nousya_yoteibi_d;
		$this->nousya_yoteibi = $nousya_yoteibi;
		$this->sei = $sei;
		$this->mei = $mei;
		$this->tel = $tel;
		$this->mail = $mail;
		$this->car_name = $car_name;
		$this->katasiki = $katasiki;
		$this->tourokubangou = $tourokubangou;
		$this->syakenmanryou_bi_y = $syakenmanryou_bi_y;
		$this->syakenmanryou_bi_m = $syakenmanryou_bi_m;
		$this->syakenmanryou_bi_d = $syakenmanryou_bi_d;
		$this->syakenmanryou_bi = $syakenmanryou_bi;
		$this->seibi_syurui = $seibi_syurui;
		$this->seibi_naiyou = $seibi_naiyou;
		$this->sensya = $sensya;
		$this->syanaiseisou = $syanaiseisou;
		$this->tokki_zikou = $tokki_zikou;
		$this->tokki_zikou_syousai = $tokki_zikou_syousai;
		$this->stmt_withdrawal1 = $stmt_withdrawal1;
		$this->stmt_withdrawal2 = $stmt_withdrawal2;
		$this->weekNo = $weekNo;
		$this->daysLeft = $daysLeft;
		$this->startDate = $startDate;
		$this->endDate = $endDate;

		require("db_connection.php");
	}

	function posted_seach_data() {

		$this->nyuko_bi_y = htmlspecialchars( $_POST[ "nyuko_bi_y" ], ENT_QUOTES );
		$this->nyuko_bi_m = htmlspecialchars( $_POST[ "nyuko_bi_m" ], ENT_QUOTES );
		$this->nyuko_bi_d = htmlspecialchars( $_POST[ "nyuko_bi_d" ], ENT_QUOTES );
		$this->nousya_yoteibi_y = htmlspecialchars( $_POST[ "nousya_yoteibi_y" ], ENT_QUOTES );
		$this->nousya_yoteibi_m = htmlspecialchars( $_POST[ "nousya_yoteibi_m" ], ENT_QUOTES );
		$this->nousya_yoteibi_d = htmlspecialchars( $_POST[ "nousya_yoteibi_d" ], ENT_QUOTES );
		$this->sei = htmlspecialchars($_POST["sei"], ENT_QUOTES );
		$this->mei = htmlspecialchars($_POST["mei"], ENT_QUOTES );
		$this->tel = htmlspecialchars($_POST["tel"], ENT_QUOTES );
		$this->mail = htmlspecialchars($_POST["mail"], ENT_QUOTES );
		$this->car_name = htmlspecialchars($_POST["car_name"], ENT_QUOTES );
		$this->katasiki = htmlspecialchars($_POST["katasiki"], ENT_QUOTES );
		$this->tourokubangou = htmlspecialchars($_POST["tourokubangou"], ENT_QUOTES );
		$this->syakenmanryou_bi_y = htmlspecialchars( $_POST[ "syakenmanryou_bi_y" ], ENT_QUOTES );
		$this->syakenmanryou_bi_m = htmlspecialchars( $_POST[ "syakenmanryou_bi_m" ], ENT_QUOTES );
		$this->syakenmanryou_bi_d = htmlspecialchars( $_POST[ "syakenmanryou_bi_d" ], ENT_QUOTES );
		$this->seibi_syurui = $_POST["seibi_syurui"];
		$this->seibi_naiyou = htmlspecialchars($_POST["seibi_naiyou"], ENT_QUOTES );
		$this->sensya = htmlspecialchars($_POST["sensya"], ENT_QUOTES );
		$this->syanaiseisou = htmlspecialchars($_POST["syanaiseisou"], ENT_QUOTES );
		$this->tokki_zikou = $_POST["tokki_zikou"];
		$this->tokki_zikou_syousai = htmlspecialchars($_POST["tokki_zikou_syousai"], ENT_QUOTES );
	}

	function posted_input_data() {

		$this->nyuko_bi_y = htmlspecialchars( $_POST[ "nyuko_bi_y" ], ENT_QUOTES );
		$this->nyuko_bi_m = htmlspecialchars( $_POST[ "nyuko_bi_m" ], ENT_QUOTES );
		$this->nyuko_bi_d = htmlspecialchars( $_POST[ "nyuko_bi_d" ], ENT_QUOTES );
		$this->nyuko_bi = $this->nyuko_bi_y."-".$this->nyuko_bi_m."-".$this->nyuko_bi_d;
		$this->nousya_yoteibi_y = htmlspecialchars( $_POST[ "nousya_yoteibi_y" ], ENT_QUOTES );
		$this->nousya_yoteibi_m = htmlspecialchars( $_POST[ "nousya_yoteibi_m" ], ENT_QUOTES );
		$this->nousya_yoteibi_d = htmlspecialchars( $_POST[ "nousya_yoteibi_d" ], ENT_QUOTES );
		$this->nousya_yoteibi = $this->nousya_yoteibi_y."-".$this->nousya_yoteibi_m."-".$this->nousya_yoteibi_d;
		$this->sei = htmlspecialchars( $_POST[ "sei" ], ENT_QUOTES );
		$this->mei = htmlspecialchars( $_POST[ "mei" ], ENT_QUOTES );
		$this->tel = htmlspecialchars( $_POST[ "tel" ], ENT_QUOTES );
		$this->mail = htmlspecialchars( $_POST[ "mail" ], ENT_QUOTES );
		$this->car_name = htmlspecialchars( $_POST[ "car_name" ], ENT_QUOTES );
		$this->katasiki = htmlspecialchars( $_POST[ "katasiki" ], ENT_QUOTES );
		$this->tourokubangou = htmlspecialchars( $_POST[ "tourokubangou" ], ENT_QUOTES );
		$this->syakenmanryou_bi_y = htmlspecialchars( $_POST[ "syakenmanryou_bi_y" ], ENT_QUOTES );
		$this->syakenmanryou_bi_m = htmlspecialchars( $_POST[ "syakenmanryou_bi_m" ], ENT_QUOTES );
		$this->syakenmanryou_bi_d = htmlspecialchars( $_POST[ "syakenmanryou_bi_d" ], ENT_QUOTES );
		$this->syakenmanryou_bi = $this->syakenmanryou_bi_y."-".$this->syakenmanryou_bi_m."-".$this->syakenmanryou_bi_d;
		$this->seibi_syurui = $_POST[ "seibi_syurui" ];
		$this->seibi_syurui = implode( '、', $this->seibi_syurui );
		$this->seibi_syurui = htmlspecialchars( $this->seibi_syurui, ENT_QUOTES );
		$this->seibi_naiyou = htmlspecialchars( $_POST[ "seibi_naiyou" ], ENT_QUOTES );
		$this->sensya = htmlspecialchars( $_POST[ "sensya" ], ENT_QUOTES );
		$this->syanaiseisou = htmlspecialchars( $_POST[ "syanaiseisou" ], ENT_QUOTES );
		$this->tokki_zikou = $_POST[ "tokki_zikou" ];
		$this->tokki_zikou = implode( '、', $this->tokki_zikou );
		$this->tokki_zikou = htmlspecialchars( $this->tokki_zikou, ENT_QUOTES );
		$this->tokki_zikou_syousai = htmlspecialchars( $_POST[ "tokki_zikou_syousai" ], ENT_QUOTES );

	}

	function identify_ID() {

		$this->query = " SELECT * FROM omanekun_users WHERE username = '{$_SESSION["login"]}' AND password = '{$_SESSION["pass"]}' ";
		$this->stmt = $this->pdo->query ( $this->query );
		if ( $this->stmt == false ) {
			$this->error2 = $this->pdo->errorInfo();
			echo "<div class=\"alert alert-warning\">エラーが発生しました。<br />{$this->error2[2]}</div>";
			exit();
		}
		$this->row = $this->stmt->fetch ( PDO::FETCH_ASSOC );
		return $this->row["ID"];

	}

	function weekly() {

		date_default_timezone_set('Asia/Tokyo');
		$this->weekNo = date('w', strtotime('today'));
		$this->startDate = date('m/d', strtotime("-{$this->weekNo} day", strtotime('today')));
		$this->daysLeft = 6 - $this->weekNo;
		$this->endDate = date('m/d', strtotime("+{$this->daysLeft} day", strtotime('today')));
		return array("startDate" => $this->startDate, "endDate" => $this->endDate);

	}

	function weekly_match($instruction, $ID) {

		$this->query = "SELECT ".$instruction." FROM maintenance_request_table WHERE yearweek(`nyuko_bi`) = yearweek(curdate()) OR yearweek(`nousya_yoteibi`) = yearweek(curdate()) AND identify_ID = '{$ID}'";

	}

	function seach($instruction, $ID) {

		$this->query = "SELECT ".$instruction." FROM maintenance_request_table WHERE identify_ID = '{$ID}'";
		if ( !empty($this->nyuko_bi_y) && !empty($this->nyuko_bi_m) && !empty($this->nyuko_bi_d) ) {
			$this->nyuko_bi = $this->nyuko_bi_y."-".$this->nyuko_bi_m."-".$this->nyuko_bi_d;
			$this->query .= " AND nyuko_bi = '{$this->nyuko_bi}' ";
		}elseif( !empty($this->nyuko_bi_y) && !empty($this->nyuko_bi_m) && empty($this->nyuko_bi_d) ) {
			$this->nyuko_bi = $this->nyuko_bi_y."-".$this->nyuko_bi_m."-";
			$this->query .= " AND nyuko_bi like '{$this->nyuko_bi}%' ";
		}elseif( !empty($this->nyuko_bi_y) && empty($this->nyuko_bi_m) && empty($this->nyuko_bi_d) ) {
			$this->nyuko_bi = $this->nyuko_bi_y."-";
			$this->query .= " AND nyuko_bi like '{$this->nyuko_bi}%' ";
		}elseif( empty($this->nyuko_bi_y) && !empty($this->nyuko_bi_m) && !empty($this->nyuko_bi_d) ) {
			$this->nyuko_bi = "-".$this->nyuko_bi_m."-".$this->nyuko_bi_d;
			$this->query .= " AND nyuko_bi like '%{$this->nyuko_bi}' ";
		}elseif( empty($this->nyuko_bi_y) && empty($this->nyuko_bi_m) && !empty($this->nyuko_bi_d) ) {
			$this->nyuko_bi = "-".$this->nyuko_bi_d;
			$this->query .= " AND nyuko_bi like '%{$this->nyuko_bi}' ";
		}elseif( !empty($this->nyuko_bi_y) && empty($this->nyuko_bi_m) && !empty($this->nyuko_bi_d) ) {
			$this->nyuko_bi_l = $this->nyuko_bi_y."-";
			$this->query .= " AND nyuko_bi like '{$this->nyuko_bi_l}%' ";
			$this->nyuko_bi_r = "-".$this->nyuko_bi_d;
			$this->query .= " AND nyuko_bi like '%{$this->nyuko_bi_r}' ";
		}elseif( empty($this->nyuko_bi_y) && !empty($this->nyuko_bi_m) && empty($this->nyuko_bi_d) ) {
			$this->nyuko_bi = "-".$this->nyuko_bi_m."-";
			$this->query .= " AND nyuko_bi like '%{$this->nyuko_bi}%' ";
		}
		if ( !empty($this->nousya_yoteibi_y) && !empty($this->nousya_yoteibi_m) && !empty($this->nousya_yoteibi_d) ) {
			$this->nousya_yoteibi = $this->nousya_yoteibi_y."-".$this->nousya_yoteibi_m."-".$this->nousya_yoteibi_d;
			$this->query .= " AND nousya_yoteibi = '{$this->nousya_yoteibi}' ";
		}elseif( !empty($this->nousya_yoteibi_y) && !empty($this->nousya_yoteibi_m) && empty($this->nousya_yoteibi_d) ) {
			$this->nousya_yoteibi = $this->nousya_yoteibi_y."-".$this->nousya_yoteibi_m."-";
			$this->query .= " AND nousya_yoteibi like '{$this->nousya_yoteibi}%' ";
		}elseif( !empty($this->nousya_yoteibi_y) && empty($this->nousya_yoteibi_m) && empty($this->nousya_yoteibi_d) ) {
			$this->nousya_yoteibi = $this->nousya_yoteibi_y."-";
			$this->query .= " AND nousya_yoteibi like '{$this->nousya_yoteibi}%' ";
		}elseif( empty($this->nousya_yoteibi_y) && !empty($this->nousya_yoteibi_m) && !empty($this->nousya_yoteibi_d) ) {
			$this->nousya_yoteibi = "-".$this->nousya_yoteibi_m."-".$this->nousya_yoteibi_d;
			$this->query .= " AND nousya_yoteibi like '%{$this->nousya_yoteibi}' ";
		}elseif( empty($this->nousya_yoteibi_y) && empty($this->nousya_yoteibi_m) && !empty($this->nousya_yoteibi_d) ) {
			$this->nousya_yoteibi = "-".$this->nousya_yoteibi_d;
			$this->query .= " AND nousya_yoteibi like '%{$this->nousya_yoteibi}' ";
		}elseif( !empty($this->nousya_yoteibi_y) && empty($this->nousya_yoteibi_m) && !empty($this->nousya_yoteibi_d) ) {
			$this->nousya_yoteibi_l = $this->nousya_yoteibi_y."-";
			$this->query .= " AND nousya_yoteibi like '{$this->nousya_yoteibi_l}%' ";
			$this->nousya_yoteibi_r = "-".$this->nousya_yoteibi_d;
			$this->query .= " AND nousya_yoteibi like '%{$this->nousya_yoteibi_r}' ";
		}elseif( empty($this->nousya_yoteibi_y) && !empty($this->nousya_yoteibi_m) && empty($this->nousya_yoteibi_d) ) {
			$this->nousya_yoteibi = "-".$this->nousya_yoteibi_m."-";
			$this->query .= " AND nousya_yoteibi like '%{$this->nousya_yoteibi}%' ";
		}
		if ( $this->sei != "" ) {
			$this->query .= " AND sei = '{$this->sei}' ";
		}
		if ( $this->mei != "" ) {
			$this->query .= " AND mei = '{$this->mei}' ";
		}
		if ( $this->tel != "" ) {
			$this->query .= " AND tel = '{$this->tel}' ";
		}
		if ( $this->mail != "" ) {
			$this->query .= " AND mail = '{$this->mail}' ";
		}
		if ( $this->car_name != "" ) {
			$this->query .= " AND car_name = '{$this->car_name}' ";
		}
		if ( $this->katasiki != "" ) {
			$this->query .= " AND katasiki = '{$this->katasiki}' ";
		}
		if ( $this->tourokubangou != "" ) {
			$this->query .= " AND tourokubangou = '{$this->tourokubangou}' ";
		}
		if ( !empty($this->syakenmanryou_bi_y) && !empty($this->syakenmanryou_bi_m) && !empty($this->syakenmanryou_bi_d) ) {
			$this->syakenmanryou_bi = $this->syakenmanryou_bi_y."-".$this->syakenmanryou_bi_m."-".$this->syakenmanryou_bi_d;
			$this->query .= " AND syakenmanryou_bi = '{$this->syakenmanryou_bi}' ";
		}elseif( !empty($this->syakenmanryou_bi_y) && !empty($this->syakenmanryou_bi_m) && empty($this->syakenmanryou_bi_d) ) {
			$this->syakenmanryou_bi = $this->syakenmanryou_bi_y."-".$this->syakenmanryou_bi_m."-";
			$this->query .= " AND syakenmanryou_bi like '{$this->syakenmanryou_bi}%' ";
		}elseif( !empty($this->syakenmanryou_bi_y) && empty($this->syakenmanryou_bi_m) && empty($this->syakenmanryou_bi_d) ) {
			$this->syakenmanryou_bi = $this->syakenmanryou_bi_y."-";
			$this->query .= " AND syakenmanryou_bi like '{$this->syakenmanryou_bi}%' ";
		}elseif( empty($this->syakenmanryou_bi_y) && !empty($this->syakenmanryou_bi_m) && !empty($this->syakenmanryou_bi_d) ) {
			$this->syakenmanryou_bi = "-".$this->syakenmanryou_bi_m."-".$this->syakenmanryou_bi_d;
			$this->query .= " AND syakenmanryou_bi like '%{$this->syakenmanryou_bi}' ";
		}elseif( empty($this->syakenmanryou_bi_y) && empty($this->syakenmanryou_bi_m) && !empty($this->syakenmanryou_bi_d) ) {
			$this->syakenmanryou_bi = "-".$this->syakenmanryou_bi_d;
			$this->query .= " AND syakenmanryou_bi like '%{$this->syakenmanryou_bi}' ";
		}elseif( !empty($this->syakenmanryou_bi_y) && empty($this->syakenmanryou_bi_m) && !empty($this->syakenmanryou_bi_d) ) {
			$this->syakenmanryou_bi_l = $this->syakenmanryou_bi_y."-";
			$this->query .= " AND syakenmanryou_bi like '{$this->syakenmanryou_bi_l}%' ";
			$this->syakenmanryou_bi_r = "-".$this->syakenmanryou_bi_d;
			$this->query .= " AND syakenmanryou_bi like '%{$this->syakenmanryou_bi_r}' ";
		}elseif( empty($this->syakenmanryou_bi_y) && !empty($this->syakenmanryou_bi_m) && empty($this->syakenmanryou_bi_d) ) {
			$this->syakenmanryou_bi = "-".$this->syakenmanryou_bi_m."-";
			$this->query .= " AND syakenmanryou_bi like '%{$this->syakenmanryou_bi}%' ";
		}
		if (!empty($this->seibi_syurui)) {
			foreach($this->seibi_syurui as $this->value){
				$this->query .= " AND seibi_syurui like '%{$this->value}%' ";}
			}
			if ( $this->seibi_naiyou != "" ) {
				$this->query .= " AND seibi_naiyou like '%{$this->seibi_naiyou}%' ";
			}
			if ( $this->sensya != "" ) {
				$this->query .= " AND sensya = '{$this->sensya}' ";
			}
			if ( $this->syanaiseisou != "" ) {
				$this->query .= " AND syanaiseisou = '{$this->syanaiseisou}' ";
			}
			if ( !empty($this->tokki_zikou)) {
				foreach($this->tokki_zikou as $this->value){
					$this->query .= " AND tokki_zikou like '%{$this->value}%' ";
				}
			}
			if ( $this->tokki_zikou_syousai != "" ) {
				$this->query .= " AND tokki_zikou_syousai like '%{$this->tokki_zikou_syousai}%' ";
			}

		}

		function res_count() {

			$this->stmt = $this->pdo->query( $this->query );
			if ( $this->stmt == false ) {
				$this->error2 = $this->pdo->errorInfo();
				echo "<div class=\"alert alert-warning\">エラーが発生しました。<br />{$this->error2[2]}</div>";
				exit();
			} else {
				return $this->stmt->fetchColumn();
			}

		}

		function res_display() {

			$this->query .= " ORDER BY nousya_yoteibi DESC";
			$this->stmt = $this->pdo->query ( $this->query );
			if ( $this->stmt == false ) {
				$this->error = $this->pdo->errorInfo();
				echo "<div class=\"alert alert-warning\">エラーが発生しました。<br />{$this->error[2]}</div>";
				exit();
			}
			return $this->stmt;

		}

		function delete($ID) {

			$this->query = "DELETE FROM maintenance_request_table WHERE ID = '{$ID}'";
			$this->stmt = $this->pdo->query ( $this->query );
			return $this->stmt;

		}

		function input($ID) {

			$this->query = "INSERT INTO maintenance_request_table VALUES(null, :nyuko_bi, :nousya_yoteibi, :sei, :mei, :tel, :mail, :car_name, :katasiki, :tourokubangou, :syakenmanryou_bi, :seibi_syurui, :seibi_naiyou, :sensya, :syanaiseisou, :tokki_zikou, :tokki_zikou_syousai, :identify_ID)";
			$this->stmt = $this->pdo->prepare ( $this->query );
			$this->stmt->bindParam ( ':nyuko_bi', $this->nyuko_bi );
			$this->stmt->bindParam ( ':nousya_yoteibi', $this->nousya_yoteibi );
			$this->stmt->bindParam ( ':sei', $this->sei );
			$this->stmt->bindParam ( ':mei', $this->mei );
			$this->stmt->bindParam ( ':tel', $this->tel );
			$this->stmt->bindParam ( ':mail', $this->mail );
			$this->stmt->bindParam ( ':car_name', $this->car_name );
			$this->stmt->bindParam ( ':katasiki', $this->katasiki );
			$this->stmt->bindParam ( ':tourokubangou', $this->tourokubangou );
			$this->stmt->bindParam ( ':syakenmanryou_bi', $this->syakenmanryou_bi );
			$this->stmt->bindParam ( ':seibi_syurui', $this->seibi_syurui );
			$this->stmt->bindParam ( ':seibi_naiyou', $this->seibi_naiyou );
			$this->stmt->bindParam ( ':sensya', $this->sensya );
			$this->stmt->bindParam ( ':syanaiseisou', $this->syanaiseisou );
			$this->stmt->bindParam ( ':tokki_zikou', $this->tokki_zikou );
			$this->stmt->bindParam ( ':tokki_zikou_syousai', $this->tokki_zikou_syousai );
			$this->stmt->bindParam ( ':identify_ID', $ID );
			return $this->stmt->execute( );

		}

		function auth($ID, $pass) {

			$this->query = "SELECT COUNT(*) FROM omanekun_users WHERE ID ='{$ID}' AND password = '{$pass}' ";
			$this->stmt = $this->pdo->query ( $this->query );
			if ( $this->stmt == false ) {
				$this->error = $this->pdo->errorInfo();
				echo "エラーが発生しました。<br />" . $this->error[2] . "<br />\n";
			}
			return $this->stmt->fetchColumn();

		}

	}
	?>
