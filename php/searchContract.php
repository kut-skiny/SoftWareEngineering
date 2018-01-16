<?php
$dsn  = 'mysql:dbname=mimic;host=localhost;unix_socket=/tmp/mysql.sock';
$host = 'localhost';
$dbusername = 'root';
$password = 'tukasa96';
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
$sdate = date("Y-m-d H:i:s");
try {
  $dbh = new PDO($dsn,$dbusername,$password);
  $stmt = $dbh->prepare("select users.name,contracts.partner from contracts join users on contracts.user_id=users.id where users.id = ? ;");
  $db->bindValue(1, $userid, PDO::PARAM_STR);
  $db->execute();
  $result = $db->fetch(PDO::FETCH_ASSOC);
  #配列の中身表示
  #print_r($result);
  $dbname = $result['name'];
  $dbpartner = $result['partner'];

  #dbCreate = $result['created_at'];
  #dbUpdate = $result['updated_at'];
  $dbh = null;
} catch (PDOException $e) {
  exit("データベースに接続できませんでした。<br>" . htmlspecialchars($e->getMessage()) . "<br>");
}
?>
