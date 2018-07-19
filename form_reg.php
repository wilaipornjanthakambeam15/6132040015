<?php
if(isset($_GET['add'])){ #แสดงค่าที่กด
$q="SELECT * FROM {$prefix}_member WHERE id = '".$_GET['add']."'"; //
$reck = $mysqli->query($q); // ทำการ query คำสั่ง sql
$rsc=$reck->fetch_object();
@$id = $rsc->id;
@$title_id = $rsc->title_id;
@$lname = $rsc->lname;
@$fname = $rsc->fname;
@$email = $rsc->email;
@$tel = $rsc->tel;
@$address = $rsc->address;
@$u_name = $rsc->u_name;
@$u_pass = $rsc->u_pass;
@$u_type = $rsc->u_type;
}

/*
เราใช้ page2.php เป็นทั้งไฟล์ที่ทำการแสดงผลและบันทึกข้อมูลกระทู้ใหม่
ดังนั้นเราจะตรวจสอบว่าการเรียกไฟล์นี้นั้นเป็นการบันทึกหรือไม่ด้วยค่าของตัวแปร $_SERVER['REQUEST_METHOD']
ซึ่งมันจะมีค่าเป็น 'POST' หากมีการ submit มาจาก <form> ที่มี method="post"
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  /*
  ตรวจสอบให้แน่ชัดว่ามีข้อมูลที่จำเป็นส่งมาครบหรือไม่ด้วย isset()
  ซึ่งจะเป็นจริงหากใน $_POST มี key ที่ต้องการครบ
  */
  if (!isset($_POST['title_id'], $_POST['lname'], $_POST['fname'] ,$_POST['email'] ,$_POST['tel'] ,$_POST['address'] ,$_POST['u_name'] ,$_POST['u_pass'])) {
    /*
    หากไม่ครบก็ให้ redirect ไปที่ index.php?form_reg=form_reg&add=add
    */
    header('Location: index.php?url=form_reg&add=add');
    exit;
  }
  /*
     กำหนดสีแสดงข้อความที่ไม่ได้กรอกข้อมูลมา
  */
  $color = "danger";
  /*
  เราจะ copy $_POST มาไว้ในตัวแปร $DATA
  ด้วยเหตุผลที่ว่าเราจะไม่เปลี่ยนแปลงค่าของ $_POST โดยตรง
  และเพื่อให้เป็นแนวทางเดียวกันกับทุกตัวแปรที่จะส่งไปยัง template
  */

  $DATA = $_POST;
  /*
  ทำการ trim() (ตัดช่องว่างหน้าและหลัง) ของข้อมูลใน $DATA ทุกตัว
  */
  foreach ($DATA as $key => $value) {
    $DATA[$key] = trim($value);
  }
  /*
  ตรวจสอบว่า $DATA['title_id'] เป็นค่าว่างหรือไม่
  จะเห็นว่าเราใช้ === เปรียบเทียบกับ empty string โดยไม่ใช้ empty() หรือ !$DATA['title_id']
  เพราะการเปรียบเทียบด้วยวิธีหลังเป็นการเปรียบเทียบแบบ loose คือมันจะเป็นจริงได้ในหลายกรณีเกินไป
  เช่น เมื่อ $DATA['title_id'] มีค่าเท่ากับ string '0' ซึ่งไม่ตรงความต้องการของเราแน่ๆ
  */
  if ($DATA['title_id'] === '') {
    /*
    กำหนดค่าให้กับตัวแปร $FORM_ERRORS เพื่อนำไปใช้ใน inc/form_errors.inc.php ต่อไป
    */
    $FORM_ERRORS['title_id'] = "กรุณาระบุ 'คำนำหน้าชื่อ'";
  }
  /*
  และตรวจสอบความยาวของ $DATA['title_id'] ว่ามีความยาวมากกว่าที่กำหนดหรือไม่
  ด้วย mb_strlen() ซึ่งเราไม่ใช้ strlen()
  เพราะว่า strlen() จะตรวจจำนวน byte ไม่ใช่จำนวนตัวอักษร
  ซึ่งปัจจุบันเราใช้ encoding ชนิด UTF-8 เป็นหลัก ตัวอักษร 1 ตัวอาจจะมีความยาวมากกว่า 1 byte
  อย่างภาษาไทย ทุกตัวอักษรจะมีขนาด 3 bytes
  */
  elseif (mb_strlen($DATA['title_id'], 'UTF-8') > 255) {
    $FORM_ERRORS['title_id'] = "'คำนำหน้าชื่อ' ต้องมีความยาวไม่เกิน 255 ตัวอักษร";
  }
  /*
  ทำการตรวจสอบกับข้อมูลอื่นๆ เช่นเดียวกัน
  */
  if ($DATA['lname'] === '') {
    $FORM_ERRORS['lname'] = "กรุณาระบุ 'ชื่อ'";
  } elseif (mb_strlen($DATA['lname'], 'UTF-8') > 65535) {
    $FORM_ERRORS['lname'] = "'ชื่อ' ต้องมีความยาวไม่เกิน 65535 ตัวอักษร";
  }

  if ($DATA['fname'] === '') {
    $FORM_ERRORS['fname'] = "กรุณาระบุ 'นามสกุล'";
  } elseif (mb_strlen($DATA['fname'], 'UTF-8') > 64) {
    $FORM_ERRORS['fname'] = "'นามสกุล' ต้องมีความยาวไม่เกิน 64 ตัวอักษร";
  }
  
    if ($DATA['email'] === '') {
    $FORM_ERRORS['email'] = "กรุณาระบุ 'อีเมลล์'";
  } elseif (mb_strlen($DATA['email'], 'UTF-8') > 64) {
    $FORM_ERRORS['email'] = "'อีเมลล์' ต้องมีความยาวไม่เกิน 64 ตัวอักษร";
  }

      if ($DATA['tel'] === '') {
    $FORM_ERRORS['tel'] = "กรุณาระบุ 'เบอร์โทร'";
  } elseif (mb_strlen($DATA['tel'], 'UTF-8') > 64) {
    $FORM_ERRORS['tel'] = "'เบอร์โทร' ต้องมีความยาวไม่เกิน 64 ตัวอักษร";
  }
  
    if ($DATA['address'] === '') {
    $FORM_ERRORS['address'] = "กรุณาระบุ 'ที่อยู่'";
  } elseif (mb_strlen($DATA['address'], 'UTF-8') > 64) {
    $FORM_ERRORS['address'] = "'ที่อยู่' ต้องมีความยาวไม่เกิน 64 ตัวอักษร";
  }

    if ($DATA['u_name'] === '') {
    $FORM_ERRORS['u_name'] = "กรุณาระบุ 'ชื่อในระบบ'";
  } elseif (mb_strlen($DATA['u_name'], 'UTF-8') > 64) {
    $FORM_ERRORS['u_name'] = "'ชื่อในระบบ' ต้องมีความยาวไม่เกิน 64 ตัวอักษร";
  }

    if ($DATA['u_pass'] === '') {
    $FORM_ERRORS['u_pass'] = "กรุณาระบุ 'รหัสผ่านในระบบ'";
  } elseif (mb_strlen($DATA['u_pass'], 'UTF-8') > 64) {
    $FORM_ERRORS['u_pass'] = "'รหัสผ่านในระบบ' ต้องมีความยาวไม่เกิน 64 ตัวอักษร";
  }
  
  /*
  ถ้าไม่มีตัวแปร $FORM_ERRORS ถูกสร้างขึ้นมาจากการตรวจสอบข้างต้น แสดงว่าไม่มี error
  ข้อมูลทั้งหมดสามารถ INSERT เข้าฐานข้อมูลได้อย่างปลอดภัย
  */
  if (!isset($FORM_ERRORS)) {
    /*
    ทำการเชื่อมต่อกับฐานข้อมูล ดู (inc/mysqli.inc.php)
    ซึ่งเราไม่จำเป็นต้องเชื่อมต่อตั้งแต่แรกเพราะยังไม่จำเป็นต้องใช้จนกว่าจะแน่ใจว่าข้อมูลนั้นถูกต้องทั้งหมด
    */
    require 'inc/mysqli.inc.php';
    /*
    ส่ง SQL query ไปยัง MySQL Server ด้วย mysqli::query()
    โดยเราจะ escape ข้อมูลที่มาจากภายนอกทั้งหมดด้วย mysqli::escape_string()
    โดยใช้ฟังก์ชั่น sprintf() ช่วย ดู (inc/main.inc.php สำหรับ sprintf())
    */
if($_GET['add']=="add"){ #แสดงค่าที่กด
    $mysqli->query(
      /*
      mysqli::escape_string() จะแปลงตัวอักษรพิเศษ เช่น ' ให้เป็น \' หรือ ''
      ซึ่งทำให้ MySQL Server รู้ว่ามันเป็นข้อมูล ไม่ใช่ delimeter
      หากเราไม่ใช้ mysqli::escape_string() และผ่านข้อมูลไปเป็น SQL query โดยตรง
      อาจจะทำให้เกิด error หรือ SQL Injection ขึ้นได้
      และนี่คือข้อดีของการใช้ mysqli ในแบบ OOP คือจะเห็นว่าเราสามารถแทนที่
      $mysqli->escape_string() ลงไปใน double quote string ได้เลย
      แต่ถ้าเราใช้ mysqli_escape_string() ที่เป็น procedural style
      จะไม่สามารถทำแบบนี้ได้
      */
      "
      INSERT INTO {$prefix}_member
      (
        title_id,
        lname,
        fname,
		email,
		tel,
		address,
		u_name,
		u_pass,
		u_type
      )
      VALUES
      (
        '{$mysqli->escape_string($DATA['title_id'])}',
        '{$mysqli->escape_string($DATA['lname'])}',
        '{$mysqli->escape_string($DATA['fname'])}',
		'{$mysqli->escape_string($DATA['email'])}',
		'{$mysqli->escape_string($DATA['tel'])}',
		'{$mysqli->escape_string($DATA['address'])}',
		'{$mysqli->escape_string($DATA['u_name'])}',
		'{$mysqli->escape_string($DATA['u_pass'])}',
		'{$mysqli->escape_string($DATA['u_type'])}'
      )
      "
    );

    $FORM_ERRORS['add'] = "ได้ทำการบันทึกข้อมูลเรียบร้อย";
    $color = "info";
    echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"5; URL=?url=$_GET[url]\">\n";
    }else{
      #echo "ทำการแก้ไขข้อมูล";
    /*  ทำการ UPDATE กระทู้
    โดยให้เวลาเพื่อให้กระทู้ย้ายขึ้นมาบนสุด
    และเพิ่มจำนวนความเห็น (num_comments)
    และกำหนดชื่อผู้แสดงความเห็นล่าสุด (last_commented_name) เป็น $DATA['name']
    */
    $mysqli->query(
      "
      UPDATE {$prefix}_member
      SET
		title_id = '{$mysqli->escape_string($DATA['title_id'])}',
        lname    = '{$mysqli->escape_string($DATA['lname'])}',
        fname    = '{$mysqli->escape_string($DATA['fname'])}',
		email    = '{$mysqli->escape_string($DATA['email'])}',
		tel      = '{$mysqli->escape_string($DATA['tel'])}',
		address  = '{$mysqli->escape_string($DATA['address'])}',
		u_name   = '{$mysqli->escape_string($DATA['u_name'])}',
		u_pass   = '{$mysqli->escape_string($DATA['u_pass'])}',
		u_type   = '{$mysqli->escape_string($DATA['u_type'])}'
      WHERE id = {$id}
      "
    );
    $FORM_ERRORS['update'] = "ได้ทำการแก้ไขข้อมูลเรียบร้อย";
    $color = "info";
    echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"5; URL=?url=$_GET[url]\">\n";

    }
    /*
    redirect ไปยัง index.php โดยส่ง query string ชื่อ highlight_id
    ที่มีค่าเป็น id ของแถวที่เพิ่ง INSERT เข้าไปในตาราง topic ไปด้วย
    เพื่อใช้เน้นสีพื้นหลังของกระทู้ใหม่ (ดู inc/index.inc.php)
    */
    #header('Location: index.php?highlight_id=' . $mysqli->insert_id);

    /*กระโดดไปยังตำแน่งที่ต้องการ      */
    #echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"5; URL=?url=$_GET[url]\">\n";
    /*
    จบการทำงาน
    */
    #exit;
  }
  /*
  หากมี error ก็จะแสดงผลให้ผู้ใช้แก้ไขข้อมูลให้ถูกต้อง
  */
} else {
  /*
  หากไม่ใช่การ POST ก็ให้กำหนดค่า default สำหรับ $DATA ซึ่งจะถูกใช้งานใน inc/page2.php
  โดยให้เป็นค่าว่างทั้งหมด
  */
  @$DATA = array(
    'title_id' => $title_id,
    'lname'    => $lname,
    'fname'    => $fname,
	'email'    => $email,
	'tel'      => $tel,
	'address'  => $address,
	'u_name'   => $u_name,
	'u_pass'   => $u_pass,
	'u_type'   => $u_type
  );
}
$TAGS = array('PHP', 'JavaScript', 'SQL', 'HTML', 'CSS');
/*
บอก template/template.php ให้ require ไฟล์ inc/page2.php เป็น template
*/

?>

<?php if(isset($_GET['add'])){ #แสดงค่าที่กด ?>

<?php
/********** เริ่ม FORM ตั้งกระทู้ใหม่ **********/
/*
โดย form นี้จะใช้ method POST ในการส่งข้อมูลไปยัง page2.php
ข้อมูลที่จะส่งให้กับ page2.php ก็ได้แก่
title_id เป็น input type=text
lname เป็น textarea
และ name เป็น input type=text
*/
?>


<?php echo pageex;?>

<form action="?url=form_reg&add=<?=$_GET['add']?>" method="post" class="form-horizontal panel panel-default">
  <div class="panel-heading">
    <h4>
      <span class="glyphicon glyphicon-pencil"></span>
      <?php echo page1;?>
    </h4>
  </div>
  <div class="panel-body">
    <?php
    /*
    แสดง errors (ถ้ามี)
    ดูคำอธิบายใน inc/form_errors.inc.php
    */
    require 'inc/message_errors.inc.php';
    ?>
    
	<div class="form-group <?php
    /*
    ถ้ามี key ชื่อ 'title_id' อยู่ใน array $FORM_ERRORS
    ให้เพิ่ม class 'has-error' เข้าไปใน <div> นี้
    */
    if (isset($FORM_ERRORS['title_id'])) {
      echo 'has-error';
    }
    ?>">
      <label for="title_idInput" class="col-sm-4 control-label">*คำนำหน้าชื่อ</label>
      <div class="col-sm-4">
        <input
          type="text"
          id="title_id"
          name="title_id"
          value="<?php
          echo htmlspecialchars($DATA['title_id'], ENT_QUOTES, 'UTF-8');
          ?>"
          placeholder="คำนำหน้าชื่อ"
          spellcheck="false"
          class="form-control"
        >
      </div>
    </div>
	
	<div class="form-group <?php
    /*
    ถ้ามี key ชื่อ 'lname' อยู่ใน array $FORM_ERRORS
    ให้เพิ่ม class 'has-error' เข้าไปใน <div> นี้
    */
    if (isset($FORM_ERRORS['lname'])) {
      echo 'has-error';
    }
    ?>">
      <label for="lnameInput" class="col-sm-4 control-label">*ชื่อ</label>
      <div class="col-sm-4">
        <input
          type="text"
          id="lname"
          name="lname"
          value="<?php
          echo htmlspecialchars($DATA['lname'], ENT_QUOTES, 'UTF-8');
          ?>"
          placeholder="ชื่อ"
          spellcheck="false"
          class="form-control"
        >
      </div>
    </div>
	
	<div class="form-group <?php
    /*
    ถ้ามี key ชื่อ 'fname' อยู่ใน array $FORM_ERRORS
    ให้เพิ่ม class 'has-error' เข้าไปใน <div> นี้
    */
    if (isset($FORM_ERRORS['fname'])) {
      echo 'has-error';
    }
    ?>">
      <label for="fnameInput" class="col-sm-4 control-label">*นามสกุล</label>
      <div class="col-sm-4">
        <input
          type="text"
          id="fname"
          name="fname"
          value="<?php
          echo htmlspecialchars($DATA['fname'], ENT_QUOTES, 'UTF-8');
          ?>"
          placeholder="นามสกุล"
          spellcheck="false"
          class="form-control"
        >
      </div>
    </div>
	
	<div class="form-group <?php
    /*
    ถ้ามี key ชื่อ 'email' อยู่ใน array $FORM_ERRORS
    ให้เพิ่ม class 'has-error' เข้าไปใน <div> นี้
    */
    if (isset($FORM_ERRORS['email'])) {
      echo 'has-error';
    }
    ?>">
      <label for="emailInput" class="col-sm-4 control-label">*อีเมลล์</label>
      <div class="col-sm-4">
        <input
          type="text"
          id="email"
          name="email"
          value="<?php
          echo htmlspecialchars($DATA['email'], ENT_QUOTES, 'UTF-8');
          ?>"
          placeholder="อีเมลล์"
          spellcheck="false"
          class="form-control"
        >
      </div>
    </div>
	
	
	<div class="form-group <?php
    /*
    ถ้ามี key ชื่อ 'tel' อยู่ใน array $FORM_ERRORS
    ให้เพิ่ม class 'has-error' เข้าไปใน <div> นี้
    */
    if (isset($FORM_ERRORS['tel'])) {
      echo 'has-error';
    }
    ?>">
      <label for="telInput" class="col-sm-4 control-label">*เบอร์โทร</label>
      <div class="col-sm-4">
        <input
          type="text"
          id="tel"
          name="tel"
          value="<?php
          echo htmlspecialchars($DATA['tel'], ENT_QUOTES, 'UTF-8');
          ?>"
          placeholder="เบอร์โทร"
          spellcheck="false"
          class="form-control"
        >
      </div>
    </div>
    <div class="form-group <?php
    /*
    ถ้ามี key ชื่อ 'address' อยู่ใน array $FORM_ERRORS
    ให้เพิ่ม class 'has-error' เข้าไปใน <div> นี้
    */
    if (isset($FORM_ERRORS['address'])) {
      echo 'has-error';
    }
    ?>">
      <label for="addressInput" class="col-sm-4 control-label">*ที่อยู่</label>
      <div class="col-sm-4">
        <textarea
             id="address"
             name="address"
             rows="5"
             placeholder="ที่อยู๋"
             spellcheck="false"
             class="form-control"
           ><?php
           echo htmlspecialchars($DATA['address'], ENT_QUOTES, 'UTF-8');
           ?></textarea>
      </div>
    </div>
    <div class="form-group <?php
    /*
    ถ้ามี key ชื่อ 'u_name' อยู่ใน array $FORM_ERRORS
    ให้เพิ่ม class 'has-error' เข้าไปใน <div> นี้
    */
    if (isset($FORM_ERRORS['u_name'])) {
      echo 'has-error';
    }
    ?>">
      <label for="u_nameInput" class="col-sm-4 control-label">*ชื่อผู้เข้าใช้ระบบ</label>
      <div class="col-sm-4">
        <input
          type="text"
          id="u_name"
          name="u_name"
          value="<?php
          echo htmlspecialchars($DATA['u_name'], ENT_QUOTES, 'UTF-8');
          ?>"
          placeholder="ชื่อผู้เข้าใช้ระบบ"
          spellcheck="false"
          class="form-control"
        >
      </div>
    </div>
	
	
	<div class="form-group <?php
    /*
    ถ้ามี key ชื่อ 'u_pass' อยู่ใน array $FORM_ERRORS
    ให้เพิ่ม class 'has-error' เข้าไปใน <div> นี้
    */
    if (isset($FORM_ERRORS['u_pass'])) {
      echo 'has-error';
    }
    ?>">
      <label for="u_passInput" class="col-sm-4 control-label">*รหัสผ่าน</label>
      <div class="col-sm-4">
        <input
          type="password"
          id="u_pass"
          name="u_pass"
          value="<?php
          echo htmlspecialchars($DATA['u_pass'], ENT_QUOTES, 'UTF-8');
          ?>"
          placeholder="รหัสผ่าน"
          spellcheck="false"
          class="form-control"
        >
      </div>
    </div>
	
    <input
          type="hidden"
          id="u_type"
          name="u_type"
          value="user"
        >
	
	<hr>
	         <div class="form-group">
        <div class="col-sm-2 col-sm-offset-4">
           <button type="submit" class="btn btn-primary btn-block">
		<?php if($_GET['add']=="add"){ #แสดงค่าที่กด?>
			เพิ่มสมาชิกใหม่
		<?php }else{?>
			ทำการแก้ไข
		  <?php }?>
        </button>

        </div>
        <div class="col-sm-2">
          <a class="btn btn-primary btn-block" href="?url=form_title">
            ยกเลิกการลบ
          </a>
        </div>
      </div>
  </div>
</form>
<?php
/********** จบ FORM แสดงความเห็น **********/
?>

<?php }else if(isset($_GET['del'])){ ?>
  <?php
  $q="SELECT * FROM {$prefix}_member WHERE id = '".$_GET['del']."'"; //
  $reck = $mysqli->query($q); // ทำการ query คำสั่ง sql
  $rsc=$reck->fetch_object();
  #print_r($rsc);
  @$DATA['id'] = $rsc->id;
  @$DATA['title_id'] = $rsc->title_id;
  @$DATA['lname'] = $rsc->lname;
  @$DATA['fname'] = $rsc->fname;

  if(isset($_GET['delete'])){ #แสดงค่าที่กด
      $mysqli->query("DELETE FROM {$prefix}_member
  			WHERE id = {$_GET['delete']}
        "
      );
      #
      $FORM_ERRORS['del'] = "ได้ทำการลบข้อมูลเรียบร้อย";
      $color = "danger";
    echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"5; URL=?url=$_GET[url]\">\n";
  }
?>

<?php echo pageex;?>

  <form class="form-horizontal panel panel-default">
    <div class="panel-heading">
      <h4>
        <span class="glyphicon glyphicon-pencil"></span>
          <?php echo form_reg;?>
      </h4>
    </div>
    <div class="panel-body">
      <?php
      /*
      แสดง errors (ถ้ามี)
      ดูคำอธิบายใน inc/form_errors.inc.php
      */
      require 'inc/message_errors.inc.php';
      ?>
      <div class="form-group <?php
      /*
      ถ้ามี key ชื่อ 'title_id' อยู่ใน array $FORM_ERRORS
      ให้เพิ่ม class 'has-error' เข้าไปใน <div> นี้
      */
      if (isset($FORM_ERRORS['title_id'])) {
        echo 'has-error';
      }
      ?>">
        <label for="title_idInput" class="col-sm-4 control-label">*หัวข้อเรื่อง</label>
        <div class="col-sm-4">
          <input
            type="text"
            id="title_idInput"
            name="title_id"
            value="<?php
            echo htmlspecialchars($DATA['title_id'], ENT_QUOTES, 'UTF-8');
            ?>"
            placeholder="หัวข้อเรื่อง"
            spellcheck="false"
            class="form-control"
            disabled
          >
        </div>
      </div>
      <div class="form-group <?php
      /*
      ถ้ามี key ชื่อ 'lname' อยู่ใน array $FORM_ERRORS
      ให้เพิ่ม class 'has-error' เข้าไปใน <div> นี้
      */
      if (isset($FORM_ERRORS['lname'])) {
        echo 'has-error';
      }
      ?>">
        <label for="lnameInput" class="col-sm-4 control-label">*ฃรายละเอียด</label>
        <div class="col-sm-4">
          <textarea
               id="lname"
               name="lname"
               rows="5"
               placeholder="รายละเอียด"
               spellcheck="false"
               class="form-control"
               disabled
             ><?php
             echo htmlspecialchars($DATA['lname'], ENT_QUOTES, 'UTF-8');
             ?></textarea>
        </div>
      </div>
      <div class="form-group <?php
      /*
      ถ้ามี key ชื่อ 'fname' อยู่ใน array $FORM_ERRORS
      ให้เพิ่ม class 'has-error' เข้าไปใน <div> นี้
      */
      if (isset($FORM_ERRORS['fname'])) {
        echo 'has-error';
      }
      ?>">
        <label for="nameInput" class="col-sm-4 control-label">*ชื่อ-นามสกุล</label>
        <div class="col-sm-4">
          <input
            type="text"
            id="fnameInput"
            name="fname"
            value="<?php
            echo htmlspecialchars($DATA['fname'], ENT_QUOTES, 'UTF-8');
            ?>"
            placeholder="ชื่อ-นามสกุล"
            spellcheck="false"
            class="form-control"
            disabled
          >
        </div>
      </div>
      <hr>
      <div class="form-group">
        <div class="col-sm-2 col-sm-offset-4">
          <a class="btn btn-primary btn-block" href="?url=form_reg&del=<?php echo $DATA['id'];?>&delete=<?php echo $DATA['id'];?>">ทำการลบ</a>

        </div>
        <div class="col-sm-2">
          <a class="btn btn-primary btn-block" href="?url=form_reg">
            ยกเลิกการลบ
          </a>
        </div>
      </div>
    </div>
  </form>
<?php }else { #แสดงค่าที่ยังไม่ได้กด ?>

<?php
$i=1;
$q="SELECT * FROM {$prefix}_member ORDER BY id DESC"; //
$result = $mysqli->query($q); // ทำการ query คำสั่ง sql
$total=$result->num_rows;  // นับจำนวนถวที่แสดง ทั้งหมด
?>

           <div class="container" style="width:100%;">
                <h3 align="center"><?php echo pageex;?></h3>
                <br />
                <div class="table-responsive">
                     <div align="right">
                       <a class="btn btn-info btn-xs add_data" href="?url=form_reg&add=add">เพิ่ม</a>

                     </div>
                     <br />
                     <div id="title_id_table">
                  <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>หัวข้อ</th>
                <th>รายละเอียด</th>
                <th>ผู้เขียน</th>
                <th>แสดง</th>
            </tr>
        </thead>
        <tbody>
		<?php  $n=1;    while($rs=$result->fetch_object()){ // วนลูปแสดงข้อมูล   ?>
            <tr>
			<td><?php echo $n++; ?></td>
                <td><?php echo $rs->title_id; ?></td>
                <td><?php echo $rs->lname; ?></td>
                <td><?php echo $rs->fname; ?></td>
                <td>
        <a class="btn btn-info btn-xs edit_data" href="?url=form_reg&add=<?php echo $rs->id; ?>">แก้ไข</a>
        <a class="btn btn-info btn-xs del_data" href="?url=form_reg&del=<?php echo $rs->id; ?>">ลบ</a>

				</td>
            </tr>
			<?php  }  ?>
        </tbody>
        <tfoot>
            <tr>
                <th>#</th>
                <th>หัวข้อ</th>
                <th>รายละเอียด</th>
                <th>ผู้เขียน</th>
                <th>แสดง</th>
            </tr>
        </tfoot>
    </table>
                     </div>
                </div>
           </div>
<!-- จบฟอร์มแสดงข้อมูล-->

<?php } ?>


<div id="dataModal" class="modal fade" data-backdrop="false" role="dialog">
     <div class="modal-dialog">
          <div class="modal-content">
               <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title_id">รายละเอียดพนักงาน</h4>
               </div>
               <div class="modal-body" id="title_id_detail">
               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
               </div>
          </div>
     </div>
</div>

<div id="add_data_Modal" class="modal fade" data-backdrop="false" role="dialog">
     <div class="modal-dialog">
          <div class="modal-content">
               <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title_id">PHP Ajax Update MySQL Data Through Bootstrap Modal</h4>
               </div>
               <div class="modal-body">
                    <form method="post" id="insert_form">
                      <div class="form-group <?php
                      /*
                      ถ้ามี key ชื่อ 'title_id' อยู่ใน array $FORM_ERRORS
                      ให้เพิ่ม class 'has-error' เข้าไปใน <div> นี้
                      */
                      if (isset($FORM_ERRORS['title_id'])) {
                        echo 'has-error';
                      }
                      ?>">
                         <label>*หัวข้อ</label>
                         <input
                                type="text"
                                id="title_id"
                                name="title_id"
                                value="<?php
                                echo htmlspecialchars($DATA['title_id'], ENT_QUOTES, 'UTF-8');
                                ?>"
                                placeholder="หัวข้อ"
                                spellcheck="false"
                                class="form-control"
                              >
                            </div>
                            <div class="form-group <?php
                            /*
                            ถ้ามี key ชื่อ 'title_id' อยู่ใน array $FORM_ERRORS
                            ให้เพิ่ม class 'has-error' เข้าไปใน <div> นี้
                            */
                            if (isset($FORM_ERRORS['lname'])) {
                              echo 'has-error';
                            }
                            ?>">
                               <label>*รายละเอียด</label>
                               <textarea
                                    id="lname"
                                    name="lname"
                                    rows="5"
                                    placeholder="รายละเอียด"
                                    spellcheck="false"
                                    class="form-control"
                                  ><?php
                                  echo htmlspecialchars($DATA['lname'], ENT_QUOTES, 'UTF-8');
                                  ?></textarea>
                                  </div>

                                  <div class="form-group <?php
                                  /*
                                  ถ้ามี key ชื่อ 'title_id' อยู่ใน array $FORM_ERRORS
                                  ให้เพิ่ม class 'has-error' เข้าไปใน <div> นี้
                                  */
                                  if (isset($FORM_ERRORS['name'])) {
                                    echo 'has-error';
                                  }
                                  ?>">
                                     <label>*ชื่อ</label>
                                     <input
                                            type="text"
                                            id="name"
                                            name="name"
                                            value="<?php
                                            echo htmlspecialchars($DATA['name'], ENT_QUOTES, 'UTF-8');
                                            ?>"
                                            placeholder="ชื่อ"
                                            spellcheck="false"
                                            class="form-control"
                                          >
                                        </div>
                         <input type="hidden" name="work01_id" id="work01_id" />

               </div>
               <div class="modal-footer">
               <input type="submit" name="insert" id="insert" value="บันทึก" class="btn btn-success" />
                    </form>
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
               </div>
          </div>
     </div>
</div>
<hr>
