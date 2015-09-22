<?php

define('DB_DATABASE', '');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
define('PDO_DSN','' . DB_DATABASE);

try{

 if(isset( $_REQUEST['event_name'] ) && isset( $_REQUEST['category_name'] ) && isset( $_REQUEST['twitter_id'] )){
  $Event = (String)$_REQUEST['event_name'];
  $Cate = (String)$_REQUEST['category_name'];
  $Twi = $_REQUEST['twitter_id'];
  $DEC = json_decode($Twi);
 }else{
  echo "error";
  exit;
 }

  $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
 );

  $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD, $options);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sth = $db->prepare("select * from category_n where category_name = '$Cate'");
  $sth->execute();

  $CATEN;

  while($row = $sth->fetch(PDO::FETCH_ASSOC)){
   $CATEN[]=array(
    'category_num'=>$row['category_num'],
    );
   }

  $CateN = (int)$CATEN[0]['category_num'];

  $sth0 = $db->prepare("insert into detail (event_name,category_num) values ('$Event',$CateN)");
  $sth0->execute();

  $sth0_1 = $db->prepare("select * from detail order by event_num desc limit 1");
  $sth0_1->execute();

  $COn;

  while($row0_1 = $sth0_1->fetch(PDO::FETCH_ASSOC)){
   $COn[]=array(
    'event_num'=>$row0_1['event_num'],
    );
   }

  $CON = (int)$COn[0]['event_num'];

  $UI_O;
  $UI_A;

  for($i = 0;$i < count($DEC);$i++ ){
  $TID = (String)$DEC[$i];

  $sth1 = $db->prepare("select * from id_demo where twitter_id = '$TID'");
  $sth1->execute();

  if($i == 0){

  while($row1_1 = $sth1->fetch(PDO::FETCH_ASSOC)){
   $UI_O[]=array(
    'user_id'=>$row1_1['user_id'],
    );
  }

  }else{

  while($row1_2 = $sth1->fetch(PDO::FETCH_ASSOC)){
   $UI_A[]=array(
    'user_id'=>$row1_2['user_id'],
    );
  }

  }
 }

 $UI_orner = (int)$UI_O[0]['user_id'];

 $sth2 = $db->prepare("insert into demo_summary(user_id,event_num,task_co,joining,orner) values($UI_orner,$CON,1,1,1)");
 $sth2->execute();

 for($c = 0;$c < count($UI_A);$c++ ){

 $UI = (int)$UI_A[$c]['user_id'];

 $sth3_0 = $db->prepare("insert into demo_summary(user_id,event_num,task_co,joining,orner) values($UI,$CON,1,0,0)");
 $sth3_0->execute();

 }

  $db = null;


}catch(PDOException $e){
 echo $e->getMessage();
 exit;
}