<?php
require("common.php");

class page_con extends common {

	public $user;
	public $pass;
	public $UID;
	public $logout_btn;

	function __construct() {

		parent::__construct();

		if (!$this->con) $this->$con = $this->conect();

		$this->session_expires_chk();
		$this->login_chk();

    $this->csrf_set();
    $this->csrf_chk();
		$this->get_chk();
		$this->arr_chk($_POST);

	}

	public function login_chk() {

		if (!isset( $_SESSION["user"])) header ( "Location:login.php" ) ;

		$this->user = $_SESSION["user"];
		$this->pass = $_SESSION["pass"];
		$this->UID = $_SESSION["UID"];
		dbg(dbg_type, $this->user, basename(__FILE__).__LINE__);
		dbg(dbg_type, $this->pass, basename(__FILE__).__LINE__);
		dbg(dbg_type, $this->UID, basename(__FILE__).__LINE__);

	}


	/*

	今週の依頼内容の取得

	*/

	public function get_weekly_requests() {

		$sql= "SELECT * FROM requests WHERE visible = '1'";
		$sql.= " AND UID = '".$this->UID."'";
		$sql.= " AND yearweek(`storage_date`) = yearweek(curdate())";
		$sql.= " OR yearweek(`retrieval_date`) = yearweek(curdate())";
		$sql .= " ORDER BY retrieval_date DESC";
		dbg(dbg_type, $sql, basename(__FILE__).__LINE__);
		$stmt = $this->con->query($sql);
		if ($stmt === false) return bs_alert("今週の作業依頼の取得に失敗しました。");

		dbg(dbg_type, $obj, basename(__FILE__).__LINE__);
		$obj = $stmt->fetchAll();
		return $obj;
	}


	/*

	依頼内容の取得

	*/

	public function get_requests($arr = false, $mode = false) {

		dbg(dbg_type, $arr, basename(__FILE__).__LINE__);
		dbg(dbg_type, $mode, basename(__FILE__).__LINE__);

		$sql = "SELECT * FROM requests WHERE visible = '1'";
		$sql.= " AND UID = '".$this->UID."'";

		if (!empty($arr["storage_date_y"]) || !empty($arr["storage_date_m"]) || !empty($arr["storage_date_d"])) $sql .= " AND storage_date like :storage_date";
		if (!empty($arr["retrieval_date_y"]) || !empty($arr["retrieval_date_m"]) || !empty($arr["retrieval_date_d"])) $sql .= " AND retrieval_date like :retrieval_date";
		if (!empty($arr["inspection_date_y"]) || !empty($arr["inspection_date_m"]) || !empty($arr["inspection_date_d"])) $sql .= " AND inspection_date like :inspection_date";
		if (!empty($arr["last_name"])) $sql .= " AND last_name = :last_name";
		if (!empty($arr["first_name"])) $sql .= " AND first_name = :first_name";
		if (!empty($arr["tel"])) $sql .= " AND tel = :tel";
		if (!empty($arr["mailaddress"])) $sql .= " AND mailaddress = :mailaddress";
		if (!empty($arr["car_name"])) $sql .= " AND car_name = :car_name";
		if (!empty($arr["model"])) $sql .= " AND model = :model";
		if (!empty($arr["license"])) $sql .= " AND license = :license";
		if (!empty($arr["maintenance_type"])) $sql .= " AND maintenance_type like :maintenance_type";
		if (!empty($arr["maintenance_detail"])) $sql .= " AND maintenance_detail like :maintenance_detail";
		if (!empty($arr["wash"])) $sql .= " AND wash = :wash ";
		if (!empty($arr["clean"])) $sql .= " AND clean = :clean";
		if (!empty($arr["notices"])) $sql .= " AND notices like :notices";
		if (!empty($arr["notices_detail"])) $sql .= " AND notices_detail like :notices_detail";
		$sql .= " ORDER BY storage_date DESC";
		dbg(dbg_type, $sql, basename(__FILE__).__LINE__);

		$stmt = $this->con->prepare($sql);

		if ( !empty($arr["storage_date_y"]) && !empty($arr["storage_date_m"]) && !empty($arr["storage_date_d"]) ) {
			$storage_date = $arr["storage_date_y"]."-".$arr["storage_date_m"]."-".$arr["storage_date_d"];
			$stmt->bindvalue(':storage_date', $storage_date);
		} elseif ( !empty($arr["storage_date_y"]) && !empty($arr["storage_date_m"]) && empty($arr["storage_date_d"]) ) {
			$storage_date = $arr["storage_date_y"]."-".$arr["storage_date_m"]."-";
			$stmt->bindvalue(':storage_date', $storage_date.'%');
		} elseif ( !empty($arr["storage_date_y"]) && empty($arr["storage_date_m"]) && empty($arr["storage_date_d"]) ) {
			$storage_date = $arr["storage_date_y"]."-";
			$stmt->bindvalue(':storage_date', $storage_date.'%');
		} elseif ( empty($arr["storage_date_y"]) && !empty($arr["storage_date_m"]) && !empty($arr["storage_date_d"]) ) {
			$storage_date = "-".$arr["storage_date_m"]."-".$arr["storage_date_d"];
			$stmt->bindvalue(':storage_date', '%'.$storage_date);
		} elseif ( empty($arr["storage_date_y"]) && !empty($arr["storage_date_m"]) && empty($arr["storage_date_d"]) ) {
			$storage_date = "-".$arr["storage_date_m"]."-";
			$stmt->bindvalue(':storage_date', '%'.$storage_date.'%');
		}

		if (!empty($arr["retrieval_date_y"]) && !empty($arr["retrieval_date_m"]) && !empty($arr["retrieval_date_d"])) {
			$retrieval_date = $arr["retrieval_date_y"]."-".$arr["retrieval_date_m"]."-".$arr["retrieval_date_d"];
			$stmt->bindvalue(':retrieval_date', $retrieval_date);
		} elseif (!empty($arr["retrieval_date_y"]) && !empty($arr["retrieval_date_m"]) && empty($arr["retrieval_date_d"])) {
			$retrieval_date = $arr["retrieval_date_y"]."-".$arr["retrieval_date_m"]."-";
			$stmt->bindvalue(':retrieval_date', $retrieval_date.'%');
		} elseif (!empty($arr["retrieval_date_y"]) && empty($arr["retrieval_date_m"]) && empty($arr["retrieval_date_d"])) {
			$retrieval_date = $arr["retrieval_date_y"]."-";
			$stmt->bindvalue(':retrieval_date', $retrieval_date.'%');
		} elseif (empty($arr["retrieval_date_y"]) && !empty($arr["retrieval_date_m"]) && !empty($arr["retrieval_date_d"])) {
			$retrieval_date = "-".$arr["retrieval_date_m"]."-".$arr["retrieval_date_d"];
			$stmt->bindvalue(':retrieval_date', '%'.$retrieval_date);
		} elseif (empty($arr["retrieval_date_y"]) && !empty($arr["retrieval_date_m"]) && empty($arr["retrieval_date_d"])) {
			$retrieval_date = "-".$arr["retrieval_date_m"]."-";
			$stmt->bindvalue(':retrieval_date', '%'.$retrieval_date.'%');
		}

		if (!empty($arr["last_name"])) $stmt->bindvalue(':last_name', $arr["last_name"]);
		if (!empty($arr["first_name"])) $stmt->bindvalue(':first_name', $arr["first_name"]);
		if (!empty($arr["tel"])) $stmt->bindvalue(':tel', $arr["tel"]);
		if (!empty($arr["mailaddress"])) $stmt->bindvalue(':mailaddress', $arr["mailaddress"]);
		if (!empty($arr["car_name"])) $stmt->bindvalue(':car_name', $arr["car_name"]);
		if (!empty($arr["model"])) $stmt->bindvalue(':model', $arr["model"]);
		if (!empty($arr["license"])) $stmt->bindvalue(':license', $arr["license"]);

		if ( !empty($arr["inspection_date_y"]) && !empty($arr["inspection_date_m"]) && !empty($arr["inspection_date_d"]) ) {
			$inspection_date = $arr["inspection_date_y"]."-".$arr["inspection_date_m"]."-".$arr["inspection_date_d"];
			$stmt->bindvalue(':inspection_date', $inspection_date);
		}elseif( !empty($arr["inspection_date_y"]) && !empty($arr["inspection_date_m"]) && empty($arr["inspection_date_d"]) ) {
			$inspection_date = $arr["inspection_date_y"]."-".$arr["inspection_date_m"]."-";
			$stmt->bindvalue(':inspection_date', $inspection_date.'%');
		}elseif( !empty($arr["inspection_date_y"]) && empty($arr["inspection_date_m"]) && empty($arr["inspection_date_d"]) ) {
			$inspection_date = $arr["inspection_date_y"]."-";
			$stmt->bindvalue(':inspection_date', $inspection_date.'%');
		}elseif( empty($arr["inspection_date_y"]) && !empty($arr["inspection_date_m"]) && !empty($arr["inspection_date_d"]) ) {
			$inspection_date = "-".$arr["inspection_date_m"]."-".$arr["inspection_date_d"];
			$stmt->bindvalue(':inspection_date', '%'.$inspection_date);
		}elseif( empty($arr["inspection_date_y"]) && !empty($arr["inspection_date_m"]) && empty($arr["inspection_date_d"]) ) {
			$inspection_date = "-".$arr["inspection_date_m"]."-";
			$stmt->bindvalue(':inspection_date', '%'.$inspection_date.'%');
		}
		if (!empty($arr["maintenance_type"])) {
			foreach($arr["maintenance_type"] as $val){
				$stmt->bindvalue(':maintenance_type', '%'.$val.'%');
			}
		}
		if (!empty($arr["maintenance_detail"])) {
			$stmt->bindvalue(':maintenance_detail', '%'.$arr["maintenance_detail"].'%');
		}
		if (!empty($arr["wash"])) {
			$stmt->bindvalue(':wash', '%'.$arr["wash"].'%');
		}
		if (!empty($arr["clean"])) {
			$stmt->bindvalue(':clean', '%'.$arr["clean"].'%');
		}
		if (!empty($arr["notices"])) {
			foreach($arr["notices"] as $val){
				$stmt->bindvalue(':notices', '%'.$val.'%');
			}
		}
		if (!empty($arr["notices_detail"])) {
			$stmt->bindvalue(':notices_detail', '%'.$arr["notices_detail"].'%');
		}

		try {
			$stmt->execute();
		} catch (PDOException $e) {
			dbg(dbg_type, __METHOD__.ng, basename(__FILE__).__LINE__);
			$error = $e->getMessage();
			return bs_alert('作業依頼の取得に失敗しました。', false, $error);
		}
		dbg(dbg_type, __METHOD__.ok, basename(__FILE__).__LINE__);

		if ($mode !== false) $stmt;
		else $obj = $stmt->fetchAll();
		return $obj;

	}


	/*

	依頼内容の削除

	*/
		public function del_requests($ID) {

			// dbg(dbg_type, $ID, basename(__FILE__).__LINE__);
			$sql = "UPDATE requests SET";
			$sql.= " visible = 0";
			$sql.= " WHERE ID = :ID";
			// dbg(dbg_type, $sql, basename(__FILE__).__LINE__);
			$stmt = $this->con->prepare ($sql);
			$stmt->bindvalue(':ID', $ID);
			try {
				$stmt->execute();
			} catch (PDOException $e) {
				// dbg(dbg_type, __METHOD__.ng, basename(__FILE__).__LINE__);
				$error = $e->getMessage();
	      return $error;
			}
			// dbg(dbg_type, __METHOD__.ok, basename(__FILE__).__LINE__);
			return 1;

		}


		/*

		依頼内容の登録

		*/

		public function add_requests($arr) {

			dbg(dbg_type, $arr, basename(__FILE__).__LINE__);
			$sql = "INSERT INTO requests VALUES(
				null,
				:UID,
				:visible,
				:storage_date,
				:retrieval_date,
				:last_name,
				:first_name,
				:tel,
				:mailaddress,
				:car_name,
				:model,
				:license,
				:inspection_date,
				:maintenance_type,
				:maintenance_detail,
				:wash,
				:clean,
				:notices,
				:notices_detail,
				CURRENT_TIME,
				CURRENT_TIME
			 )";
			dbg(dbg_type, $sql, basename(__FILE__).__LINE__);
			$stmt = $this->con->prepare ( $sql );
			$stmt->bindvalue ( ':UID', $this->UID );
			$stmt->bindvalue ( ':visible', 1 );
			$stmt->bindvalue ( ':storage_date', $arr["storage_date"] );
			$stmt->bindvalue ( ':retrieval_date', $arr["retrieval_date"] );
			$stmt->bindvalue ( ':last_name', $arr["last_name"] );
			$stmt->bindvalue ( ':first_name', $arr["first_name"] );
			$stmt->bindvalue ( ':tel', $arr["tel"] );
			$stmt->bindvalue ( ':mailaddress', $arr["mailaddress"] );
			$stmt->bindvalue ( ':car_name', $arr["car_name"] );
			$stmt->bindvalue ( ':model', $arr["model"] );
			$stmt->bindvalue ( ':license', $arr["license"] );
			$stmt->bindvalue ( ':inspection_date', $arr["inspection_date"] );
			$stmt->bindvalue ( ':maintenance_type', $arr["maintenance_type"] );
			$stmt->bindvalue ( ':maintenance_detail', $arr["maintenance_detail"] );
			$stmt->bindvalue ( ':wash', $arr["wash"] );
			$stmt->bindvalue ( ':clean', $arr["clean"] );
			$stmt->bindvalue ( ':notices', $arr["notices"] );
			$stmt->bindvalue ( ':notices_detail', $arr["notices_detail"] );

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

		/*

		依頼内容の更新

		*/

		public function edit_requests($arr) {

			dbg(dbg_type, $arr, basename(__FILE__).__LINE__);
			$sql = "UPDATE requests SET";
			$sql.= " visible = 1";
			$sql.= ", storage_date = :storage_date";
			$sql.= ", retrieval_date = :retrieval_date";
			$sql.= ", last_name = :last_name";
			$sql.= ", first_name = :first_name";
			$sql.= ", tel = :tel";
			$sql.= ", mailaddress = :mailaddress";
			$sql.= ", car_name = :car_name";
			$sql.= ", model = :model";
			$sql.= ", license = :license";
			$sql.= ", inspection_date = :inspection_date";
			$sql.= ", maintenance_type = :maintenance_type";
			$sql.= ", maintenance_detail = :maintenance_detail";
			$sql.= ", wash = :wash";
			$sql.= ", clean = :clean";
			$sql.= ", notices = :notices";
			$sql.= ", notices_detail = :notices_detail";
			$sql.= " WHERE ID = :ID";
			dbg(dbg_type, $sql, basename(__FILE__).__LINE__);

			$stmt = $this->con->prepare ( $sql );

			$stmt->bindvalue ( ':storage_date', $arr["storage_date"] );
			$stmt->bindvalue ( ':retrieval_date', $arr["retrieval_date"] );
			$stmt->bindvalue ( ':last_name', $arr["last_name"] );
			$stmt->bindvalue ( ':first_name', $arr["first_name"] );
			$stmt->bindvalue ( ':tel', $arr["tel"] );
			$stmt->bindvalue ( ':mailaddress', $arr["mailaddress"] );
			$stmt->bindvalue ( ':car_name', $arr["car_name"] );
			$stmt->bindvalue ( ':model', $arr["model"] );
			$stmt->bindvalue ( ':license', $arr["license"] );
			$stmt->bindvalue ( ':inspection_date', $arr["inspection_date"] );
			$stmt->bindvalue ( ':maintenance_type', $arr["maintenance_type"] );
			$stmt->bindvalue ( ':maintenance_detail', $arr["maintenance_detail"] );
			$stmt->bindvalue ( ':wash', $arr["wash"] );
			$stmt->bindvalue ( ':clean', $arr["clean"] );
			$stmt->bindvalue ( ':notices', $arr["notices"] );
			$stmt->bindvalue ( ':notices_detail', $arr["notices_detail"] );
			$stmt->bindvalue ( ':ID', $arr["ID"] );
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


		/*

		CSVのエキスポート

		*/

		public function export_csv() {

			$sql = "SELECT * FROM requests WHERE visible = '1' AND UID = '".$this->UID."'" ;
			dbg(dbg_type, $sql, basename(__FILE__).__LINE__);
			$stmt = $this->con->query($sql);
			$current = time();
			dbg(dbg_type, $current, basename(__FILE__).__LINE__);
			$time = date( "YmdHi", $current );
			dbg(dbg_type, $time, basename(__FILE__).__LINE__);
			header ( "Content-Type: text/csv" ) ;
			header ( "Content-Disposition: attachment; filename=\"{$time}_{$_SESSION["user"]}.csv\"" ) ;
			$fh = fopen( "php://output", "w" ) ;
			dbg(dbg_type, $fh, basename(__FILE__).__LINE__);
			while ( $row = $stmt->fetch ( PDO::FETCH_ASSOC ) ) {
			dbg(dbg_type, $row, basename(__FILE__).__LINE__);

				unset($row["ID"]);
				unset($row["UID"]);
				unset($row["visible"]);
				unset($row["updated"]);
				unset($row["modified"]);
				foreach ( $row as $key => $value ) {
					$row[$key] = mb_convert_encoding( $value, "Shift_JIS", "UTF-8" );
				}
				fputcsv( $fh, $row );
			}
			exit;

		}

		/*

		CSVのインポート

		*/

		public function import_csv($file_path) {

			dbg(dbg_type, $file_path, basename(__FILE__).__LINE__);
			$sql = "INSERT INTO requests VALUES(
				null,
				:UID,
				:visible,
				:storage_date,
				:retrieval_date,
				:last_name,
				:first_name,
				:tel,
				:mailaddress,
				:car_name,
				:model,
				:license,
				:inspection_date,
				:maintenance_type,
				:maintenance_detail,
				:wash,
				:clean,
				:notices,
				:notices_detail,
				CURRENT_TIME,
				CURRENT_TIME
			 )";
			dbg(dbg_type, $sql, basename(__FILE__).__LINE__);
			$stmt = $this->con->prepare ( $sql ) ;
			$stmt->bindvalue ( ':visible', 1 );
			$stmt->bindParam ( ':storage_date', $storage_date ) ;
			$stmt->bindParam ( ':retrieval_date', $retrieval_date ) ;
			$stmt->bindParam ( ':last_name', $last_name ) ;
			$stmt->bindParam ( ':first_name', $first_name ) ;
			$stmt->bindParam ( ':tel', $tel ) ;
			$stmt->bindParam ( ':mailaddress', $mailaddress ) ;
			$stmt->bindParam ( ':car_name', $car_name ) ;
			$stmt->bindParam ( ':model', $model ) ;
			$stmt->bindParam ( ':license', $license ) ;
			$stmt->bindParam ( ':inspection_date', $inspection_date ) ;
			$stmt->bindParam ( ':maintenance_type', $maintenance_type ) ;
			$stmt->bindParam ( ':maintenance_detail', $maintenance_detail ) ;
			$stmt->bindParam ( ':wash', $wash ) ;
			$stmt->bindParam ( ':clean', $clean ) ;
			$stmt->bindParam ( ':notices', $notices ) ;
			$stmt->bindParam ( ':notices_detail', $notices_detail ) ;
			$stmt->bindvalue ( ':UID', $this->UID );

			$buffer = file_get_contents($file_path);
			dbg(dbg_type, $buffer, basename(__FILE__).__LINE__);
			$buffer = mb_convert_encoding($buffer, "UTF-8", "Shift_JIS");
			dbg(dbg_type, $buffer, basename(__FILE__).__LINE__);
			$fh = tmpfile();
			dbg(dbg_type, $fh, basename(__FILE__).__LINE__);
			fwrite($fh, $buffer);
			rewind($fh) ;
			while ( $cols = fgetcsv ( $fh ) ) {
				$storage_date = $cols[0] ;
				$retrieval_date = $cols[1] ;
				$last_name = $cols[2] ;
				$first_name = $cols[3] ;
				$tel = $cols[4] ;
				$mailaddress = $cols[5] ;
				$car_name = $cols[6] ;
				$model = $cols[7] ;
				$license = $cols[8] ;
				$inspection_date = $cols[9] ;
				$maintenance_type = $cols[10] ;
				$maintenance_detail = $cols[11] ;
				$wash = $cols[12] ;
				$clean = $cols[13] ;
				$notices = $cols[14] ;
				$notices_detail = $cols[15] ;
				try {
					$stmt->execute();
				} catch (PDOException $e) {
					dbg(dbg_type, __METHOD__.ng, basename(__FILE__).__LINE__);
					$error = $e->getMessage();
					dbg(dbg_type, $error, basename(__FILE__).__LINE__);
					return $error;
				}
			}
			dbg(dbg_type, __METHOD__.ok, basename(__FILE__).__LINE__);
			return 1;
		}
	}
	?>
