<?php

define('DB_DATABASE', '');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
define('PDO_DSN','' . DB_DATABASE);

try{

 if(isset( $_REQUEST[ "user_id" ]) && isset($_REQUEST[ "event_num" ]) && isset($_REQUEST[ "task_num" ])){

  $USE = (int)$_REQUEST[ "user_id" ];
  $EVE = (int)$_REQUEST[ "event_num" ];
  $TAS = (int)$_REQUEST[ "task_num" ];

 }else{
  echo "error";
  exit;
 }

  $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sth = $db->prepare("UPDATE demo_summary SET naiyo = NULL where user_id = $USE AND event_num = $EVE AND task_num = $TAS");

  $sth->execute();
  echo "insert";

  $db = null;

}catch(PDOException $e){
 echo $e->getMessage();
 exit;
}