<?php
require_once('loading.php');
require_once('db.php');

if ( isset( $_POST["submit"] ) ) {
	$message = "";
	$error_message = "";
	$password = htmlspecialchars($_POST["password"], ENT_QUOTES ) ;
	$maintenance_request = new Maintenance_request();
	$identify_ID = $maintenance_request->identify_ID();
	$auth_match = $maintenance_request->auth($identify_ID, $password);

	if($auth_match == 1 ){
		require_once('db_direct_connection.php');
		$query = "INSERT INTO maintenance_request_table VALUES(null, :nyuko_bi, :nousya_yoteibi, :sei, :mei, :tel, :mail, :car_name, :katasiki, :tourokubangou, :syakenmanryou_bi, :seibi_syurui, :seibi_naiyou, :sensya, :syanaiseisou, :tokki_zikou, :tokki_zikou_syousai, :identify_ID)";
		$stmt = $pdo->prepare ( $query ) ;
		$stmt->bindParam ( ':nyuko_bi', $nyuko_bi ) ;
		$stmt->bindParam ( ':nousya_yoteibi', $nousya_yoteibi ) ;
		$stmt->bindParam ( ':sei', $sei ) ;
		$stmt->bindParam ( ':mei', $mei ) ;
		$stmt->bindParam ( ':tel', $tel ) ;
		$stmt->bindParam ( ':mail', $mail ) ;
		$stmt->bindParam ( ':car_name', $car_name ) ;
		$stmt->bindParam ( ':katasiki', $katasiki ) ;
		$stmt->bindParam ( ':tourokubangou', $tourokubangou ) ;
		$stmt->bindParam ( ':syakenmanryou_bi', $syakenmanryou_bi ) ;
		$stmt->bindParam ( ':seibi_syurui', $seibi_syurui ) ;
		$stmt->bindParam ( ':seibi_naiyou', $seibi_naiyou ) ;
		$stmt->bindParam ( ':sensya', $sensya ) ;
		$stmt->bindParam ( ':syanaiseisou', $syanaiseisou ) ;
		$stmt->bindParam ( ':tokki_zikou', $tokki_zikou ) ;
		$stmt->bindParam ( ':tokki_zikou_syousai', $tokki_zikou_syousai ) ;
		$stmt->bindParam ( ':identify_ID', $identify_ID ) ;

		$file_path = $_FILES["csvfile"]["tmp_name"] ;
		$file_name = $_FILES["csvfile"]["name"];
		if ( !is_uploaded_file( $file_path ) ) {
			$error_message = "ファイルが選択されていません。";
		}else {
			if (pathinfo($file_name, PATHINFO_EXTENSION) == 'csv') {
				$buffer = file_get_contents($file_path) ;
				$buffer = mb_convert_encoding( $buffer, "UTF-8", "Shift_JIS" ) ;
				$fh = tmpfile() ;
				fwrite( $fh, $buffer ) ;
				rewind( $fh) ;
				while ( $cols = fgetcsv ( $fh ) ) {
					$nyuko_bi = $cols[0] ;
					$nousya_yoteibi = $cols[1] ;
					$sei = $cols[2] ;
					$mei = $cols[3] ;
					$tel = $cols[4] ;
					$mail = $cols[5] ;
					$car_name = $cols[6] ;
					$katasiki = $cols[7] ;
					$tourokubangou = $cols[8] ;
					$syakenmanryou_bi = $cols[9] ;
					$seibi_syurui = $cols[10] ;
					$seibi_naiyou = $cols[11] ;
					$sensya = $cols[12] ;
					$syanaiseisou = $cols[13] ;
					$tokki_zikou = $cols[14] ;
					$tokki_zikou_syousai = $cols[15] ;
					$result = $stmt->execute( );
				}
				if ( $result == false ) {
					$error_message = "インポートに失敗しました。" ;
				} else {
					$message = "インポートに成功しました" ;
				}
			} else {
				$error_message = "CSVファイルのみ対応しています。";
			}
		}
	} else {
		$error_message = "パスワードが間違っています。";
	}
}

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
	<title>インポート</title>
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
			<h1>インポート</h1>
			<?php
			if ($message != "") {
				echo "<div class=\"alert alert-success\">{$message}</div>";
			}
			if ($error_message != "") {
				echo "<div class=\"alert alert-warning\">{$error_message}</div>";
			}
			?>
			<form class="form-reauth mt-5" action="" method="post" enctype="multipart/form-data">
				<dl>
					<dt>ファイル（.csv）</dt>
					<dd>
						<label class="submit_file" for="csvfile">
							＋ファイルを選択<input type="file" name="csvfile" style="display:none;" id="csvfile"  onchange="file_select(this);"/>
						</label>
						<p id="name"></p>
					</dd>
				</dl>
				<dl>
					<dt>パスワードを入力してください。</dt>
					<dd><input type="password" name="password" value=""/></dd>
				</dl>
				<input class="small_btn" type="submit" name="submit" id="submit" value="インポート"/>
			</form>
			<script type="text/javascript">
			function file_select() {
				var input = document.querySelector('#csvfile').files[0];
				document.querySelector('#name').innerHTML = input.name;
			}
			</script>
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
