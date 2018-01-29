<?php
#$dsn  = 'mysql:dbname=mimic;host=localhost;unix_socket=/tmp/mysql.sock';
#$host = 'localhost';
#$dbusername = 'root';
#$password = 'tukasa96';
#$dbname = 'mimic';
require_once '../DBN.php';
#idあってるか確認する（修正）
#$id = $_SESSION["id"];
#契約終了させるやつ

$userid = $_POST['id'];
#$userps = $_POST['pass'];
#$usermail = $_POST['mail'];
#$userphone = $_POST['phone'];
#$userip = $_POST['ip'];
date_default_timezone_set('Asia/Tokyo');
$sdate = date("Y-m-d H:i:s");

  $stmt = $dbh->prepare("update users set deleted_at = ?, updated_at = ? where id = ?;");
  $stmt->bindValue(1, $sdate);
  $stmt->bindValue(2, $sdate);
  $stmt->bindValue(3, $userid);
  $stmt->execute();
  $stmt2 = $dbh->prepare("update contracts set closed_at = ?, updated_at = ? where user_id = ?;");
  $stmt2->bindValue(1, $sdate);
  $stmt2->bindValue(2, $sdate);
  $stmt2->bindValue(3, $userid);
  $stmt2->execute();

  #dbCreate = $result['created_at'];
  #dbUpdate = $result['updated_at'];
  $dbh = null;

?>
