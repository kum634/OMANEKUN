<?php

// var_dump($_POST);
require("page_con.php");
$page_con = new page_con();

if (!empty($_POST["ajax_mode"]) && $_POST['ajax_mode'] == 'del') {

  $res = $page_con->del_requests($_POST['id']);
  $data = array(
    'res' => $res,
    'ajax_mode' => $_POST['ajax_mode']
  );
  echo json_encode($data);

}























 ?>
