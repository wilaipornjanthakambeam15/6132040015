<?php session_start();?>
<?php
  @$database = include('database/database.php');
  if(!$database){ 
  echo '<br><br><br><div class="container"><div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>
  ทำการติดตั้งฐานข้อมูลก่อนทำงานของระบบก่อน  <a href="install/index.php" class="button large pink"><button type="button" class="btn btn-success fa fa-database" aria-hidden="true""> ติดตั้ง ! </button></a>
</div></div>';
}else{
  $db_username = isset($_SESSION['db_username']) ? $_SESSION['db_username'] : $database['mysqli']['username'];
  $db_password = isset($_SESSION['db_password']) ? $_SESSION['db_password'] : $database['mysqli']['password'];
  $db_server = isset($_SESSION['db_server']) ? $_SESSION['db_server'] : 'localhost';
  $db_name = isset($_SESSION['db_name']) ? $_SESSION['db_name'] : $database['mysqli']['dbname'];
  $prefix = isset($_SESSION['prefix']) ? $_SESSION['prefix'] : $database['mysqli']['prefix'];
  }
?>
<?php
define('pageex', '<center><h3> ตัวอย่าง PHP INSERT Update Delete MySQL Data Through Bootstrap Modal </h3></center><br><hr>');
define('page1', 'ตัวอย่างที่ 1 การสร้างฟอร์ม');


?>
