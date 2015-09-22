<?php

define('DB_DATABASE', '');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
define('PDO_DSN','' . DB_DATABASE);

try{

 if(isset( $_REQUEST['user_id'] ) && isset( $_REQUEST['category_name'] ) && isset( $_REQUEST['task_name'] ) ){
  $User = (int)$_REQUEST['user_id'];
  $C_name = (String)$_REQUEST['category_name'];
  $T_name = json_decode($_REQUEST['task_name']);
 }else{
  echo "error";
  exit;
 }

  $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
 );

  $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD, $options);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sth = $db->prepare("insert into category_n (category_name,user_id) values ('$C_name',$User)");
  $sth->execute();

  $sth1 = $db->prepare("select * from category_n order by category_num desc limit 1");
  $sth1->execute();

  while($row1 = $sth1->fetch(PDO::FETCH_ASSOC)){
   $Category[]=array(
    'category_num'=>$row1['category_num'],
    );
   }

  $C_num = (int)$Category[0]['category_num'];

  for($i = 0;$i < count($T_name);$i++){

  $Task_name = (String)$T_name[$i];

  $sth2 = $db->prepare("insert into need_task (task_name) values ('$Task_name')");
  $sth2->execute();

}

 $T_count = (int)count($T_name);

  $sth3 = $db->prepare("select * from need_task order by task_num desc limit $T_count");
  $sth3->execute();

  while($row3 = $sth3->fetch(PDO::FETCH_ASSOC)){
   $Task_n[]=array(
    'task_num'=>$row3['task_num'],
    );
   }

  for($s = 0;$s < count($Task_n);$s++){

  $Task_num = (int)$Task_n[$s]['task_num'];

  $sth4 = $db->prepare("insert into category (category_num,task_num) values ($C_num,$Task_num)");

  $sth4->execute();

}

echo "insert";


}catch(PDOException $e){
 echo $e->getMessage();
 exit;
}