<?php

define('DB_DATABASE', '');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
define('PDO_DSN','' . DB_DATABASE);

try{

 if(isset( $_GET['user_id'] )){
  $User = (int)$_GET['user_id'];
 }else{
  echo "error";
  exit;
 }

  $options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
 );

  $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD, $options);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sth = $db->prepare("select count(*) from category_n WHERE user_id = $User");
  $sth->execute();

  while($row = $sth->fetch(PDO::FETCH_ASSOC)){
   $Cou[]=array(
    'count'=>$row['count(*)'],
    );
   }

  $Count = (int)$Cou[0]['count'];

  if($Count == 0){

   $Cate[0]=array(
    'category_num'=>NULL,
    'category_name'=>NULL,
    );

  $result['category'] = $Cate;

  header('Content-Type: text/javascript; charset=utf-8');
  header('Content-type: application/json');
  echo json_encode($result);

}else{

  $sth1 = $db->prepare("select * from category_n WHERE user_id = $User");
  $sth1->execute();

  while($row1 = $sth1->fetch(PDO::FETCH_ASSOC)){
   $Cate[]=array(
    'category_num'=>$row1['category_num'],
    'category_name'=>$row1['category_name'],
    );
   }

  $result['category'] = $Cate;

  header('Content-Type: text/javascript; charset=utf-8');
  header('Content-type: application/json');
  echo json_encode($result);
}

}catch(PDOException $e){
 echo $e->getMessage();
 exit;
}