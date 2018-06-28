<?php
/*
กำหนดค่า default ให้กับตัวแปร $TITLE หากไม่ได้กำหนดไว้ก่อนหน้านี้
*/
if (!isset($TITLE)) {
  $TITLE = 'ตัวอย่างการทำ Webboard Workshop';
}
/*
กำหนดตัวแปร $PARENT_FILENAME ให้เป็นชื่อไฟล์ที่ผู้ใช้เรียก
โดยตรวจจาก $_SERVER['SCRIPT_FILENAME'] ซึ่งจะมีค่าเป็นชื่อไฟล์ PHP ที่ผู้ใช้เรียก
เช่น C:\xampp\htdocs\workshop-webboard\index.php
แต่เนื่องจากเราต้องการเพียงส่วนท้ายสุด คือ index.php เราจึงใช้ฟังก์ชั่น pathinfo()
ดึงข้อมูลส่วนนี้ออกมา ซึ่งปกติ pathinfo() จะคืนค่าออกมาเป็น array รายละเอียดของชื่อไฟล์
แต่ถ้าเรากำหนด argument ตัวที่สอง ก็จะดึงเฉพาะส่วนออกมาได้
ซึ่ง PATHINFO_BASENAME หมายถึง ให้เอาเฉพาะชื่อไฟล์และนามสกุลมา
*/
$PARENT_FILENAME = pathinfo($_SERVER['SCRIPT_FILENAME'], PATHINFO_BASENAME);
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php
    /*
    ก่อน echo ค่าของตัวแปรใดใดก็ตามที่ไม่แน่ใจว่าค่าของมันจะเป็นอะไรกันแน่ ออกมาเป็นส่วนหนึ่งของ HTML
    และไม่ต้องการให้ค่าเหล่านั้นมีความหมายพิเศษ เช่น เราอยากแสดงผลคำว่า '<div>'
    แต่หากเรา echo มันออกมาตรงๆ browser ก็จะมองว่ามันเป็น tag <div> ไม่ใช่ข้อความ '<div>'
    ดังนั้นเราจึงจำเป็นต้อง escape ตัวอักษรพิเศษ < > & " '
    ที่อาจจะมีอยู่ในค่าของตัวแปรให้เป็น html entity เสียก่อน ด้วยฟังก์ชั่น htmlspecialchars()
    เช่น <div> ก็จะกลายเป็น &lt;div&gt;
    */
    echo htmlspecialchars($TITLE, ENT_QUOTES, 'UTF-8');
    ?>
  </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css" title="currentStyle">
        @import "bootstrap-3.3.6-dist/css/bootstrap.min.css";
        @import "bootstrap-3.3.6-dist/css/dataTables.bootstrap4.min.css";
        @import "bootstrap-3.3.6-dist/font-awesome-4.7.0/css/font-awesome.min.css";
</style>

<script src="bootstrap-3.3.6-dist/js/jquery.min.js"></script>
<script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>

<script type="text/javascript" language="javascript" src="bootstrap-3.3.6-dist/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="bootstrap-3.3.6-dist/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function()
{
$('#example').dataTable({
"bJQueryUI": true,
"oLanguage": {
    "sUrl": "bootstrap-3.3.6-dist/thai.txt",
},
"sPaginationType": "full_numbers"
});


});

</script>
  </head>
  <body>
    <div class="container">
      <?php include "nav_manu.php"; ?>
      <br>
      <?php
      /*
      หากมีตัวแปร $FATAL_ERROR ถูกกำหนดไว้ก่อนหน้า
      แสดงว่ามี error ที่ทำให้ไม่สามารถแสดงผลข้อมูลหน้านั้นได้อย่างถูกต้อง
      เช่น ไม่สามารถเชื่อมต่อฐานข้อมูลได้ หรือผู้ใช้ส่ง id ของกระทู้ที่ไม่มีอยู่จริงมาให้
      เราก็จะแสดงผลข้อความที่กำหนดไว้ใน $FATAL_ERROR
      */
      if (isset($FATAL_ERROR)):
      ?>
      <div class="alert alert-danger">
        <?php
        echo htmlspecialchars($FATAL_ERROR, ENT_QUOTES, 'UTF-8');
        ?>
      </div>
      <?php
      /*
      นอกนั้นจะ require ไฟล์ที่กำหนดไว้ในตัวแปร $PAGE_TEMPLATE
      ซึ่งจะตรวจสอบด้วย isset() ก่อนว่ามีตัวแปรนี้กำหนดไว้หรือไม่
      ถ้าไม่ได้กำหนด ก็จะไม่ require ไฟล์ใดใด และแสดงหน้าเปล่าๆ ที่มีแค่ส่วน navigation
      */
      elseif (isset($PAGE_TEMPLATE)):
        /*
        และไม่ได้ตรวจสอบว่าไฟล์ตามค่าของ $PAGE_TEMPLATE นั้นมีอยู่จริงหรือไม่
        หากไม่มีอยู่จริงก็จะเกิด PHP fatal error และจบการทำงาน
        เพราะ require เป็นคำสั่งที่ต่างจาก include (ซึ่งไม่ได้ใช้ในตัวอย่างนี้)
        จะจบการทำงานทันทีหากหาไฟล์ที่กำหนดไม่เจอ
        */
        require $PAGE_TEMPLATE;
      endif;
      ?>
    </div>
    <?php
    /*
    ตรวจสอบว่ามี key 'REQUEST_TIME_FLOAT' อยู่ใน array $_SERVER หรือไม่
    ซึ่ง $_SERVER['REQUEST_TIME_FLOAT'] จะเป็นเวลาที่ PHP เริ่มต้นทำงาน
    เป็นหน่วย microsecond (1/1000000 วินาที)
    และมีให้ใช้ตั้งแต่ PHP 5.4 เราจึงต้องตรวจสอบการมีอยู่ของมันก่อนใช้งาน
    หากมีตัวแปรนี้อยู่ เราจะแสดงผลเวลาการทำงานของ request นี้ ว่าใช้เวลาไปเท่าไหร่
    โดยเอาค่าจาก microtime(true) ที่จะ return microsecond ปัจจุบันกลับมา
    ไปลบกับ $_SERVER['REQUEST_TIME_FLOAT'] ก็จะได้เวลาที่ request นี้ใช้
    และจัดรูปแบบให้เป็นทศนิยม 4 ตำแหน่งด้วย number_format()
    การจับเวลาเป็นวิธีหนึ่งที่จะบอกเราได้ว่า เราเขียนโปรแกรมได้อย่างมีประสิทธิภาพหรือไม่ในด้านความเร็ว
    */
    if (isset($_SERVER['REQUEST_TIME_FLOAT'])):
    ?>
    <div class="text-center">
      <span class="label label-info">Time: <?php
      echo number_format(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 4);
      ?>s</span>
    </div>
    <?php
    endif;
    ?>
  </body>
</html>
<?php
/*
จบการทำงานเสมอ
ดังนั้น ณ จุดใดก็ตามที่มีการ require หรือ include ไฟล์นี้ ก็มั่นใจได้ว่าจะจบการทำงานแน่นอน
*/
exit;
