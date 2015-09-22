<?php

define('DB_DATABASE', '');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
define('PDO_DSN','' . DB_DATABASE);

try{

 if(isset( $_GET[ 'event_num' ])){
  $Num = (int)$_GET[ 'event_num' ];
 }else{
  $Num = 0;
 }

$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

  $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD, $options);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $exe = $db->prepare("select * from demo_summary where event_num = $Num");
  $exe->execute();

  $Sum;

  while($row_ex = $exe->fetch(PDO::FETCH_ASSOC)){
   $Sum[]=array(
    'user_id'=>$row_ex['user_id'],
    'task_num'=>$row_ex['task_num'],
    'naiyo'=>$row_ex['naiyo'],
    );
  }

  $SUM;

  for($s = 0;$s < count($Sum);$s++){

  $USE = (int)$Sum[$s]['user_id'];
  $TAS = $Sum[$s]['task_num'];
  $NAI = $Sum[$s]['naiyo'];

  $exe2 = $db->prepare("select * from id_demo where user_id = $USE");
  $exe2->execute();

  while($row_ex2 = $exe2->fetch(PDO::FETCH_ASSOC)){
   $SUM[]=array(
    'user_id'=>$USE,
    'twitter_id'=>$row_ex2['twitter_id'],
    'twitter_name' =>$row_ex2['twitter_name'],
    'task_num'=>$TAS,
    'naiyo'=>$NAI,
    );
  }

}

  $sth1 = $db->prepare("select * from detail where event_num = $Num");
  $sth1->execute();

  $Cat;

  while($row1 = $sth1->fetch(PDO::FETCH_ASSOC)){
   $Cat[]=array(
    'category_num'=>$row1['category_num'],
    );
  }

  $Cate = (int)$Cat[0]["category_num"];

  $sth2 = $db->prepare("select * from category where category_num = $Cate");
  $sth2->execute();

  $Task;

  while($row2 = $sth2->fetch(PDO::FETCH_ASSOC)){

   $Task[]=array(
    'task_num'=>$row2['task_num'],
    );

  }

  $TaskName;

  for($i = 0;$i < count($Task);$i++){

  $TaskI = (int)$Task[$i]['task_num'];

  $sth3 = $db->prepare("select * from need_task where task_num = $TaskI");
  $sth3->execute();

  while($row3 = $sth3->fetch(PDO::FETCH_ASSOC)){
   $TaskName[]=array(
   'task_num'=>$TaskI,
   'task_name'=>$row3['task_name'],
    );
  }
 }

$sth4 = $db->prepare("select * from category_n where category_num = $Cate");
$sth4->execute();

 while($row4 = $sth4->fetch(PDO::FETCH_ASSOC)){
  $CateName[]=array(
  'category_name'=>$row4['category_name'],
   );
 }

$result['event'] = $SUM;
$result['task'] = $TaskName;
$result['category'] = $CateName;

  header('Content-Type: text/javascript; charset=utf-8');
  header('Content-type: application/json');
  echo json_encode($result);

 $db = null;

}catch(PDOException $e){
 echo $e->getMessage();
 exit;
}