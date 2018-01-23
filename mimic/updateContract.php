<?php
#$dsn  = 'mysql:dbname=mimic;host=localhost;unix_socket=/tmp/mysql.sock';
#$host = 'localhost';
#$dbusername = 'root';
#$password = 'tukasa96';
#$dbname = 'mimic';
$dsn  = 'mysql:dbname=mimic;host=localhost';
$host = 'localhost';
$dbusername = 'root';
$password = 'uz@1!Hm!';
$dbname = 'mimic';

#idあってるか確認する（修正）
#$id = $_SESSION["id"];
#契約更新を行う際のやつ
$userid = $_POST['id'];
$username = $_POST['name1'];
$partnername = $_POST['name2'];
$userps = $_POST['pass'];
$usermail = $_POST['mail'];
$userphone = $_POST['phone'];
$userip = $_POST['ip'];
date_default_timezone_set('Asia/Tokyo');
$sdate = date("Y-m-d H:i:s");
try {
  $dbh = new PDO($dsn,$dbusername,$password);
  $stmt = $dbh->prepare("update users set name = ?, password = ?, mail = ?, phone_number = ?, updated_at = ? where id = ?;");
  $stmt->bindValue(1, $username);
  $stmt->bindValue(2, $userps);
  $stmt->bindValue(3, $usermail);
  $stmt->bindValue(4, $userphone);
  $stmt->bindValue(5, $sdate);
  $stmt->bindValue(6, $userid);
  $stmt->execute();
  $stmt2 = $dbh->prepare("update contracts set user_id = ?, partner = ?, ip_address = ?, updated_at = ? where id = ?;");
  $stmt2->bindValue(1, $userid);
  $stmt2->bindValue(2, $partnername);
  $stmt2->bindValue(3, $userip);
  $stmt2->bindValue(4, $sdate);
  $stmt2->bindValue(5, 20000002);
  $stmt2->execute();

//update contracts set user_id = 10000002, partner = 'DAIGO', ip_address = '123456789', updated_at = '2018-01-22 17:31:05' where id = 20000002;

  #dbCreate = $result['created_at'];
  #dbUpdate = $result['updated_at'];
  $dbh = null;
} catch (PDOException $e) {
  exit("データベースに接続できませんでした。<br>" . htmlspecialchars($e->getMessage()) . "<br>");
}
?>
