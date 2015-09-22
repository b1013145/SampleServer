<?php

define('DB_DATABASE', '');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
define('PDO_DSN','' . DB_DATABASE);

try{

 if(isset( $_REQUEST['event_num'] ) && isset( $_REQUEST['user_id'] ) && isset( $_REQUEST['answer'] )){
  $Event = (int)$_REQUEST['event_num'];
  $User = (int)$_REQUEST['user_id'];
  $Ans = (int)$_REQUEST['answer'];
 }else{
  echo "error";
  exit;
 }

  $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
 );

  $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD, $options);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if($Ans == 1){

  $sth = $db->prepare("UPDATE demo_summary SET joining = 1 WHERE user_id = $User AND event_num = $Event");
  $sth->execute();

  echo "join";

 }else{

  $sth1 = $db->prepare("DELETE FROM demo_summary WHERE user_id = $User AND event_num = $Event");
  $sth1->execute();

  echo "delete";

 }

  $db = null;

}catch(PDOException $e){
 echo $e->getMessage();
 exit;
}