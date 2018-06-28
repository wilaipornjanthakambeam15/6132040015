<?php
/*
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(-1);
 */
session_start();
$step = isset($_REQUEST['step']) ? (int)$_REQUEST['step'] : 0;
// header
echo '<!DOCTYPE html>';
echo '<html lang=TH dir=ltr>';
echo '<head>';
echo '<meta charset=utf-8>';
echo '<title>การติดตั้ง &rsaquo; Setup Configuration File</title>';
echo '<style type="text/css" title="currentStyle">
        @import "../bootstrap-3.3.6-dist/css/bootstrap.min.css";
        @import "../bootstrap-3.3.6-dist/css/dataTables.bootstrap4.min.css";
        @import "../bootstrap-3.3.6-dist/font-awesome-4.7.0/css/font-awesome.min.css";
</style>';
echo '<script src="../bootstrap-3.3.6-dist/js/jquery.min.js"></script>';
echo '<script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>';
echo '<link rel=stylesheet href="style.css">';
echo '</head>';
echo '<body>';
echo '<main>';
echo '<h1 id=logo>การติดตั้ง</h1>';
define('ROOT_PATH', str_replace(array('\\', 'install/index.php',), array('/', ''), __FILE__));
if (is_file('../inc/database.php') && is_array(include('../inc/database.php'))) {
  // ติดตั้งแล้ว
  echo '<h2>ติดตั้งเรียบร้อยแล้ว</h2>';
  echo '<p>คุณได้ทำการติดตั้ง ตัวอย่างที่ให้ไป เป็นที่เรียบร้อยแล้ว</p>';
  echo '<p class=warning>เพื่อความปลอดภัย กรุณาลบไดเร็คทอรี่ <em>install/</em> ออกก่อนดำเนินการต่อ</p>';
  echo '<p><a href="../index.php?module=system" class="button large admin"><button type="button" class="btn btn-success"> เข้าระบบ </button></a></p>';
} elseif (is_file(ROOT_PATH.'install/step'.$step.'.php')) {
  // ติดตั้ง
  include ROOT_PATH.'install/step'.$step.'.php';
}
// footer
echo '<div class=footer> สงวนลิขสิทธิ์ ตามพระราชบัญญัติลิขสิทธิ์ พ.ศ. 2539</div>';
echo '</main>';
echo '<link href="https://fonts.googleapis.com/css?family=Athiti&subset=thai,latin" rel=stylesheet type="text/css">';
echo '</body>';
echo '</html>';
