<?php
if (defined('ROOT_PATH')) {
  $database = include('settings/database.php');
  $db_username = isset($_SESSION['db_username']) ? $_SESSION['db_username'] : $database['mysql']['username'];
  $db_password = isset($_SESSION['db_password']) ? $_SESSION['db_password'] : $database['mysql']['password'];
  $db_server = isset($_SESSION['db_server']) ? $_SESSION['db_server'] : 'localhost';
  $db_name = isset($_SESSION['db_name']) ? $_SESSION['db_name'] : $database['mysql']['dbname'];
  $prefix = isset($_SESSION['prefix']) ? $_SESSION['prefix'] : $database['mysql']['prefix'];
}
?>