<?php
#session_start();
#if (!isset($_SESSION["id"])) {
#    header("Location: Logout.php");
#    exit;
#}
#新規登録のやつ

$dsn  = 'mysql:dbname=mimic;host=localhost;unix_socket=/tmp/mysql.sock';
$host = 'localhost';
$dbusername = 'root';
$password = 'tukasa96';
$dbname = 'mimic';

#idあってるか確認する（修正）
#$id = $_SESSION["id"];

$userid = $_POST['id'];
$username = $_POST['name1'];
$partnername = $_POST['name2'];
$userps = $_POST['pass'];
$usermail = $_POST['mail'];
$userphone = $_POST['phone'];
$userip = $_POST['ip'];
$sdate = date("Y-m-d H:i:s");
try {
  $dbh = new PDO($dsn,$dbusername,$password);
  $stmt = $dbh->prepare("insert into users(id,name,password,mail,phone_number,registered_at) values (?,?,?,?,?,?);");
  $stmt->bindValue(1, $userid);
  $stmt->bindValue(2, $username);
  $stmt->bindValue(3, $userps);
  $stmt->bindValue(4, $usermail);
  $stmt->bindValue(5, $userphone);
  $stmt->bindValue(6, $sdate);
  $stmt->execute();
  $stmt2 = $dbh->prepare("insert into contracts(id,user_id,partner,ip_address,started_at) values (?,?,?,?,?);");
  $stmt2->bindValue(1, 20000002);#ここは指定されてないから適当な値が入れてある
  $stmt2->bindValue(2, $userid);
  $stmt2->bindValue(3, $partnername);
  $stmt2->bindValue(4, $userip);
  $stmt2->bindValue(5, $sdate);
  $stmt2->execute();

  #dbCreate = $result['created_at'];
  #dbUpdate = $result['updated_at'];
  $dbh = null;
} catch (PDOException $e) {
  exit("データベースに接続できませんでした。<br>" . htmlspecialchars($e->getMessage()) . "<br>");
}
?>
