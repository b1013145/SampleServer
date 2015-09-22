<?php

define('DB_DATABASE', '');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
define('PDO_DSN','' . DB_DATABASE);

try{

 if(isset( $_REQUEST['user_id'] ) && isset( $_REQUEST['category_num'] ) ){
  $User = (int)$_REQUEST['user_id'];
  $C_num = (int)$_REQUEST['category_num'];
 }else{
  echo "error";
  exit;
 }

  $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
 );

  $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD, $options);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sth = $db->prepare("UPDATE category_n SET user_id = NULL WHERE user_id = $User AND category_num = $C_num");
  $sth->execute();

echo "delete";

}catch(PDOException $e){
 echo $e->getMessage();
 exit;
}