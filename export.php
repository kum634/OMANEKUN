<?php
require_once('loading.php');
require_once('db.php');

if ( isset( $_POST["submit"] ) ) {
	$error_message = "";
	$password = htmlspecialchars($_POST["password"], ENT_QUOTES ) ;
	$maintenance_request = new Maintenance_request();
	$identify_ID = $maintenance_request->identify_ID();
	$auth_match = $maintenance_request->auth($identify_ID, $password);
	if($auth_match == 1 ){
		require_once('db_direct_connection.php');
		$query = "SELECT * FROM maintenance_request_table WHERE identify_ID = '{$identify_ID}'" ;
		$stmt = $pdo->query ( $query ) ;
		$current = time();
		date_default_timezone_set( "Asia/Tokyo" );
		$time = date( "YmdHi", $current );
		header ( "Content-Type: text/csv" ) ;
		header ( "Content-Disposition: attachment; filename=\"{$time}_{$_SESSION["login"]}.csv\"" ) ;
		$fh = fopen( "php://output", "w" ) ;
		while ( $row = $stmt->fetch ( PDO::FETCH_ASSOC ) ) {
			unset($row["ID"]);
			unset($row["identify_ID"]);
			foreach ( $row as $key => $value ) {
				$row[$key] = mb_convert_encoding( $value, "Shift_JIS", "UTF-8" );
			}
			fputcsv( $fh, $row );
		}
		exit();
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
	<title>エキスポート</title>
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
			<h1>エキスポート</h1>
			<?php if($error_message != ""){ ?>
				<div class="alert alert-warning"><?= $error_message ?></div>
			<?php } ?>
			<form class="form-reauth mt-5" action="" method="post">
				<dl>
					<dt>パスワードを入力してください。</dt>
					<dd><input type="password" name="password" value=""/></dd>
				</dl>
				<input class="small_btn" type="submit" name="submit" id="submit" value="エキスポート"/>
			</form>
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
