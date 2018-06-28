          <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">

            <li class="<?php
            /*
            ตรวจว่าขณะนี้ผู้ใช้อยู่ที่หน้าแรกหรือไม่
            */
            if ($PARENT_FILENAME === 'index.php') {
              /*
              ถ้าใช่ ก็ให้เพิ่ม class 'active' เข้าไปใน <li> นี้
              เพื่อเน้นว่าในขณะนี้ ผู้ใช้อยู่ที่หน้านี้
              */
              #echo 'active';
            }
            ?>">
              <a href="index.php">
                <i class="fa fa-home" aria-hidden="true"></i>
                หน้าแรก
              </a>
            </li>

            <li class="<?php
                        /*
                        ทำการตรวจสอบเมนูอื่นเช่นเดียวกัน
                        */
                        if ($PARENT_FILENAME === '?url=ex') {
                          #echo 'active';
                        }
                        ?>">
                          <a href="?url=ex">
                            <i class="fa fa-calendar-o" aria-hidden="true"></i>
                            ตัวอย่าง 
                          </a>
                        </li>
                        
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
     <i class="fa fa-paperclip" aria-hidden="true"></i>         
              แบบอย่าง <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="?url=page1">ตัวอย่างที่ 1</a></li>
                <li><a href="?url=page2">ตัวอย่างที่ 2</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a class="icon-unlock" href="#" data-toggle="modal" data-target="#login"> เข้าสู่ระบบ</a></li>
            <li><a href="../navbar-static-top/">Static top</a></li>
            <li class="active"><a href="./">Fixed top <span class="sr-only">(current)</span></a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
