<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: Logout.php");
    exit;
}

$dsn  = 'mysql:dbname=mimic;host=localhost';
$host = 'localhost';
$username = 'root';
$password = 'uz@1!Hm!';
$dbname = 'mimic';
$id = $_SESSION["id"];

try{
    $dbh = new PDO($dsn,$username,$password);
    #契約者の名前を取り出す
    $db = $dbh->prepare("select name from users where id = ?");
    $db->bindValue(1, $id);
    $db->execute();
    $result = $db->fetch(PDO::FETCH_ASSOC);
    $name = $result['name'];
}catch (PDOException $e) {
    $errorMessage = 'エラー発生';
    exit("データベースに接続できませんでした。<br>" . htmlspecialchars($e->getMessage()) . "<br>");
}
 ?>

<!DOCTYPE html>
<html>
  <head>
    <title>株式会社 skiny</title>
    <link rel="stylesheet" type"text/css" href="userMyPage.css">
   <META charset="UTF-8" name="viewport" content="width=device-width">
  </head>
  <body>
    <ul class="pagetop">
    <li><h1 id="top1" onClick="location.href='userMyPage.php'"/>　ミミック　　</h1></li>
    <li class="right"><input id="button3" type="button" value="ログアウト" onClick="location.href='logout.php'"/></li>
    </ul>
    <center>


      <h1><?php echo "$name"; ?>様のマイページ<h1></center>


    <form>
      <div class="button">
	<ul>
	  <li><button class="button1" type="button" value="履歴" onClick="location.href='history.php'">履歴</li>
      <li><button class="button1" type="button" value="使用設定" onClick="location.href='getConf.php'">使用設定</li>
      <li><button class="button1" type="button" value="使い方" onClick="location.href='useManagement.html'">使い方</li>
      <li><button class="button1" type="button" value="QandA" onClick="location.href='questionAndAnswer.html'">Q & A</li>
      <li><button class="button1" type="button" value="契約情報" onClick="location.href='contractInformation.php'">契約情報</li>

	</ul>
      </div>
    </form>
  </body>
</html>
