<?php

define('DB_DATABASE', '');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
define('PDO_DSN','' . DB_DATABASE);

try{

 if(isset( $_GET[ 'twitter_id' ]) && isset( $_GET[ 'user_name' ])){
  $ID = (String)$_GET[ 'twitter_id' ];
  $Name = (String)$_GET[ 'user_name' ];
 }else{
  echo "error";
  exit;
 }

$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

  $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD, $options);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sth = $db->prepare("select count(*) from id_demo where twitter_id = '$ID'");
  $sth->execute();

  $Count;

  while($row = $sth->fetch(PDO::PARAM_INT)){
   $Count[]=array(
    'count'=>$row['count(*)'],
    );
}

  $cont=$Count[0]['count'];
  $count=(int)$cont;

  if($count==0){

  $s = $db->prepare("insert into id_demo (twitter_id,twitter_name) values ('$ID','$Name')");

  $s->execute();

  $st = $db->prepare("select * from id_demo where twitter_id = '$ID'");
  $st->execute();

  while($row = $st->fetch(PDO::FETCH_ASSOC)){
   $UserID[]=array(
    'user_id'=>$row['user_id'],
    );
  }

   $Details[0]=array(
    'event_num'=>NULL,
    'event_name'=>NULL,
    );

   $Orner[0]=array(
    'joining'=>NULL,
    'orner'=>NULL,
    );

   $U_ID = (int)$UserID[0]['user_id'];

$response['user_id'] = $U_ID;
$response['event'] = array(
                'event_num' => 'NULL',
                );

header('Content-Type: text/javascript; charset=utf-8');
header('Content-type: application/json');
echo json_encode($response);

}else{

  $st1 = $db->prepare("select * from id_demo where twitter_id = '$ID'");
  $st1->execute();

  while($row1 = $st1->fetch(PDO::PARAM_INT)){
   $UserID[]=array(
    'user_id'=>$row1['user_id'],
    'twitter_name'=>$row1['twitter_name'],
    );
  }

  $u_ID = $UserID[0]['user_id'];
  $U_ID = (int)$u_ID;

  $TwiName = (String)$UserID[0]['twitter_name'];

  if($TwiName != $Name){

  $sth101 = $db->prepare("UPDATE id_demo SET twitter_name = '$Name' WHERE user_id = $U_ID");
  $sth101->execute();



  }

  $sth100 = $db->prepare("select count(*) from demo_summary where user_id = $U_ID AND task_co = 1");
  $sth100->execute();

  $C;

  while($row100 = $sth100->fetch(PDO::PARAM_INT)){
   $C[]=array(
    'count'=>$row100['count(*)'],
    );
  }

  $Count = (int)$C[0]['count'];

  if($Count == 0){

   $Details[0]=array(
    'event_num'=>NULL,
    'event_name'=>NULL,
    );

   $Orner[0]=array(
    'joining'=>NULL,
    'orner'=>NULL,
    );

   $U_ID = (int)$UserID[0]['user_id'];

$response['user_id'] = $U_ID;
$response['event'] = array(
                'event_num' => 'NULL',
                );

header('Content-Type: text/javascript; charset=utf-8');
header('Content-type: application/json');
echo json_encode($response);

else{

  $st2 = $db->prepare("select * from demo_summary where user_id = $U_ID AND task_co = 1");
  $st2->execute();

  $Detail;
  $Orner;

  while($row2 = $st2->fetch(PDO::FETCH_ASSOC)){
   $Detail[]=array(
    'event_num'=>$row2['event_num'],
    );
   $Orner[]=array(
    'joining'=>$row2['joining'],
    'orner'=>$row2['orner'],
    );
  }

  $Details;

for($i = 0; $i < count($Detail); $i++){

  $even = $Detail[$i]['event_num'];
  $event = (int)$even;

  $st3 = $db->prepare("select * from detail where event_num = $event");
  $st3->execute();

  while($row3 = $st3->fetch(PDO::FETCH_ASSOC)){
   $Details[]=array(
    'event_num'=>$event,
    'event_name'=>$row3['event_name']
    );
  }
}

  $st3 = $db->prepare("select * from detail where event_num = $event");
  $st3->execute();

$response['user_id'] = $U_ID;
$response['event'] = $Details;
$response['orner'] = $Orner;

header('Content-Type: text/javascript; charset=utf-8');
header('Content-type: application/json');
echo json_encode($response);

 }
}

  $db = null;

}catch(PDOException $e){
 echo $e->getMessage();
 exit;
}