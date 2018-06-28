<?php
if (defined('ROOT_PATH')) {
  echo '<form method=post action=index.php autocomplete=off>';
  echo '<h2>ตรวจสอบก่อนการติดตั้ง</h2>';
  echo '<p>คุณสามารถเริ่มต้นติดตั้ง ตัวอย่างที่ให้ไป ได้ง่ายๆโดยการตอบคำถามไม่กี่ข้อ เพื่อที่คุณจะได้เป็นเจ้าของระบบที่สมบูรณ์แบบ ที่สร้างสรรค์โดยคน</p>';
  echo '<p>ไทยก่อนอื่น ลอง<b>ตรวจสอบคุณสมบัติต่างๆของ Server</b> ของคุณตามรายการด้านล่าง ต้องเป็น<span class=correct>สีเขียว</span>ทั้งหมด</p>';
  echo '<ul>';
  $v = version_compare(PHP_VERSION, '5.3.0', '>=');
  $check = array(
    ($v ? 'เวอร์ชั่นของ PHP <b>'.PHP_VERSION.'</b>' : 'ต้องการ PHP เวอร์ชั่น <b>5.3.0</b> ขึ้นไป') => $v ? 'correct' : 'incorrect',
    'PDO mysql Support' => defined('PDO::ATTR_DRIVER_NAME') && in_array('mysql', \PDO::getAvailableDrivers()) ? 'correct' : 'incorrect',
    'MB String Support' => extension_loaded('mbstring') ? 'correct' : 'incorrect',
    'Register Globals <b>Off</b>' => ini_get('register_globals') == false ? 'correct' : 'incorrect',
    'Zlib Compression Support' => extension_loaded('zlib') ? 'correct' : 'incorrect',
    'JSON Support' => function_exists('json_encode') && function_exists('json_decode') ? 'correct' : 'incorrect',
    'XML Support' => extension_loaded('xml') ? 'correct' : 'incorrect'
  );
  $error = false;
  foreach ($check as $text => $class) {
    $error = $class == 'incorrect' || $error;
    echo '<li class='.$class.'>'.$text.'</li>';
  }

  if ($error) {
    echo '<p class=warning>Server ของคุณไม่พร้อมสำหรับการติดตั้ง GCMS กรุณาแก้ไขค่าติดตั้งของ Server ที่ถูกทำเครื่องหมาย <span class=incorrect>สีแดง</span> ให้สามารถใช้งานได้ก่อน</p>';
  } else {
    echo '<p>พร้อมแล้วคลิก "ติดตั้ง !" ได้เลย</p>';
    echo '<input type=hidden name=step value=1>';
    #echo '<p><input class="button large save" type=submit value="ติดตั้ง !"></p>';
	echo '<button type="submit" class="btn btn-primary large save"> ติดตั้ง ! </button>';
  }
  echo '</form>';
}