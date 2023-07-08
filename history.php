<?php

require_once('func/page.php');
$page = new page();
if (isset($_POST['logout'])) $page->logout();
$bs_alert = $page->reg_requests();
$title = get_title(basename(__FILE__, ".php"));

?>
<?php require_once('parts/meta.php'); ?>
<?php require_once('parts/header.php'); ?>
<h1>整備履歴</h1>
<?php
if (!empty($bs_alert) && $bs_alert != '') {
  echo $bs_alert;
echo "<script type='text/javascript'>setTimeout(function(){location.href = location.href},2000);</script>";
}
?>

 <div class="container">
   <div class="btn_area">
     <button type="button" class="btn btn-success" data-toggle="modal" data-title="詳細検索" data-mode="search" data-target="#modal-form"><i class="fas fa-search"></i> 詳細検索</button>
     <button type="button" class="btn btn-success" data-toggle="modal" data-title="新規登録" data-mode="add" data-target="#modal-form"><i class="fas fa-plus"></i> 新規登録</button>
   </div>
   <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="label1"></h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <?php require('parts/form.php'); ?>
       </div>
     </div>
   </div>
   <div class="result">
     <?php
     if (!empty($_POST["mode"]) && $_POST["mode"] == 'search') $page->the_search_get();
     else $page->the_all_get();
     ?>
   </div>
 </div>
<?php require_once('parts/footer.php'); ?>
