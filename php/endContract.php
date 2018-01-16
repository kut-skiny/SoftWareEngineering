<?php
$dsn  = 'mysql:dbname=mimic;host=localhost;unix_socket=/tmp/mysql.sock';
$host = 'localhost';
$dbusername = 'root';
$password = 'tukasa96';
$dbname = 'mimic';

#idあってるか確認する（修正）
#$id = $_SESSION["id"];
#契約終了させるやつ

$userid = $_POST['id'];
$username = $_POST['name1'];
$partnername = $_POST['name2'];
#$userps = $_POST['pass'];
#$usermail = $_POST['mail'];
#$userphone = $_POST['phone'];
#$userip = $_POST['ip'];
$sdate = date("Y-m-d H:i:s");
try {
  $dbh = new PDO($dsn,$dbusername,$password);
  $stmt = $dbh->prepare("update users set deleted_at = ?, updated_at = ? where id = ?;");
  $stmt->bindValue(1, $sdate);
  $stmt->bindValue(2, $sdate);
  $stmt->bindValue(3, $userid);
  #$stmt->bindValue(4, $sdate);
  #$stmt->bindValue(5, $userphone);
  $stmt->execute();
  $stmt2 = $dbh->prepare("update contracts set closed_at = ?, updated_at = ? where user_id = ?;");
  $stmt2->bindValue(1, $sdate);
  $stmt2->bindValue(2, $sdate);
  $stmt2->bindValue(3, $userid);
  #$stmt2->bindValue(4, $userip);
  #$stmt2->execute();

  #dbCreate = $result['created_at'];
  #dbUpdate = $result['updated_at'];
  $dbh = null;
} catch (PDOException $e) {
  exit("データベースに接続できませんでした。<br>" . htmlspecialchars($e->getMessage()) . "<br>");
}
?>
