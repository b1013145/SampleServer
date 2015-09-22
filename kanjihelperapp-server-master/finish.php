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

  $sth = $db->prepare("select * from demo_summary where event_num = $Event AND joining = 1");
  $sth->execute();

  $User;

  while($row = $sth->fetch(PDO::FETCH_ASSOC)){
   $User[]=array(
    'user_id'=>$row['user_id'],
    );
   }

  $sth1 = $db->prepare("DELETE FROM demo_summary WHERE event_num = $Event");
  $sth1->execute();

  $sth2 = $db->prepare("select * from detail where event_num = $Event");
  $sth2->execute();

  $Category;

  while($row2 = $sth2->fetch(PDO::FETCH_ASSOC)){
   $Category[]=array(
    'category_num'=>$row2['category_num'],
    );
   }

  $category = (int)$Category[0]['category_num'];

  $sth3 = $db->prepare("select * from category where category_num = $category");
  $sth3->execute();

  $Task;

  while($row3 = $sth3->fetch(PDO::FETCH_ASSOC)){
   $Task[]=array(
    'task_num'=>$row3['task_num'],
    );
   }

  shuffle($User);

  $count = 0;
  $T_co1 = 1;

  for($s = 0;$s < count($Task);$s++ ){

   if($s > (count($User)-1) ){

   $s = 0;
   $T_co1 = $T_co1 + 1;

   }

   $user = (int)$User[$s]['user_id'];

   $sth4 = $db->prepare("insert into demo_summary(user_id,event_num,task_co) values($user,$Event,$T_co1)");
   $sth4->execute();

   $count = $count + 1;

   if($count == count($Task) ){
   break;
   }
 }

  $count_t = 0;
  $T_co2 = 1;

  for($d = 0;$d < count($Task);$d++){

   if($d > (count($User)-1) ){

   $d = 0;
   $T_co2 = $T_co2 + 1;

   }

   $UIT = (int)$User[$d]['user_id'];
   $TAS2 = (int)$Task[$count_t]['task_num'];

   $sth5 = $db->prepare("UPDATE demo_summary SET task_num = $TAS2 WHERE user_id = $UIT AND event_num = $Event AND task_co = $T_co2");
   $sth5->execute();

   $count_t = $count_t + 1;

   if($count_t == count($Task)){
   break;
   }
 }

  $db = null;

}catch(PDOException $e){
 echo $e->getMessage();
 exit;
}