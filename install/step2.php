<?php
if (defined('ROOT_PATH')) {
  $database = include('settings/database.php');
  $db_username = isset($_SESSION['db_username']) ? $_SESSION['db_username'] : $database['mysqli']['username'];
  $db_password = isset($_SESSION['db_password']) ? $_SESSION['db_password'] : $database['mysqli']['password'];
  $db_server = isset($_SESSION['db_server']) ? $_SESSION['db_server'] : 'localhost';
  $db_name = isset($_SESSION['db_name']) ? $_SESSION['db_name'] : $database['mysqli']['dbname'];
  $prefix = isset($_SESSION['prefix']) ? $_SESSION['prefix'] : $database['mysqli']['prefix'];
  ?>
  
  <form class="form-horizontal" method="post" action="index.php" autocomplete="off">
  <h2>ค่ากำหนดของฐานข้อมูล</h2>
  <p>คุณจะต้องระบุข้อมูลการเชื่อมต่อที่ถูกต้องด้านล่างเพื่อเริ่มดำเนินการติดตั้งฐานข้อมูล</p>
  
  <div class="form-group">
    <label for="db_username" class="col-sm-3 control-label">ชื่อผู้ใช้</label>
    <div class="col-sm-4"> 
      <input type="text" id="db_username" name="db_username" value="<?=$db_username?>" placeholder="ชื่อผู้ใช้" class="form-control">
	</div><p class="comment">ชื่อผู้ใช้ของ MySQL ของคุณ</p>
  </div>

  <div class="form-group">
    <label for="db_password" class="col-sm-3 control-label">รหัสผ่าน</label>
    <div class="col-sm-4">
      <input type="text" id="db_password" name="db_password" value="<?=$db_password?>" placeholder="รหัสผ่าน" class="form-control">
    </div>
	<p class="comment">รหัสผ่านของ MySQL ของคุณ</p>
  </div>
  
    <div class="form-group">
    <label for="db_server" class="col-sm-3 control-label">โฮสท์ของฐานข้อมูล</label>
    <div class="col-sm-4">
      <input type="text" id="db_server" name="db_server" value="<?=$db_server?>" placeholder="โฮสท์ของฐานข้อมูล" class="form-control">
    </div>
	<p class=comment>ดาตาเบสเซิร์ฟเวอร์ของคุณ (โฮสท์ส่วนใหญ่ใช้ localhost)</p>
   </div>

    <div class="form-group">
    <label for="db_name" class="col-sm-3 control-label">ชื่อฐานข้อมูล</label>
    <div class="col-sm-4">
      <input type="text" id="db_name" name="db_name" value="<?=$db_name?>" placeholder="ชื่อฐานข้อมูล" class="form-control">
    </div>
	<p class=comment>ชื่อฐานข้อมูลที่ใช้ในการติดตั้งโปรแกรม</p>
   </div>
    <div class="form-group">
    <label for="prefix" class="col-sm-3 control-label">คำนำหน้าตาราง</label>
    <div class="col-sm-4">
      <input type="text" id="prefix" name="prefix" value="<?=$prefix?>" placeholder="คำนำหน้าตาราง" class="form-control">
    </div>
	<p class=comment>คำนำหน้าตารางที่ใช้ในการติดตั้งโปรแกรม</p>
   </div>
   <input type="hidden" name="step" value="3">
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-10">
	<button type="submit" class="btn btn-primary large save"> ติดตั้ง  </button>
    </div>
  </div>
</form>

<?php } ?>