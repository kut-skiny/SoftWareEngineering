<?php
#session_start();
#if (!isset($_SESSION["id"])) {
#    header("Location: Logout.php");
#    exit;
#}
#新規登録のやつ

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
  $stmt = $dbh->prepare("insert into users(id,name,password,mail,phone_number,registered_at) values (?,?,?,?,?,?)");
  $stmt->bindValue(1, $userid);
  $stmt->bindValue(2, $username);
  $stmt->bindValue(3, $userps);
  $stmt->bindValue(4, $usermail);
  $stmt->bindValue(5, $userphone);
  $stmt->bindValue(6, $sdate);
  $stmt->execute();
  $stmt2 = $dbh->prepare("insert into contracts(id,user_id,partner,ip_address,started_at) values (?,?,?,?,?)");
  $cid = (int)$userid + 10000000;
  $stmt2->bindValue(1, (string)$cid);#ここは指定されてないから適当な値が入れてある
  $stmt2->bindValue(2, $userid);
  $stmt2->bindValue(3, $partnername);
  $stmt2->bindValue(4, $userip);
  $stmt2->bindValue(5, $sdate);
  $stmt2->execute();
  $stmt3 = $dbh->prepare("insert into configurations(id, contract_id, morning_enabled, morning_time, noon_enabled,noon_time, evening_enabled, evening_time, night_enabled, night_time, mail, mail_after_blank_time_enabled, blank_time_for_mail, mail_once_a_day_enabled, line, line_after_blank_time_enabled, blank_time_for_line, line_once_a_day_enabled, created_at,updated_at) values (?,?,'off','06:00:00','off','12:00:00','off','15:00:00','off','21:00:00',?,'off','06:00:00','off','test','off','06:00:00','off',?,'0000-00-00 00:00:00')");
  $c2id = $cid + 10000000;
  $stmt3->bindValue(1, (string)$c2id);
  $stmt3->bindValue(2, (string)$cid);
  $stmt3->bindValue(3, $usermail);
  $stmt3->bindValue(4, $sdate);
  $stmt3->execute();

  #insert into configurations(id, contract_id, morning_enabled, morning_time, noon_enabled,noon_time, evening_enabled, evening_time, night_enabled, night_time, mail, mail_after_blank_time_enabled, blank_time_for_mail, mail_once_a_day_enabled, line, line_after_blank_time_enabled, blank_time_for_line, line_once_a_day_enabled, created_at, updated_at) values('30000003','20000003','off','06:00:00','off','12:00:00','off','15:00:00','off','21:00:00','test@test','off','06:00:00','off','test','off','06:00:00','off','0000-00-00 00:00:00','0000-00-00 00:00:00');
  #dbCreate = $result['created_at'];
  #dbUpdate = $result['updated_at'];
  $dbh = null;
} catch (PDOException $e) {
  exit("データベースに接続できませんでした。<br>" . htmlspecialchars($e->getMessage()) . "<br>");
}
?>
