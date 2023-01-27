<body>
  <header class="fixed-top bg-success">
    <nav class=" navbar navbar-expand-lg navbar-dark custom-hamburger"><a class="navbar-brand top_logo" href="index.php"><span class="logo">オーマネ君</span><span class="hyphen_left">-</span><span class="catch_copy">整備依頼管理</span><span class="hyphen_right">-</span></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span><span class="navbar-toggler-icon"></span><span class="navbar-toggler-icon"></span> </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-calendar"></i>週間作業予定</a> </li>
          <li class="nav-item"><a class="nav-link" href="history.php"><i class="fas fa-book"></i>依頼履歴</a></li>
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
        <li class="nav-item"><a class="nav-link" href="history.php"><i class="fas fa-book"></i>依頼履歴</a></li>
        <li class="nav-item"><a class="nav-link" href="import.php"><i class="fas fa-upload"></i>インポート</a></li>
        <li class="nav-item"><a class="nav-link" href="export.php"><i class="fas fa-download"></i>エキスポート</a></li>
        <li class="nav-item"><a class="nav-link" href="withdrawal.php"><i class="fas fa-door-open"></i>退会</a></li>
      </ul>
      <ul class="middle_screen navbar-nav mr-auto">
        <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-calendar"></i></a> </li>
        <li class="nav-item"><a class="nav-link" href="history.php"><i class="fas fa-book"></i></a></li>
        <li class="nav-item"><a class="nav-link" href="import.php"><i class="fas fa-upload"></i></a></li>
        <li class="nav-item"><a class="nav-link" href="export.php"><i class="fas fa-download"></i></a></li>
        <li class="nav-item"><a class="nav-link" href="withdrawal.php"><i class="fas fa-door-open"></i></a></li>
      </ul>
    </nav>
  </aside>
  <article class="jumbotron jumbotron-fluid text-center mb-0" style="width:100%;">
    <div class="login_info text-right">
      <p class="user text-center"><?= $page->user ?></p>
      <?= $page->logout_btn ?>
    </div>
