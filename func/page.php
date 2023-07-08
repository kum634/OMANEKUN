<?php
require("page_con.php");

class page  {

	public $page_con;
	public $user;
	public $logout_btn;
	public $week_no;
	public $start_date;
	public $days_left;
	public $end_date;

	function __construct() {

		$this->page_con = new page_con();

		$this->user = $this->page_con->user;
		$this->logout_btn = $this->create_logout_btn();

	}

	public function create_logout_btn() {

		$logout_btn = '<a id="logout">ログアウト</a>'."\n";
		$logout_btn.= '<form id="logout_form" method="post" action="">'."\n";
		$logout_btn.= ' <input type="hidden" name="logout" value="logout">'."\n";
		$logout_btn.= ' <input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">'."\n";
		$logout_btn.= '</form>'."\n";

		return $logout_btn;
	}

	/*

	今週の開始日と終了日の取得

	*/

		public function get_this_week() {

		$this->week_no = date('w', strtotime('today'));
		$this->start_date = date('m/d', strtotime("-{$this->week_no} day", strtotime('today')));
		$this->days_left = 6 - $this->week_no;
		$this->end_date = date('m/d', strtotime("+{$this->days_left} day", strtotime('today')));
		$week = array(
			'start_date' => $this->start_date,
			'end_date' => $this->end_date
		);
		return $week;

	}


	/*

	今週の開始日と終了日を出力

	*/

	public function the_weekly() {

		$date = $this->get_this_week();
		dbg(dbg_type, $date, basename(__FILE__).__LINE__);
		echo $date['start_date'].' - '.$date['end_date'];

  }
	/*

	今週の開始日と終了日を出力

	*/

	public function the_weekly_get() {

		$obj = $this->page_con->get_weekly_requests();
		dbg(dbg_type, $obj, basename(__FILE__).__LINE__);
		$this->create_requests_table($obj);

  }


	/*

	テーブルの作成

	*/

	public function create_requests_table($obj, $alert = false) {

		$cnt = count($obj);
		dbg(dbg_type, $cnt, basename(__FILE__).__LINE__);
		if (!$cnt || $cnt <= 0) {
			if ($alert !== false) echo "<script type='text/javascript'>alert('一致するデータがありませんでした。');</script>";
			echo '<div class="result_title"><h2>一致する整備依頼がありません。</h2></div>';
			return;
		}

		if ($alert !== false) echo '<script type="text/javascript">alert("'.$cnt.' 件該当しました。");</script>';
		echo '<div class="result_title"><h2>該当件数 '.$cnt.' 件</h2></div>';
		echo '<table style="width: 90%;font-size: 90%;" id="datatable-example" class="nowrap table table-striped text-left">';
		echo ' <thead class="thead-dark">';
		echo '  <tr>';
		echo '	  <th scope="col">入庫日</th><th>納車予定日</th>';
		echo '	  <th scope="col">お客様氏名</th><th>車種名</th>';
		echo '	  <th scope="col">型式</th><th>登録番号</th>';
		echo '	  <th scope="col">整備の種類</th>';
		echo '	  <th scope="col"></th>';
		echo '  </tr>';
		echo ' </thead>';
		echo '<tbody>';

		foreach ($obj as $row) {
			if ($row["tel"] == "0") $row["tel"] = '';
			if ($row["retrieval_date"] == "0000-00-00") $row["retrieval_date"] = '';
			if ($row["inspection_date"] == "0000-00-00") $row["inspection_date"] = '';

			echo ' <tr>';
			echo '	 <td>'.$row["storage_date"].'</td>';
			echo '	 <td>'.$row["retrieval_date"].'</td>';
			echo '	 <td>'.$row["last_name"].' '.$row["first_name"].'</td>';
			echo '	 <td>'.$row["car_name"].'</td>';
			echo '	 <td>'.$row["model"].'</td>';
			echo '	 <td>'.$row["license"].'</td>';
			echo '	 <td>'.$row["maintenance_type"].'</td>';
			echo '	 <td>';
			echo '			<button
										data-id="'.$row["ID"].'" data-storage_date="'.$row["storage_date"].'" data-retrieval_date="'.$row["retrieval_date"].'"
										data-last_name="'.$row["last_name"].'" data-first_name="'.$row["first_name"].'" data-tel="'.$row["tel"].'" data-mailaddress="'.$row["mailaddress"].'"
										data-car_name="'.$row["car_name"].'" data-model="'.$row["model"].'" data-license="'.$row["license"].'"
										data-inspection_date="'.$row["inspection_date"].'" data-maintenance_type="'.$row["maintenance_type"].'" data-maintenance_detail="'.$row["maintenance_detail"].'"
										data-wash="'.$row["wash"].'" data-clean="'.$row["clean"].'" data-notices="'.$row["notices"].'" data-notices="'.$row["notices"].'" data-notices_detail="'.$row["notices_detail"].'"
									class="btn btn-lg btn-success" data-toggle="modal" data-mode="detail" data-target="#modal-detail">詳細</button>';
			echo '			<button type="button" class="del btn btn-lg btn-success" data-csrf_token="'.$_SESSION['csrf_token'].'" data-id="'.$row["ID"].'">削除</button>';
			echo '	 </td>';
			echo "  </tr>\n";
		}

		echo " </tbody>\n";
		echo "</table>\n" ;

		foreach ($obj as $row) {
			echo '<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">';
			echo '  <div class="modal-dialog" role="document">';
			echo '    <div class="modal-content">';
			echo '      <div class="modal-header">';
			echo '        <h5 class="modal-title" id="label1"></h5>';
			echo '        <button type="button" class="close" data-dismiss="modal" aria-label="Close">';
			echo '          <span aria-hidden="true">&times;</span>';
			echo '        </button>';
			echo '      </div>';
			require('parts/detail.php');
			require('parts/form.php');
			echo '    </div>';
			echo '  </div>';
			echo '</div>';
		}

	}


	/*

	ポストデータの集約

	*/

	public function post_data_ag($insert = false) {

		dbg(dbg_type, $_POST, basename(__FILE__).__LINE__);

		
		$notices = (!empty($_POST[ "notices" ])) ? $_POST[ "notices" ] : '';
		$maintenance_type = (!empty($_POST[ "maintenance_type" ])) ? $_POST[ "maintenance_type" ] : '';
		$storage_date_y = (!empty($_POST[ "storage_date_y" ])) ? $_POST[ "storage_date_y" ] : '';
		$storage_date_m = (!empty($_POST[ "storage_date_m" ])) ? $_POST[ "storage_date_m" ] : '';
		$storage_date_d = (!empty($_POST[ "storage_date_d" ])) ? $_POST[ "storage_date_d" ] : '';
		$retrieval_date_y = (!empty($_POST[ "retrieval_date_y" ])) ? $_POST[ "retrieval_date_y" ] : '';
		$retrieval_date_m = (!empty($_POST[ "retrieval_date_m" ])) ? $_POST[ "retrieval_date_m" ] : '';
		$retrieval_date_d = (!empty($_POST[ "retrieval_date_d" ])) ? $_POST[ "retrieval_date_d" ] : '';
		$last_name = (!empty($_POST[ "last_name" ])) ? $_POST[ "last_name" ] : '';
		$first_name = (!empty($_POST[ "first_name" ])) ? $_POST[ "first_name" ] : '';
		$tel = (!empty($_POST[ "tel" ])) ? $_POST[ "tel" ] : '';
		$mailaddress = (!empty($_POST[ "mailaddress" ])) ? $_POST[ "mailaddress" ] : '';
		$car_name = (!empty($_POST[ "car_name" ])) ? $_POST[ "car_name" ] : '';
		$model = (!empty($_POST[ "model" ])) ? $_POST[ "model" ] : '';
		$license = (!empty($_POST[ "license" ])) ? $_POST[ "license" ] : '';
		$inspection_date_y = (!empty($_POST[ "inspection_date_y" ])) ? $_POST[ "inspection_date_y" ] : '';
		$inspection_date_m = (!empty($_POST[ "inspection_date_m" ])) ? $_POST[ "inspection_date_m" ] : '';
		$inspection_date_d = (!empty($_POST[ "inspection_date_d" ])) ? $_POST[ "inspection_date_d" ] : '';
		$maintenance_detail = (!empty($_POST[ "maintenance_detail" ])) ? $_POST[ "maintenance_detail" ] : '';
		$wash = (!empty($_POST[ "wash" ])) ? $_POST[ "wash" ] : '';
		$clean = (!empty($_POST[ "clean" ])) ? $_POST[ "clean" ] : '';
		$notices_detail = (!empty($_POST[ "notices_detail" ])) ? $_POST[ "notices_detail" ] : '';
		$mode = (!empty($_POST[ "mode" ])) ? $_POST[ "mode" ] : '';


		if ($insert === true) {
			$notices = implode( ',', (array)$notices );
			dbg(dbg_type, $notices, basename(__FILE__).__LINE__);
			$maintenance_type = implode( ',', (array)$maintenance_type );
			dbg(dbg_type, $maintenance_type, basename(__FILE__).__LINE__);
		}

		$arr = array(
			'storage_date_y' => $storage_date_y,
			'storage_date_m' => $storage_date_m,
			'storage_date_d' => $storage_date_d,
			'retrieval_date_y' => $retrieval_date_y,
			'retrieval_date_m' => $retrieval_date_m,
			'retrieval_date_d' => $retrieval_date_d,
			'last_name' => $last_name,
			'first_name' => $first_name,
			'tel' => $tel,
			'mailaddress' => $mailaddress,
			'car_name' => $car_name,
			'model' => $model,
			'license' => $license,
			'inspection_date_y' => $inspection_date_y,
			'inspection_date_m' => $inspection_date_m,
			'inspection_date_d' => $inspection_date_d,
			'maintenance_type' => $maintenance_type,
			'maintenance_detail' => $maintenance_detail,
			'wash' => $wash,
			'clean' => $clean,
			'notices' => $notices,
			'notices_detail' => $notices_detail
		);
		dbg(dbg_type, $arr, basename(__FILE__).__LINE__);
		$arr +=  array('storage_date' => $storage_date_y.'-'.$storage_date_m.'-'.$storage_date_d);
		$arr +=  array('inspection_date' => $inspection_date_y.'-'.$inspection_date_m.'-'.$inspection_date_d);
		$arr +=  array('retrieval_date' => $retrieval_date_y.'-'.$retrieval_date_m.'-'.$retrieval_date_d);

		if ($arr['storage_date'] == '--') $arr['storage_date'] =  date("Y").'-'.date("m").'-'.date("d");
		if ($arr['inspection_date'] == '--') $arr['inspection_date'] =  null;
		if ($arr['retrieval_date'] == '--') $arr['retrieval_date'] =  null;

		if ($mode == 'edit' && !empty($_POST["id"])) $arr +=  array('ID' => $_POST["id"]);
		dbg(dbg_type, $arr, basename(__FILE__).__LINE__);

		return $arr;
	}


	/*

	検索によって得られた作業内容を出力

	*/

		public function the_search_get() {

			$data = $this->post_data_ag();
			dbg(dbg_type, $data, basename(__FILE__).__LINE__);
	    if (!is_array($data)) return 0;
			$obj = $this->page_con->get_requests($data);
			dbg(dbg_type, $obj, basename(__FILE__).__LINE__);
	    $this->create_requests_table($obj);

		}

	/*

	全ての作業内容を出力

	*/

		public function the_all_get() {

	    $obj = $this->page_con->get_requests();
			dbg(dbg_type, $obj, basename(__FILE__).__LINE__);
	    $this->create_requests_table($obj);

		}

		/*

		作業内容の登録準備

		*/

		public function reg_requests() {

			$arr = $this->post_data_ag(true);
			dbg(dbg_type, $arr, basename(__FILE__).__LINE__);
			if (!empty($_POST["mode"]) && $_POST["mode"] == 'add') {
			  $res = $this->page_con->add_requests($arr);
				dbg(dbg_type, $res, basename(__FILE__).__LINE__);
			  if ($res === 1) {
			      return bs_alert('登録に成功しました。', true);
			  } else {
			    return bs_alert('エラーが発生しました。', false, $res);
			  }
			}
			if (!empty($_POST["mode"]) && $_POST["mode"] == 'edit') {
			  $res = $this->page_con->edit_requests($arr);
				dbg(dbg_type, $res, basename(__FILE__).__LINE__);
			  if ($res === 1) {
			      return bs_alert('更新に成功しました。', true);
			  } else {
			    return bs_alert('エラーが発生しました。', false, $res);
			  }
			}

		}



		/*

		CSV準備

		*/

		public function csv_use() {
			if ($_POST["password"] == "") return bs_alert('パスワードを入力してください。', false);
			dbg(dbg_type, $_POST, basename(__FILE__).__LINE__);
			$arr = array(
        'ID' => $this->page_con->UID
      );
			dbg(dbg_type, $arr, basename(__FILE__).__LINE__);
			$row = $this->page_con->select_users($arr, true);
			dbg(dbg_type, $row, basename(__FILE__).__LINE__);
			if ($this->page_con->UID == 1) {
				if (!$row || $_POST["password"] != $row["password"]) return bs_alert('パスワードが間違っています。', false);
			} else {
				if (!$row || !password_verify($_POST["password"], $row["password"])) return bs_alert('パスワードが間違っています。', false);
			}

				if ($_POST["csv_mode"] == 'ex') $this->page_con->export_csv();
				if ($_POST["csv_mode"] == 'im') {

					$res = $this->csvfile_check();
					dbg(dbg_type, $res, basename(__FILE__).__LINE__);

					if (!is_array($res)) return bs_alert($res, false);

					$res = $this->page_con->import_csv($res['pass']);
					dbg(dbg_type, $res, basename(__FILE__).__LINE__);
					if ($res == 1) return bs_alert('インポートに成功しました', true);
					else return bs_alert('インポートに失敗しました。', false, $res);

					return $bs_alert;
				}

		}


		/*

		アップロードしたCSVファイルの判定

		*/

		public function csvfile_check() {
			dbg(dbg_type, $_FILES, basename(__FILE__).__LINE__);

			$file_path = $_FILES["csvfile"]["tmp_name"] ;
			dbg(dbg_type, $file_path, basename(__FILE__).__LINE__);

			$file_name = $_FILES["csvfile"]["name"];
			dbg(dbg_type, $file_name, basename(__FILE__).__LINE__);

			if (!is_uploaded_file($file_path)) return "ファイルが選択されていません。";
			if (pathinfo($file_name, PATHINFO_EXTENSION) != 'csv') return "CSVファイルのみ対応しています。";


			return array('pass' => $file_path);
		}


		/*

		ログアウト

		*/

		public function logout() {

			$this->page_con->logout();

		}


		/*

		退会準備

		*/

		public function erasure() {

			dbg(dbg_type, $_POST, basename(__FILE__).__LINE__);
			dbg(dbg_type, $this->page_con->UID, basename(__FILE__).__LINE__);
			if ($_POST["password"] == "") return bs_alert('パスワードを入力してください。', false);
			if ($this->page_con->UID == 1) return bs_alert('テスト用ユーザー情報は削除できません。', false);
			$arr = array(
				'ID' => $this->page_con->UID
			);
			dbg(dbg_type, $arr, basename(__FILE__).__LINE__);
			$row = $this->page_con->select_users($arr, true);
			dbg(dbg_type, $row, basename(__FILE__).__LINE__);
			if (!$row || !password_verify($_POST["password"], $row["password"])) return bs_alert('パスワードが間違っています。', false);

			$res1 = $this->page_con->del_user($row["ID"]);
			dbg(dbg_type, $res1, basename(__FILE__).__LINE__);
			if ($res1 != 1 ) return bs_alert('退会処理に失敗しました。', false, $res1);
			$res2 = $this->page_con->del_all_requests($row["ID"]);
			dbg(dbg_type, $res2, basename(__FILE__).__LINE__);
			if ($res2 != 1 ) return bs_alert('退会処理に失敗しました。', false, $res2);

			$this->logout(false);
			$_SESSION["withdrawal"] = 1;
			dbg(dbg_type, $res2, basename(__FILE__).__LINE__,ex);
			header ( "Location:signup.php" ) ;

		}


}
?>
