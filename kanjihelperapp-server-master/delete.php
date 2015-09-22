<?php

define('DB_DATABASE', '');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
define('PDO_DSN','' . DB_DATABASE);

try{

 if(isset( $_REQUEST['event_num'] )){
  $Event = (int)$_REQUEST['event_num'];
 }else{
  echo "error";
  exit;
 }

  $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
 );

  $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD, $options);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sth = $db->prepare("DELETE FROM demo_summary WHERE event_num = $Event");
  $sth->execute();

  $sth1 = $db->prepare("DELETE FROM detail WHERE event_num = $Event");
  $sth1->execute();

  echo "delete";

  $db = null;

}catch(PDOException $e){
 echo $e->getMessage();
 exit;
}