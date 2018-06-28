<?php include('inc/define.php');?>

<?php
/*
ตัวอย่างนี้จะเน้นการแยกส่วนการทำงาน
คือส่วนที่ติดต่อกับฐานข้อมูลก็จะเป็นตัวสร้างข้อมูลเพื่อส่งไปให้ template แสดงผล
โดยตัวแปรที่จะถูกใช้ใน template (inc/index.inc.php, inc/post.inc.php, inc/view.inc.php)
จะเป็นตัวแปรที่เป็นตัวพิมพ์ใหญ่ทั้งหมด เช่น $PAGE, $ITEMS
ซึ่งเราจะใช้แนวทางนี้ทั้งหมดสำหรับตัวอย่างนี้
*/

/*
ทำการเชื่อมต่อกับฐานข้อมูล ดู (inc/mysqli.inc.php)
*/
require 'inc/mysqli.inc.php';

/*
บอก inc/main.inc.php ให้ require ไฟล์ inc/index.inc.php เป็น template
*/
if($database){
	echo "<br><br>";
if(isset($_GET['url'])){
  $PAGE_TEMPLATE = $_GET['url'].".php";
  #include $_GET['url'].".php";
}else {
  // code...
    $PAGE_TEMPLATE = 'show.php';
}
}
include 'template/template.php';
